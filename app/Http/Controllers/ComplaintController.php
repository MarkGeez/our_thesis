<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\Complaints;
use Illuminate\Http\JsonResponse;

class ComplaintController extends Controller
{
    private function formatResidentTypes($types): ?string
    {
        $labels = [
            'voter' => 'Voter',
            'senior_citizen' => 'Senior Citizen',
            'pwd' => 'PWD',
            'solo_parent' => 'Solo Parent',
        ];

        $rawResidentTypes = is_array($types)
            ? $types
            : (filled($types) ? [$types] : []);

        $residentTypes = collect($rawResidentTypes)
            ->filter()
            ->map(function ($residentType) use ($labels) {
                return $labels[$residentType]
                    ?? \Illuminate\Support\Str::title(str_replace('_', ' ', (string) $residentType));
            })
            ->unique()
            ->values();

        return $residentTypes->isNotEmpty() ? $residentTypes->implode(', ') : null;
    }

    private function formatResidentAddress($resident): ?string
    {
        if (!$resident) {
            return null;
        }

        $house = optional($resident->households->first())->house;
        $street = optional($house)->street;

        $parts = array_filter([
            $house?->house_no,
            $street?->street_name,
        ], fn ($value) => filled($value));

        return !empty($parts) ? implode(' ', $parts) : null;
    }

    public function submitComplaint(Request $request):RedirectResponse{
        $user= Auth::user();


        $request->validate([
            "address"=> "required|string|max:100",
            "details"=> "required|string|max:10000",
            "complaint_datetime" => "nullable|date",
            "attachment_image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:5120",
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment_image')) {
            $attachmentPath = $request->file('attachment_image')->store('complaints/attachments', 'public');
        }

        Complaints::create([


            "complainant_id"=> $user->id,
            "complainantName"=>  trim($user->firstName . " " . ($user->middleName ?? '') . " " . $user->lastName),
            "address"=> $request->address,
            "details"=> $request->details,
            "attachment_path" => $attachmentPath,
            "complaint_datetime" => $request->filled('complaint_datetime')
                ? \Carbon\Carbon::parse($request->input('complaint_datetime'))
                : null,
            "respondent_id"=> null,
            "status" => "pending"

        ]);

        return redirect()->back()->with('success', 'Complaint submitted successfully!');

    }

    public function showComplaints(Request $request){
        $user = Auth::user();
        $activeTab = request('tab', 'all');
        if (!in_array($activeTab, ['all', 'pending', 'on-going', 'rejected', 'resolved'], true)) {
            $activeTab = 'all';
        }

        $search = trim((string) $request->query('search', ''));
        $statusFilter = (string) $request->query('status_filter', 'all');
        $sort = (string) $request->query('sort', 'id_desc');

        $query = Complaints::query()->with([
            'complainant:id,firstName,middleName,lastName,contactNumber',
            'respondent:id,firstName,middleName,lastName,contactNumber',
        ]);

        if ($search !== '') {
            // Extract numeric ID from formatted ID (e.g., "CMPL-2026-000001" -> "1")
            $formattedIdNumericPart = null;
            if (preg_match('/^[A-Z]+-\d+-(\d+)$/', strtoupper($search), $matches)) {
                $formattedIdNumericPart = (int) $matches[1];
            }

            $query->where(function ($q) use ($search, $formattedIdNumericPart) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('complainantName', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('details', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');

                if ($formattedIdNumericPart !== null) {
                    $q->orWhere('id', (int) $formattedIdNumericPart);
                }
            });
        }

        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'complainant_asc':
                $query->orderBy('complainantName', 'asc');
                break;
            case 'complainant_desc':
                $query->orderBy('complainantName', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('status', 'asc')->latest('id');
                break;
            case 'status_desc':
                $query->orderBy('status', 'desc')->latest('id');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $complaints = $query->paginate(10)->appends($request->query());
        $route = $user->role . ".complaintRequest";
        return view($route, compact('complaints', 'activeTab', 'search', 'statusFilter', 'sort'));
        
    }

    public function updateStatus(Request $request, $id){
        $complaint = Complaints::findOrFail($id);
        $respondent = Auth::user()->id;

        if ($complaint->status === 'resolved') {
            return redirect()->back()->with('error', 'Resolved complaints can no longer be updated.');
        }

        $request->validate([
            "status"=> "required|in:resolved,on-going,rejected",
            "remarks"=> "nullable|string|max:1000",
        ]);

        $complaint->status = $request->status;
        $complaint->respondent_id = $respondent;

        $newRemarks = trim((string) $request->remarks);
        if ($newRemarks !== '') {
            $user = Auth::user();
            $remarkerName = trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? ''));
            if ($remarkerName === '') {
                $remarkerName = $user->name ?? $user->email ?? 'Unknown';
            }
            $remarkerName = Str::title($remarkerName);

            $timestamp = now()->format('M d, Y g:i A');
            $entry = $timestamp . ' - ' . $remarkerName . ': ' . $newRemarks;
            $existingRemarks = trim((string) $complaint->remarks);
            $complaint->remarks = $existingRemarks === ''
                ? $entry
                : $existingRemarks . PHP_EOL . $entry;
        }

        $complaint->save();

    return redirect()->back()->with('success', 'Complaint updated successfully.');
    }

    public function complainantHistory(int $userId): JsonResponse
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'subadmin'], true)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $history = Complaints::query()
            ->with('complainant:id,firstName,middleName,lastName')
            ->where('complainant_id', $userId)
            ->orderByDesc('created_at')
            ->get(['id', 'complainant_id', 'status', 'address', 'details', 'created_at']);

        $complainant = $history->first()?->complainant;
        $complainantName = $complainant
            ? trim(($complainant->firstName ?? '') . ' ' . ($complainant->middleName ?? '') . ' ' . ($complainant->lastName ?? ''))
            : null;

        return response()->json([
            'complainant_id' => $userId,
            'complainant_name' => $complainantName,
            'total' => $history->count(),
            'pending' => $history->where('status', 'pending')->count(),
            'on_going' => $history->where('status', 'on-going')->count(),
            'resolved' => $history->where('status', 'resolved')->count(),
            'rejected' => $history->where('status', 'rejected')->count(),
            'complaints' => $history->map(function ($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'address' => $item->address,
                    'details' => $item->details,
                    'created_at' => optional($item->created_at)->format('M d, Y g:i A'),
                ];
            })->values(),
        ]);
    }

    public function complainantProfile(int $userId): JsonResponse
    {
        $auth = Auth::user();
        if (!$auth || !in_array($auth->role, ['admin', 'subadmin'], true)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = \App\Models\User::with('resident.households.house.street')->find($userId);
        if (!$user) {
            return response()->json(['error' => 'Complainant not found'], 404);
        }

        $resident = $user->resident;
        $history = Complaints::query()
            ->where('complainant_id', $userId)
            ->orderByDesc('created_at')
            ->get(['id', 'status', 'address', 'details', 'created_at']);

        $profileImage = null;
        if (!empty($user->profile_image)) {
            $profileImage = asset('storage/' . ltrim((string) $user->profile_image, '/'));
        } elseif (!empty($resident?->image_path)) {
            $profileImage = asset('storage/' . ltrim((string) $resident->image_path, '/'));
        }

        return response()->json([
            'fullName' => trim(($user->firstName ?? '') . ' ' . ($user->middleName ?? '') . ' ' . ($user->lastName ?? '')),
            'email' => $user->email,
            'contact' => $user->contactNumber ?? $resident?->contactNo,
            'birthday' => $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('F d, Y') : null,
            'role' => $user->role,
            'age' => $resident?->age,
            'sex' => $resident?->sex,
            'residentType' => $resident ? $this->formatResidentTypes($resident->type) : null,
            'parentStatus' => $resident?->parent ? ucfirst((string) $resident->parent) : null,
            'enrollmentStatus' => $resident?->enrolled ? ucfirst((string) $resident->enrolled) : null,
            'headOfFamily' => $resident?->headOfFamily ? ucfirst((string) $resident->headOfFamily) : null,
            'educationalAttainment' => $resident?->educationalAttainment,
            'religion' => $resident?->religion,
            'emergencyContactName' => $resident?->emergencyContactName,
            'emergencyContactNo' => $resident?->emergencyContactNo,
            'address' => $this->formatResidentAddress($resident),
            'profileImage' => $profileImage,
            'history' => [
                'total' => $history->count(),
                'pending' => $history->where('status', 'pending')->count(),
                'on_going' => $history->where('status', 'on-going')->count(),
                'resolved' => $history->where('status', 'resolved')->count(),
                'rejected' => $history->where('status', 'rejected')->count(),
                'requests' => $history->map(function ($item) {
                    return [
                        'created_at' => optional($item->created_at)->format('M d, Y g:i A'),
                        'status' => $item->status,
                        'address' => $item->address,
                        'details' => $item->details,
                    ];
                })->values(),
            ],
        ]);
    }
    
}
    
