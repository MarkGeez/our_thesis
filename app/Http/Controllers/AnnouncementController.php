<?php

namespace App\Http\Controllers;

use App\Services\ArchiveService;
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

    public function showEdit($id):View{
        $announcement = Announcement::findOrFail($id);
        $role = Auth::user()->role;
        $route = $role . ".edit-announcement";
        return view($route, compact("announcement"));
    }

    public function update(Request $request, $id){
        $announcement = Announcement::find($id);

       
        $request->validate([
            "title" => "string|max:255|required", 
            "details" => "required|string", 
            "eventTime" => "nullable|date",
            "eventEnd" => "nullable|date|after_or_equal:eventTime", 
        ]);
       
       
       

        $announcement->title= $request->title;
        
        $announcement->details= $request->details;
        $announcement->eventTime= $request->eventTime;
        $announcement->eventEnd= $request->eventEnd;

        $announcement->save();
        $role = Auth::user()->role;
        $route = $role . ".dashboard";

        return redirect()->route($route)->with("success", "Announcement updated successfully");


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

        $role = Auth::user()->role;
        $route = $role . ".dashboard";

        return redirect()->route($route)->with('success', 'Announcement created successfully!');
        

      
    }

    public function archive($id, ArchiveService $archiveService){
        $announcement = Announcement::findOrFail($id);

        $archiveService->archive($announcement, "Old announcement");
       
        $role = Auth::user()->role;
        $route = $role . ".dashboard";
        return redirect()->route($route)->with('success',"Announcement archived successfully");

    }
}