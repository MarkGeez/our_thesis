<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use App\Services\ArchiveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function residentIndex(): View
    {
        $resident = Auth::user();

        $services = Service::orderBy('name')->get();
        $requests = ServiceRequest::with('service')
            ->where('user_id', $resident?->id)
            ->latest()
            ->get();

        return view('resident.services', compact('resident', 'services', 'requests'));
    }

    public function adminIndex(): View
    {
        $admin = Auth::user();
        $services = Service::latest()->get();
        $requests = ServiceRequest::with('service')
            ->where('user_id', $admin?->id)
            ->latest()
            ->get();

        return view('admin.adminServices', compact('admin', 'services', 'requests'));
    }

    public function subadminIndex(): View
    {
        $subadmin = Auth::user();
        $services = Service::latest()->get();
        $requests = ServiceRequest::with('service')
            ->where('user_id', $subadmin?->id)
            ->latest()
            ->get();

        return view('subadmin.subadminServices', compact('subadmin', 'services', 'requests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'serviceAvailability' => 'required|in:AVAILABLE,UNAVAILABLE',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $imagePath = 'storage/' . $path;
        }

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'serviceAvailability' => $request->serviceAvailability,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Service saved successfully.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'serviceAvailability' => 'required|in:AVAILABLE,UNAVAILABLE,BORROWED',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'serviceAvailability' => $request->serviceAvailability,
        ];

        if ($request->hasFile('image')) {
            $existingPath = $service->image_path ? str_replace('storage/', '', $service->image_path) : null;

            if ($existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }

            $path = $request->file('image')->store('services', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $service->update($data);

        return back()->with('success', 'Service updated.');
    }

    public function archive(Service $service, ArchiveService $archiveService): RedirectResponse
    {
        $archiveService->archive($service, 'Archived service/equipment');

        return back()->with('success', 'Service archived.');
    }
}
