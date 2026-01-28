<?php

namespace App\Http\Controllers;
use App\Http\Controllers\NonResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Models\Resident;
use App\Models\Official;


class NonResidentController extends Controller
{
    public function dashboard()
    {
        $nonResident = auth()->user();
        $announcements = Announcement::with('user:id,firstName,lastName')->latest()->get();
        return view('non-resident.dashboard', compact('nonResident', 'announcements'));
    }
    public function profile()
    {
        $user = auth()->user();
        $resident = Resident::where('user_id', $user->id)->first();
        return view('non-resident.profile', compact('resident', 'user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = auth()->user();

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
        
        return redirect()->route('non-resident.profile')->with('success', 'Profile updated successfully!');
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
        
        return redirect()->route('non-resident.profile')->with('success', 'Resident information updated successfully!');
    }

    

    public function blotter()
    {
               $nonResident = auth()->user();

        return view('non-resident.blotter', compact('nonResident'));
    }
    public function contactus()
    {
        $nonResident = auth()->user();
        return view('resident.contactus', compact('resident'));
    }

    public function aboutus()
    {
        $positions = [
            'Barangay Chairman',
            'Barangay Secretary',
            'Barangay Treasurer',
            'Kagawad 1',
            'Kagawad 2',
            'Kagawad 3',
            'Kagawad 4',
            'Kagawad 5',
            'Kagawad 6',
            'Kagawad 7',
            'SK Chairman',
            'SK Kagawad 1',
            'SK Kagawad 2',
            'SK Kagawad 3',
            'SK Kagawad 4',
            'SK Kagawad 5',
            'SK Kagawad 6',
            'SK Kagawad 7',
        ];

        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $positions)
            ->get()
            ->keyBy('position');

        $nonResident = auth()->user();
        return view('non-resident.aboutus', compact('nonResident', 'positions', 'officialsByPosition'));
    }
}
