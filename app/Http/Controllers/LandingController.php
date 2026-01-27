<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\Announcement;

class LandingController extends Controller
{
    public function display()
    {
        $positions = [
            'Barangay Chairman',
            'Barangay Secretary',
            'Barangay Treasurer',
            'Kagawad 1',
            'Kagawad 2',
            'Kagawad 3',
            'Kagawad 4',
            'Kagawad 5',
            'Kagawad 6',
            'Kagawad 7',
            'SK Chairman',
            'SK Kagawad 1',
            'SK Kagawad 2',
            'SK Kagawad 3',
            'SK Kagawad 4',
            'SK Kagawad 5',
            'SK Kagawad 6',
            'SK Kagawad 7',
        ];

        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $positions)
            ->get()
            ->keyBy('position');
        
        $announcements = Announcement::with('user:id,firstName,lastName')
            ->latest()
            ->limit(2)
            ->get();
            
        return view('index', compact('positions', 'officialsByPosition', 'announcements'));
    }
    
    
}
