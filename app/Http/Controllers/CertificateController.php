<?php

namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use App\Models\Official;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CertificateController extends Controller
{
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
    
    $data = $validated['request_data'] ?? [];
    
    // For solo parent and senior, get form data
    if (in_array($validated['certificate_type'], ['soloparent', 'senior'])) {
        $formData = $request->form_data ?? [];
        $data = array_merge($data, $formData);
    }
    
    if (!empty($validated['address'])) {
        $data['address'] = $validated['address'];
    }
    
    CertificateRequest::create([
        'user_id' => $user->id,
        'resident_id' => $resident?->id,
        'certificate_type' => $validated['certificate_type'],
        'purpose' => $finalPurpose,
        'purpose_other' => $purposeOthers,
        'request_data' => $data,
        'status' => 'pending',
    ]);
    
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
        $req = CertificateRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is no longer pending.');
        }
        $req->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'decline_reason' => null,
        ]);
        return back()->with('success', 'Certificate request approved. Requester may pick up at admin\'s house.');
    }

    public function reject(Request $request, int $id)
    {
        $validated = $request->validate([
            'decline_reason' => 'nullable|string|max:500',
        ]);
        $req = CertificateRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is no longer pending.');
        }
        $req->update([
            'status' => 'declined',
            'decline_reason' => $validated['decline_reason'] ?? null,
            'approved_at' => null,
            'approved_by' => null,
        ]);
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

        $name = $request->input('name', ucwords(strtolower($req->requester_name)));
        $address = $request->input(
    'former_address',
    $req->request_data['former_address'] ?? null
);
        $data = $req->request_data ?? [];
        $submitted = $request->input('request_data', []);
        foreach ($submitted as $k => $v) {
            $data[$k] = $v;
        }
        // Clear checkbox keys not in submitted (user unchecked them)
        $checkboxKeys = ['bonafide','medical','hospital','postal','school','referral','transaction','overseas','Ccalamity','sss','others','married_to','no_knowledge_whereabouts','separated'];
        foreach ($checkboxKeys as $k) {
            if (!array_key_exists($k, $submitted)) {
                $data[$k] = null;
            }
        }

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
            'Kagawad 5', 'Kagawad 6', 'Kagawad 7', 'Barangay Secretary', 'Barangay Treasurer', 'SK Chairman',
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

        $name = ucwords(strtolower($req->requester_name));
$address = $data['former_address'] ?? null;
        $purpose = $req->purpose;
        $data = $req->request_data ?? [];
        $issued = $req->approved_at ?? now();

        $certificatePositions = [
            'Barangay Chairman', 'Kagawad 1', 'Kagawad 2', 'Kagawad 3', 'Kagawad 4',
            'Kagawad 5', 'Kagawad 6', 'Kagawad 7', 'Barangay Secretary', 'Barangay Treasurer', 'SK Chairman',
        ];
        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $certificatePositions)
            ->get()
            ->keyBy('position');

        return view($view, compact('req', 'name', 'address', 'purpose', 'data', 'issued', 'forPrint', 'editable', 'officialsByPosition'));
    }
}