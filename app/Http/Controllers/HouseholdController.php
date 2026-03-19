<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\House;
use App\Models\HouseholdResident;
use App\Models\Household;
use App\Models\Resident;
use App\Models\FamilyMember;

class HouseholdController extends Controller
{
    use ValidatesContactNumbers;

    public function showHousehold()
    {
        $street = Street::withCount('houses')->get();

        $totalStreets = Street::count();
        $totalHouses = House::count();
        $totalHouseholds = Household::count();
        $totalHeads = HouseholdResident::where('is_household_head', true)->count();
        $totalMembers = FamilyMember::count();
        $householdsWithMembers = FamilyMember::query()
            ->distinct('household_id')
            ->count('household_id');

        // A "family" is counted when a household head has added at least one member.
        $headsWithFamilies = HouseholdResident::query()
            ->join('residents', 'residents.id', '=', 'household_resident.resident_id')
            ->where('household_resident.is_household_head', true)
            ->whereExists(function ($query) {
                $query->selectRaw('1')
                    ->from('family_members')
                    ->whereColumn('family_members.encoded_by', 'residents.user_id');
            })
            ->count();

        $stats = [
            'total_streets' => $totalStreets,
            'total_houses' => $totalHouses,
            'total_households' => $totalHouseholds,
            'total_heads' => $totalHeads,
            'total_members' => $totalMembers,
            'families_with_members' => $headsWithFamilies,
            'heads_without_members' => max($totalHeads - $headsWithFamilies, 0),
            'households_with_members' => $householdsWithMembers,
            'average_members_per_family' => $headsWithFamilies > 0 ? round($totalMembers / $headsWithFamilies, 2) : 0,
            'head_engagement_rate' => $totalHeads > 0 ? round(($headsWithFamilies / $totalHeads) * 100, 1) : 0,
            'household_coverage_rate' => $totalHouseholds > 0 ? round(($householdsWithMembers / $totalHouseholds) * 100, 1) : 0,
        ];

        return view('admin.household', compact('street', 'stats'));
    }

    public function showStreets($id)
    {
        $houses = House::where('street_id', $id)
            ->withCount('households')
            ->get();

        $houseIds = $houses->pluck('id');

        $headsCountByHouse = HouseholdResident::join('households', 'household_resident.household_id', '=', 'households.id')
            ->where('household_resident.is_household_head', true)
            ->whereIn('households.house_id', $houseIds)
            ->selectRaw('households.house_id, count(*) as heads_count')
            ->groupBy('households.house_id')
            ->pluck('heads_count', 'households.house_id');

        $houses->transform(function ($house) use ($headsCountByHouse) {
            $house->heads_count = (int) ($headsCountByHouse[$house->id] ?? 0);
            return $house;
        });

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'houses' => $houses,
            ]);
        }

        return view('admin.houses', compact('houses'));
    }

    public function showHeads($id)
    {
        $house = House::findOrFail($id);

        // Get Heads - explicitly ensure user_id is loaded from the resident relationship
        $heads = HouseholdResident::with(['resident' => function($query) {
                $query->select('id', 'user_id', 'firstName', 'middleName', 'lastName', 'contactNo', 'birthday', 'age', 'sex', 'image_path');
            }])
            ->whereHas('household', function ($q) use ($id) {
                $q->where('house_id', $id);
            })
            ->where('is_household_head', true)
            ->get();

        // Get members with resident relationship eager loaded
        $membersRaw = FamilyMember::with(['resident' => function($q) {
                $q->select('id', 'firstName', 'middleName', 'lastName', 'contactNo', 'birthday', 'age', 'sex', 'image_path');
            }])
            ->whereHas('household', function($q) use($id) {
                $q->where('house_id', $id);
            })->get();

        $allMembers = $membersRaw->map(function($member) {
            return [
                'id' => $member->id,
                'household_id' => $member->household_id,
                'encoded_by' => (int)$member->encoded_by,
                'relationship' => $member->relationship ?? 'Member',
                'resident' => [
                    'firstName' => $member->resident->firstName ?? 'N/A',
                    'middleName' => $member->resident->middleName ?? 'N/A',
                    'lastName' => $member->resident->lastName ?? 'N/A',
                    'contactNo' => $member->resident->contactNo ?? 'N/A',
                    'birthday' => $member->resident->birthday ?? 'N/A',
                    'age' => $this->calculateAge($member->resident->birthday ?? null),
                    'sex' => $member->resident->sex ?? 'N/A',
                    'image_path' => $member->resident->image_path ?? null
                ]
            ];
        });

        $groups = $heads->map(function ($head) use ($allMembers) {
            // This is the key link: Head's User ID == Member's Encoded By
            $headUserId = (int)$head->resident->user_id;

            $headMembers = $allMembers->filter(function($m) use ($headUserId) {
                return $m['encoded_by'] === $headUserId;
            })->values();

            return [
                'head' => $head,
                'members' => $headMembers,
            ];
        })->values();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'groups' => $groups,
                'unassigned_members' => $allMembers->whereNotIn('encoded_by', $heads->pluck('resident.user_id'))->values(),
            ]);
        }
    }

    private function calculateAge($birthdate)
    {
        if (!$birthdate) {
            return 'N/A';
        }
        try {
            return \Carbon\Carbon::parse($birthdate)->age;
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    public function storeFamilyMember(Request $request)
    {
        \Log::info('storeFamilyMember called', ['request' => $request->all()]);

        try {
            $user = auth()->user();
            \Log::info('User: ' . $user->id . ' Role: ' . $user->role);

            // Get logged-in resident - try by user_id first, then by name match
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                // For admin who might not have user_id set
                $resident = Resident::where('firstName', $user->firstName)
                    ->where('lastName', $user->lastName)
                    ->first();
            }

            if (!$resident) {
                \Log::warning('Resident not found for user: ' . $user->id);
                return back()->with('error', 'Resident record not found. Please contact administrator.');
            }

            \Log::info('Found resident: ' . $resident->id);

            // Find household of the resident
            $householdResident = HouseholdResident::where('resident_id', $resident->id)
                ->with('household')
                ->first();

            if (!$householdResident) {
                \Log::warning('No household found for resident: ' . $resident->id);
                return back()->with('error', 'No household found. Please ensure you are assigned to a household first.');
            }

            $household = $householdResident->household;
            \Log::info('Found household: ' . $household->id);

            // New table stores only household_id, resident_id, encoded_by.
            $validated = $request->validate([
                'resident_id' => 'required|exists:residents,id',
                'relationship' => 'required|string|max:50'
            ]);

            $selectedId = (int) $validated['resident_id'];

            if ((int) $resident->id === $selectedId) {
                return back()->withErrors([
                    'resident_id' => 'You cannot add yourself as a family member.',
                ]);
            }

            $alreadyTagged = FamilyMember::where('household_id', $household->id)
                ->where('resident_id', $selectedId)
                ->exists();

            if ($alreadyTagged) {
                return back()->withErrors([
                    'resident_id' => 'That resident is already added as a family member.',
                ]);
            }

            $familyMember = FamilyMember::create([
                'household_id' => $household->id,
                'resident_id' => $selectedId,
                'encoded_by' => $user->id,
                'relationship' => $validated['relationship']
            ]);

            \Log::info('Family member created: ' . $familyMember->id);

            return redirect()->route($user->role . '.profile')->with('success', 'Family member added successfully!');
        } catch (\Exception $e) {
            \Log::error('Family member storage error: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return back()->with('error', 'Error adding family member: ' . $e->getMessage());
        }
    }

    public function untagMember(Request $request, $id)
    {
        $member = FamilyMember::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Family member untagged successfully');
    }

    public function editMember(Request $request, $id)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'middleName' => 'nullable|string|max:100',
            'lastName' => 'required|string|max:100',
            'birthdate' => 'required|date|before:today',
            'sex' => 'required|in:male,female',
            'relationship' => 'required|string|max:50',
            'contactNumber' => $this->nullableContactNumberRules(),
        ], $this->contactNumberMessages(['contactNumber']));

        $validated['is_inactive'] = $request->boolean('is_inactive');
        $member = FamilyMember::findOrFail($id);
        $member->update($validated);

        return redirect()->back()->with('success', 'Family member details successfully updated.');
    }

    public function updateHead($id)
    {
        $user = auth()->user();

        $currentResident = Resident::where('user_id', $user->id)->first();

        if (!$currentResident) {
            $currentResident = Resident::where('firstName', $user->firstName)
                ->where('lastName', $user->lastName)
                ->first();
        }

        if (!$currentResident) {
            return redirect()->back()->with('error', 'Resident record not found.');
        }

        $member = FamilyMember::with('resident')->findOrFail($id);

        $currentHeadMembership = HouseholdResident::where('household_id', $member->household_id)
            ->where('resident_id', $currentResident->id)
            ->where('is_household_head', true)
            ->first();

        if (!$currentHeadMembership) {
            return redirect()->back()->with('error', 'Only the current household head can assign a new head.');
        }

        $newHeadResident = $member->resident;

        if (!$newHeadResident) {
            return redirect()->back()->with('error', 'Selected resident not found.');
        }

        if (!$newHeadResident->user_id) {
            return redirect()->back()->with('error', 'The selected resident must have an account before becoming the household head.');
        }

        HouseholdResident::firstOrCreate(
            [
                'household_id' => $member->household_id,
                'resident_id' => $newHeadResident->id,
            ],
            [
                'is_household_head' => false,
            ]
        );

        $householdResidentIds = HouseholdResident::where('household_id', $member->household_id)
            ->pluck('resident_id');

        HouseholdResident::where('household_id', $member->household_id)
            ->update(['is_household_head' => false]);

        if ($householdResidentIds->isNotEmpty()) {
            Resident::whereIn('id', $householdResidentIds)->update(['headOfFamily' => 'no']);
        }

        $currentHeadMembership->update(['is_household_head' => false]);
        $currentResident->update(['headOfFamily' => 'no']);

        HouseholdResident::where('household_id', $member->household_id)
            ->where('resident_id', $newHeadResident->id)
            ->update(['is_household_head' => true]);

        $newHeadResident->update(['headOfFamily' => 'yes']);

        FamilyMember::where('household_id', $member->household_id)
            ->where('encoded_by', $user->id)
            ->update(['encoded_by' => $newHeadResident->user_id]);

        FamilyMember::where('household_id', $member->household_id)
            ->where('resident_id', $newHeadResident->id)
            ->delete();

        FamilyMember::updateOrCreate(
            [
                'household_id' => $member->household_id,
                'resident_id' => $currentResident->id,
            ],
            [
                'encoded_by' => $newHeadResident->user_id,
                'relationship' => 'Member',
            ]
        );

        return redirect()->back()->with('success', 'Household head updated successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $residents = Resident::select('id', 'firstName', 'lastName', 'middleName')->get();
        return view('profileforms.addMember', compact('residents'));
    }
}
