<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Complaints;

class ComplaintController extends Controller
{

    public function submitComplaint(Request $request):RedirectResponse{
        $user= Auth::user();


        $request->validate([
            "address"=> "required|string|max:100",
            "details"=> "required|string|max:10000"
        ]);

        Complaints::create([


            "complainant_id"=> $user->id,
            "complainantName"=>  $user->firstName . ", " . $user->lastName,
            "address"=> $request->address,
            "details"=> $request->details,
            "respondent_id"=> null,
            "status" => "pending"

        ]);

        return redirect()->back()->with('success', 'Complaint submitted successfully!');

    }

    public function showComplaints(){
        $user= Auth::user();
        $activeTab = request('tab', 'all');
        if (!in_array($activeTab, ['all', 'pending', 'on-going', 'rejected', 'resolved'], true)) {
            $activeTab = 'all';
        }

        $query = Complaints::query()->latest();
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }

        $complaints = $query->paginate(10)->appends(['tab' => $activeTab]);
        $route = $user->role . ".complaintRequest";
        return view($route, compact ('complaints', 'activeTab'));
        
    }

    public function updateStatus(Request $request, $id){
        $complaint = Complaints::findOrFail($id);
        $respondent = Auth::user()->id;

        $request->validate([
            "status"=> "required|in:resolved,on-going,rejected",
            "remarks"=> "nullable|string|max:1000",
        ]);

        $complaint->status = $request->status;
        $complaint->respondent_id = $respondent;

        $newRemarks = trim((string) $request->remarks);
        if ($newRemarks !== '') {
            $user = Auth::user();
            $remarkerName = trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? ''));
            if ($remarkerName === '') {
                $remarkerName = $user->name ?? $user->email ?? 'Unknown';
            }
            $remarkerName = Str::title($remarkerName);

            $timestamp = now()->format('M d, Y g:i A');
            $entry = $timestamp . ' - ' . $remarkerName . ': ' . $newRemarks;
            $existingRemarks = trim((string) $complaint->remarks);
            $complaint->remarks = $existingRemarks === ''
                ? $entry
                : $existingRemarks . PHP_EOL . $entry;
        }

        $complaint->save();

    return redirect()->back()->with('sucess', 'Complaint status updated successfully!');
    }
    
}
    
