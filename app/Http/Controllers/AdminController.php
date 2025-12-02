<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Announcement;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
        $admin = Auth::user();
            
        return view("admin.dashboard", compact('announcement', 'admin'));
    }
    
    
    public function profile(): View
    {
        $admin = Auth::user();
        return view("admin.profile", compact('admin'));
    }
    
    public function blotter(): View
    {
        $admin = Auth::user();
        return view("admin.blotter", compact('admin'));
    }
    
    public function certificate(): View
    {
        $admin = Auth::user();
        return view("admin.certificate", compact('admin'));
    }
    
    public function clearance(): View
    {
        $admin = Auth::user();
        return view("admin.clearance", compact('admin'));
    }
    
    public function service(): View
    {
        $admin = Auth::user();
        return view("admin.service", compact('admin'));
    }
    
    public function complaint(): View
    {
        $admin = Auth::user();
        return view("admin.complaint", compact('admin'));
    }
    
    public function feedback(): View
    {
        $admin = Auth::user();
        return view("admin.feedback", compact('admin'));
    }
    
    public function aboutus(): View
    {
        $admin = Auth::user();
        return view("admin.aboutus", compact('admin'));
    }
    
    public function contactus(): View
    {
        $admin = Auth::user();
        return view("admin.contactus", compact('admin'));
    }
}



