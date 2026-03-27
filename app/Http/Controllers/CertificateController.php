<?php

namespace App\Http\Controllers;

use App\Mail\NewCertificateRequestAlertMail;
use App\Mail\CertificateStatusUpdateMail;
use App\Models\CertificateRequest;
use App\Models\Official;
use App\Models\Resident;
use App\Models\User;
use App\Services\ArchiveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CertificateController extends Controller
{
    private function resolveRequesterAge(?User $user, ?Resident $resident): ?int
    {
        if ($resident && !is_null($resident->age)) {
            return (int) $resident->age;
        }

        if ($user && !empty($user->birthday)) {
            try {
                return (int) \Carbon\Carbon::parse($user->birthday)->age;
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    private function resolveCertificateDisplayName(CertificateRequest $req): string
    {
        $data = $req->request_data ?? [];

        if ($req->certificate_type === 'senior' && !empty($data['certificate_name'])) {
            return ucwords(strtolower(trim((string) $data['certificate_name'])));
        }

        return ucwords(strtolower($req->requester_name));
    }

    public function archive(CertificateRequest $certificateRequest, ArchiveService $archiveService): RedirectResponse
    {
        if ($certificateRequest->status !== 'picked_up') {
            return back()->withErrors(['error' => 'Only received certificate requests can be archived.']);
        }

        $archiveService->archive($certificateRequest, 'Archived received certificate request');

        return back()->with('success', 'Certificate request archived successfully.');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'certificate_type' => 'required|in:bonafide,indigency,soloparent,senior',
        'address' => 'nullable|string|max:255',
        'request_data' => 'nullable|array',
    ]);
    
    // Conditional validation based on certificate type
    switch ($validated['certificate_type']) {
        case 'bonafide':
        case 'indigency':
            $request->validate([
                'purpose' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
            break;
        case 'soloparent':
            // Validate solo parent specific fields
            $request->validate([
                'form_data.partner_name' => 'nullable|string|max:255',
                'form_data.separated_from' => 'nullable|string|max:255',
                'form_data.since' => 'nullable|date',
                // Add children validation if needed
            ]);
            break;
        case 'senior':
            // Validate senior specific fields
            $request->validate([
                'form_data.former_address' => 'nullable|string|max:255',
                'form_data.new_address' => 'nullable|string|max:255',
            ]);
            break;
    }
    
    // Handle "Others" for bonafide and indigency
    $finalPurpose = $request->purpose ?? null;
    $purposeOthers = null;
    
    if (in_array($validated['certificate_type'], ['bonafide', 'indigency'])) {
        if ($request->purpose === 'others') {
            $request->validate([
                'purpose_other' => 'required|string|max:500',
            ]);
            $finalPurpose = 'others';
            $purposeOthers = $request->purpose_other;
        }
    }
    
    $user = Auth::user();
    $resident = Resident::where('user_id', $user->id)->first();

    $hasPendingSameType = CertificateRequest::where('user_id', $user->id)
        ->where('certificate_type', $validated['certificate_type'])
        ->where('status', 'pending')
        ->exists();

    if ($hasPendingSameType) {
        $typeLabels = [
            'bonafide' => 'Bonafide',
            'indigency' => 'Indigency',
            'soloparent' => 'Solo Parent',
            'senior' => 'Senior Citizen',
        ];

        $certificateTypeLabel = $typeLabels[$validated['certificate_type']] ?? ucfirst($validated['certificate_type']);

        return back()
            ->withErrors([
                'certificate_type' => "You already have a pending {$certificateTypeLabel} certificate request. Please wait for it to be processed before submitting another one.",
            ])
            ->withInput();
    }
    
    $data = $validated['request_data'] ?? [];
    
    // For solo parent and senior, get form data
    if (in_array($validated['certificate_type'], ['soloparent', 'senior'])) {
        $formData = $request->form_data ?? [];
        $data = array_merge($data, $formData);
    }

    if ($validated['certificate_type'] === 'soloparent' && empty($data['age'])) {
        $resolvedAge = $this->resolveRequesterAge($user, $resident);
        if (!is_null($resolvedAge)) {
            $data['age'] = $resolvedAge;
        }
    }

    if ($validated['certificate_type'] === 'senior' && empty($data['certificate_name'])) {
        $data['certificate_name'] = $user
            ? trim("{$user->firstName} {$user->middleName} {$user->lastName}")
            : null;
    }
    
    $certificateRequest = CertificateRequest::create([
        'user_id' => $user->id,
        'resident_id' => $resident?->id,
        'certificate_type' => $validated['certificate_type'],
        'purpose' => $finalPurpose,
        'address' => $validated['address'] ?? null,
        'purpose_other' => $purposeOthers,
        'request_data' => $data,
        'status' => 'pending',
    ]);

    $this->notifyAdminsOfNewCertificateRequest($certificateRequest->loadMissing('user', 'resident'));
    
    $route = match ($user->role) {
        'admin' => 'admin.adminCertificate',
        'subadmin' => 'subadmin.subadminCertificate',
        default => 'resident.certificate',
    };
    
    return redirect()
        ->route($route)
        ->with('success', 'Certificate request submitted successfully.');
}

    public function approve(int $id)
    {
        $req = CertificateRequest::with('user')->findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is no longer pending.');
        }
        $req->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'decline_reason' => null,
        ]);

        if (!empty($req->user?->email)) {
            Mail::send(new CertificateStatusUpdateMail($req));
        }

        return back()->with('success', 'Certificate request approved. Requester may pick up at admin\'s house.');
    }

    public function reject(Request $request, int $id)
    {
        $validated = $request->validate([
            'decline_reason' => 'nullable|string|max:500',
        ]);
        $req = CertificateRequest::with('user')->findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is no longer pending.');
        }
        $req->update([
            'status' => 'declined',
            'decline_reason' => $validated['decline_reason'] ?? null,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        if (!empty($req->user?->email)) {
            Mail::send(new CertificateStatusUpdateMail($req));
        }

        return back()->with('success', 'Certificate request declined.');
    }

    public function preview(int $id): View
    {
        $req = CertificateRequest::with('user', 'resident')->findOrFail($id);
        if ($req->status !== 'approved' && $req->status !== 'picked_up') {
            abort(403, 'Certificate is not yet approved.');
        }
        return $this->certificateView($req, false, true);
    }

    public function pendingPreview(int $id): View
    {
        $req = CertificateRequest::with('user', 'resident')->findOrFail($id);
        if ($req->status !== 'pending') {
            abort(403, 'Only pending certificate requests can be previewed here.');
        }

        return $this->certificateView($req, false, true);
    }

    public function generate(int $id): View
    {
        $req = CertificateRequest::with('user', 'resident')->findOrFail($id);
        if ($req->status !== 'approved') {
            if ($req->status === 'picked_up') {
                abort(403, 'Certificate has already been printed.');
            }
            abort(403, 'Certificate is not yet approved.');
        }
        $req->update(['status' => 'picked_up']);
        return $this->certificateView($req, true, false);
    }

    public function printWithData(Request $request): View
    {
        $id = $request->input('certificate_id');
        $req = CertificateRequest::with('user', 'resident')->findOrFail($id);
        if ($req->status !== 'approved') {
            if ($req->status === 'picked_up') {
                abort(403, 'Certificate has already been printed.');
            }
            abort(403, 'Certificate is not yet approved.');
        }

        $name = $request->input('name', $this->resolveCertificateDisplayName($req));
        $data = $req->request_data ?? [];
        $submitted = $request->input('request_data', []);


foreach ($submitted as $k => $v) {
    $data[$k] = $v;
}
// Auto-count number of children from the children array
if (!isset($submitted['children']) && isset($req->request_data['children'])) {
    $data['children'] = $req->request_data['children'];
}


// Clear unchecked checkboxes
$checkboxKeys = [
    'bonafide','medical','hospital','postal','school','referral',
    'transaction','overseas','Ccalamity','sss','others',
    'married_to','whereabouts','separated','attest_truth'
];

foreach ($checkboxKeys as $k) {
    if (!array_key_exists($k, $submitted)) {
        $data[$k] = null;
    }
}

// Restore children if it exists and was not part of checkboxKeys
if (isset($req->request_data['children'])) {
    $data['children'] = $req->request_data['children'];
}

if (in_array($req->certificate_type, ['bonafide', 'indigency'])) {
    $address = $request->input('address', $req->address ?? $data['address'] ?? $data['postal_address'] ?? null);
    if (!empty($address)) {
        $req->address = $address;
    }
} else {
    $address = $request->input('former_address', $data['former_address'] ?? null);
}

$req->request_data = $data;
$req->save();

        $issued = $req->approved_at ?? now();
        if ($request->filled('issued_day') && $request->filled('issued_month') && $request->filled('issued_year')) {
            try {
                $issued = \Carbon\Carbon::parse(
                    $request->input('issued_day') . ' ' . $request->input('issued_month') . ' ' . $request->input('issued_year')
                );
            } catch (\Exception $e) {
                // keep default
            }
        }

        $purpose = $request->input('purpose', $req->purpose);
        $forPrint = true;
        $editable = false;

        $certificatePositions = [
            'Barangay Chairman', 'Kagawad 1', 'Kagawad 2', 'Kagawad 3', 'Kagawad 4',
            'Kagawad 5', 'Kagawad 6', 'Kagawad 7', 'SK Chairman', 'Barangay Secretary', 'Barangay Treasurer',
        ];
        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $certificatePositions)
            ->get()
            ->keyBy('position');

        $view = match ($req->certificate_type) {
            'bonafide' => 'certificate.print.bonafide',
            'indigency' => 'certificate.print.indigency',
            'soloparent' => 'certificate.print.soloparent',
            'senior' => 'certificate.print.senior',
            default => 'certificate.print.bonafide',
        };

        $req->update(['status' => 'picked_up']);

        return view($view, compact('req', 'name', 'address', 'purpose', 'data', 'issued', 'forPrint', 'editable', 'officialsByPosition'));
    }

    public function history(int $userId)
    {
        $requests = CertificateRequest::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($req) {
                return [
                    'id' => $req->id,
                    'certificate_type' => ucfirst($req->certificate_type),
                    'purpose' => \Illuminate\Support\Str::limit($req->purpose, 40),
                    'status' => $req->status,
                    'created_at' => $req->created_at->format('M d, Y H:i'),
                ];
            });

        $stats = [
            'total' => $requests->count(),
            'approved' => $requests->where('status', 'approved')->count(),
            'declined' => $requests->where('status', 'declined')->count(),
            'pending' => $requests->where('status', 'pending')->count(),
        ];

        return response()->json([
            'requests' => $requests,
            'total' => $stats['total'],
            'approved' => $stats['approved'],
            'declined' => $stats['declined'],
            'pending' => $stats['pending'],
        ]);
    }

    private function notifyAdminsOfNewCertificateRequest(CertificateRequest $certificateRequest): void
    {
        $adminEmails = User::query()
            ->where('role', 'admin')
            ->where('status', 'approved')
            ->whereNotNull('email')
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($adminEmails)) {
            return;
        }

        Mail::to($adminEmails)->send(new NewCertificateRequestAlertMail($certificateRequest));
    }

    private function certificateView(CertificateRequest $req, bool $forPrint, bool $editable = false): View
    {
        $view = match ($req->certificate_type) {
            'bonafide' => 'certificate.print.bonafide',
            'indigency' => 'certificate.print.indigency',
            'soloparent' => 'certificate.print.soloparent',
            'senior' => 'certificate.print.senior',
            default => 'certificate.print.bonafide',
        };
        $data = $req->request_data ?? [];

        $name = $this->resolveCertificateDisplayName($req);
        $address = match ($req->certificate_type) {
            'bonafide', 'indigency' => $req->address ?? $data['address'] ?? $data['postal_address'] ?? null,
            default => $data['former_address'] ?? null,
        };
        $purpose = $req->purpose;
        $data = $req->request_data ?? [];
        $issued = $req->approved_at ?? now();

        $certificatePositions = [
            'Barangay Chairman', 'Kagawad 1', 'Kagawad 2', 'Kagawad 3', 'Kagawad 4',
            'Kagawad 5', 'Kagawad 6', 'Kagawad 7', 'SK Chairman', 'Barangay Secretary', 'Barangay Treasurer',
        ];
        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $certificatePositions)
            ->get()
            ->keyBy('position');

        return view($view, compact('req', 'name', 'address', 'purpose', 'data', 'issued', 'forPrint', 'editable', 'officialsByPosition'));
    }
}
