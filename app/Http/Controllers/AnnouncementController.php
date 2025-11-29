<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
     public function showAnnouncement(): View
    {
        $announcements = Announcement::where('archiveTime', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view("resident.dashboard", compact('announcements'));
    }

    public function createAnnouncement(Request $request): RedirectResponse
    {
       
        $request->validate([
            "title" => "string|max:255|required", 
            
            "image" => "nullable|image|mimes:png,jpg,jpeg|max:4096", 

            "details" => "required|string", 

            "eventTime" => "nullable|date",

            "eventEnd" => "nullable|date|after_or_equal:eventTime", 
            
            "archiveTime" => "required|date|after:eventTime|after:eventEnd", 
        ]);

        $imageData=null;
        if($request->hasFile("image")){
            $imageData = $request->file("image")->store("photos", "public");
        };

        Announcement::create([
                "title" => $request->title, 
                "image" => $imageData,
                "details" => $request->details,
                "eventTime" => $request->eventTime,
                "eventEnd" => $request->eventEnd,
                "archiveTime" => $request->archiveTime,
            ]);

    }

    

}
