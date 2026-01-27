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
        $blotters = Blotter::with(['updates.updater'])->latest()->paginate(10);
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
'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
]);

$proofPath = null;

if ($request->hasFile('proof')) {
    $proofPath = $request->file('proof')->store('blotter_proofs', 'public');
}

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

    'proof' => $proofPath,
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
    'photo_path' => $proofPath,
    'date' => now(),
]);

return redirect()->route('admin.blotter.index')
    ->with('success', 'Blotter created successfully.');


}

    // SHOW UPDATE FORM
  public function showUpdateForm($id)
    {
        $blotter = Blotter::with(['updates.updater'])->findOrFail($id);

    $history = $blotter->updates->sortByDesc('date');
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
    return view('forms.update', compact('blotter', 'availableStatuses' , 'history'));
    }

    // STORE NEW UPDATE (NO EDITING)
    public function storeUpdate(Request $request, $id)
    {
        $blotter = Blotter::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'remarks' => 'required|string',
            'photo_path' => 'nullable|mimes:png,jpg,jpeg|max:4096',
            'date' => 'required|date',
        ]);

        $exists = UpdateBlotter::where('blotter_id', $blotter->id)
            ->where('status', $request->status)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This status has already been used.');
        }
        $image=null;
        if($request->hasFile('photo_path')){
            $image = $request->file('photo_path')->store('blotter', 'public');
        }

        UpdateBlotter::create([
            'blotter_id' => $blotter->id,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'photo_path' => $image,
            'updated_by' => Auth::id(),
            'date' => $request->date,
            'is_finished' => in_array($request->status, ['coldCase', 'criminalCase']),
        ]);

        $blotter->update([
            'current_status' => $request->status,
        ]);
    
        return back()->with('success', 'Blotter updated successfully.');
    }
}
