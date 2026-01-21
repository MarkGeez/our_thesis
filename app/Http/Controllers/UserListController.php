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

        $userList = User::with('resident:houseNo,street,emergencyContactNo,emergencyContactName,age,sex,parent,enrolled,educationalAttainment,headOfFamily,EncodedBy,user_id')
        ->when($search, function($query, $search){
            return $query-> where(function($q) use ($search){
                $q->where('firstName', 'like', "{$search}")->orWhere('lastName', 'like', "{$search}")->orWhere('id', 'like', "{$search}");
            });
        })->paginate(10);

        return view($user->role . '.users', compact('user', 'search', 'userList'));
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
        // Validate the request
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contactNumber' => 'required|string|max:20',
            'birthday' => 'required|date',
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Find the user
        $user = User::findOrFail($id);
        
        // Update basic info
        $user->email = $validated['email'];
        $user->contactNumber = $validated['contactNumber'];
        $user->birthday = $validated['birthday'];
        
        // Update password if provided
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
        
        $user->save();
        
        return redirect()->route($user->role . '.profile')->with('success', 'Profile updated successfully.');
    }
}
