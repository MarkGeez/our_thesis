<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{
    private function authorizeResident($id)
    {
        if (auth()->user()->id != $id) {
            abort(403, "Cant access someone's dashboard");
        }

        return auth()->user();
    }

    public function dashboard($id)
    {
        $resident = $this->authorizeResident($id); 
        return view('resident.dashboard', compact('resident'));
    }

    public function profile($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.profile', compact('resident'));
    }

    public function announcement($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.announcement', compact('resident'));
    }

    public function blotter($id)
    {
        $resident = $this->authorizeResident($id); 
        return view('resident.blotter', compact('resident'));
    }

    public function certificate($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.certificate', compact('resident'));
    }

    public function clearance($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.clearance', compact('resident'));
    }

    public function service($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.service', compact('resident'));
    }

    public function complaint($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.complaint', compact('resident'));
    }

    public function feedback($id)
    {
        $resident = $this->authorizeResident($id);
        return view('resident.feedback', compact('resident'));
    }

    public function contactus($id){
        $resident = $this->authorizeResident($id);
        return view('resident.contactus', compact('resident'));
    }
}