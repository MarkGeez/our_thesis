<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blotter;
use App\Models\UpdateBlotter;
use Illuminate\Support\Facades\Auth;

class BlotterController extends Controller
{
    /**
     * Map status codes to human-readable labels
     */
    private static function getStatusLabels()
    {
        return [
            'first' => 'First Summon',
            'second' => 'Second Summon',
            'third' => 'Third Summon',
            'brgyHearing' => 'Brgy Hearing',
            'coldCase' => 'Cold Case',
            'criminalCase' => 'Criminal Case',
        ];
    }

    /**
     * Get display label for a status code
     */
    public static function getStatusLabel($status)
    {
        $labels = self::getStatusLabels();
        return $labels[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    // LIST ALL BLOTTERS (ADMIN)
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $statusFilter = (string) $request->query('status_filter', 'all');
        $sort = (string) $request->query('sort', 'id_desc');

        $query = Blotter::with(['updates.updater']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('plaintiffName', 'like', '%' . $search . '%')
                    ->orWhere('plaintiffLastName', 'like', '%' . $search . '%')
                    ->orWhere('defendantName', 'like', '%' . $search . '%')
                    ->orWhere('defendantLastName', 'like', '%' . $search . '%')
                    ->orWhere('current_status', 'like', '%' . $search . '%');
            });
        }

        if ($statusFilter === 'pending') {
            $query->whereIn('current_status', ['first', 'second', 'third']);
        } elseif ($statusFilter === 'ongoing') {
            $query->where('current_status', 'brgyHearing');
        } elseif ($statusFilter === 'closed') {
            $query->whereIn('current_status', ['coldCase', 'criminalCase']);
        }

        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'complainant_asc':
                $query->orderBy('plaintiffName', 'asc')->orderBy('plaintiffLastName', 'asc');
                break;
            case 'complainant_desc':
                $query->orderBy('plaintiffName', 'desc')->orderBy('plaintiffLastName', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('current_status', 'asc')->orderBy('id', 'desc');
                break;
            case 'status_desc':
                $query->orderBy('current_status', 'desc')->orderBy('id', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $blotters = $query->paginate(10)->appends($request->query());
        return view('admin.Blotter', compact('blotters', 'search', 'statusFilter', 'sort'));
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
    
    // Create status labels mapping for view
    $statusLabels = self::getStatusLabels();

    // Return the UPDATE FORM view, not the main Blotter index view
    return view('forms.update', compact('blotter', 'availableStatuses', 'history', 'statusLabels'));
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
           // 'is_finished' => in_array($request->status, ['coldCase', 'criminalCase']),
        ]);

        $blotter->update([
            'current_status' => $request->status,
        ]);
    
        return back()->with('success', 'Blotter updated successfully.');
    }

    /*
    public function updateStatus(Request $request, $id){
        $blotter = UpdateBlotter::findOrFail($id);
        
        if($blotter->isFinished()===true){
            return back()->with('error', 'cannot update blotter, it is already finished');
        }


        $request->validate([
            'is_finished' = "required|boolean"
        ]);

        

        $blotter->update([
            'is_finished' => $request->boolean('is_finished'),
            'finished_by' => auth()->id()
        ]);
    } */
}
