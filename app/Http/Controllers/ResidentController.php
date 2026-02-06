<?php
namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Announcement;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\House;
use App\Models\Street;
use App\Models\Official;

use App\Models\FamilyMember;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    
     public function dashboard()
    {
        $resident = auth()->user();
        $announcements = Announcement::with('user:id,firstName,lastName')->latest()->get();
        return view('resident.dashboard', compact('resident', 'announcements'));
    }

    public function profile()
    {
        $user = auth()->user();
        $resident = Resident::with('households.house.street')->where('user_id', $user->id)->first();
       
        // Get family members from the same household
        $members = FamilyMember::where('encoded_by', $user->id)->orderBy('firstName')->get();

        
        return view('resident.profile', compact('resident', 'user', 'members'));
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

        return redirect()->route('resident.profile')->with('success', 'Profile updated successfully!');
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
        
        return redirect()->route('resident.profile')->with('success', 'Resident information updated successfully!');
    }
    

    public function blotter()
    {
               $resident = auth()->user();

        return view('resident.blotter', compact('resident'));
    }

    public function certificate()
    {
        $resident = auth()->user();
        $requests = $resident->certificateRequests()->latest()->get();
        return view('resident.certificate', compact('resident', 'requests'));
    }

    public function clearance()
    {
                $resident = auth()->user();

        return view('resident.clearance', compact('resident'));
    }

    public function service()
    {
                $resident = auth()->user();

        return view('resident.service', compact('resident'));
    }

    public function complaint()
{   
    $resident = auth()->user();
    $myComplaints = $resident->complaints()->get();
    return view('resident.complaint', compact('resident', 'myComplaints'));
}

    public function feedback()
    {
        $resident = auth()->user();
        return view('resident.feedback', compact('resident'));
    }

    public function contactus()
    {
        $resident = auth()->user();
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

        $resident = auth()->user();

        return view('resident.aboutus', compact('resident', 'positions', 'officialsByPosition'));
    }

    
}