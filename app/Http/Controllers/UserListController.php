<?php

namespace App\Http\Controllers;

use App\Mail\UserAccountStatusUpdateMail;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserListController extends Controller
{
    private function syncResidentLink(User $user, string $role): void
    {
        if (!in_array($role, ['admin', 'subadmin', 'resident'], true)) {
            return;
        }

        $resident = Resident::where('user_id', $user->id)->first();

        if (!$resident) {
            $resident = Resident::matchingUser($user)
                ->first();
        }

        if ($resident && (int) $resident->user_id !== (int) $user->id) {
            $resident->update(['user_id' => $user->id]);
        }
    }

    public function showUsers(Request $request){

        $user= auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }

        $search = $request->input('search');
        $statusFilter = $request->input('status_filter', 'all');
        $roleFilter = $request->input('role_filter', 'all');
        $sort = $request->input('sort', 'id_desc');
        
         // $userList = User::with('resident:houseNo,street,emergencyContactNo,emergencyContactName,age,sex,parent,enrolled,educationalAttainment,headOfFamily,EncodedBy,user_id')
        $userList = User::with('resident:user_id,contactNo,birthday,age,sex,parent,enrolled,educationalAttainment,religion,headOfFamily,emergencyContactNo,emergencyContactName')
        ->when($search, function($query, $search){
            // Extract numeric ID from formatted ID (e.g., "USER-2026-000001" -> "1")
            $formattedIdNumericPart = null;
            if (preg_match('/^[A-Z]+-\d+-(\d+)$/', strtoupper($search), $matches)) {
                $formattedIdNumericPart = (int) $matches[1];
            }

            return $query-> where(function($q) use ($search, $formattedIdNumericPart){
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");

                if ($formattedIdNumericPart !== null) {
                    $q->orWhere('id', (int) $formattedIdNumericPart);
                }
            });
        })
        ->when(in_array($statusFilter, ['approved', 'pending', 'declined', 'rejected'], true), function ($query) use ($statusFilter) {
            if ($statusFilter === 'declined') {
                return $query->whereIn('status', ['declined', 'rejected']);
            }
            return $query->where('status', $statusFilter);
        })
        ->when(in_array($roleFilter, ['admin', 'subadmin', 'resident', 'non-resident'], true), function ($query) use ($roleFilter) {
            return $query->where('role', $roleFilter);
        });

        switch ($sort) {
            case 'id_asc':
                $userList->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $userList->orderBy('lastName', 'asc')->orderBy('firstName', 'asc');
                break;
            case 'name_desc':
                $userList->orderBy('lastName', 'desc')->orderBy('firstName', 'desc');
                break;
            case 'role_asc':
                $userList->orderBy('role', 'asc')->orderBy('id', 'desc');
                break;
            case 'role_desc':
                $userList->orderBy('role', 'desc')->orderBy('id', 'desc');
                break;
            case 'status_asc':
                $userList->orderBy('status', 'asc')->orderBy('id', 'desc');
                break;
            case 'status_desc':
                $userList->orderBy('status', 'desc')->orderBy('id', 'desc');
                break;
            case 'id_desc':
            default:
                $userList->orderBy('id', 'desc');
                break;
        }

        $userList = $userList->paginate(20)->appends($request->query());
        $maxAdmins = 7;
        $currentAdminCount = User::where('role', 'admin')->count();
        $adminLimitReached = $currentAdminCount >= $maxAdmins;
        $maxSubadmins = 7;
        $currentSubadminCount = User::where('role', 'subadmin')->count();
        $subadminLimitReached = $currentSubadminCount >= $maxSubadmins;
        

        $hours = 72;
        $pendingUsersCount = User::where('status', 'pending')->count();
        $pendingOver72HoursCount = User::where('status', 'pending')
            ->whereNotNull('created_at')
            ->where('created_at', '<=', Carbon::now()->subHours($hours))
            ->count();
        $hasPendingUsers = $pendingUsersCount > 0;
        $hasOverduePendingUsers = $pendingOver72HoursCount > 0;
        // Backward compatibility for existing blade checks.
        $pendingUser = $hasPendingUsers;

       
        return view($user->role . '.users', compact(
            'user',
            'search',
            'userList',
            'statusFilter',
            'roleFilter',
            'sort',
            'maxAdmins',
            'currentAdminCount',
            'adminLimitReached',
            'maxSubadmins',
            'currentSubadminCount',
            'subadminLimitReached',
            'pendingUser',
            'pendingUsersCount',
            'pendingOver72HoursCount',
            'hasPendingUsers',
            'hasOverduePendingUsers'
        ));
    }


    public function updateRole(Request $request, $id){
        $request->validate(['role' => 'in:admin,subadmin,resident,non-resident']);

        $actor = auth()->user();
        $user = User::findOrFail($id);
        $requestedRole = $request->role;

        // Admins cannot change their own role from the users module.
        if ($actor && $actor->role === 'admin' && (int) $actor->id === (int) $user->id) {
            return redirect()->back()->withErrors([
                'role' => 'You cannot modify your own role.',
            ]);
        }
        
        $roleLimits = [
            'admin' => ['max' => 7, 'label' => 'Admin'],
            'subadmin' => ['max' => 7, 'label' => 'Sub-admin'],
        ];

        // Enforce role caps during role updates.
        if (isset($roleLimits[$requestedRole]) && $user->role !== $requestedRole) {
            $currentRoleCount = User::where('role', $requestedRole)
                ->where('id', '!=', $user->id)
                ->count();

            if ($currentRoleCount >= $roleLimits[$requestedRole]['max']) {
                return redirect()->back()->withErrors([
                    'role' => 'Only ' . $roleLimits[$requestedRole]['max'] . ' users can have the ' . $roleLimits[$requestedRole]['label'] . ' role at the same time.',
                ]);
            }
        }

        $user->role = $requestedRole;
        $user->save();
        $this->syncResidentLink($user, $requestedRole);

        return redirect()->back()->with('success', 'user role updated');
    }


    public function updateStatus(Request $request, $id){
        $user = User::findOrFail($id);
        $request->validate(['status'=> "required"]);
        $newStatus = $request->status;
        $oldStatus = $user->status;

        $shouldNotifyCurrentUser = $oldStatus === 'pending' && in_array($newStatus, ['approved', 'declined', 'rejected'], true);

        if ($newStatus === 'approved') {
            // Bind user to resident if exists
            $resident = \App\Models\Resident::matchingUser($user)
                ->first();
            if ($resident) {
                // User -> resident is a hasOne relation; assign the FK on resident.
                $resident->user_id = $user->id;
                $resident->save();
            }
            // Decline all other users with same name and birthday
            $duplicatePendingUsers = User::where('id', '!=', $user->id)
                ->where('firstName', $user->firstName)
                ->where('middleName', $user->middleName)
                ->where('lastName', $user->lastName)
                ->where('birthday', $user->birthday)
                ->where('status', 'pending')
                ->get();

            User::whereIn('id', $duplicatePendingUsers->pluck('id'))
                ->update(['status' => 'declined']);

            foreach ($duplicatePendingUsers as $duplicatePendingUser) {
                $duplicatePendingUser->status = 'declined';
                $this->sendAccountStatusEmail($duplicatePendingUser);
            }
        }
        $user->status = $newStatus;
        $user->save();

        if ($shouldNotifyCurrentUser) {
            $this->sendAccountStatusEmail($user);
        }

        return redirect()->back()->with('success', 'user status updated');
    }

    private function sendAccountStatusEmail(User $user): void
    {
        if (empty($user->email)) {
            return;
        }

        Mail::send(new UserAccountStatusUpdateMail($user));
    }

    public function updateProfile(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);
        $linkedResident = $user->resident ?: Resident::matchingUser($user)->first();

        $rules = [
            'firstName' => 'required|string|max:70',
            'middleName' => 'nullable|string|max:70',
            'lastName' => 'required|string|max:70',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contactNumber' => 'required|string|max:11|',
            'birthday' => 'required|date|before:today',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'proofOfIdentity' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];

        // If password change is attempted, validate only the new password + confirmation
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        // Validate the request
        $validated = $request->validate($rules);

        $validated['firstName'] = strtolower(trim((string) $validated['firstName']));
        $validated['middleName'] = strtolower(trim((string) ($validated['middleName'] ?? '')));
        $validated['lastName'] = strtolower(trim((string) $validated['lastName']));
        
        // Update basic info
        $user->firstName = $validated['firstName'];
        $user->middleName = $validated['middleName'];
        $user->lastName = $validated['lastName'];
        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];
        
        // Keep the linked resident profile aligned with account-level identity fields.
        if ($linkedResident) {
            $linkedResident->user_id = $user->id;
            $linkedResident->firstName = $validated['firstName'];
            $linkedResident->middleName = $validated['middleName'];
            $linkedResident->lastName = $validated['lastName'];
            $linkedResident->contactNo = $validated['contactNumber'];
            $linkedResident->birthday = $validated['birthday'];
            $linkedResident->age = Carbon::parse($validated['birthday'])->age;
            $linkedResident->save();
        }

        // Update password if provided
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
        
        return redirect()->route($user->role . '.profile')->with('success', 'Profile updated successfully.');
    }
}
