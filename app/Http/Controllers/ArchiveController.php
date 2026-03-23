<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\ActiveLog;
use App\Models\CertificateRequest;
use App\Models\HouseholdResident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        $recordType = strtolower(trim((string) $archive->record_type));
        if (!in_array($recordType, ['resident', 'residents'], true)) {
            return back()->withErrors(['error' => 'Only resident records can be retrieved.']);
        }

        try {
            $residentData = $archive->data;
            if (!is_array($residentData) && is_string($residentData)) {
                $decoded = json_decode($residentData, true);
                $residentData = is_array($decoded) ? $decoded : [];
            }

            if (!is_array($residentData) || empty($residentData)) {
                return back()->withErrors(['error' => 'Archived resident data is missing or invalid.']);
            }

            $householdResidents = is_array($residentData['household_residents'] ?? null)
                ? $residentData['household_residents']
                : [];
            unset($residentData['household_residents']);

            $residentColumns = array_flip(Schema::getColumnListing('residents'));
            $datetimeColumns = ['created_at', 'updated_at', 'deleted_at'];
            $dateColumns = ['birthday'];
            $payload = [];

            foreach ($residentData as $column => $value) {
                if (!isset($residentColumns[$column])) {
                    continue;
                }

                if ($column === 'type' && is_array($value)) {
                    $payload[$column] = json_encode($value);
                    continue;
                }

                if (in_array($column, $datetimeColumns, true)) {
                    if ($value === '' || $value === null) {
                        $payload[$column] = null;
                        continue;
                    }

                    if (is_string($value)) {
                        try {
                            $payload[$column] = Carbon::parse($value)->format('Y-m-d H:i:s');
                        } catch (\Throwable $e) {
                            $payload[$column] = $value;
                        }
                        continue;
                    }
                }

                if (in_array($column, $dateColumns, true)) {
                    if ($value === '' || $value === null) {
                        $payload[$column] = null;
                        continue;
                    }

                    if (is_string($value)) {
                        try {
                            $payload[$column] = Carbon::parse($value)->format('Y-m-d');
                        } catch (\Throwable $e) {
                            $payload[$column] = $value;
                        }
                        continue;
                    }
                }

                if (is_array($value) || is_object($value)) {
                    // Convert JSON-backed columns that might come back as arrays/objects.
                    $payload[$column] = json_encode($value);
                    continue;
                }

                $payload[$column] = $value;
            }

            if (isset($payload['user_id']) && !empty($payload['user_id'])) {
                $linkedUserExists = User::whereKey((int) $payload['user_id'])->exists();
                if (!$linkedUserExists) {
                    $payload['user_id'] = null;
                }
            }

            if (isset($payload['EncodedBy'])) {
                $encodedByExists = User::whereKey((int) $payload['EncodedBy'])->exists();
                if (!$encodedByExists) {
                    $payload['EncodedBy'] = Auth::id();
                }
            }

            if (array_key_exists('id', $payload)) {
                $idAlreadyTaken = DB::table('residents')->where('id', $payload['id'])->exists();
                if ($idAlreadyTaken) {
                    unset($payload['id']);
                }
            }

            $now = now();
            if (isset($residentColumns['created_at']) && empty($payload['created_at'])) {
                $payload['created_at'] = $now;
            }
            if (isset($residentColumns['updated_at'])) {
                $payload['updated_at'] = $now;
            }

            $restoredResidentId = null;
            DB::transaction(function () use ($payload, $archive, $householdResidents, &$restoredResidentId) {
                $restoredResidentId = DB::table('residents')->insertGetId($payload);

                // Restore resident <> household membership (pivot rows).
                foreach ($householdResidents as $householdResident) {
                    if (!is_array($householdResident)) {
                        continue;
                    }

                    $householdId = isset($householdResident['household_id'])
                        ? (int) $householdResident['household_id']
                        : 0;
                    if ($householdId <= 0) {
                        continue;
                    }

                    $isHead = (bool) ($householdResident['is_household_head'] ?? false);

                    HouseholdResident::updateOrCreate(
                        [
                            'household_id' => $householdId,
                            'resident_id' => $restoredResidentId,
                        ],
                        [
                            'is_household_head' => $isHead,
                        ]
                    );
                }

                $archive->delete();
            });

            return back()->with('success', 'Resident retrieved successfully! The resident is now in the active residents table.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to retrieve resident: ' . $e->getMessage()]);
        }
    }

    /**
     * Retrieve/restore an archived certificate request back to active certificate requests table
     */
    public function retrieveCertificateRequest(Archive $archive): RedirectResponse
    {
        $recordType = strtolower(trim((string) $archive->record_type));
        if (!in_array($recordType, ['certificate_request', 'certificate_requests'], true)) {
            return back()->withErrors(['error' => 'Only certificate request records can be retrieved here.']);
        }

        try {
            $requestData = $archive->data;
            if (!is_array($requestData) && is_string($requestData)) {
                $decoded = json_decode($requestData, true);
                $requestData = is_array($decoded) ? $decoded : [];
            }

            if (!is_array($requestData) || empty($requestData)) {
                return back()->withErrors(['error' => 'Archived certificate request data is missing or invalid.']);
            }

            $requestColumns = array_flip(Schema::getColumnListing('certificate_requests'));
            $datetimeColumns = ['created_at', 'updated_at', 'approved_at'];
            $payload = [];

            foreach ($requestData as $column => $value) {
                if (!isset($requestColumns[$column])) {
                    continue;
                }

                if ($column === 'request_data' && (is_array($value) || is_object($value))) {
                    $payload[$column] = json_encode($value);
                    continue;
                }

                if (in_array($column, $datetimeColumns, true)) {
                    if ($value === '' || $value === null) {
                        $payload[$column] = null;
                        continue;
                    }

                    if (is_string($value)) {
                        try {
                            $payload[$column] = Carbon::parse($value)->format('Y-m-d H:i:s');
                        } catch (\Throwable $e) {
                            $payload[$column] = $value;
                        }
                        continue;
                    }
                }

                if (is_array($value) || is_object($value)) {
                    $payload[$column] = json_encode($value);
                    continue;
                }

                $payload[$column] = $value;
            }

            if (isset($payload['user_id']) && !empty($payload['user_id'])) {
                $linkedUserExists = User::whereKey((int) $payload['user_id'])->exists();
                if (!$linkedUserExists) {
                    $payload['user_id'] = Auth::id();
                }
            }

            if (isset($payload['resident_id']) && !empty($payload['resident_id'])) {
                $linkedResidentExists = DB::table('residents')->where('id', (int) $payload['resident_id'])->exists();
                if (!$linkedResidentExists) {
                    $payload['resident_id'] = null;
                }
            }

            if (isset($payload['approved_by']) && !empty($payload['approved_by'])) {
                $approverExists = User::whereKey((int) $payload['approved_by'])->exists();
                if (!$approverExists) {
                    $payload['approved_by'] = null;
                }
            }

            if (array_key_exists('id', $payload)) {
                $idAlreadyTaken = CertificateRequest::query()->whereKey($payload['id'])->exists();
                if ($idAlreadyTaken) {
                    unset($payload['id']);
                }
            }

            $now = now();
            if (isset($requestColumns['created_at']) && empty($payload['created_at'])) {
                $payload['created_at'] = $now;
            }
            if (isset($requestColumns['updated_at'])) {
                $payload['updated_at'] = $now;
            }

            DB::transaction(function () use ($payload, $archive) {
                DB::table('certificate_requests')->insert($payload);
                $archive->delete();
            });

            return back()->with('success', 'Certificate request retrieved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to retrieve certificate request: ' . $e->getMessage()]);
        }
    }

    /**
     * Retrieve/restore an archived activity log back to active logs table
     */
    public function retrieveActivityLog(Archive $archive): RedirectResponse
    {
        $recordType = strtolower(trim((string) $archive->record_type));
        if (!in_array($recordType, ['active_log', 'active_logs', 'activity_log', 'activity_logs'], true)) {
            return back()->withErrors(['error' => 'Only activity log records can be retrieved here.']);
        }

        try {
            $logData = $archive->data;
            if (!is_array($logData) && is_string($logData)) {
                $decoded = json_decode($logData, true);
                $logData = is_array($decoded) ? $decoded : [];
            }

            if (!is_array($logData) || empty($logData)) {
                return back()->withErrors(['error' => 'Archived activity log data is missing or invalid.']);
            }

            $logColumns = array_flip(Schema::getColumnListing('active_logs'));
            $datetimeColumns = ['created_at', 'updated_at'];
            $payload = [];

            foreach ($logData as $column => $value) {
                if (!isset($logColumns[$column])) {
                    continue;
                }

                if (in_array($column, $datetimeColumns, true)) {
                    if ($value === '' || $value === null) {
                        $payload[$column] = null;
                        continue;
                    }

                    if (is_string($value)) {
                        try {
                            $payload[$column] = Carbon::parse($value)->format('Y-m-d H:i:s');
                        } catch (\Throwable $e) {
                            $payload[$column] = $value;
                        }
                        continue;
                    }
                }

                if (is_array($value) || is_object($value)) {
                    $payload[$column] = json_encode($value);
                    continue;
                }

                $payload[$column] = $value;
            }

            if (isset($payload['user_id']) && !empty($payload['user_id'])) {
                $linkedUserExists = User::whereKey((int) $payload['user_id'])->exists();
                if (!$linkedUserExists) {
                    $payload['user_id'] = null;
                }
            }

            if (array_key_exists('id', $payload)) {
                $idAlreadyTaken = ActiveLog::query()->whereKey($payload['id'])->exists();
                if ($idAlreadyTaken) {
                    unset($payload['id']);
                }
            }

            $now = now();
            if (isset($logColumns['created_at']) && empty($payload['created_at'])) {
                $payload['created_at'] = $now;
            }
            if (isset($logColumns['updated_at'])) {
                $payload['updated_at'] = $now;
            }

            DB::transaction(function () use ($payload, $archive) {
                DB::table('active_logs')->insert($payload);
                $archive->delete();
            });

            return back()->with('success', 'Activity log retrieved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to retrieve activity log: ' . $e->getMessage()]);
        }
    }
}
