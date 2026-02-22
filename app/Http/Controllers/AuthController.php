<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class AuthController extends Controller
{
    public function ShowLoginForm(): View{
        return view('auth.login');
    }

    private function redirect(): RedirectResponse
{
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect("/admin/dashboard");

        case 'subadmin':
            return redirect("/subadmin/dashboard");

        case 'resident':
            return redirect("/resident/dashboard");

        case 'non-resident':
            return redirect("/non-resident/dashboard");

        default:
            return redirect("/");
    }
}
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => "required"
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('auth_error', 'Email not found. Please check your email address.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput()
                ->with('auth_error', 'Incorrect password. Please try again.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Log user login
            \App\Services\ActiveLogger::log(
                'User',
                'login',
                $user->id,
                'User logged in'
            );
            return $this->redirect();
        }

        return back()
            ->withInput()
            ->with('auth_error', 'Invalid email or password. Please check your credentials and try again.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        // Log user logout
        if ($user) {
            \App\Services\ActiveLogger::log(
                'User',
                'logout',
                $user->id,
                'User logged out'
            );
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


}
