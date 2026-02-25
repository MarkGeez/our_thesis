<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserListController extends Controller
{
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
            return $query-> where(function($q) use ($search){
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
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

        return view($user->role . '.users', compact('user', 'search', 'userList', 'statusFilter', 'roleFilter', 'sort'));
    }


    public function updateRole(Request $request, $id){
        $request->validate(['role' => 'in:admin,subadmin,resident,non-resident']);

        $user = User::findOrFail($id);

        $user->role = $request->role;
        
        $user->save();

        return redirect()->back()->with('success', 'user role updated');
    }


    public function updateStatus(Request $request, $id){
        $user = User::findOrFail($id);
        $request->validate(['status'=> "required"]);
        $user->status = $request->status;
        $user->save();
        
        return redirect()->back()->with('success', 'user status updated');

    }

    public function updateProfile(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contactNumber' => 'required|string|max:20',
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
        
        // Update basic info
        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];
        
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
