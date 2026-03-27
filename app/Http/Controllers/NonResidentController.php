<?php

namespace App\Http\Controllers;
use App\Http\Controllers\NonResident;
use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Models\Resident;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\Official;


class NonResidentController extends Controller
{
    use ValidatesContactNumbers;

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

        $linkedResident = $user->resident ?: Resident::matchingUser($user)->first();

        $rules = [
            'firstName' => 'required|string|max:70',
            'middleName' => 'nullable|string|max:70',
            'lastName' => 'required|string|max:70',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contactNumber' => $this->requiredContactNumberRules(),
            'birthday' => 'required|date|before:today',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'proofOfIdentity' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];

        // If password change is attempted, validate only the new password + confirmation
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }
        
        $validated = $request->validate($rules, $this->contactNumberMessages(['contactNumber']));

        $validated['firstName'] = strtolower(trim((string) $validated['firstName']));
        $validated['middleName'] = strtolower(trim((string) ($validated['middleName'] ?? '')));
        $validated['lastName'] = strtolower(trim((string) $validated['lastName']));
        
        $user->firstName = $validated['firstName'];
        $user->middleName = $validated['middleName'];
        $user->lastName = $validated['lastName'];
        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];

        if ($linkedResident) {
            $linkedResident->user_id = $user->id;
            $linkedResident->firstName = $validated['firstName'];
            $linkedResident->middleName = $validated['middleName'];
            $linkedResident->lastName = $validated['lastName'];
            $linkedResident->contactNo = $validated['contactNumber'];
            $linkedResident->birthday = $validated['birthday'];
            $linkedResident->age = \Carbon\Carbon::parse($validated['birthday'])->age;
            $linkedResident->save();
        }

        if (!empty($validated['password'] ?? null)) {
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

            // Keep resident photo in sync with user profile image.
            if ($linkedResident) {
                $linkedResident->image_path = $path;
                $linkedResident->save();
            }
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
            'birthday' => 'required|date|before:today',
            'age' => 'required|integer',
            'sex' => 'required|in:male,female',
            'parent' => 'required|in:yes,no,single',
            'enrolled' => 'required|in:yes,no',
            'headOfFamily' => 'required|in:yes,no',
            'educationalAttainment' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'emergencyContactName' => 'required|string|max:255',
            'emergencyContactNo' => $this->requiredContactNumberRules(),
        ], $this->contactNumberMessages(['emergencyContactNo']));

        $validated['contactNo'] = $resident->user->contactNumber ?? $resident->contactNo;
        
        $resident->update($validated);
        
        return redirect()->route('non-resident.profile')->with('success', 'Resident information updated successfully!');
    }

    

    public function blotter()
    {
               $nonResident = auth()->user();

        return view('non-resident.blotter', compact('nonResident'));
    }

    public function complaint()
    {
        $nonResident = auth()->user();
        $myComplaints = $nonResident->complaints()->get();
        return view('non-resident.complaint', compact('nonResident', 'myComplaints'));
    }

    public function contactus()
    {
        $nonResident = auth()->user();
        return view('non-resident.contactus', compact('nonResident'));
    }

    public function aboutus()
    {
        $positions = [
            'Barangay Chairman',
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
            'Barangay Secretary',
            'Barangay Treasurer',
        ];

        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $positions)
            ->get()
            ->keyBy('position');

        $nonResident = auth()->user();
        return view('non-resident.aboutus', compact('nonResident', 'positions', 'officialsByPosition'));
    }
}
