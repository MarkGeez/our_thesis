<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\Announcement;

class LandingController extends Controller
{
    public function display(){
         $officials = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->orderByRaw("
                CASE position
                    WHEN 'Chairman' THEN 1
                    WHEN 'Secretary' THEN 2
                    WHEN 'Treasurer' THEN 3
                    WHEN 'Kagawad' THEN 4
                    WHEN 'Sk Chairman' THEN 5
                    WHEN 'Sk Kagawad' THEN 6
                    ELSE 99
                END
            ")
            ->paginate(30);
        
        $announcements = Announcement::with('user:id,firstName,lastName')
            ->latest()
            ->limit(2)
            ->get();
            
        return view('index', compact('officials', 'announcements'));
    }
    
    
}
