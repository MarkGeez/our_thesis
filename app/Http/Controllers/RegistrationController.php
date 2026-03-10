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
            'middleName'      => 'nullable|string|max:50',
            'lastName'        => 'required|string|max:50',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'password'        => 'required|string|min:8|max:255',
            'contactNumber'   => 'required|string|digits:11',
            'birthday'        => 'required|date|before:today',
            'proofOfIdentity' => 'required|image|mimes:jpg,png,jpeg|max:4096'
        ]);

        $firstName = Resident::normalizeNamePart($request->firstName);
        $middleName = Resident::normalizeNamePart($request->middleName);
        $lastName = Resident::normalizeNamePart($request->lastName);

        // Check for duplicate name with approved status
        $existingUser = User::whereRaw('LOWER(firstName) = ?', [$firstName])
            ->whereRaw(
                "LOWER(COALESCE(NULLIF(TRIM(middleName), ''), '')) = ?",
                [$middleName]
            )
            ->whereRaw('LOWER(lastName) = ?', [$lastName])
            ->where('status', 'approved')
            ->first();
        if ($existingUser) {
            return back()
                ->withInput()
                ->with('auth_error', 'A user with the same name is already registered and approved.');
        }

        // Email uniqueness is already validated by unique rule above, but double check for safety
        if (\App\Models\User::where('email', $request->email)->exists()) {
            return back()
                ->withInput()
                ->with('auth_error', 'This email is already registered.');
        }

        $imageData = null;
        if($request->hasFile('proofOfIdentity')){
            $imageData = $request->file('proofOfIdentity')->store('photos', 'public');
        }

        // Check if user exists in residents table
        $resident = Resident::matchingIdentity(
            $request->firstName,
            $request->middleName,
            $request->lastName,
            $request->birthday
        )
            ->first();

        $role = "non-resident";
        $status = "pending";
        if($resident){
            $role = "resident";
            $status = "pending";
        }

        $user = User::create([
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'firstName'        => $firstName,
            'middleName'       => $middleName,
            'lastName'         => $lastName,
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


        return redirect()->route('login')->with('auth_success', 'Registration successful. Please wait up to 3 working days while officials review your registration request.');
    }
}
