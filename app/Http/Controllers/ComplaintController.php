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

    public function showComplaints(Request $request){
        $user = Auth::user();
        $activeTab = request('tab', 'all');
        if (!in_array($activeTab, ['all', 'pending', 'on-going', 'rejected', 'resolved'], true)) {
            $activeTab = 'all';
        }

        $search = trim((string) $request->query('search', ''));
        $statusFilter = (string) $request->query('status_filter', 'all');
        $sort = (string) $request->query('sort', 'id_desc');

        $query = Complaints::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('complainantName', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('details', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'complainant_asc':
                $query->orderBy('complainantName', 'asc');
                break;
            case 'complainant_desc':
                $query->orderBy('complainantName', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('status', 'asc')->latest('id');
                break;
            case 'status_desc':
                $query->orderBy('status', 'desc')->latest('id');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $complaints = $query->paginate(10)->appends($request->query());
        $route = $user->role . ".complaintRequest";
        return view($route, compact('complaints', 'activeTab', 'search', 'statusFilter', 'sort'));
        
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
            $statusLabel = Str::title(str_replace('-', ' ', (string) $request->status));

            $timestamp = now()->format('M d, Y g:i A');
            $entry = $timestamp . ' - ' . $remarkerName . ': [Status: ' . $statusLabel . '] ' . $newRemarks;
            $existingRemarks = trim((string) $complaint->remarks);
            $complaint->remarks = $existingRemarks === ''
                ? $entry
                : $existingRemarks . PHP_EOL . $entry;
        }

        $complaint->save();

    return redirect()->back()->with('success', 'Complaint status updated successfully!');
    }
    
}
    
