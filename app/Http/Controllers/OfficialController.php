<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Official;
use App\Models\Positions;


class OfficialController extends Controller
{
    public function displayOfficials()
    {
        $officials = Official::with('resident:id,firstName,middleName,lastName', 'position:id,positionName')->paginate(30);
        $user = auth()->user();
        $positions = Positions::get();
        return view($user->role . '.barangayOfficials', compact('officials', 'user', 'positions'));
    }
    
    public function addOfficial(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:120'
        ]);

        if (Official::where('resident_id', $resident->id)->exists()) {
            return redirect()->back()->with('error', 'Resident is already an official!');
        }

        Official::create([
            'resident_id' => $resident->id,  
            'position_id' => $request->input('position_id'),
            'description' => $validated['description']
        ]);

        return redirect()->back()->with('success', 'Added to officials successfully!');
    }

    public function createOfficialName(Request $request)
{
    $validated = $request->validate([
        'positionName' => 'required|string|max:255',
    ]);

    Positions::create([
        'positionName' => $validated['positionName'],
    ]);

    return redirect()->back()->with('success', 'Position created');
}

}