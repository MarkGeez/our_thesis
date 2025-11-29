<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    public function dashboard(): View
    {
        $announcements = Announcement::where('archiveTime', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
   
        $resident = Auth::user();
            
        return view("resident.dashboard", compact('announcements', 'resident'));
    }
    
    public function profile(): View
    {
        $resident = Auth::user();
        return view("resident.profile", compact('resident'));
    }
    
    public function blotter(): View
    {
        $resident = Auth::user();
        return view("resident.blotter", compact('resident'));
    }
    
    public function certificate(): View
    {
        $resident = Auth::user();
        return view("resident.certificate", compact('resident'));
    }
    
    public function clearance(): View
    {
        $resident = Auth::user();
        return view("resident.clearance", compact('resident'));
    }
    
    public function service(): View
    {
        $resident = Auth::user();
        return view("resident.service", compact('resident'));
    }
    
    public function complaint(): View
    {
        $resident = Auth::user();
        return view("resident.complaint", compact('resident'));
    }
    
    public function feedback(): View
    {
        $resident = Auth::user();
        return view("resident.feedback", compact('resident'));
    }
    
    public function aboutus(): View
    {
        $resident = Auth::user();
        return view("resident.aboutus", compact('resident'));
    }
    
    public function contactus(): View
    {
        $resident = Auth::user();
        return view("resident.contactus", compact('resident'));
    }
}