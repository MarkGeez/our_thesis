<?php

namespace App\Http\Controllers;

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

    $headCandidateResidents = Resident::with('households:id')
        ->select('id', 'firstName', 'middleName', 'lastName', 'headOfFamily')
        ->get()
        ->map(function (Resident $resident) {
            return [
                'id' => $resident->id,
                'firstName' => $resident->firstName,
                'middleName' => $resident->middleName,
                'lastName' => $resident->lastName,
                'headOfFamily' => $resident->headOfFamily,
                'householdIds' => $resident->households->pluck('id')->values(),
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
            'contactNo' => 'nullable|string|max:11',
            'birthday' => 'required|date',
            'emergencyContactNo' => 'nullable|string|max:11',
            'emergencyContactName' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0|max:255',
            'sex' => 'nullable|in:male,female',
            'parent' => 'nullable|in:yes,no,single',
            'enrolled' => 'nullable|in:yes,no',
            'religion' => 'nullable|string|max:255',
            'educationalAttainment' => 'nullable|string',
            'headOfFamily' => 'required|in:yes,no',
            'image_path' => 'nullable|mimes:jpg,jpeg,png|max:4096', // Changed to match form
            'house_id' => 'required|exists:houses,id',
        ]);



        // Handle image upload
        if($request->hasFile('image_path')){
            $image = $request->file('image_path')->store('resident', 'public');
            $validated['image_path'] = $image;
        }

        // Format names
        $validated['firstName'] = strtolower(trim($validated['firstName']));
        $validated['middleName'] = strtolower(trim($validated['middleName']));
        $validated['lastName'] = strtolower(trim($validated['lastName']));
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
            'contactNo' => 'required|string|max:11',
            'birthday' => 'required|date',
            'emergencyContactNo' => 'required|string|max:11',
            'emergencyContactName' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:255',
            'sex' => 'required|in:male,female',
            'parent' => 'required|in:yes,no,single',
            'enrolled' => 'required|in:yes,no',
            'educationalAttainment' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'headOfFamily' => 'required|in:yes,no',
            'new_head_id' => 'nullable|exists:residents,id',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'
        ]);

        $validated = $this->normalizeResidentPayload($validated);

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
                    throw ValidationException::withMessages([
                        'new_head_id' => 'The selected new Head of Family must belong to the same household.',
                    ]);
                }

                Resident::whereKey($newHeadId)->update(['headOfFamily' => 'yes']);
                $newHeadMembership->update(['is_household_head' => true]);
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
        'contactNo' => 'required|string|max:11',
        'birthday' => 'required|date',
        'emergencyContactNo' => 'nullable|string|max:11',
        'emergencyContactName' => 'nullable|string|max:255',
        'age' => 'required|integer|min:0|max:255',
        'sex' => 'required|in:male,female',
        'parent' => 'required|in:yes,no,single',
        'enrolled' => 'required|in:yes,no',
        'educationalAttainment' => 'nullable|string|max:255',
        'headOfFamily' => 'nullable|in:yes,no',
        'religion' => 'nullable|string|max:255',
        'new_head_id' => 'nullable|exists:residents,id'
    ]);

    $resident = Resident::findOrFail($id);

    $user = auth()->user();

    if (!in_array($user->role, ['admin', 'subadmin']) && $resident->user_id !== $user->id) {
        return back()->withErrors(['error' => 'You can only update your own information.']);
    }

    $validated = $this->normalizeResidentPayload($validated);
    $requestedHeadStatus = $validated['headOfFamily'] ?? $resident->headOfFamily;

    if ($resident->headOfFamily === 'no' && $requestedHeadStatus !== 'no') {
        throw ValidationException::withMessages([
            'headOfFamily' => 'Only the current household head can update head of family status from the profile.',
        ]);
    }

    DB::transaction(function () use ($resident, $validated, $requestedHeadStatus) {
        $householdResident = HouseholdResident::where('resident_id', $resident->id)->first();

        if ($resident->headOfFamily === 'yes' && $requestedHeadStatus === 'no') {
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

            if (!$householdResident) {
                throw ValidationException::withMessages([
                    'headOfFamily' => 'No household record was found for this resident.',
                ]);
            }

            $newHeadMembership = HouseholdResident::where('household_id', $householdResident->household_id)
                ->where('resident_id', $newHeadId)
                ->first();

            if (!$newHeadMembership) {
                throw ValidationException::withMessages([
                    'new_head_id' => 'The selected new Head of Family must belong to the same household.',
                ]);
            }

            Resident::whereKey($newHeadId)->update(['headOfFamily' => 'yes']);
            $newHeadMembership->update(['is_household_head' => true]);
        }

        if ($requestedHeadStatus === 'yes' && $householdResident) {
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

        if ($householdResident) {
            $householdResident->update([
                'is_household_head' => $requestedHeadStatus === 'yes',
            ]);
        }

        $this->syncLinkedUserFromResident($resident->fresh('user'), $validated);
    });

    return redirect()
        ->route($user->role . '.profile')
        ->with('success', 'Resident information updated successfully.');
}


}
