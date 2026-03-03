<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blotter;
use App\Models\UpdateBlotter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlotterController extends Controller
{
    private const BLOTTER_TYPES = [
        'regular',
        'vawc',
    ];

    private const STATUS_SEQUENCE = [
        'first',
        'second',
        'third',
        'brgyHearing',
        'coldCase',
        'criminalCase',
        'referredToPnp',
        'resolved',
    ];

    private const TERMINAL_STATUSES = [
        'referredToPnp',
        'resolved',
    ];

    private static function getBlotterTypeLabels(): array
    {
        return [
            'regular' => 'Regular Blotter',
            'vawc' => 'VAWC Blotter',
        ];
    }

    /**
     * Map status codes to human-readable labels
     */
    private static function getStatusLabels()
    {
        return [
            'first' => 'First Summon',
            'second' => 'Second Summon',
            'third' => 'Third Summon',
            'brgyHearing' => 'Barangay Hearing',
            'coldCase' => 'Cold Case',
            'criminalCase' => 'Criminal Case',
            'referredToPnp' => 'Referred to PNP',
            'resolved' => 'Resolved',
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
        $activeTab = (string) $request->query('tab', 'all');
        $sort = (string) $request->query('sort', 'id_desc');

        if (!in_array($activeTab, ['all', ...self::BLOTTER_TYPES], true)) {
            $activeTab = 'all';
        }

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
            $query->whereIn('current_status', ['coldCase', 'criminalCase', 'referredToPnp', 'resolved']);
        }

        if ($activeTab !== 'all') {
            $query->where('blotter_type', $activeTab);
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
                $query->orderByRaw("
                    CASE current_status
                        WHEN 'first' THEN 1
                        WHEN 'second' THEN 2
                        WHEN 'third' THEN 3
                        WHEN 'brgyHearing' THEN 4
                        WHEN 'coldCase' THEN 5
                        WHEN 'criminalCase' THEN 6
                        WHEN 'referredToPnp' THEN 7
                        WHEN 'resolved' THEN 8
                        ELSE 99
                    END ASC
                ")->orderBy('id', 'desc');
                break;
            case 'status_desc':
                $query->orderByRaw("
                    CASE current_status
                        WHEN 'first' THEN 1
                        WHEN 'second' THEN 2
                        WHEN 'third' THEN 3
                        WHEN 'brgyHearing' THEN 4
                        WHEN 'coldCase' THEN 5
                        WHEN 'criminalCase' THEN 6
                        WHEN 'referredToPnp' THEN 7
                        WHEN 'resolved' THEN 8
                        ELSE 99
                    END DESC
                ")->orderBy('id', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $blotters = $query->paginate(10)->appends($request->query());
        $statusLabels = self::getStatusLabels();
        $typeLabels = self::getBlotterTypeLabels();

        return view('admin.Blotter', compact('blotters', 'search', 'statusFilter', 'activeTab', 'sort', 'statusLabels', 'typeLabels'));
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
'blotter_type' => ['nullable', Rule::in(self::BLOTTER_TYPES)],
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
    'blotter_type' => $request->input('blotter_type', 'regular'),
    'schedule' => $request->schedule,

    'encodedBy' => Auth::id(),
    'current_status' => 'first',
]);

UpdateBlotter::create([
    'blotter_id' => $blotter->id,
    'status' => 'first',
    'remarks' => $request->blotterDescription,
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
    $usedStatuses = $blotter->updates->pluck('status')->toArray();
    $isTerminal = in_array($blotter->current_status, self::TERMINAL_STATUSES, true);
    $availableStatuses = $isTerminal ? [] : array_diff(self::STATUS_SEQUENCE, $usedStatuses);
    
    // Create status labels mapping for view
    $statusLabels = self::getStatusLabels();

    // Return the UPDATE FORM view, not the main Blotter index view
    return view('forms.update', compact('blotter', 'availableStatuses', 'history', 'statusLabels', 'isTerminal'));
    }

    // STORE NEW UPDATE (NO EDITING)
    public function storeUpdate(Request $request, $id)
    {
        $blotter = Blotter::findOrFail($id);

        if (in_array($blotter->current_status, self::TERMINAL_STATUSES, true)) {
            return back()->with('error', 'This blotter is already closed and can no longer be updated.');
        }

        $request->validate([
            'status' => ['required', Rule::in(self::STATUS_SEQUENCE)],
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
            'is_finished' => in_array($request->status, self::TERMINAL_STATUSES, true),
            'finished_by' => in_array($request->status, self::TERMINAL_STATUSES, true) ? Auth::id() : null,
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
