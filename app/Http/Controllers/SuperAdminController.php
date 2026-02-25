<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;

class SuperAdminController extends Controller
{
    public function displayUsers()
{
    $currentUser = auth()->user();

    $users = \App\Models\User::query()

        // Hide superadmin from everyone
        ->where('role', '!=', 'superadmin')

        // Prevent user from seeing himself (optional safety)
        ->where('id', '!=', $currentUser->id)

        ->get();

    return view('superadmin.users', compact('users'));
}

public function updateRole(Request $request, $id){
        $request->validate(['role' => 'in:admin,subadmin,resident,non-resident']);

        $user = User::findOrFail($id);

        $user->role = $request->role;
        
        $user->save();

        return redirect()->back()->with('success', 'user role updated');
    
}
}
