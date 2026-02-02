<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\House;
use App\Models\HouseholdResident;
use App\Models\Household;
use App\Models\Resident;




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
    $members= HouseholdResident::with('resident:id,firstName,middleName,lastName,contactNo,birthday,age,sex,image_path')
        ->whereHas('household', function($q) use($id){
        $q->where('house_id', $id);
        })->where('is_household_head', false)->get();

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
        'sex' => 'required|in:male,female',
        'contactNo' => 'nullable|string|max:11',
    ]);

    // Calculate age from birthday
    $birthday = \Carbon\Carbon::parse($validated['birthday']);
    $age = $birthday->age;

    // Get the house information from the household
    $house = $household->house;
    
    // Create new resident record
    $newResident = Resident::create([
        'firstName' => $validated['firstName'],
        'middleName' => $validated['middleName'] ?? '',
        'lastName' => $validated['lastName'],
        'birthday' => $validated['birthday'],
        'age' => $age,
        'sex' => $validated['sex'],
        'contactNo' => $validated['contactNo'] ?? '',
        'houseNo' => $house->house_no ?? '',
        'street' => optional($house->street)->street_name ?? '',
        'religion' => 'Not specified',
        'emergencyContactNo' => '',
        'emergencyContactName' => '',
        'parent' => 'no',
        'enrolled' => 'no',
        'educationalAttainment' => '',
        'headOfFamily' => 'no',
        'EncodedBy' => $user->id,
    ]);

    // Attach to SAME household
    HouseholdResident::create([
        'household_id' => $household->id,
        'resident_id'  => $newResident->id,
        'is_household_head' => false,
    ]);

    return redirect()->route($user->role . '.profile')->with('success', 'Family member added successfully!');
}


    
}
