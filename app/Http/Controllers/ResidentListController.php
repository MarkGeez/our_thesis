<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Archive;

class ResidentListController extends Controller
{
    public function showResidents(){
        $user = auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident" ){
            abort(403);
        }else{
            $residents = Resident::with('user:id,firstName,lastname')->paginate(10);
            return view($user->role . '.residents', compact('user', 'residents'));
        }
    }

    public function encodeResidents(Request $request){
    $validated = $request->validate([
        'firstName' => 'required|string|max:70',
        'middleName' => 'required|string|max:70',
        'lastName' => 'required|string|max:70',
        'houseNo' => 'required|string|max:8',
        'street' => 'required|string|max:70',
        'contactNo' => 'required|string|max:11',
        'birthday' => 'required|date',
        'emergencyContactNo' => 'required|string|max:11',
        'emergencyContactName' => 'required|string|max:255',
        'age' => 'required|integer|min:0|max:255',
        'sex' => 'required|in:male,female',
        'parent' => 'required|in:yes,no,single',
        'enrolled' => 'required|in:yes,no',
        'educationalAttainment' => 'nullable|string',
        'religionId' => 'nullable|exists:religions,id',
        'headOfFamily' => 'required|in:yes,no',
    ]);

    // Remove religionId from validation since we're forcing it to 1
    unset($validated['religionId']);
    
    $validated['EncodedBy'] = auth()->id();
    $validated['religionList'] = 1; // instead of $validated['religionId'] = 1


    Resident::create($validated);

    return redirect()->back()->with('success', 'Resident encoded successfully!');
}

    public function updateResident(Request $request, $id){
        $user = auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }

        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'firstName' => 'required|string|max:70',
            'middleName' => 'required|string|max:70',
            'lastName' => 'required|string|max:70',
            'houseNo' => 'required|string|max:8',
            'street' => 'required|string|max:70',
            'contactNo' => 'required|string|max:11',
            'birthday' => 'required|date',
            'emergencyContactNo' => 'required|string|max:11',
            'emergencyContactName' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:255',
            'sex' => 'required|in:male,female',
            'parent' => 'required|in:yes,no,single',
            'enrolled' => 'required|in:yes,no',
            'educationalAttainment' => 'nullable|string',
            'religionId' => 'nullable|exists:religions,id',
            'headOfFamily' => 'required|in:yes,no',
        ]);

        unset($validated['religionId']);
        $validated['religionList'] = 1;

        $resident->update($validated);

        return redirect()->back()->with('success', 'Resident updated successfully!');
    }

    public function archiveResident($id){
        $user = auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }

        $resident = Resident::findOrFail($id);

        // Create archive record
        Archive::create([
            'record_type' => 'resident',
            'record_id' => $resident->id,
            'data' => $resident->toArray(),
            'archived_by' => $user->id,
        ]);

        // Delete the resident
        $resident->delete();

        return redirect()->back()->with('success', 'Resident archived successfully!');
    }
}