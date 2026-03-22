<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Archive;
use App\Models\Official;
use App\Models\House;
use App\Models\Street;
use App\Models\Household;
use App\Models\HouseholdResident;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


class ResidentListController extends Controller
{
    use ValidatesContactNumbers;

    private const RESIDENT_TYPE_OPTIONS = [
        'voter',
        'senior_citizen',
        'pwd',
        'solo_parent',
    ];

private function normalizeResidentTypes($types): ?array
{
    $normalized = collect($types)
        ->map(function ($value) {
            return strtolower(trim((string) $value));
        })
        ->filter(function (string $value) {
            return $value !== '' && in_array($value, self::RESIDENT_TYPE_OPTIONS, true);
        })
        ->unique()
        ->values()
        ->all();

    return empty($normalized) ? null : $normalized;
}

private function normalizeResidentPayload(array $validated): array
{
    if (array_key_exists('firstName', $validated)) {
        $validated['firstName'] = strtolower(trim((string) $validated['firstName']));
    }

    if (array_key_exists('middleName', $validated)) {
        $validated['middleName'] = strtolower(trim((string) $validated['middleName']));
    }

    if (array_key_exists('lastName', $validated)) {
        $validated['lastName'] = strtolower(trim((string) $validated['lastName']));
    }

    if (array_key_exists('contactNo', $validated)) {
        $validated['contactNo'] = trim((string) $validated['contactNo']);
    }

    if (array_key_exists('emergencyContactNo', $validated)) {
        $validated['emergencyContactNo'] = trim((string) $validated['emergencyContactNo']);
    }

    if (array_key_exists('emergencyContactName', $validated)) {
        $validated['emergencyContactName'] = trim((string) $validated['emergencyContactName']);
    }

    if (!empty($validated['birthday'])) {
        $validated['birthday'] = Carbon::parse($validated['birthday'])->format('Y-m-d');
        $validated['age'] = Carbon::parse($validated['birthday'])->age;
    }

    $normalizedTypes = [];
    if (array_key_exists('type', $validated)) {
        $normalizedTypes = $this->normalizeResidentTypes($validated['type']) ?? [];
    }

    $isSeniorCitizenWorthy = !empty($validated['birthday'])
        && isset($validated['age'])
        && (int) $validated['age'] >= 60;

    $normalizedTypes = array_values(array_filter($normalizedTypes, function (string $residentType): bool {
        return $residentType !== 'senior_citizen';
    }));

    if ($isSeniorCitizenWorthy) {
        $normalizedTypes[] = 'senior_citizen';
    }

    $validated['type'] = empty($normalizedTypes)
        ? null
        : array_values(array_unique($normalizedTypes));

    return $validated;
}

private function syncLinkedUserFromResident(Resident $resident, array $validated, bool $syncNames = false): void
{
    if (!$resident->user) {
        return;
    }

    if ($syncNames) {
        $resident->user->firstName = $validated['firstName'] ?? $resident->user->firstName;
        $resident->user->middleName = $validated['middleName'] ?? $resident->user->middleName;
        $resident->user->lastName = $validated['lastName'] ?? $resident->user->lastName;
    }

    if (array_key_exists('contactNo', $validated)) {
        $resident->user->contactNumber = $validated['contactNo'];
    }

    if (array_key_exists('birthday', $validated)) {
        $resident->user->birthday = $validated['birthday'];
    }

    if (array_key_exists('image_path', $validated) && !empty($validated['image_path'])) {
        $resident->user->profile_image = $validated['image_path'];
    }

    $resident->user->save();
}

public function showResidents(Request $request)
{
    $streets = Street::has('houses')->get();
    $houses  = House::all();
    $user = auth()->user();
    
    if(!$user || $user->role === "resident" || $user->role === "non-resident"){
        abort(403);
    }
    
    $searchTerm = $request->input('search');
    $sexFilter = $request->input('sex_filter', 'all');
    $sort = $request->input('sort', 'id_desc');
    
    $residentCount = Resident::count();
    $maleCount = Resident::where('sex', 'male')->count();
    $femaleCount = Resident::where('sex', 'female')->count();
    $seniorCount = Resident::where('age', '>=', 60)->count();
    
    $residents = Resident::with(['user:id,firstName,lastname,profile_image', 'official', 'households.house.street'])
        ->when($searchTerm, function($query, $searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $q->where('firstName', 'like', "%{$searchTerm}%")
                  ->orWhere('lastName', 'like', "%{$searchTerm}%")
                  ->orWhere('middleName', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        })
        ->when(in_array($sexFilter, ['male', 'female'], true), function ($query) use ($sexFilter) {
            return $query->where('sex', $sexFilter);
        });


    switch ($sort) {
        case 'id_asc':
            $residents->orderBy('id', 'asc');
            break;
        case 'name_asc':
            $residents->orderBy('lastName', 'asc')->orderBy('firstName', 'asc');
            break;
        case 'name_desc':
            $residents->orderBy('lastName', 'desc')->orderBy('firstName', 'desc');
            break;
        case 'id_desc':
        default:
            $residents->orderBy('id', 'desc');
            break;
    }

    $residents = $residents->paginate(20)->appends($request->query());
    $allResidents =  Resident::select(
        'id',
        'firstName',
        'middleName',
        'lastName'
    )->get();

    $headCandidateResidents = Resident::with('households:id,house_id')
        ->select('id', 'firstName', 'middleName', 'lastName', 'birthday', 'age', 'sex', 'contactNo', 'headOfFamily')
        ->get()
        ->map(function (Resident $resident) {
            return [
                'id' => $resident->id,
                'firstName' => $resident->firstName,
                'middleName' => $resident->middleName,
                'lastName' => $resident->lastName,
                'birthday' => $resident->birthday,
                'age' => $resident->age,
                'sex' => $resident->sex,
                'contactNo' => $resident->contactNo,
                'headOfFamily' => $resident->headOfFamily,
                'householdIds' => $resident->households->pluck('id')->values(),
                'houseIds' => $resident->households->pluck('house_id')->filter()->values(),
            ];
        });

    return view($user->role . '.residents', compact(
    'user', 'residents', 'searchTerm', 'streets', 'houses',
    'residentCount', 'maleCount', 'femaleCount', 'seniorCount', 'sexFilter', 'sort', 'allResidents', 'headCandidateResidents'
));
}

// Then remove searchResidents() or keep it as an alias
public function searchResidents(Request $request)
{
    return $this->showResidents($request);
}

    public function encodeResidents(Request $request){
     
        $validated = $request->validate([
            'firstName' => 'required|string|max:70',
            'middleName' => 'nullable|string|max:70',
            'lastName' => 'required|string|max:70',
            'contactNo' => $this->nullableContactNumberRules(),
            'birthday' => 'required|date',
            'emergencyContactNo' => $this->nullableContactNumberRules(),
            'emergencyContactName' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0|max:255',
            'sex' => 'nullable|in:male,female',
            'parent' => 'nullable|in:yes,no,single',
            'enrolled' => 'nullable|in:yes,no',
            'educationalAttainment' => 'nullable|string',
            'headOfFamily' => 'required|in:yes,no',
            'type' => 'nullable|array',
            'type.*' => 'nullable|in:voter,senior_citizen,pwd,solo_parent',
            'image_path' => 'nullable|mimes:jpg,jpeg,png|max:4096', // Changed to match form
            'house_id' => 'required|exists:houses,id',
        ], $this->contactNumberMessages(['contactNo', 'emergencyContactNo']));



        // Handle image upload
        if($request->hasFile('image_path')){
            $image = $request->file('image_path')->store('resident', 'public');
            $validated['image_path'] = $image;
        }

        $validated = $this->normalizeResidentPayload($validated);

        $validated['contactNo'] = filled($validated['contactNo'] ?? null)
            ? trim((string) $validated['contactNo'])
            : 'N/A';
        $validated['emergencyContactNo'] = filled($validated['emergencyContactNo'] ?? null)
            ? trim((string) $validated['emergencyContactNo'])
            : 'N/A';
        $validated['emergencyContactName'] = filled($validated['emergencyContactName'] ?? null)
            ? trim((string) $validated['emergencyContactName'])
            : 'N/A';
        
        // Add encoded by
        $validated['EncodedBy'] = auth()->id();

        // Create resident
        $resident = Resident::create($validated);
$household = Household::firstOrCreate(['house_id' => $validated['house_id']]);  
        HouseholdResident::create([
    'household_id' => $household->id,
    'resident_id'  => $resident->id,
    'is_household_head'   => $validated['headOfFamily'] === 'yes' ? true : false,]);
    
        return redirect()->back()->with('success', 'Resident encoded successfully!');
    
    }

      public function updateResident(Request $request, $id){
        $user = auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }
        

        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'firstName' => 'required|string|max:70',
            'middleName' => 'nullable|string|max:70',
            'lastName' => 'required|string|max:70',
            'contactNo' => $this->nullableContactNumberRules(),
            'birthday' => 'required|date',
            'emergencyContactNo' => $this->nullableContactNumberRules(),
            'emergencyContactName' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0|max:255',
            'sex' => 'required|in:male,female',
            'parent' => 'required|in:yes,no,single',
            'enrolled' => 'required|in:yes,no',
            'educationalAttainment' => 'nullable|string|max:255',
            'headOfFamily' => 'required|in:yes,no',
            'type' => 'nullable|array',
            'type.*' => 'nullable|in:voter,senior_citizen,pwd,solo_parent',
            'new_head_id' => 'nullable|exists:residents,id',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'
        ], $this->contactNumberMessages(['contactNo', 'emergencyContactNo']));

        $validated = $this->normalizeResidentPayload($validated);

        // Mirror encode behavior: blank contact/emergency fields become explicit "N/A"
        $validated['contactNo'] = filled($validated['contactNo'] ?? null)
            ? trim((string) $validated['contactNo'])
            : 'N/A';
        $validated['emergencyContactNo'] = filled($validated['emergencyContactNo'] ?? null)
            ? trim((string) $validated['emergencyContactNo'])
            : 'N/A';
        $validated['emergencyContactName'] = filled($validated['emergencyContactName'] ?? null)
            ? trim((string) $validated['emergencyContactName'])
            : 'N/A';

        if($request->hasFile('image_path')){
        // Delete old image if exists
        if($resident->image_path && Storage::disk('public')->exists($resident->image_path)){
            Storage::disk('public')->delete($resident->image_path);
        }
        
        $validated['image_path'] = $request->file('image_path')->store('resident', 'public');
        } else {
        // Keep the old image if no new image uploaded
        unset($validated['image_path']);
        }

        $data = Arr::except($validated, ['house_id', 'new_head_id']);

        DB::transaction(function () use ($resident, $validated, $data) {
            $householdResident = HouseholdResident::where('resident_id', $resident->id)->firstOrFail();
            $household = Household::findOrFail($householdResident->household_id);
            $currentHeadStatus = $resident->headOfFamily;
            $requestedHeadStatus = $validated['headOfFamily'];

            if ($currentHeadStatus === 'yes' && $requestedHeadStatus === 'no') {
                $newHeadId = $validated['new_head_id'] ?? null;

                if (!$newHeadId) {
                    throw ValidationException::withMessages([
                        'new_head_id' => 'Please select a new Head of Family.',
                    ]);
                }

                if ((int) $newHeadId === (int) $resident->id) {
                    throw ValidationException::withMessages([
                        'new_head_id' => 'The replacement head of family must be a different resident.',
                    ]);
                }

                $newHeadMembership = HouseholdResident::where('household_id', $householdResident->household_id)
                    ->where('resident_id', $newHeadId)
                    ->first();

                if (!$newHeadMembership) {
                    $sameHouseMembership = HouseholdResident::query()
                        ->where('resident_id', $newHeadId)
                        ->whereHas('household', function ($query) use ($household) {
                            $query->where('house_id', $household->house_id);
                        })
                        ->first();

                    if ($sameHouseMembership) {
                        $newHeadMembership = HouseholdResident::firstOrCreate(
                            [
                                'household_id' => $householdResident->household_id,
                                'resident_id' => $newHeadId,
                            ],
                            [
                                'is_household_head' => false,
                            ]
                        );
                    }
                }

                if (!$newHeadMembership) {
                    throw ValidationException::withMessages([
                        'new_head_id' => 'The selected new Head of Family must belong to the same house or household.',
                    ]);
                }

                Resident::whereKey($newHeadId)->update(['headOfFamily' => 'yes']);
                HouseholdResident::where('household_id', $newHeadMembership->household_id)
                    ->where('resident_id', $newHeadMembership->resident_id)
                    ->update(['is_household_head' => true]);
            }

            if ($requestedHeadStatus === 'yes') {
                $otherResidentIds = HouseholdResident::where('household_id', $householdResident->household_id)
                    ->where('resident_id', '!=', $resident->id)
                    ->pluck('resident_id');

                if ($otherResidentIds->isNotEmpty()) {
                    Resident::whereIn('id', $otherResidentIds)->update(['headOfFamily' => 'no']);
                }

                HouseholdResident::where('household_id', $householdResident->household_id)
                    ->where('resident_id', '!=', $resident->id)
                    ->update(['is_household_head' => false]);
            }

            $resident->update($data);

            $household->update([
                'house_id' => $validated['house_id']
            ]);

            $householdResident->update([
                'is_household_head' => $requestedHeadStatus === 'yes',
            ]);

            $this->syncLinkedUserFromResident($resident->fresh('user'), $validated, true);
        });


        return redirect()->back()->with('success', 'Resident updated successfully!');
    }

    public function archiveResident($id){
        $user = auth()->user();

        if(!$user || $user->role === "resident" || $user->role === "non-resident"){
            abort(403);
        }

        $resident = Resident::findOrFail($id);

        // Create archive record
        Archive::create([
            'record_type' => 'resident',
            'record_id' => $resident->id,
            'data' => $resident->toArray(),
            'archived_by' => $user->id,
        ]);

        // Delete the resident
        $resident->delete();

        return redirect()->back()->with('success', 'Resident archived successfully!');
    }

public function updateOwnInfo(Request $request, $id)
{
    $validated = $request->validate([
        'birthday' => 'required|date',
        'emergencyContactNo' => $this->nullableContactNumberRules(),
        'emergencyContactName' => 'nullable|string|max:255',
        'age' => 'required|integer|min:0|max:255',
        'sex' => 'required|in:male,female',
        'parent' => 'required|in:yes,no,single',
        'enrolled' => 'required|in:yes,no',
        'educationalAttainment' => 'nullable|string|max:255',
        'headOfFamily' => 'nullable|in:yes,no',
        'new_head_id' => 'nullable|exists:residents,id'
    ], $this->contactNumberMessages(['emergencyContactNo']));

    $resident = Resident::findOrFail($id);

    $user = auth()->user();

    if (!in_array($user->role, ['admin', 'subadmin']) && $resident->user_id !== $user->id) {
        return back()->withErrors(['error' => 'You can only update your own information.']);
    }

    $validated['contactNo'] = $resident->user->contactNumber ?? $resident->contactNo;
    $validated = $this->normalizeResidentPayload($validated);

    // Align with encode behavior: blank emergency contact fields are stored as "N/A"
    $validated['emergencyContactNo'] = filled($validated['emergencyContactNo'] ?? null)
        ? trim((string) $validated['emergencyContactNo'])
        : 'N/A';
    $validated['emergencyContactName'] = filled($validated['emergencyContactName'] ?? null)
        ? trim((string) $validated['emergencyContactName'])
        : 'N/A';

    $requestedHeadStatus = $validated['headOfFamily'] ?? $resident->headOfFamily;

    DB::transaction(function () use ($request, $resident, $validated, $requestedHeadStatus) {
        $householdResident = HouseholdResident::where('resident_id', $resident->id)->firstOrFail();
        $household = Household::findOrFail($householdResident->household_id);

        if ($resident->headOfFamily === 'yes' && $requestedHeadStatus === 'no') {
            $newHeadId = $request->new_head_id;

            if (!$newHeadId) {
                throw ValidationException::withMessages([
                    'new_head_id' => 'Please select a new Head of Family.',
                ]);
            }

            if ((int) $newHeadId === (int) $resident->id) {
                throw ValidationException::withMessages([
                    'new_head_id' => 'The replacement head of family must be a different resident.',
                ]);
            }

            $newHeadMembership = HouseholdResident::where('household_id', $householdResident->household_id)
                ->where('resident_id', $newHeadId)
                ->first();

            if (!$newHeadMembership) {
                $sameHouseMembership = HouseholdResident::query()
                    ->where('resident_id', $newHeadId)
                    ->whereHas('household', function ($query) use ($household) {
                        $query->where('house_id', $household->house_id);
                    })
                    ->first();

                if ($sameHouseMembership) {
                    $newHeadMembership = HouseholdResident::firstOrCreate(
                        [
                            'household_id' => $householdResident->household_id,
                            'resident_id' => $newHeadId,
                        ],
                        [
                            'is_household_head' => false,
                        ]
                    );
                }
            }

            if (!$newHeadMembership) {
                throw ValidationException::withMessages([
                    'new_head_id' => 'The selected new Head of Family must belong to the same house or household.',
                ]);
            }

            Resident::whereKey($newHeadId)->update(['headOfFamily' => 'yes']);
            HouseholdResident::where('household_id', $newHeadMembership->household_id)
                ->where('resident_id', $newHeadMembership->resident_id)
                ->update(['is_household_head' => true]);
        }

        if ($requestedHeadStatus === 'yes') {
            $otherResidentIds = HouseholdResident::where('household_id', $householdResident->household_id)
                ->where('resident_id', '!=', $resident->id)
                ->pluck('resident_id');

            if ($otherResidentIds->isNotEmpty()) {
                Resident::whereIn('id', $otherResidentIds)->update(['headOfFamily' => 'no']);
            }

            HouseholdResident::where('household_id', $householdResident->household_id)
                ->where('resident_id', '!=', $resident->id)
                ->update(['is_household_head' => false]);
        }

        $resident->update(Arr::except($validated, ['new_head_id']));
        $householdResident->update([
            'is_household_head' => $requestedHeadStatus === 'yes',
        ]);
        $this->syncLinkedUserFromResident($resident->fresh('user'), $validated);
    });

    return redirect()
        ->route($user->role . '.profile')
        ->with('success', 'Resident information updated successfully.');
}


}
