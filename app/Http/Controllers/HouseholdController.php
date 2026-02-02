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

    // Get logged-in resident
    $resident = Resident::where('user_id', $user->id)->firstOrFail();

    // Find household of the resident
    $household = HouseholdResident::where('resident_id', $resident->id)
        ->with('household')
        ->firstOrFail()
        ->household;

    // Validate
    $validated = $request->validate([
        'firstName' => 'required|string|max:70',
        'middleName' => 'nullable|string|max:70',
        'lastName' => 'required|string|max:70',
        'birthday' => 'required|date',
        'sex' => 'required|in:male,female',
        'contactNo' => 'nullable|string|max:11',
    ]);

    // Create resident
    $random = random_int(2,5);

    // Attach to SAME household
    HouseholdResident::create([
        'household_id' => $household->id,
        'resident_id'  => $random,
        'is_household_head' => false,
    ]);

    return back()->with('success', 'Family member added.');
}


    
}
