<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function showArchive(){
        $archive = Archive::latest()->get();
        return view("admin.archives",compact("archive"));
    }
}
