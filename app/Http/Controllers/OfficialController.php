<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Official;


class OfficialController extends Controller
{
    public function displayOfficials()
{
    $officials = Official::with('resident:id,firstName,middleName,lastName,image_path')
        ->orderByRaw("
            CASE position
                WHEN 'Chairman' THEN 1
                WHEN 'Secretary' THEN 2
                WHEN 'Treasurer' THEN 3
                WHEN 'Kagawad' THEN 4
                WHEN 'Sk Chairman' THEN 5
                WHEN 'Sk Kagawad' THEN 6
                ELSE 99
            END
        ")
        ->paginate(30);

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

    public function updateOfficial(Request $request, $id)
    {
        $official = Official::findOrFail($id);
        
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
            'start'    => 'required|date_format:Y-m-d',
            'end'      => 'required|date_format:Y-m-d|after:start',
            'position' => 'required|in:' . implode(',', array_keys($positionLimits)),
        ]);

        $position = $request->position;
        
        // Check if position change would exceed limit (excluding current official)
        if ($official->position !== $position) {
            $limit = $positionLimits[$position];
            $count = Official::where('position', $position)->count();
            
            if ($count >= $limit) {
                return back()->with('error', "{$position} position has reached its limit.");
            }
        }

        $official->update([
            'details'  => $request->details,
            'start'    => $request->start,
            'end'      => $request->end,
            'position' => $position,
        ]);

        return back()->with('success', 'Official information updated successfully.');
    }

}