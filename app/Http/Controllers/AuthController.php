<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Resident;

class AuthController extends Controller
{
    public function ShowLoginForm(): View{
        return view('auth.login');
    }

    private function syncResidentRole(User $user): void
    {
        if ($user->role !== 'non-resident') {
            return;
        }

        $resident = Resident::where('user_id', $user->id)->first();

        if (!$resident) {
            $resident = Resident::matchingUser($user)
                ->first();
        }

        if ($resident) {
            if (!$resident->user_id) {
                $resident->update(['user_id' => $user->id]);
            }
            $user->update(['role' => 'resident']);
        }
    }

    private function redirect(): RedirectResponse
{
    $user = Auth::user();
    $this->syncResidentRole($user);
    $user->refresh();

    switch ($user->role) {
        case 'superadmin':
            return redirect('/superadmin/users');
        case 'admin':
            return redirect('/admin/dashboard');
        case 'subadmin':
            return redirect('/subadmin/dashboard');
        case 'resident':
            return redirect('/resident/dashboard');
        case 'non-resident':
            return redirect('/non-resident/dashboard');
        default:
            return redirect('/');
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

        // Block login for pending or declined users
        if ($user->status === 'pending') {
            $created = $user->created_at;
            $msg = 'Your account is still pending for verification.';
            if ($created) {
                $hoursPending = (int) now()->diffInHours($created);
                if ($hoursPending >= 72) {
                    $msg .= ' Your registration has been pending for more than 72 hours. Please contact the barangay for assistance or follow-up.';
                } else {
                    $msg .= ' Please wait while the barangay reviews your registration request.';
                }
            }
            return back()->withInput()->with('auth_error', $msg);
        }
        if ($user->status === 'declined') {
            return back()->withInput()->with('auth_error', 'Your account has been declined and cannot login.');
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
