<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function showArchive(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $sort = (string) $request->query('sort', 'date_desc');

        $query = Archive::with('user:id,firstName,lastName');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('record_type', 'like', '%' . $search . '%')
                    ->orWhere('data', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('firstName', 'like', '%' . $search . '%')
                            ->orWhere('lastName', 'like', '%' . $search . '%');
                    });
            });
        }

        switch ($sort) {
            case 'date_asc':
                $query->oldest();
                break;
            case 'type_asc':
                $query->orderBy('record_type', 'asc')->latest('created_at');
                break;
            case 'type_desc':
                $query->orderBy('record_type', 'desc')->latest('created_at');
                break;
            case 'archived_by_asc':
                $query->orderBy(
                    User::select('firstName')
                        ->whereColumn('users.id', 'archives.user_id')
                        ->limit(1),
                    'asc'
                )->latest('created_at');
                break;
            case 'archived_by_desc':
                $query->orderBy(
                    User::select('firstName')
                        ->whereColumn('users.id', 'archives.user_id')
                        ->limit(1),
                    'desc'
                )->latest('created_at');
                break;
            default:
                $query->latest();
                break;
        }

        $archive = $query->paginate(10)->appends($request->query());
        return view('admin.archives', compact('archive', 'search', 'sort'));
    }
}
