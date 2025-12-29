<?php

namespace App\Http\Controllers;
use App\Http\Controllers\NonResident;
use Illuminate\Http\Request;
use App\Models\Announcement;  // Add this line

class NonResidentController extends Controller
{
    public function dashboard()
    {
        $nonResident = auth()->user();
        $announcements = Announcement::with('user:id,firstName,lastName')->latest()->get();
        return view('non-resident.dashboard', compact('nonResident', 'announcements'));
    }
    public function profile()
    {
        $nonResident = auth()->user();
        return view('non-resident.profile', compact('nonResident'));
    }


    

    public function blotter()
    {
               $nonResident = auth()->user();

        return view('non-resident.blotter', compact('nonResident'));
    }
    public function contactus()
    {
        $nonResident = auth()->user();
        return view('non-resident.contactus', compact('nonResident'));
    }

    public function aboutus()
    {
        $nonResident = auth()->user();
        return view('non-resident.aboutus', compact('nonResident'));
    }
}
