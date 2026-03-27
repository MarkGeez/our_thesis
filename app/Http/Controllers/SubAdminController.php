<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use App\Mail\ComplaintStatusUpdateMail;
use App\Models\Announcement;
use App\Models\Complaints;
use App\Models\Resident;
use App\Models\Official;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\House;
use App\Models\Street;
use App\Models\User;
use App\Models\FamilyMember;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubAdminController extends Controller
{
    use ValidatesContactNumbers;

    private function getHeadCandidateResidents()
    {
        return Resident::with('households:id,house_id')
            ->select('id', 'firstName', 'middleName', 'lastName', 'birthday', 'age', 'sex', 'contactNo', 'headOfFamily')
            ->get()
            ->map(function (Resident $resident) {
                return [
                    'id' => $resident->id,
                    'firstName' => $resident->firstName,
                    'middleName' => $resident->middleName,
                    'lastName' => $resident->lastName,
                    'birthday' => $resident->birthday,
                    'age' => $resident->age,
                    'sex' => $resident->sex,
                    'contactNo' => $resident->contactNo,
                    'headOfFamily' => $resident->headOfFamily,
                    'householdIds' => $resident->households->pluck('id')->values(),
                    'houseIds' => $resident->households->pluck('house_id')->filter()->values(),
                ];
            });
    }

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
        $user = auth()->user();

        $resident = Resident::with('households.house.street')
            ->where('user_id', $user->id)
            ->first();

        if (!$resident) {
            $resident = Resident::with('households.house.street')
                ->where('firstName', $user->firstName)
                ->where('lastName', $user->lastName)
                ->whereDate('birthday', $user->birthday)
                ->first();

            if ($resident && !$resident->user_id) {
                $resident->update(['user_id' => $user->id]);
            }
        }

        $members = FamilyMember::with('resident')->where('encoded_by', $user->id)->get();
        // Include address fields for family-member suggestions (street + house number).
        $residents = Resident::with('households.house.street')
            ->get(['id', 'firstName', 'middleName', 'lastName', 'birthday', 'sex', 'contactNo', 'age'])
            ->map(function (Resident $r) {
                $household = $r->households->first();
                $house = $household?->house;
                $street = $house?->street;

                return [
                    'id' => $r->id,
                    'firstName' => $r->firstName,
                    'middleName' => $r->middleName,
                    'lastName' => $r->lastName,
                    'birthday' => $r->birthday,
                    'age' => $r->age,
                    'sex' => $r->sex,
                    'contactNo' => $r->contactNo,
                    'streetId' => $street?->id,
                    'streetName' => $street?->street_name,
                    'houseNo' => $house?->house_no,
                ];
            });
        $headCandidateResidents = $this->getHeadCandidateResidents();

        return view('subadmin.profile', compact('user', 'resident', 'members', 'residents', 'headCandidateResidents'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();

        if ((int) $user->id !== (int) $id) {
            abort(403);
        }

        $rules = [
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

        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];

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
            if ($user->resident) {
                $user->resident->image_path = $path;
                $user->resident->save();
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

        return redirect()->route('subadmin.profile')
            ->with('success', 'Profile updated successfully');
    }

    public function updateOwnInfo(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'contactNo' => $this->requiredContactNumberRules(),
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
        ], $this->contactNumberMessages(['contactNo', 'emergencyContactNo']));
        
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
        $requests = $subadmin->certificateRequests()->latest()->paginate(10);
        return view("subadmin.certificateRequest", compact('subadmin', 'requests'));
    }

    public function subadminCertificate(): View
    {
        $subadmin = Auth::user();
        $requests = $subadmin->certificateRequests()->latest()->paginate(10);
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

    public function contactus(): View
    {
        $subadmin = auth()->user();
        return view('subadmin.contactus', compact('subadmin'));
    }

    public function aboutus(): View
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

        $subadmin = auth()->user();
        return view('subadmin.aboutus', compact('subadmin', 'positions', 'officialsByPosition'));
    }
    public function subadminBlotter(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.subadminBlotter", compact('subadmin'));
    }
    public function complaintRequest(Request $request): View
    {
        $subadmin = Auth::user();
        $activeTab = $request->query('tab', 'all');
        if (!in_array($activeTab, ['all', 'pending', 'on-going', 'rejected', 'resolved'], true)) {
            $activeTab = 'all';
        }

        $search = trim((string) $request->query('search', ''));
        $statusFilter = (string) $request->query('status_filter', 'all');
        $sort = (string) $request->query('sort', 'id_desc');

        $query = Complaints::query()->with([
            'complainant:id,firstName,middleName,lastName,contactNumber',
            'respondent:id,firstName,middleName,lastName,contactNumber',
        ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('complainantName', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('details', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'complainant_asc':
                $query->orderBy('complainantName', 'asc');
                break;
            case 'complainant_desc':
                $query->orderBy('complainantName', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('status', 'asc')->latest('id');
                break;
            case 'status_desc':
                $query->orderBy('status', 'desc')->latest('id');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $complaints = $query->paginate(10)->appends($request->query());
        return view('subadmin.complaintRequest', compact(
            'subadmin',
            'complaints',
            'activeTab',
            'search',
            'statusFilter',
            'sort'
        ));
    }

    public function updateComplaint(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:resolved,rejected,on-going',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaints::with('complainant')->findOrFail($id);

        if ($complaint->status === 'resolved') {
            return back()->with('error', 'Resolved complaints can no longer be updated.');
        }

        $complaint->status = $request->input('status');
        $complaint->respondent_id = Auth::id();

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

        if (!empty($complaint->complainant?->email)) {
            Mail::send(new ComplaintStatusUpdateMail($complaint));
        }

        return back()->with('success', 'Complaint updated successfully.');
    }
    public function adminComplaint(): View
        {   
    $subadmin = auth()->user();
    $myComplaints = $subadmin->complaints()->get();
    return view('subadmin.complaint', compact('subadmin', 'myComplaints'));
}
    
}
