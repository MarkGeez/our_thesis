<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Archive;
use App\Models\Official;
use Illuminate\Support\Facades\Storage;


class ResidentListController extends Controller
{
   public function showResidents(Request $request)
{
    $user = auth()->user();
    
    if(!$user || $user->role === "resident" || $user->role === "non-resident"){
        abort(403);
    }
    
    $searchTerm = $request->input('search');
    
    $residents = Resident::with(['user:id,firstName,lastname', 'official'])
        ->when($searchTerm, function($query, $searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $q->where('firstName', 'like', "%{$searchTerm}%")
                  ->orWhere('lastName', 'like', "%{$searchTerm}%")
                  ->orWhere('middleName', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        })
        ->paginate(20);

    return view($user->role . '.residents', compact('user', 'residents', 'searchTerm'));
}

// Then remove searchResidents() or keep it as an alias
public function searchResidents(Request $request)
{
    return $this->showResidents($request);
}

    public function encodeResidents(Request $request){
        $houses = Houses::with('');
     
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
            'sex' => 'nullable|in:male,female',
            'parent' => 'nullable|in:yes,no,single',
            'enrolled' => 'nullable|in:yes,no',
            'religion' => 'nullable|string|max:255',
            'educationalAttainment' => 'nullable|string',
            'headOfFamily' => 'required|in:yes,no',
            'image_path' => 'nullable|mimes:jpg,jpeg,png|max:4096' // Changed to match form
        ]);

        // Handle image upload
        if($request->hasFile('image_path')){
            $image = $request->file('image_path')->store('resident', 'public');
            $validated['image_path'] = $image;
        }

        // Format names
        $validated['firstName'] = strtolower(trim($validated['firstName']));
        $validated['middleName'] = strtolower(trim($validated['middleName']));
        $validated['lastName'] = strtolower(trim($validated['lastName']));
        
        // Add encoded by
        $validated['EncodedBy'] = auth()->id();

        // Create resident
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
            'educationalAttainment' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'headOfFamily' => 'required|in:yes,no',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'
        ]);


    
        if($request->hasFile('image_path')){
        // Delete old image if exists
        if($resident->image_path && Storage::disk('public')->exists($resident->image_path)){
            Storage::disk('public')->delete($resident->image_path);
        }
        
        $validated['image_path'] = $request->file('image_path')->store('resident', 'public');
        } else {
        // Keep the old image if no new image uploaded
        unset($validated['image_path']);
        }


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

    public function updateOwnInfo(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
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
        'educationalAttainment' => 'nullable|string|max:255',
        'headOfFamily' => 'required|in:yes,no',
        'religion' => 'nullable|string|max:255'
    ]);

    // Find the resident record
    $resident = Resident::findOrFail($id);
    
    // Check if the resident belongs to the logged-in user (skip for admin/subadmin)
    $user = auth()->user();
    if (!in_array($user->role, ['admin', 'subadmin']) && $resident->user_id !== $user->id) {
        return back()->withErrors(['error' => 'You can only update your own information.']);
    }

    // Update the resident
    $resident->update($validated);

    return redirect()->route($user->role . '.profile')->with('success', 'Resident information updated successfully.');
}
}