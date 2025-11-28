<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function showRegister(): View
    {
        return view(view: 'auth.register');
    }

   
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName'       => 'required|string|max:70',
            'middleName'      => 'required|string|max:50',
            'lastName'        => 'required|string|max:50',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'password'        => 'required|string|min:8|max:255',
            'contactNumber'   => 'required|string|digits:11',
            'birthday'        => 'required|date|before:today',
            'role'            => 'required|in:yes,no',
            'proofOfIdentity' => 'required|image|mimes:jpg,png,jpeg|max:4096',
        ]);

        $role = $request->role === 'yes' ? 'resident' : 'non-resident';
        
        $imageData = null;
        if($request->hasFile('proofOfIdentity')){
            $imageData = $request->file('proofOfIdentity')->store('photos', 'public');
        }

        User::create([
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'firstName'        => $request->firstName,
            'middleName'       => $request->middleName,
            'lastName'         => $request->lastName,
            'contactNumber'     => $request->contactNumber,
            'birthday'         => $request->birthday,
            'proofOfIdentity'  => $imageData,  
            'role'             => $role,
            'registrationDate' => now(),
            'status'           => 'pending'
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Registration successful! Awaiting Administrator Review to Access Our Services');
    }
    
}
