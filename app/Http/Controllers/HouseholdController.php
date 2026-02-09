<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\House;
use App\Models\HouseholdResident;
use App\Models\Household;
use App\Models\Resident;

use App\Models\FamilyMember;



class HouseholdController extends Controller
{
    public function showHousehold()
{
    $street = Street::withCount('houses')->get();
    return view('admin.household', compact('street'));
}

    public function showStreets($id)
{
    $houses = House::where('street_id', $id)
        ->withCount('households')
        ->get();

    $houseIds = $houses->pluck('id');

    $headsCountByHouse = HouseholdResident::join('households', 'household_resident.household_id', '=', 'households.id')
        ->where('household_resident.is_household_head', true)
        ->whereIn('households.house_id', $houseIds)
        ->selectRaw('households.house_id, count(*) as heads_count')
        ->groupBy('households.house_id')
        ->pluck('heads_count', 'households.house_id');

    $houses->transform(function ($house) use ($headsCountByHouse) {
        $house->heads_count = (int) ($headsCountByHouse[$house->id] ?? 0);
        return $house;
    });
    
    // Return JSON for AJAX requests
    if (request()->ajax() || request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'houses' => $houses,
                


        ]);
    }
    
    return view('admin.houses', compact('houses'));
}

public function showHeads($id)
{
    $house = House::findOrFail($id);

    // Get Heads - explicitly ensure user_id is loaded from the resident relationship
    $heads = HouseholdResident::with(['resident' => function($query) {
            $query->select('id', 'user_id', 'firstName', 'middleName', 'lastName', 'contactNo', 'birthday', 'age', 'sex', 'image_path');
        }])
        ->whereHas('household', function ($q) use ($id) {
            $q->where('house_id', $id);
        })
        ->where('is_household_head', true)
        ->get();
        
    // Get members and ensure we have encoded_by
    $membersRaw = FamilyMember::whereHas('household', function($q) use($id) {
            $q->where('house_id', $id);
        })->get();

    $allMembers = $membersRaw->map(function($member) {
        return [
            'id' => $member->id,
            'household_id' => $member->household_id,
            'encoded_by' => (int)$member->encoded_by, // Cast to int for strict comparison
            'resident' => [
                'firstName' => $member->firstName,
                'middleName' => $member->middleName,
                'lastName' => $member->lastName,
                'contactNo' => $member->contactNumber,
                'birthday' => $member->birthdate,
                'age' => $this->calculateAge($member->birthdate),
                'sex' => $member->sex,
                'image_path' => null
            ]
        ];
    });

    $groups = $heads->map(function ($head) use ($allMembers) {
        // This is the key link: Head's User ID == Member's Encoded By
        $headUserId = (int)$head->resident->user_id; 
        
        $headMembers = $allMembers->filter(function($m) use ($headUserId) {
            return $m['encoded_by'] === $headUserId;
        })->values();

        return [
            'head' => $head,
            'members' => $headMembers,
        ];
    })->values();

    if (request()->ajax() || request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'groups' => $groups,
            'unassigned_members' => $allMembers->whereNotIn('encoded_by', $heads->pluck('resident.user_id'))->values(),
        ]);
    }
}
private function calculateAge($birthdate)
{
    if (!$birthdate) {
        return 'N/A';
    }
    try {
        return \Carbon\Carbon::parse($birthdate)->age;
    } catch (\Exception $e) {
        return 'N/A';
    }
}
    public function storeFamilyMember(Request $request)
    {
        \Log::info('storeFamilyMember called', ['request' => $request->all()]);
        
        try {
            $user = auth()->user();
            \Log::info('User: ' . $user->id . ' Role: ' . $user->role);

            // Get logged-in resident - try by user_id first, then by name match
            $resident = Resident::where('user_id', $user->id)->first();
            
            if (!$resident) {
                // For admin who might not have user_id set
                $resident = Resident::where('firstName', $user->firstName)
                    ->where('lastName', $user->lastName)
                    ->first();
            }
            
            if (!$resident) {
                \Log::warning('Resident not found for user: ' . $user->id);
                return back()->with('error', 'Resident record not found. Please contact administrator.');
            }

            \Log::info('Found resident: ' . $resident->id);

            // Find household of the resident
            $householdResident = HouseholdResident::where('resident_id', $resident->id)
                ->with('household')
                ->first();
            
            if (!$householdResident) {
                \Log::warning('No household found for resident: ' . $resident->id);
                return back()->with('error', 'No household found. Please ensure you are assigned to a household first.');
            }
            
            $household = $householdResident->household;
            \Log::info('Found household: ' . $household->id);

            // Validate
            $validated = $request->validate([
                'firstName' => 'required|string|max:70',
                'middleName' => 'nullable|string|max:70',
                'lastName' => 'required|string|max:70',
                'birthdate' => 'required|date',
                'relationship' => 'required|string|max:70',
                'sex' => 'required|in:male,female',
                'contactNumber' => 'nullable|string|max:12',
            ]);
            
            \Log::info('Validation passed', $validated);
            
            $birthday = \Carbon\Carbon::parse($validated['birthdate']);

            $familyMember = FamilyMember::create([
                'household_id' => $household->id,
                'encoded_by' => $user->id,
                'firstName' => $validated['firstName'],
                'middleName' => $validated['middleName'] ?? null,
                'lastName' => $validated['lastName'],
                'birthdate' => $validated['birthdate'],
                'relationship' => $validated['relationship'],
                'sex' => $validated['sex'],
                'contactNumber' => $validated['contactNumber'] ?? '',
            ]);

            \Log::info('Family member created: ' . $familyMember->id);
            
            return redirect()->route($user->role . '.profile')->with('success', 'Family member added successfully!');
        } catch (\Exception $e) {
            \Log::error('Family member storage error: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return back()->with('error', 'Error adding family member: ' . $e->getMessage());
        }
    }




public function untagMember(Request $request, $id){
    $member= FamilyMember::findOrFail($id);

    $member->delete();

    return redirect()->back()->with('success', 'Family member untagged successfully');

}
public function editMember(Request $request, $id)
{
    $validated = $request->validate([
        'firstName' => 'required|string|max:100',
        'middleName' => 'nullable|string|max:100',
        'lastName' => 'required|string|max:100',
        'birthdate' => 'required|date',
        'sex' => 'required|in:male,female',
        'relationship' => 'required|string|max:50',
        'contactNumber' => 'nullable|string|max:20',
    ]);
    
    $validated['is_inactive'] = $request->boolean('is_inactive');
    $member = FamilyMember::findOrFail($id);
    $member->update($validated);
    
    
    return redirect()->back()->with('success', 'Family member details successfully updated.');
}

    
}