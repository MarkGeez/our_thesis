<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActiveLogController extends Controller
{
    public function logs()
        {
    $user = auth()->user();
    
    if (!$user || !in_array($user->role, ['admin', 'sub-admin'])) {
        abort(403, 'Unauthorized access.');
    }
    
    $logs = ActiveLog::with('user')->latest()->paginate(20);
    
    // Dynamic view based on role
    $viewName = $user->role . '.activeLogs';
    
    return view($viewName, compact('logs', 'user'));
    }
}
