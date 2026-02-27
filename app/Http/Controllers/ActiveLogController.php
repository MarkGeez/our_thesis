<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveLog;
use App\Services\ActiveLogRecordDetails;

class ActiveLogController extends Controller
{
    public function logs()
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['admin', 'subadmin'])) {
            abort(403, 'Unauthorized access.');
        }

        $logs = ActiveLog::with('user')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->appends(request()->query());
        $logs->setCollection(
            ActiveLogRecordDetails::enrich($logs->getCollection())
        );

        return view('admin.activityLogs', compact('logs', 'user'));
    }
    
}
