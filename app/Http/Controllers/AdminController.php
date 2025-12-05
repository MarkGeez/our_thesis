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
    
    public function blotterRequest(): View
    {
        $admin = Auth::user();
        return view("admin.blotterRequest", compact('admin'));
    }
    
    public function certificateRequest(): View
    {
        $admin = Auth::user();
        return view("admin.certificateRequest", compact('admin'));
    }
    
    public function clearanceRequest(): View
    {
        $admin = Auth::user();
        return view("admin.clearanceRequest", compact('admin'));
    }
    
    public function serviceRequest(): View
    {
        $admin = Auth::user();
        return view("admin.serviceRequest", compact('admin'));
    }
    
    public function complaintRequest(): View
    {
        $admin = Auth::user();
        return view("admin.complaintRequest", compact('admin'));
    }
    
    public function feedbackRequest(): View
    {
        $admin = Auth::user();
        return view("admin.feedbackRequest", compact('admin'));
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
    public function settings(): View
    {
        $admin = Auth::user();
        return view("admin.settings", compact('admin'));
    }
    public function barangayOfficials(): View
    {
        $admin = Auth::user();
        return view("admin.barangayOfficials", compact('admin'));
    }
     public function census(): View
    {
        $admin = Auth::user();
        return view("admin.census", compact('admin'));
    }
     public function users(): View
    {
        $admin = Auth::user();
        return view("admin.users", compact('admin'));
    }
     public function reports(): View
    {
        $admin = Auth::user();
        return view("admin.reports", compact('admin'));
    }
    public function adminBlotter(): View
{
    $admin = Auth::user();
    return view("admin.adminBlotter", compact('admin'));
}

<<<<<<< HEAD
}
=======

     public function adminCertificate(): View
    {
        $admin = Auth::user();
        return view("admin.adminCertificate", compact('admin'));
    }
         public function adminServices(): View
    {
        $admin = Auth::user();
        return view("admin.adminServices", compact('admin'));
    }
         public function adminComplaint(): View
    {
        $admin = Auth::user();
        return view("admin.adminComplaint", compact('admin'));
    }
        
     public function activityLogs(): View
    {
        $admin = Auth::user();
        return view("admin.activityLogs", compact('admin'));
    }
    public function showAnnouncementForm(): View
    {
        return view('admin.create-announcement', [
            'admin' => auth()->user(),
        ]);
    }

}
>>>>>>> f54c290f0ba724f4655e264294db60b35e66ed26
