<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Resident;
use App\Models\Household;
use App\Models\HouseholdResident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    /**
     * Retrieve/restore an archived resident back to the active residents table
     */
    public function retrieveResident(Archive $archive): RedirectResponse
    {
        // Only allow retrieval of resident records
        if ($archive->record_type !== 'resident') {
            return back()->withErrors(['error' => 'Only resident records can be retrieved.']);
        }

        try {
            // Extract resident data from archive
            $residentData = $archive->data;

            // Remove timestamps and relations that shouldn't be directly recreated
            unset($residentData['created_at']);
            unset($residentData['updated_at']);

            // Ensure ID is preserved so relationships can be maintained
            $originalResidentId = $residentData['id'] ?? null;

            // Create the resident record with the archived data
            $resident = Resident::create($residentData);

            // If there were households associated, we need to restore those relationships
            // This is handled by keeping relationships intact in the archived data
            // Note: Household relationships will need to be manually recreated if they were deleted
            // For now, we'll just recreate the resident and let admins manage household assignments if needed

            // Delete the archive record after successful restoration
            $archive->delete();

            return back()->with('success', 'Resident retrieved successfully! The resident is now in the active residents table.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to retrieve resident: ' . $e->getMessage()]);
        }
    }
}
