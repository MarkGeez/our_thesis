<?php

namespace App\Http\Controllers;

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
            
            $request->session()->regenerate();
            return $this->redirect();
        }


        return back()->withInput()->with('status', 'Invalid Login Credentials');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}
