<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\House;
use App\Models\HouseholdResident;
use App\Models\Household;




class HouseholdController extends Controller
{
    public function showHousehold(){
        $street= Street::withCount('houses')->get();
        return view('admin.household', compact('street'));
    }
    public function showStreets(Request $request, $id){
        $house= House::where('street_id', $id)->get();
        return view('admin.houses', compact('house'));
    }
    public function showHeads(Request $request, $id){
        $house= Household::where('house_id', $id)->get();
        return view('admin.houses', compact('house'));
    }
    
}
