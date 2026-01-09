<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Facades\Hash;
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

        $status = $request->input('status');
        $user->status = $status;

        $user->save();
        
        return redirect()->back()->with('success', 'user status updated');

    }

    public function updateProfile(Request $request, $id)
{
   
    
    // Validate the request
    $validated = $request->validate([
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'contactNumber' => 'required|string|max:11',
        'birthday' => 'required|date',
        'current_password' => 'required_with:password',
        'password' => 'nullable|min:6|confirmed',
    ]);
    
    // Find the user
    $user = User::findOrFail($id);
    
    // Update basic info
    $user->email = $validated['email'];
    $user->contactNumber = $validated['contactNumber'];
    $user->birthday = $validated['birthday'];
    
    // Update password if provided
    if (!empty($validated['password'])) {
        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $user->password = Hash::make($validated['password']);
    }
    
    $user->save();
    
    return back()->with('success', 'Profile updated successfully.');
}
}
