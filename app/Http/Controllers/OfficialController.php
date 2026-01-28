<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\Resident;
use App\Models\Official;


class OfficialController extends Controller
{
    /**
     * Fixed official slots displayed on the module.
     * These labels also double as the position keys stored in the database.
     */
    private array $positionSlots = [
        'Barangay Chairman',
        'Barangay Secretary',
        'Barangay Treasurer',
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

        $user = auth()->user();

        return view($user->role . '.barangayOfficials', compact('positions', 'officialsByPosition', 'residents', 'user'));
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
            if ($existing && $existing->id !== $official->id) {
                $existing->delete();
            }

            $official->update($payload);
            return $official;
        }

        if ($existing) {
            $existing->update($payload);
            return $existing;
        }

        return Official::create($payload);
    }

    public function assign(Request $request)
    {
        $this->persistOfficial($request->all());

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
        $official->delete();

        return redirect()->back()->with('success', 'Official removed successfully.');
    }
}