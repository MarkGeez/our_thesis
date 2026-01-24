<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Complaints;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubAdminController extends Controller
{
    public function dashboard(): View
    {
        $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
        $subadmin = Auth::user();
            
        return view("subadmin.dashboard", compact('announcement', 'subadmin'));
    }

    public function profile(): View
    {
        $user = Auth::user();
        $resident = Resident::where('user_id', $user->id)->first();
        return view("subadmin.profile", compact('resident', 'user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();

        if ((int) $user->id !== (int) $id) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contactNumber' => 'required|string|max:20',
            'birthday' => 'required|date',
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'proofOfIdentity' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }
            
            // Store new image
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        if ($request->hasFile('proofOfIdentity')) {
            if ($user->proofOfIdentity && Storage::exists('public/' . $user->proofOfIdentity)) {
                Storage::delete('public/' . $user->proofOfIdentity);
            }

            $proofPath = $request->file('proofOfIdentity')->store('photos', 'public');
            $user->proofOfIdentity = $proofPath;
        }

        $user->save();

        return redirect()->route('subadmin.profile')
            ->with('success', 'Profile updated successfully');
    }

    public function updateOwnInfo(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $validated = $request->validate([
            'houseNo' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'contactNo' => 'required|string|max:20',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'sex' => 'required|in:male,female',
            'parent' => 'required|in:yes,no,single',
            'enrolled' => 'required|in:yes,no',
            'headOfFamily' => 'required|in:yes,no',
            'educationalAttainment' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'emergencyContactName' => 'required|string|max:255',
            'emergencyContactNo' => 'required|string|max:20',
        ]);
        
        $resident->update($validated);
        
        return redirect()->route('subadmin.profile')->with('success', 'Resident information updated successfully!');
    }
    public function announcements(){
    $subadmin = Auth::user();
    $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
    return view('subadmin.announcements', compact('subadmin', 'announcement'));
}

    public function blotterRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.blotterRequest", compact('subadmin'));
    }

    public function certificateRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.certificateRequest", compact('subadmin'));
    }

    public function clearanceRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.clearanceRequest", compact('subadmin'));
    }

    public function serviceRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.serviceRequest", compact('subadmin'));
    }
    public function subadminBlotter(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.subadminBlotter", compact('subadmin'));
    }
    public function complaintRequest(): View
    {
        $subadmin = Auth::user();
        $complaints = Complaints::orderByDesc('created_at')->get();
        return view('subadmin.complaintRequest', compact('subadmin', 'complaints'));
    }

    public function updateComplaint(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:resolved,rejected,on-going',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaints::findOrFail($id);
        $complaint->status = $request->input('status');
        $complaint->remarks = $request->input('remarks');
        $complaint->save();

        return back()->with('success', 'Complaint updated successfully.');
    }
    public function adminComplaint(): View
        {   
    $subadmin = auth()->user();
    $myComplaints = $subadmin->complaints()->get();
    return view('subadmin.complaint', compact('subadmin', 'myComplaints'));
}
    
}