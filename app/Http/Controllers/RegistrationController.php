<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName'       => 'required|string|max:70',
            'middleName'      => 'required|string|max:50',
            'lastName'        => 'required|string|max:50',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255', // Remove 'confirmed'    
            'contactNumber'   => 'required|string|digits:11',
            'birthday'        => 'required|date|before:today',
            'proofOfIdentity' => 'nullable|image|mimes:jpg,png,jpeg|max:4096'
        ]);

        $imageData = null;
        if($request->hasFile('proofOfIdentity')){
            $imageData = $request->file('proofOfIdentity')->store('photos', 'public');
        }

        // Check if user exists in residents table
        $resident = Resident::where('firstName', $request->firstName)
            ->where('middleName', $request->middleName)
            ->where('lastName', $request->lastName)
            ->where('contactNo', $request->contactNumber) // Match with contactNo in residents
            ->first();

        $role = "non-resident";
        $status = "pending";

        if($resident){
            $role = "resident";
            $status = "approved";
        }
        
        $user = User::create([
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'firstName'        => $request->firstName,
            'middleName'       => $request->middleName,
            'lastName'         => $request->lastName,
            'contactNumber'    => $request->contactNumber,
            'birthday'         => $request->birthday,
            'proofOfIdentity'  => $imageData,  
            'role'             => $role,
            'registrationDate' => now(),
            'status'           => $status
        ]);

        if($resident){
            $resident->update([
                'user_id' => $user->id
            ]);
        }

        return redirect()
            ->route('login')
            ->with('status', 'Registration successful! Awaiting Administrator Review to Access Our Services');
    }
}