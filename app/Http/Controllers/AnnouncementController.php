<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function showAnnouncementForm(): View
    {
        
        return view("admin.create-announcement");
    }

    public function createAnnouncement(Request $request): RedirectResponse
    {
        $request->validate([
            "title" => "string|max:255|required", 
            "image" => "nullable|image|mimes:png,jpg,jpeg|max:4096", 
            "details" => "required|string", 
            "eventTime" => "nullable|date",
            "eventEnd" => "nullable|date|after_or_equal:eventTime", 
        ]);

        $imageData = null;
        if($request->hasFile("image")){
            $imageData = $request->file("image")->store("photos", "public");
        }

        Announcement::create([
            "user_id" => Auth::id(),
            "title" => $request->title, 
            "image" => $imageData,
            "details" => $request->details,
            "eventTime" => $request->eventTime,
            "eventEnd" => $request->eventEnd,
        ]);

        // Add the missing return statement
        return redirect()->back()->with('success', 'Announcement created successfully!');
        

      
    }
}