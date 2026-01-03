<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;

class UserListController extends Controller
{
    public function showUsers(Request $request){

        $user= auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }

        $search = $request->input('search');

        $userList = User::with('resident:houseNo,street,emergencyContactNo,emergencyContactName,age,sex,parent,enrolled,educationalAttainment,headOfFamily,EncodedBy,user_id')
        ->when($search, function($query, $search){
            return $query-> where(function($q) use ($search){
                $q->where('firstName', 'like', "{$search}")->orWhere('lastName', 'like', "{$search}")->orWhere('id', 'like', "{$search}");
            });
        })->paginate(10);

        return view($user->role . '.users', compact('user', 'search', 'userList'));
    }
}
