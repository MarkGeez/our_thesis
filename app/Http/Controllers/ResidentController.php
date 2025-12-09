<?php
namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Announcement;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    
     public function dashboard()
    {
        $resident = auth()->user();
        $announcements = Announcement::with('user:id,firstName,lastName')->latest()->get();
        return view('resident.dashboard', compact('resident', 'announcements'));
    }

    public function profile()
    {
        $resident = auth()->user();
        return view('resident.profile', compact('resident'));
    }


    

    public function blotter()
    {
               $resident = auth()->user();

        return view('resident.blotter', compact('resident'));
    }

    public function certificate()
    {
                $resident = auth()->user();

        return view('resident.certificate', compact('resident'));
    }

    public function clearance()
    {
                $resident = auth()->user();

        return view('resident.clearance', compact('resident'));
    }

    public function service()
    {
                $resident = auth()->user();

        return view('resident.service', compact('resident'));
    }

    public function complaint()
    {
        $resident = auth()->user();
        return view('resident.complaint', compact('resident'));
    }

    public function feedback()
    {
        $resident = auth()->user();
        return view('resident.feedback', compact('resident'));
    }

    public function contactus()
    {
        $resident = auth()->user();
        return view('resident.contactus', compact('resident'));
    }

    public function aboutus()
    {
        $resident = auth()->user();
        return view('resident.aboutus', compact('resident'));
    }
}