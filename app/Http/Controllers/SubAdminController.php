<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Complaints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SubAdminController extends Controller
{
    public function dashboard(): View
    {
        $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
        $subadmin = Auth::user();
            
        return view("subadmin.dashboard", compact('announcement', 'subadmin'));
    }

    public function profile(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.profile", compact('subadmin'));
    }

    public function blotterRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.blotterRequest", compact('subadmin'));
    }

    public function certificateRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.certificateRequest", compact('subadmin'));
    }

    public function clearanceRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.clearanceRequest", compact('subadmin'));
    }

    public function serviceRequest(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.serviceRequest", compact('subadmin'));
    }
    public function adminBlotter(): View
    {
        $subadmin = Auth::user();
        return view("subadmin.adminBlotter", compact('subadmin'));
    }
    public function complaintRequest(): View
    {
        $subadmin = Auth::user();
        $complaints = Complaints::orderByDesc('created_at')->get();
        return view('subadmin.complaintRequest', compact('subadmin', 'complaints'));
    }

    public function updateComplaint(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:resolved,rejected,on-going',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaints::findOrFail($id);
        $complaint->status = $request->input('status');
        $complaint->remarks = $request->input('remarks');
        $complaint->save();

        return back()->with('success', 'Complaint updated successfully.');
    }
}