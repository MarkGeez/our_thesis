<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function showArchive(){
        $archive = Archive::with('user:id,firstName,lastName')->latest()->get();
        return view("admin.archives",compact("archive"));
    }
}
