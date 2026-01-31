<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\House;
use App\Models\HouseholdResident;
use App\Models\Household;




class HouseholdController extends Controller
{
    public function showHousehold()
{
    $street = Street::withCount('houses')->get();
    return view('admin.household', compact('street'));
}

    public function showStreets($id)
{
    $houses = House::where('street_id', $id)->get();
    return view('admin.houses', compact('houses'));
}

    public function showHeads($id)
{
    $house = House::findOrFail($id);

    $heads = HouseholdResident::with('resident:id,firstName,lastName,contactNo,birthday')
        ->whereHas('household', function ($q) use ($id) {
            $q->where('house_id', $id);
        })
        ->where('is_household_head', true)
        ->get();

    return view('admin.househeads', compact('heads', 'house'));
}

    
}
