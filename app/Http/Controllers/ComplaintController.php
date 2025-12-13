<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $complaints = Complaints::oldest()->get();
        $route = $user->role . ".complaintRequest";
        return view($route, compact ('complaints'));
        
    }

    public function updateStatus(Request $request, $id){
        $complaint = Complaints::findOrFail($id);
        $respondent = Auth::user()->id;

        $request->validate([
            "status"=> "required|in:resolved,on-going,rejected",
            "remarks"=> "nullable|string|max:1000",
        ]);

        $complaint->status = $request->status;
        $complaint->remarks = $request->remarks;
        $complaint->respondent_id = $respondent;

        $complaint->save();

    return redirect()->back()->with('sucess', 'Complaint status updated successfully!');
    }
    
}
    