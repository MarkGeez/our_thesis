<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function ShowLoginForm(): View{
        return view('auth.login');
    }

    private function resolveLinkedResident($user): ?Resident
    {
        $resident = Resident::where('user_id', $user->id)->first();

        if (!$resident) {
            $resident = Resident::matchingUser($user)->first();
        }

        return $resident;
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

        
 
    

        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $resident = $this->resolveLinkedResident($user);

            if ($resident && strtolower((string) $resident->status) === 'inactive') {
                Auth::logout();

                return back()
                    ->withInput($request->only('email'))
                    ->with('status', 'Login is unavailable because your linked resident record is marked inactive.');
            }
            
            $request->session()->regenerate();
            return $this->redirect();
        }


        return back()->withInput()->with('status', 'Invalid Login Credentials. Please try again.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}
