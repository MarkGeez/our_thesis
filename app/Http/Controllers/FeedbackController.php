<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedbacks;

class FeedbackController extends Controller
{
    public function showFeedbackForm(){
        return view('resident.feedback');

    }


    public function submitFeedback(Request $request){
        $user = auth()->user();
        $request->validate([
            "message"=> "required|string|max:5000"
        ]);

        Feedbacks::create([
            "user_id"=> $user->id,
            "message"=> $request->message
        ]);

        return redirect()->back()->with('success', 'Feedback successfully submitted');
    }

    
}
