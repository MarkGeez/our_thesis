<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Official;


class OfficialController extends Controller
{
    public function displayOfficials()
    {
        $officials = Official::with('resident:id,firstName,middleName,lastName')->paginate(30);
        $user = auth()->user();
        return view($user->role . '.barangayOfficials', compact('officials', 'user'));
    }
    
    public function addOfficial(Request $request, $id)
{
    $resident = Resident::findOrFail($id);

    $positionLimits = [
        'Chairman'     => 1,
        'Kagawad'      => 7,
        'Secretary'    => 1,
        'Treasurer'    => 1,  
        'Sk Chairman'  => 1,
        'Sk Kagawad'   => 7,
    ];

    $request->validate([
        'details'  => 'nullable|string|max:255',
        'start'    => 'required|date_format:Y-m-d|before:tomorrow',
        'end'      => 'required|date_format:Y-m-d|after:start',
        'position' => 'required|in:' . implode(',', array_keys($positionLimits)),
    ]);

    if (Official::where('resident_id', $resident->id)->exists()) {
        return back()->with('error', 'Resident is already an official.');
    }

    $position = $request->position;
    $limit    = $positionLimits[$position];

    $count = Official::where('position', $position)->count();

    if ($count >= $limit) {
        return back()->with('error', "{$position} position has reached its limit.");
    }

    Official::create([
        'details'     => $request->details,
        'start'       => $request->start,
        'end'         => $request->end,
        'position'    => $position,
        'resident_id' => $resident->id,
    ]);

    return back()->with('success', 'Successfully added to the official list.');
}


    

}