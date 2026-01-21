<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blotter;
use App\Models\UpdateBlotter;
use Illuminate\Support\Facades\Auth;

class BlotterController extends Controller
{
    // LIST ALL BLOTTERS (ADMIN)
    public function index()
    {
        $blotters = Blotter::with('updates')->latest()->paginate(10);
        return view('admin.Blotter', compact('blotters'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('admin.Blotter');
    }

    // STORE NEW BLOTTER
    public function submitBlotter(Request $request)
    {
        $request->validate([
            'plaintiffName' => 'required|string',
            'plaintiffLastName' => 'required|string',
            'blotterDescription' => 'required|string',
        ]);

        $blotter = Blotter::create([
            'plaintiffName' => $request->plaintiffName,
            'plaintiffMiddleName' => $request->plaintiffMiddleName,
            'plaintiffLastName' => $request->plaintiffLastName,
            'plaintiffAge' => $request->plaintiffAge,
            'plaintiffAddress' => $request->plaintiffAddress,
            'plaintiffContactNumber' => $request->plaintiffContactNumber,

            'defendantName' => $request->defendantName,
            'defendantMiddleName' => $request->defendantMiddleName,
            'defendantLastName' => $request->defendantLastName,
            'defendantAge' => $request->defendantAge,
            'defendantAddress' => $request->defendantAddress,
            'defendantContactNumber' => $request->defendantContactNumber,

            'witnessName' => $request->witnessName,
            'witnessContactNumber' => $request->witnessContactNumber,

            'proof' => $request->proof,
            'blotterDescription' => $request->blotterDescription,
            'schedule' => $request->schedule,

            'encodedBy' => Auth::id(),
            'current_status' => 'first',
        ]);

        UpdateBlotter::create([
            'blotter_id' => $blotter->id,
            'status' => 'first',
            'remarks' => 'Initial blotter record',
            'updated_by' => Auth::id(),
            'photo_path' => $blotter->proof,
            'date' => now(),
        ]);

        return redirect()->route('admin.blotter.index')
            ->with('success', 'Blotter created successfully.');
    }

    // SHOW UPDATE FORM
  public function showUpdateForm($id)
{
    $blotter = Blotter::with('updates')->findOrFail($id);

    $statuses = [
        'first',
        'second',
        'third',
        'brgyHearing',
        'coldCase',
        'criminalCase',
    ];

    $usedStatuses = $blotter->update_blotter 
        ? $blotter->update_blotter->pluck('status')->toArray() 
        : [];

    $availableStatuses = array_diff($statuses, $usedStatuses);

    // Return the UPDATE FORM view, not the main Blotter index view
    return view('forms.update', compact('blotter', 'availableStatuses'));
}

    // STORE NEW UPDATE (NO EDITING)
    public function storeUpdate(Request $request, $id)
    {
        $blotter = Blotter::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'remarks' => 'required|string',
            'photo_path' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $exists = UpdateBlotter::where('blotter_id', $blotter->id)
            ->where('status', $request->status)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This status has already been used.');
        }

        UpdateBlotter::create([
            'blotter_id' => $blotter->id,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'photo_path' => $request->photo_path,
            'updated_by' => Auth::id(),
            'date' => $request->date,
            'is_finished' => in_array($request->status, ['coldCase', 'criminalCase']),
        ]);

        $blotter->update([
            'current_stauts' => $request->status,
        ]);

        return back()->with('success', 'Blotter updated successfully.');
    }
}
