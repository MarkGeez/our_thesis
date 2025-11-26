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

    private function redirect(): RedirectResponse{
        $credential = Auth::user();

        if($credential->role === "resident"){
            return redirect("resident/{$credential->id}/dashboard");
        }

        return redirect("/");
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


}
