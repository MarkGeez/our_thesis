<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\Resident;
use App\Models\Official;
use App\Models\OfficialHistory;


class OfficialController extends Controller
{
    /**
     * Fixed official slots displayed on the module.
     * These labels also double as the position keys stored in the database.
     */
    private array $positionSlots = [
        'Barangay Chairman',
        'Kagawad 1',
        'Kagawad 2',
        'Kagawad 3',
        'Kagawad 4',
        'Kagawad 5',
        'Kagawad 6',
        'Kagawad 7',
        'SK Chairman',
        'SK Kagawad 1',
        'SK Kagawad 2',
        'SK Kagawad 3',
        'SK Kagawad 4',
        'SK Kagawad 5',
        'SK Kagawad 6',
        'SK Kagawad 7',
        'Barangay Secretary',
        'Barangay Treasurer',
    ];

    private function positionOptions(): array
    {
        return $this->positionSlots;
    }

    public function displayOfficials()
    {
        $positions = $this->positionOptions();

        $officialsByPosition = Official::with('resident:id,firstName,middleName,lastName,image_path')
            ->whereIn('position', $positions)
            ->get()
            ->keyBy('position');

        $residents = Resident::orderBy('lastName')
            ->orderBy('firstName')
            ->get(['id', 'firstName', 'middleName', 'lastName', 'image_path']);

        $selectedYear = (int) request()->integer('year', now()->year);
        if ($selectedYear < 1900 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        $historyYears = OfficialHistory::selectRaw('YEAR(start) as year')
            ->whereNotNull('start')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->values();

        if (!$historyYears->contains($selectedYear)) {
            $historyYears = $historyYears->prepend($selectedYear)->unique()->values();
        }

        $fromDate = sprintf('%04d-01-01', $selectedYear);
        $toDate = sprintf('%04d-12-31', $selectedYear);

        $historyRows = OfficialHistory::with('resident:id,firstName,middleName,lastName')
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('start', [$fromDate, $toDate])
                    ->orWhereBetween('end', [$fromDate, $toDate])
                    ->orWhere(function ($q) use ($fromDate, $toDate) {
                        $q->whereNotNull('start')
                          ->whereNotNull('end')
                          ->where('start', '<=', $fromDate)
                          ->where('end', '>=', $toDate);
                    });
            })
            ->orderBy('position')
            ->orderByDesc('start')
            ->get();

        $user = auth()->user();

        return view($user->role . '.barangayOfficials', compact(
            'positions',
            'officialsByPosition',
            'residents',
            'user',
            'historyRows',
            'historyYears',
            'selectedYear'
        ));
    }

    private function recordHistoryFromOfficial(Official $official, string $action): void
    {
        OfficialHistory::create([
            'official_id' => $official->id,
            'resident_id' => $official->resident_id,
            'position' => $official->position,
            'details' => $official->details,
            'start' => $official->start,
            'end' => $official->end,
            'action' => $action,
            'changed_by' => auth()->id(),
        ]);
    }

    private function persistOfficial(array $data, ?Official $official = null): Official
    {
        $validPositions = $this->positionOptions();

        $validated = validator($data, [
            'position'    => ['required', Rule::in($validPositions)],
            'resident_id' => ['required', 'exists:residents,id'],
            'details'     => ['nullable', 'string', 'max:255'],
            'start'       => ['nullable', 'date_format:Y-m-d'],
            'end'         => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start'],
        ])->validate();

        $start = $validated['start'] ?? now()->toDateString();
        $end = $validated['end'] ?? now()->copy()->addYears(3)->toDateString();

        $existing = Official::where('position', $validated['position'])->first();

        $residentAssigned = Official::where('resident_id', $validated['resident_id'])
            ->when($official, function ($query) use ($official) {
                $query->where('id', '!=', $official->id);
            })
            ->first();

        if ($residentAssigned) {
            throw ValidationException::withMessages([
                'resident_id' => 'Resident is already assigned to ' . $residentAssigned->position . '. Clear that slot first.',
            ]);
        }

        $payload = [
            'position'    => $validated['position'],
            'resident_id' => $validated['resident_id'],
            'details'     => $validated['details'] ?? '',
            'start'       => $start,
            'end'         => $end,
        ];

        if ($official) {
            $this->recordHistoryFromOfficial($official, 'updated');

            if ($existing && $existing->id !== $official->id) {
                $this->recordHistoryFromOfficial($existing, 'replaced');
                $existing->delete();
            }

            $official->update($payload);
            return $official;
        }

        if ($existing) {
            $this->recordHistoryFromOfficial($existing, 'replaced');
            $existing->update($payload);
            return $existing;
        }

        return Official::create($payload);
    }

    public function assign(Request $request)
    {
        $user = auth()->user();
        $userResidentId = optional($user?->resident)->id;

        if ($user && $user->role === 'admin' && $userResidentId) {
            $selfOfficial = Official::where('resident_id', $userResidentId)->first();

            if ($selfOfficial) {
                $requestedPosition = (string) $request->input('position', '');
                $requestedResidentId = (int) $request->input('resident_id');

                $isReplacingSelfFromOwnSlot =
                    $requestedPosition === (string) $selfOfficial->position &&
                    $requestedResidentId !== (int) $userResidentId;

                $isMovingSelfToAnotherSlot =
                    $requestedResidentId === (int) $userResidentId &&
                    $requestedPosition !== (string) $selfOfficial->position;

                if ($isReplacingSelfFromOwnSlot || $isMovingSelfToAnotherSlot) {
                    return back()->withErrors([
                        'position' => 'You cannot modify your own official position from the Officials module.',
                    ]);
                }
            }
        }

        $term = $request->validate([
            'term_start' => ['required', 'date_format:Y-m-d'],
            'term_end' => ['required', 'date_format:Y-m-d', 'after_or_equal:term_start'],
        ]);

        $data = $request->all();
        $data['start'] = $term['term_start'];
        $data['end'] = $term['term_end'];

        $this->persistOfficial($data);

        return back()->with('success', 'Official slot updated successfully.');
    }

    public function addOfficial(Request $request, $id)
    {
        $data = $request->all();
        $data['resident_id'] = $id;

        $this->persistOfficial($data);

        return back()->with('success', 'Successfully assigned resident to official slot.');
    }

    public function updateOfficial(Request $request, $id)
    {
        $official = Official::findOrFail($id);

        $data = $request->all();
        $data['resident_id'] = $request->input('resident_id', $official->resident_id);
        $data['position'] = $request->input('position', $official->position);

        $this->persistOfficial($data, $official);

        return back()->with('success', 'Official information updated successfully.');
    }

    public function untagOfficial(Request $request, $id)
    {
        $official = Official::findOrFail($id);
        $user = auth()->user();
        $userResidentId = optional($user?->resident)->id;

        if ($user && $user->role === 'admin' && $userResidentId && (int) $official->resident_id === (int) $userResidentId) {
            return back()->withErrors([
                'errors' => 'You cannot remove your own official position from the Officials module.',
            ]);
        }

        if($official->position === "chairman" && $user->role === "admin"){
            return back()->withErrors([
                "errors" => "Cant untag chairman, contact the super admin to remove."
            ]);
        }
        
        $this->recordHistoryFromOfficial($official, 'removed');
        $official->delete();

        return redirect()->back()->with('success', 'Official removed successfully.');
    }
}
