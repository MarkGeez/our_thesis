<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;

class LandingController extends Controller
{
    public function display(){
         $officials = Official::with('resident:id,firstName,middleName,lastName,image_path')->paginate(30);
        return view('index', compact('officials'));
    }
}
