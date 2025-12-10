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
            "complainantName"=>  $user->name . ", " . $user->lastName,
            "address"=> $request->address,
            "details"=> $request->details,
            "respondent_id"=> null,
            "status" => "pending"

        ]);

        return redirect()->back()->with('success', 'Complaint submitted successfully!');

    }
    
}
    