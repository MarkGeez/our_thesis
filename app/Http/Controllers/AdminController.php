<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Feedbacks;
use App\Models\Blotter;
use App\Models\Setting;
use App\Models\Resident;
use App\Models\Official;
use App\Models\Position;
use App\Models\User;

use App\Models\FamilyMember;


use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive;
use App\Models\CertificateRequest;

class AdminController extends Controller
{
    use ValidatesContactNumbers;

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

    private function formatResidentAddress(?Resident $resident): ?string
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

    private function getHeadCandidateResidents()
    {
        return Resident::with('households:id,house_id')
            ->select('id', 'firstName', 'middleName', 'lastName', 'birthday', 'age', 'sex', 'contactNo', 'headOfFamily')
            ->get()
            ->map(function (Resident $resident) {
                return [
                    'id' => $resident->id,
                    'firstName' => $resident->firstName,
                    'middleName' => $resident->middleName,
                    'lastName' => $resident->lastName,
                    'birthday' => $resident->birthday,
                    'age' => $resident->age,
                    'sex' => $resident->sex,
                    'contactNo' => $resident->contactNo,
                    'headOfFamily' => $resident->headOfFamily,
                    'householdIds' => $resident->households->pluck('id')->values(),
                    'houseIds' => $resident->households->pluck('house_id')->filter()->values(),
                ];
            });
    }

    public function dashboard(): View
    {
    
    $announcement= Announcement::with('user:id,firstName,lastName')->latest()->get();
    $admin = Auth::user();
    $residentCount = Resident::count();
    $maleCount = Resident::where('sex', 'male')->count();
    $femaleCount = Resident::where('sex', 'female')->count();
    $seniorCount = Resident::where('age', '>=', 60)->count();
    $userCount = User::count();
    return view("admin.dashboard", compact('announcement', 'admin', 'residentCount', 'maleCount', 'femaleCount', 'seniorCount', 'userCount'));
    }
    
    
    public function profile()
{
    $user = auth()->user();
    
    // Try to find resident by user_id first (consistent with other roles)
    $resident = Resident::with('households.house.street')
                        ->where('user_id', $user->id)
                        ->first();
    
    // Fall back to name matching if user_id not found
    if (!$resident) {
        $resident = Resident::with('households.house.street')
                            ->where('firstName', $user->firstName)
                            ->where('lastName', $user->lastName)
                            ->first();
    }
    
    $members = FamilyMember::with('resident')->where('encoded_by', $user->id)->get();
    // Include address fields for family-member suggestions (street + house number).
    $residents = Resident::with('households.house.street')
        ->get(['id', 'firstName', 'middleName', 'lastName', 'birthday', 'sex', 'contactNo', 'age'])
        ->map(function (Resident $r) {
            $household = $r->households->first();
            $house = $household?->house;
            $street = $house?->street;

            return [
                'id' => $r->id,
                'firstName' => $r->firstName,
                'middleName' => $r->middleName,
                'lastName' => $r->lastName,
                'birthday' => $r->birthday,
                'age' => $r->age,
                'sex' => $r->sex,
                'contactNo' => $r->contactNo,
                'streetId' => $street?->id,
                'streetName' => $street?->street_name,
                'houseNo' => $house?->house_no,
            ];
        });
    $headCandidateResidents = $this->getHeadCandidateResidents();
    return view('admin.profile', compact('user', 'resident', 'members', 'residents', 'headCandidateResidents'));
}
    public function adminComplaint():View{
        $admin = Auth::user();

        $myComplaints = $admin->complaints()->with('respondent')->get();
        return view("admin.adminComplaint", compact('admin', 'myComplaints'));
    }
    
    public function blotterRequest(): View
    {
        $admin = Auth::user();
        $blotters= Blotter::latest()->paginate(10);
        return view("admin.blotterRequest", compact('admin', 'blotters'));
    }
    public function adminServices(){
        $admin = Auth::user();
        return view("admin.adminServices", compact('admin'));
    }
    public function certificateRequest(): View
    {
        $admin = Auth::user();
        $search = trim((string) request('search', ''));
        $sort = (string) request('sort', 'date_desc');
        $statusFilter = (string) request('status_filter', 'all');
        $certificateTypeFilter = (string) request('certificate_type_filter', 'all');
        $activeTab = request('tab', 'all');
        if (!in_array($activeTab, ['all', 'pending', 'approved', 'declined'], true)) {
            $activeTab = 'all';
        }

        $certificateTypeOptions = CertificateRequest::query()
            ->select('certificate_type')
            ->whereNotNull('certificate_type')
            ->distinct()
            ->orderBy('certificate_type')
            ->pluck('certificate_type')
            ->filter()
            ->values();

        if ($certificateTypeFilter !== 'all' && !$certificateTypeOptions->contains($certificateTypeFilter)) {
            $certificateTypeFilter = 'all';
        }

        $baseQuery = CertificateRequest::with([
            'user:id,firstName,middleName,lastName,role,email,contactNumber,birthday,profile_image',
            'resident:id,firstName,middleName,lastName,contactNo,birthday,age,sex,image_path',
            'approver:id,firstName,middleName,lastName'
        ]);

        $applyCommonFilters = function ($query) use ($search, $sort, $statusFilter, $activeTab, $certificateTypeFilter) {
            if ($search !== '') {
                // Extract numeric ID from formatted ID (e.g., "CERT-2026-000001" -> "1")
                $formattedIdNumericPart = null;
                if (preg_match('/^[A-Z]+-\d+-(\d+)$/', strtoupper($search), $matches)) {
                    $formattedIdNumericPart = (int) $matches[1];
                }

                $query->where(function ($q) use ($search, $formattedIdNumericPart) {
                    $q->where('id', 'like', '%' . $search . '%')
                        ->orWhere('certificate_type', 'like', '%' . $search . '%')
                        ->orWhere('purpose', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('firstName', 'like', '%' . $search . '%')
                                ->orWhere('lastName', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('resident', function ($residentQuery) use ($search) {
                            $residentQuery->where('firstName', 'like', '%' . $search . '%')
                                ->orWhere('lastName', 'like', '%' . $search . '%');
                        });

                    if ($formattedIdNumericPart !== null) {
                        $q->orWhere('id', (int) $formattedIdNumericPart);
                    }
                });
            }

            if ($activeTab === 'all' && $statusFilter !== 'all') {
                $query->where('status', $statusFilter);
            }

            if ($certificateTypeFilter !== 'all') {
                $query->where('certificate_type', $certificateTypeFilter);
            }

            switch ($sort) {
                case 'id_asc':
                    $query->orderBy('id', 'asc');
                    break;
                case 'id_desc':
                    $query->orderBy('id', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'type_asc':
                    $query->orderBy('certificate_type', 'asc')->latest('id');
                    break;
                case 'type_desc':
                    $query->orderBy('certificate_type', 'desc')->latest('id');
                    break;
                case 'status_asc':
                    $query->orderBy('status', 'asc')->latest('id');
                    break;
                case 'status_desc':
                    $query->orderBy('status', 'desc')->latest('id');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        };

        $requestsQuery = clone $baseQuery;
        $applyCommonFilters($requestsQuery);

        $pendingQuery = clone $baseQuery;
        $applyCommonFilters($pendingQuery);
        $pendingQuery->where('status', 'pending');

        $approvedQuery = clone $baseQuery;
        $applyCommonFilters($approvedQuery);
        $approvedQuery->whereIn('status', ['approved', 'picked_up']);

        $declinedQuery = clone $baseQuery;
        $applyCommonFilters($declinedQuery);
        $declinedQuery->where('status', 'declined');

        $requests = $requestsQuery->paginate(10, ['*'], 'all_page')->appends(request()->query());
        $pendingRequests = $pendingQuery->paginate(10, ['*'], 'pending_page')->appends(request()->query());
        $approvedRequests = $approvedQuery->paginate(10, ['*'], 'approved_page')->appends(request()->query());
        $declinedRequests = $declinedQuery->paginate(10, ['*'], 'declined_page')->appends(request()->query());
        // Get request stats for each user
        $requestStats = CertificateRequest::selectRaw('user_id, COUNT(*) as total, 
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "declined" THEN 1 ELSE 0 END) as declined,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');
        
        return view("admin.certificateRequest", compact(
            'admin',
            'requests',
            'pendingRequests',
            'approvedRequests',
            'declinedRequests',
            'activeTab',
            'requestStats',
            'search',
            'sort',
            'statusFilter',
            'certificateTypeFilter',
            'certificateTypeOptions'
        ));
    }

    public function getCertificateRequestDetails(int $id)
    {
        $request = CertificateRequest::findOrFail($id);
        
        return response()->json([
            'id' => $request->id,
            'certificate_type' => $request->certificate_type,
            'purpose' => $request->purpose,
            'status' => $request->status,
            'created_at' => $request->created_at->format('M d, Y H:i'),
            'request_data' => $request->request_data ?? []
        ]);
    }
    
    public function clearanceRequest(): View
    {
        $admin = Auth::user();
        return view("admin.clearanceRequest", compact('admin'));
    }
    
    public function serviceRequest(): View
    {
        $admin = Auth::user();
        return view("admin.serviceRequest", compact('admin'));
    }
    
    
    public function announcements(){
     $admin = Auth::user();
    $announcement = Announcement::with('user:id,firstName,lastName')->latest()->get();
    return view('admin.announcements', compact('admin', 'announcement'));
}

    public function feedbackRequest(): View
    {
        $admin = Auth::user();
        $sort = request('sort', 'oldest');
        $feedbacks = Feedbacks::with('user:id,firstName,lastName')
            ->when($sort === 'newest', fn($q) => $q->latest(), fn($q) => $q->oldest())
            ->paginate(10);
        return view("admin.feedbackRequest", compact('admin', 'feedbacks', 'sort'));
    }
    
    public function aboutus(): View
    {
        $admin = Auth::user();
        return view("admin.aboutus", compact('admin'));
    }
    
    public function contactus(): View
    {
        $admin = Auth::user();
        return view("admin.contactus", compact('admin'));
    }
    public function settings(): View
    {
        $admin = Auth::user();
        $settings = Setting::first();
        return view("admin.settings", compact('admin', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'barangay_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'theme' => 'nullable|string|max:7',
            'contact_address' => 'nullable|string|max:255',
            'contact_number' => $this->nullableContactNumberRules(),
            'contact_email' => 'nullable|email|max:255',
        ], $this->contactNumberMessages(['contact_number']));

        $settings = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && file_exists(public_path($settings->logo_path))) {
                unlink(public_path($settings->logo_path));
            }

            // Store new logo
            $file = $request->file('logo');
            $path = $file->store('uploads/logo', 'public');
            $settings->logo_path = 'storage/' . $path;
        }

        $settings->barangay_name = $request->barangay_name;
        if ($request->filled('theme')) {
            $settings->theme = $request->theme;
        }
        if ($request->filled('contact_address')) {
            $settings->contact_address = $request->contact_address;
        }
        if ($request->filled('contact_number')) {
            $settings->contact_number = $request->contact_number;
        }
        if ($request->filled('contact_email')) {
            $settings->contact_email = $request->contact_email;
        }
        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
    public function barangayOfficials(): View
    {
        $admin = Auth::user();
        $positions = Position::get();

        return view("admin.barangayOfficials", compact('admin', 'positions'));
    }
     public function census(): View
    {
        $admin = Auth::user();
        return view("admin.census", compact('admin'));
    }
     public function users(): View
    {
        $admin = Auth::user();
        return view("admin.users", compact('admin'));
    }
     public function reports()
    {
        // legacy handler – forward to the dedicated ReportsController
        return redirect()->route('admin.reports.index');
    }
   

    public function adminCertificate(): View
    {
        $admin = Auth::user();
        $requests = $admin->certificateRequests()->latest()->get();
        return view("admin.adminCertificate", compact('admin', 'requests'));
    }

    

    
    public function archives(): View
    {
    $admin = Auth::user();
    $archive = Archive::latest()->paginate(10);
    return view("admin.archives", compact('admin', 'archive'));
    }

    public function getUserInfo(int $id)
    {
        $user = User::findOrFail($id);
        $resident = Resident::with('households.house.street')
            ->where('user_id', $user->id)
            ->first();

        $profileImage = null;
        if (!empty($user->profile_image)) {
            $profileImage = asset('storage/' . ltrim((string) $user->profile_image, '/'));
        } elseif (!empty($resident?->image_path)) {
            $profileImage = asset('storage/' . ltrim((string) $resident->image_path, '/'));
        }
        
        return response()->json([
            'fullName' => trim("{$user->firstName} {$user->middleName} {$user->lastName}"),
            'email' => $user->email,
            'contact' => $user->contactNumber,
            'birthday' => $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('F d, Y') : null,
            'role' => $user->role,
            'profileImage' => $profileImage,
            'residentType' => $resident ? $this->formatResidentTypes($resident->type) : null,
            'parentStatus' => $resident?->parent ? ucfirst((string) $resident->parent) : null,
            'enrollmentStatus' => $resident?->enrolled ? ucfirst((string) $resident->enrolled) : null,
            'headOfFamily' => $resident?->headOfFamily ? ucfirst((string) $resident->headOfFamily) : null,
            'educationalAttainment' => $resident?->educationalAttainment,
            'religion' => $resident?->religion,
            'emergencyContactName' => $resident?->emergencyContactName,
            'emergencyContactNo' => $resident?->emergencyContactNo,
            'address' => $this->formatResidentAddress($resident),
        ]);
    }

    public function getResidentInfo(int $id)
    {
        $resident = Resident::with('households.house.street')->findOrFail($id);

        $profileImage = null;
        if (!empty($resident->image_path)) {
            $profileImage = asset('storage/' . ltrim((string) $resident->image_path, '/'));
        } elseif (!empty($resident->user?->profile_image)) {
            $profileImage = asset('storage/' . ltrim((string) $resident->user->profile_image, '/'));
        }
        
        return response()->json([
            'fullName' => trim("{$resident->firstName} {$resident->middleName} {$resident->lastName}"),
            'email' => $resident->user?->email,
            'contact' => $resident->contactNo,
            'birthday' => $resident->birthday ? \Carbon\Carbon::parse($resident->birthday)->format('F d, Y') : null,
            'age' => $resident->age,
            'sex' => $resident->sex,
            'profileImage' => $profileImage,
            'residentType' => $this->formatResidentTypes($resident->type),
            'parentStatus' => $resident->parent ? ucfirst((string) $resident->parent) : null,
            'enrollmentStatus' => $resident->enrolled ? ucfirst((string) $resident->enrolled) : null,
            'headOfFamily' => $resident->headOfFamily ? ucfirst((string) $resident->headOfFamily) : null,
            'educationalAttainment' => $resident->educationalAttainment,
            'religion' => $resident->religion,
            'emergencyContactName' => $resident->emergencyContactName,
            'emergencyContactNo' => $resident->emergencyContactNo,
            'address' => $this->formatResidentAddress($resident),
        ]);
    }

}
