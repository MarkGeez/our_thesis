<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveLog;

class ActiveLogController extends Controller
{
    public function logs()
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['admin', 'subadmin'])) {
            abort(403, 'Unauthorized access.');
        }

        $logs = ActiveLog::with('user')->latest()->paginate(20);

        return view('admin.activityLogs', compact('logs', 'user'));
    }
    
}