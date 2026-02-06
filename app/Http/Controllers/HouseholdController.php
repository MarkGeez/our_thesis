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

    // Get all households in this house, eager loading the Head and their Family Members
    $households = Household::where('house_id', $id)
        ->with(['residents' => function($query) {
            $query->wherePivot('is_household_head', true);
        }, 'familyMembers'])
        ->get();

    $formattedHouseholds = $households->map(function ($household) {
        $head = $household->residents->first(); // Get the primary head resident
        
        return [
            'household_id' => $household->id,
            'head' => $head ? [
                'firstName' => $head->firstName,
                'middleName' => $head->middleName,
                'lastName' => $head->lastName,
                'contactNo' => $head->contactNo,
                'age' => $head->age,
                'sex' => $head->sex,
                'birthday' => $head->birthday,
                'image_path' => $head->image_path
            ] : null,
            'members' => $household->familyMembers->map(function ($member) {
                return [
                    'fullName' => $member->firstName . ' ' . $member->lastName,
                    'contactNo' => $member->contactNumber,
                    'age' => $this->calculateAge($member->birthdate),
                    'sex' => $member->sex,
                    'relationship' => $member->relationship,
                    'birthday' => $member->birthdate
                ];
            })
        ];
    });

    if (request()->ajax() || request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'households' => $formattedHouseholds,
            'house' => $house
        ]);
    }

    return view('admin.househeads', compact('formattedHouseholds', 'house'));
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
    $user = auth()->user();

    // Get logged-in resident - try by user_id first, then by name match
    $resident = Resident::where('user_id', $user->id)->first();
    
    if (!$resident) {
        // For admin who might not have user_id set
        $resident = Resident::where('firstName', $user->firstName)
            ->where('lastName', $user->lastName)
            ->first();
    }
    
    if (!$resident) {
        return back()->with('error', 'Resident record not found. Please contact administrator.');
    }

    // Find household of the resident
    $householdResident = HouseholdResident::where('resident_id', $resident->id)
        ->with('household')
        ->first();
    
    if (!$householdResident) {
        return back()->with('error', 'No household found. Please ensure you are assigned to a household first.');
    }
    
    $household = $householdResident->household;

    // Validate
    $validated = $request->validate([
        'firstName' => 'required|string|max:70',
        'middleName' => 'nullable|string|max:70',
        'lastName' => 'required|string|max:70',
        'birthday' => 'required|date',
        'relationship' => 'required|string|max:70',
        'sex' => 'required|in:male,female',
        'contactNumber' => 'nullable|string|max:11',
    ]);
    $birthday = \Carbon\Carbon::parse($validated['birthday']);

    FamilyMember::create([
    'household_id' => $household->id,
    'encoded_by' => $user->id,
    'firstName' => $validated['firstName'],
    'middleName' => $validated['middleName'] ?? null,
    'lastName' => $validated['lastName'],
    'birthdate' => $validated['birthday'],
    'relationship' => $validated['relationship'],
    'sex' => $validated['sex'],
    'contactNumber' => $validated['contactNumber'] ?? '' ,
    ]);

    return redirect()->route($user->role . '.profile')->with('success', 'Family member added successfully!');
}


    
}
