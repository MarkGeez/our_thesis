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

    public function submitComplaint(Request $request):RedirectResponse{
        $user= Auth::user();


        $request->validate([
            "address"=> "required|string|max:100",
            "details"=> "required|string|max:10000"
        ]);

        Complaints::create([


            "complainant_id"=> $user->id,
            "complainantName"=>  trim($user->firstName . " " . ($user->middleName ?? '') . " " . $user->lastName),
            "address"=> $request->address,
            "details"=> $request->details,
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
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('complainantName', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('details', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
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
            $statusLabel = Str::title(str_replace('-', ' ', (string) $request->status));

            $timestamp = now()->format('M d, Y g:i A');
            $entry = $timestamp . ' - ' . $remarkerName . ': [Status: ' . $statusLabel . '] ' . $newRemarks;
            $existingRemarks = trim((string) $complaint->remarks);
            $complaint->remarks = $existingRemarks === ''
                ? $entry
                : $existingRemarks . PHP_EOL . $entry;
        }

        $complaint->save();

    return redirect()->back()->with('success', 'Complaint status updated successfully!');
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

        $user = \App\Models\User::with('resident')->find($userId);
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
    
