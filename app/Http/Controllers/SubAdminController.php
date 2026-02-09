<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Complaints;
use App\Models\Resident;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\House;
use App\Models\Street;
use App\Models\User;
use App\Models\FamilyMember;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubAdminController extends Controller
{
    public function dashboard(): View
    {
        $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
        $subadmin = Auth::user();
        $residentCount = Resident::count();
        $maleCount = Resident::where('sex', 'male')->count();
        $femaleCount = Resident::where('sex', 'female')->count();
        $seniorCount = Resident::where('age', '>=', 60)->count();
        $userCount = User::count();

        return view("subadmin.dashboard", compact('announcement', 'subadmin', 'residentCount', 'maleCount', 'femaleCount', 'seniorCount', 'userCount'));
    }

    public function profile(): View
    {
        $user = Auth::user();
        $resident = Resident::with('households.house.street')->where('user_id', $user->id)->first();
       
        
        // Get family members from the same household
        $members = FamilyMember::where('encoded_by', $user->id)->orderBy('firstName')->get();
        return view("subadmin.profile", compact('resident', 'user',  'members'));
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
            'house_id' => 'required|exists:houses,id',
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
        
        // Update household assignment
        $household = Household::firstOrCreate(['house_id' => $validated['house_id']]);
        $householdResident = HouseholdResident::where('resident_id', $resident->id)->first();

        if ($householdResident) {
            $householdResident->update([
                'household_id' => $household->id,
                'is_household_head' => $validated['headOfFamily'] === 'yes',
            ]);
        } else {
            HouseholdResident::create([
                'household_id' => $household->id,
                'resident_id' => $resident->id,
                'is_household_head' => $validated['headOfFamily'] === 'yes',
            ]);
        }

        unset($validated['house_id']);
        
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
        $requests = $subadmin->certificateRequests()->latest()->get();
        return view("subadmin.certificateRequest", compact('subadmin', 'requests'));
    }

    public function subadminCertificate(): View
    {
        $subadmin = Auth::user();
        $requests = $subadmin->certificateRequests()->latest()->get();
        return view("subadmin.subadminCertificate", compact('subadmin', 'requests'));
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

        $newRemarks = trim((string) $request->input('remarks'));
        if ($newRemarks !== '') {
            $user = Auth::user();
            $remarkerName = trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? ''));
            if ($remarkerName === '') {
                $remarkerName = $user->name ?? $user->email ?? 'Unknown';
            }
            $remarkerName = Str::title($remarkerName);

            $timestamp = now()->format('M d, Y g:i A');
            $entry = $timestamp . ' - ' . $remarkerName . ': ' . $newRemarks;
            $existingRemarks = trim((string) $complaint->remarks);
            $complaint->remarks = $existingRemarks === ''
                ? $entry
                : $existingRemarks . PHP_EOL . $entry;
        }
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