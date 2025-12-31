<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function adminIndex(): View
    {
        $admin = Auth::user();
        $serviceRequests = ServiceRequest::with(['service', 'user'])->latest()->paginate(10);
        $services = Service::orderBy('name')->get();

        return view('admin.serviceRequest', compact('admin', 'serviceRequests', 'services'));
    }

    public function subadminIndex(): View
    {
        $subadmin = Auth::user();
        $serviceRequests = ServiceRequest::with(['service', 'user'])->latest()->paginate(10);
        $services = Service::orderBy('name')->get();

        return view('subadmin.serviceRequest', compact('subadmin', 'serviceRequests', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'service_type_id' => 'required|exists:services,id',
            'purpose' => 'required|string|max:255',
            'request_schedule' => 'nullable|date|after_or_equal:today',
            'quantity_requested' => 'nullable|integer|min:1',
            'remarks' => 'nullable|string|max:255',
        ]);

        $service = Service::findOrFail($request->service_type_id);

        $hasApprovedBorrow = ServiceRequest::where('service_type_id', $service->id)
            ->where('status', 'APPROVED')
            ->exists();

        if (strtoupper($service->serviceAvailability) !== 'AVAILABLE' || $hasApprovedBorrow) {
            return back()->withErrors(['service_type_id' => 'This service is currently not available for borrowing.'])->withInput();
        }

        ServiceRequest::create([
            'service_type_id' => $service->id,
            'user_id' => Auth::id(),
            'purpose' => $request->purpose,
            'status' => 'PENDING',
            'request_schedule' => $request->request_schedule,
            'quantity_requested' => $request->quantity_requested ?? 1,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Service request submitted.');
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        if (! in_array(Auth::user()->role, ['admin', 'subadmin'])) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:PENDING,APPROVED,DECLINED,RETURNED',
            'remarks' => 'nullable|string|max:255',
        ]);

        $service = $serviceRequest->service;

        if ($request->status === 'APPROVED') {
            $alreadyApproved = ServiceRequest::where('service_type_id', $service?->id)
                ->where('status', 'APPROVED')
                ->where('id', '!=', $serviceRequest->id)
                ->exists();

            if ($service && (strtoupper($service->serviceAvailability) === 'BORROWED' || $alreadyApproved) && $serviceRequest->status !== 'APPROVED') {
                return back()->withErrors(['status' => 'This service is already borrowed and cannot be approved again.']);
            }
            if ($service) {
                $service->serviceAvailability = 'BORROWED';
                $service->save();
            }
        }

        if (in_array($request->status, ['DECLINED', 'RETURNED'], true) && $service) {
            $service->serviceAvailability = 'AVAILABLE';
            $service->save();
        }

        $serviceRequest->status = $request->status;
        $serviceRequest->remarks = $request->remarks;
        $serviceRequest->returned_at = $request->status === 'RETURNED' ? now() : null;
        $serviceRequest->save();

        return back()->with('success', 'Request updated.');
    }
}
