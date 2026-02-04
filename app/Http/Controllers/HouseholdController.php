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

    $heads = HouseholdResident::with('resident:id,firstName,middleName,lastName,contactNo,birthday,age,sex,image_path')
        ->whereHas('household', function ($q) use ($id) {
            $q->where('house_id', $id);
        })
        ->where('is_household_head', true)
        ->get();
        
    $members = FamilyMember::whereHas('household', function($q) use($id) {
        $q->where('house_id', $id);
    })->get();

    // Transform FamilyMember data to match expected format with 'resident' object
    $members = $members->map(function($member) {
        return [
            'id' => $member->id,
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

    // Return JSON for AJAX requests
    if (request()->ajax() || request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'heads' => $heads,
            'members' => $members,
            'house' => $house
        ]);
    }

    return view('admin.househeads', compact('heads', 'house', 'members'));
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
                'birthdate' => $birthday,
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
    
    $member = FamilyMember::findOrFail($id);
    $member->update($validated);
    
    return redirect()->back()->with('success', 'Family member details successfully updated.');
}
    
}
