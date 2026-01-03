<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Archive;

class ResidentListController extends Controller
{
   public function showResidents(Request $request)
{
    $user = auth()->user();
    
    if(!$user || $user->role === "resident" || $user->role === "non-resident"){
        abort(403);
    }
    
    $searchTerm = $request->input('search');
    
    $residents = Resident::with('user:id,firstName,lastname')
        ->when($searchTerm, function($query, $searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $q->where('firstName', 'like', "%{$searchTerm}%")
                  ->orWhere('lastName', 'like', "%{$searchTerm}%")
                  ->orWhere('middleName', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        })
        ->paginate(10);
    
    return view($user->role . '.residents', compact('user', 'residents', 'searchTerm'));
}

// Then remove searchResidents() or keep it as an alias
public function searchResidents(Request $request)
{
    return $this->showResidents($request);
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
        'religion' => 'nullable|string|max:255', 

        'educationalAttainment' => 'nullable|string',
        'headOfFamily' => 'required|in:yes,no',
    ]);

    
    $validated['EncodedBy'] = auth()->id();


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