<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Feedbacks;
use App\Models\Blotter;
use App\Models\Setting;
use App\Models\Resident;
use App\Models\Official;
use App\Models\Position;
use App\Models\User;

use App\Models\FamilyMember;


use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive;
use App\Models\CertificateRequest;

class AdminController extends Controller
{
    public function dashboard(): View
    {
    
    $announcement= Announcement::with('user:id,firstName,lastName')->latest()->get();
    $admin = Auth::user();
    $residentCount = Resident::count();
    $maleCount = Resident::where('sex', 'male')->count();
    $femaleCount = Resident::where('sex', 'female')->count();
    $seniorCount = Resident::where('age', '>=', 60)->count();
    $userCount = User::count();
    return view("admin.dashboard", compact('announcement', 'admin', 'residentCount', 'maleCount', 'femaleCount', 'seniorCount', 'userCount'));
    }
    
    
    public function profile()
{
    $user = auth()->user();
    
    // Try to find resident by matching firstName, lastName
    $resident = Resident::with('households.house.street')
                        ->where('firstName', $user->firstName)
                        ->where('lastName', $user->lastName)
                        ->first();
     $members = FamilyMember::where('encoded_by', $user->id)->orderBy('firstName')->get();
    return view('admin.profile', compact('user', 'resident', 'members'));
}
    public function adminComplaint():View{
        $admin = Auth::user();

        $myComplaints = $admin->complaints()->with('respondent')->get();
        return view("admin.adminComplaint", compact('admin', 'myComplaints'));
    }
    
    public function blotterRequest(): View
    {
        $admin = Auth::user();
        $blotters= Blotter::latest()->paginate(10);
        return view("admin.blotterRequest", compact('admin', 'blotters'));
    }
    public function adminServices(){
        $admin = Auth::user();
        return view("admin.adminServices", compact('admin'));
    }
    public function certificateRequest(): View
    {
        $admin = Auth::user();
        $requests = CertificateRequest::with(['user:id,firstName,middleName,lastName,role', 'resident:id,firstName,middleName,lastName,houseNo,street'])
            ->latest()
            ->get();
        
        // Get request stats for each user
        $requestStats = CertificateRequest::selectRaw('user_id, COUNT(*) as total, 
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "declined" THEN 1 ELSE 0 END) as declined,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');
        
        return view("admin.certificateRequest", compact('admin', 'requests', 'requestStats'));
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
    
    
    public function announcements(){
     $admin = Auth::user();
    $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
    return view('admin.announcements', compact('admin', 'announcement'));
}

    public function feedbackRequest(): View
    {
        $admin = Auth::user();
        $feedbacks = Feedbacks::with('user:id,firstName,lastName')->oldest()->paginate(10);
        return view("admin.feedbackRequest", compact('admin', 'feedbacks'));
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
        $settings = Setting::first();
        return view("admin.settings", compact('admin', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'barangay_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'theme' => 'nullable|string|max:7',
            'contact_address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $settings = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && file_exists(public_path($settings->logo_path))) {
                unlink(public_path($settings->logo_path));
            }

            // Store new logo
            $file = $request->file('logo');
            $path = $file->store('uploads/logo', 'public');
            $settings->logo_path = 'storage/' . $path;
        }

        $settings->barangay_name = $request->barangay_name;
        if ($request->filled('theme')) {
            $settings->theme = $request->theme;
        }
        if ($request->filled('contact_address')) {
            $settings->contact_address = $request->contact_address;
        }
        if ($request->filled('contact_number')) {
            $settings->contact_number = $request->contact_number;
        }
        if ($request->filled('contact_email')) {
            $settings->contact_email = $request->contact_email;
        }
        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
    public function barangayOfficials(): View
    {
        $admin = Auth::user();
        $positions = Position::get();

        return view("admin.barangayOfficials", compact('admin', 'positions'));
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
   

    public function adminCertificate(): View
    {
        $admin = Auth::user();
        $requests = $admin->certificateRequests()->latest()->get();
        return view("admin.adminCertificate", compact('admin', 'requests'));
    }

    

    
    public function archives(): View
    {
    $admin = Auth::user();
    $archive = Archive::latest()->get();
    return view("admin.archives", compact('admin', 'archive'));
    }

}