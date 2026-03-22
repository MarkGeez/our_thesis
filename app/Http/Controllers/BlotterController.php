<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesContactNumbers;
use App\Models\Blotter;
use App\Models\Resident;
use App\Models\UpdateBlotter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlotterController extends Controller
{
    use ValidatesContactNumbers;

    private const BLOTTER_TYPES = [
        'regular',
        'vawc',
        'katarungang_pambarangay',
    ];

    private const INITIAL_STATUS = 'filed';

    private const WORKFLOWS = [
        'regular' => [
            'updatable' => false,
            'stages' => [],
            'repeatable_between_hearings' => [],
            'outcomes' => [],
            'terminal' => [],
        ],
        'katarungang_pambarangay' => [
            'updatable' => true,
            'stages' => ['first_hearing', 'second_hearing', 'third_hearing'],
            'repeatable_between_hearings' => ['for_summons'],
            'outcomes' => ['criminal_civil_case', 'referred_to_pnp', 'certificate_to_file_action', 'resolved'],
            'terminal' => ['criminal_civil_case', 'referred_to_pnp', 'certificate_to_file_action', 'resolved'],
        ],
        'vawc' => [
            'updatable' => true,
            'stages' => ['first_hearing', 'second_hearing', 'third_hearing'],
            'repeatable_between_hearings' => ['for_summons'],
            'outcomes' => ['referred_to_pnp', 'barangay_protection_order', 'resolved'],
            'terminal' => ['referred_to_pnp', 'barangay_protection_order', 'resolved'],
        ],
    ];

    private const STATUS_SORT_ORDER = [
        'filed' => 1,
        'first_hearing' => 2,
        'second_hearing' => 3,
        'third_hearing' => 4,
        'for_summons' => 5,
        'barangay_protection_order' => 6,
        'criminal_civil_case' => 7,
        'certificate_to_file_action' => 8,
        'referred_to_pnp' => 9,
        'resolved' => 10,
        // Legacy support
        'barangayBlotter' => 1,
        'first' => 2,
        'second' => 3,
        'third' => 4,
        'brgyHearing' => 5,
        'coldCase' => 8,
        'criminalCase' => 7,
        'referredToPnp' => 9,
    ];

    private static function getWorkflow(string $type): array
    {
        return self::WORKFLOWS[$type] ?? self::WORKFLOWS['regular'];
    }

    private static function getBlotterTypeLabels(): array
    {
        return [
            'regular' => 'Regular Blotter',
            'vawc' => 'VAWC Blotter',
            'katarungang_pambarangay' => 'Katarungang Pambarangay',
        ];
    }

    public static function getBlotterTypeLabel(?string $type): string
    {
        $labels = self::getBlotterTypeLabels();
        return $labels[$type ?? 'regular'] ?? ucfirst((string) $type);
    }

    public static function getStatusLabels(): array
    {
        return [
            'filed' => 'Filed',
            'first_hearing' => 'First Hearing',
            'second_hearing' => 'Second Hearing',
            'third_hearing' => 'Third Hearing',
            'for_summons' => 'For Summons',
            'criminal_civil_case' => 'Criminal Case/Civil Case',
            'referred_to_pnp' => 'Referred to PNP',
            'certificate_to_file_action' => 'Certificate to File Action',
            'barangay_protection_order' => 'Barangay Protection Order',
            'resolved' => 'Resolved',
            // Legacy support
            'barangayBlotter' => 'Filed',
            'first' => 'First Hearing',
            'second' => 'Second Hearing',
            'third' => 'Third Hearing',
            'brgyHearing' => 'Barangay Hearing',
            'coldCase' => 'Cold Case',
            'criminalCase' => 'Criminal Case',
            'referredToPnp' => 'Referred to PNP',
        ];
    }

    public static function getReportStatusOptions(): array
    {
        return [
            'filed',
            'first_hearing',
            'second_hearing',
            'third_hearing',
            'for_summons',
            'criminal_civil_case',
            'referred_to_pnp',
            'certificate_to_file_action',
            'barangay_protection_order',
            'resolved',
        ];
    }

    public static function getPendingStatuses(): array
    {
        return ['filed', 'first_hearing', 'second_hearing', 'third_hearing', 'for_summons'];
    }

    public static function getOngoingStatuses(): array
    {
        return ['barangay_protection_order'];
    }

    public static function getClosedStatuses(): array
    {
        return ['criminal_civil_case', 'referred_to_pnp', 'certificate_to_file_action', 'resolved'];
    }

    public static function getStatusLabel($status): string
    {
        $labels = self::getStatusLabels();
        return $labels[$status] ?? ucfirst(str_replace('_', ' ', (string) $status));
    }

    public static function getStatusUiClass(?string $status): string
    {
        return match ($status) {
            'filed', 'barangayBlotter' => 'status-default',
            'first_hearing', 'second_hearing', 'third_hearing', 'for_summons', 'first', 'second', 'third' => 'status-pending',
            'barangay_protection_order', 'brgyHearing' => 'status-ongoing',
            'criminal_civil_case', 'referred_to_pnp', 'certificate_to_file_action', 'resolved', 'coldCase', 'criminalCase', 'referredToPnp' => 'status-closed',
            default => 'status-default',
        };
    }

    public static function getTimelineBadgeClass(?string $status): string
    {
        return match ($status) {
            'filed', 'barangayBlotter' => 'scheduled',
            'first_hearing', 'second_hearing', 'third_hearing', 'for_summons', 'first', 'second', 'third' => 'pending',
            'barangay_protection_order', 'brgyHearing' => 'ongoing',
            'resolved' => 'resolved',
            'criminal_civil_case', 'referred_to_pnp', 'certificate_to_file_action', 'coldCase', 'criminalCase', 'referredToPnp' => 'closed',
            default => 'pending',
        };
    }

    public static function canBeUpdated(string $type, ?string $currentStatus): bool
    {
        $workflow = self::getWorkflow($type);

        if (!($workflow['updatable'] ?? false)) {
            return false;
        }

        return !self::isTerminalStatus($type, $currentStatus);
    }

    public static function isTerminalStatus(string $type, ?string $currentStatus): bool
    {
        if ($currentStatus === null || $currentStatus === '') {
            return false;
        }

        return in_array($currentStatus, self::getWorkflow($type)['terminal'] ?? [], true);
    }

    public static function getAvailableStatusesForBlotter(Blotter $blotter): array
    {
        $type = (string) ($blotter->blotter_type ?? 'regular');
        $workflow = self::getWorkflow($type);

        if (!($workflow['updatable'] ?? false) || self::isTerminalStatus($type, $blotter->current_status)) {
            return [];
        }

        $history = $blotter->relationLoaded('updates')
            ? $blotter->updates->pluck('status')->filter()->values()
            : $blotter->updates()->pluck('status');

        $statuses = array_values(array_filter(
            self::getAllStatusesForBlotterType($type),
            fn (string $status) => $status !== self::INITIAL_STATUS
        ));

        $nextHearing = null;
        foreach ($workflow['stages'] ?? [] as $stage) {
            if (!$history->contains($stage)) {
                $nextHearing = $stage;
                break;
            }
        }

        return array_values(array_filter($statuses, function (string $status) use ($workflow, $nextHearing) {
            if (in_array($status, $workflow['stages'] ?? [], true)) {
                return $status === $nextHearing;
            }

            return true;
        }));
    }

    public static function getAllStatusesForBlotterType(string $type): array
    {
        $workflow = self::getWorkflow($type);

        if (!($workflow['updatable'] ?? false)) {
            return [];
        }

        return array_values(array_unique(array_merge(
            [self::INITIAL_STATUS],
            $workflow['stages'] ?? [],
            $workflow['repeatable_between_hearings'] ?? [],
            $workflow['outcomes'] ?? []
        )));
    }

    private static function getUpdateBlockedReason(Blotter $blotter): ?string
    {
        $type = (string) ($blotter->blotter_type ?? 'regular');

        if ($type === 'regular') {
            return 'Regular blotters cannot be updated once they have been encoded.';
        }

        if (self::isTerminalStatus($type, $blotter->current_status)) {
            return 'This blotter is already in a terminal status and can no longer be updated.';
        }

        return null;
    }

    private static function normalizeSearchTerm(string $value): string
    {
        return strtolower(trim(preg_replace('/\s+/', ' ', str_replace('#', '', $value))));
    }

    private static function resolveMatchingStatuses(string $search): array
    {
        $normalizedSearch = self::normalizeSearchTerm($search);

        return collect(self::getStatusLabels())
            ->filter(function (string $label, string $code) use ($normalizedSearch) {
                $normalizedLabel = self::normalizeSearchTerm($label);
                $normalizedCode = self::normalizeSearchTerm($code);

                return str_contains($normalizedLabel, $normalizedSearch)
                    || str_contains($normalizedSearch, $normalizedLabel)
                    || str_contains($normalizedCode, $normalizedSearch);
            })
            ->keys()
            ->values()
            ->all();
    }

    private static function resolveMatchingBlotterTypes(string $search): array
    {
        $normalizedSearch = self::normalizeSearchTerm($search);

        return collect(self::getBlotterTypeLabels())
            ->filter(function (string $label, string $code) use ($normalizedSearch) {
                $normalizedLabel = self::normalizeSearchTerm($label);
                $normalizedCode = self::normalizeSearchTerm($code);

                return str_contains($normalizedLabel, $normalizedSearch)
                    || str_contains($normalizedSearch, $normalizedLabel)
                    || str_contains($normalizedCode, $normalizedSearch);
            })
            ->keys()
            ->values()
            ->all();
    }

    private function normalizeNullableContactNumber(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/\s+/', '', (string) $value);

        if ($normalized === '' || preg_match('/^09\d{9}$/', $normalized) !== 1) {
            return null;
        }

        return $normalized;
    }

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
            $matchingStatuses = self::resolveMatchingStatuses($search);
            $matchingTypes = self::resolveMatchingBlotterTypes($search);
            $searchId = preg_replace('/\D+/', '', $search);
            $normalizedSearch = self::normalizeSearchTerm($search);
            $searchLike = '%' . $normalizedSearch . '%';

            $query->where(function ($q) use ($search, $matchingStatuses, $matchingTypes, $searchId, $searchLike) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhereRaw('LOWER(plaintiffName) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(COALESCE(plaintiffMiddleName, "")) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(plaintiffLastName) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(defendantName) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(COALESCE(defendantMiddleName, "")) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(defendantLastName) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(blotterDescription) LIKE ?', [$searchLike])
                    ->orWhereRaw("LOWER(CONCAT_WS(' ', plaintiffName, plaintiffMiddleName, plaintiffLastName)) LIKE ?", [$searchLike])
                    ->orWhereRaw("LOWER(CONCAT_WS(' ', plaintiffName, plaintiffLastName)) LIKE ?", [$searchLike])
                    ->orWhereRaw("LOWER(CONCAT_WS(' ', defendantName, defendantMiddleName, defendantLastName)) LIKE ?", [$searchLike])
                    ->orWhereRaw("LOWER(CONCAT_WS(' ', defendantName, defendantLastName)) LIKE ?", [$searchLike])
                    ->orWhereRaw('LOWER(current_status) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(blotter_type) LIKE ?', [$searchLike]);

                if ($searchId !== '') {
                    $q->orWhere('id', (int) $searchId)
                        ->orWhereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchId . '%']);
                }

                if ($matchingStatuses !== []) {
                    $q->orWhereIn('current_status', $matchingStatuses);
                }

                if ($matchingTypes !== []) {
                    $q->orWhereIn('blotter_type', $matchingTypes);
                }
            });
        }

        if ($statusFilter === 'pending') {
            $query->whereIn('current_status', array_merge(self::getPendingStatuses(), ['barangayBlotter', 'first', 'second', 'third']));
        } elseif ($statusFilter === 'ongoing') {
            $query->whereIn('current_status', array_merge(self::getOngoingStatuses(), ['brgyHearing']));
        } elseif ($statusFilter === 'closed') {
            $query->whereIn('current_status', array_merge(self::getClosedStatuses(), ['coldCase', 'criminalCase', 'referredToPnp']));
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
                $query->orderByRaw($this->buildStatusSortSql('ASC'))->orderBy('id', 'desc');
                break;
            case 'status_desc':
                $query->orderByRaw($this->buildStatusSortSql('DESC'))->orderBy('id', 'desc');
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

    private function buildStatusSortSql(string $direction): string
    {
        $cases = collect(self::STATUS_SORT_ORDER)
            ->map(fn (int $order, string $status) => "WHEN '{$status}' THEN {$order}")
            ->implode(' ');

        return "
            CASE current_status
                {$cases}
                ELSE 99
            END {$direction}
        ";
    }

    public function create()
    {
        return view('admin.Blotter');
    }

    public function searchResidents(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        if ($search === '') {
            return response()->json(['data' => []]);
        }

        $normalizedSearch = strtolower(preg_replace('/\s+/', ' ', $search));
        $searchLike = '%' . $normalizedSearch . '%';

        $residents = Resident::query()
            ->with(['households.house.street'])
            ->select(['id', 'firstName', 'middleName', 'lastName', 'age', 'contactNo'])
            ->where(function ($query) use ($search, $searchLike) {
                $query->whereRaw('LOWER(CONCAT_WS(" ", firstName, middleName, lastName)) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(CONCAT_WS(" ", firstName, lastName)) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(CONCAT_WS(" ", lastName, firstName, middleName)) LIKE ?', [$searchLike])
                    ->orWhereRaw('LOWER(CONCAT_WS(" ", lastName, firstName)) LIKE ?', [$searchLike]);

                if (preg_match('/^\d+$/', $search) === 1) {
                    $query->orWhere('id', (int) $search)
                        ->orWhere('id', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('lastName')
            ->orderBy('firstName')
            ->limit(10)
            ->get()
            ->map(function (Resident $resident) {
                $household = $resident->households->first();
                $house = $household?->house;
                $street = $house?->street;

                $address = collect([
                    filled($house?->house_no) ? 'House ' . $house->house_no : null,
                    $street?->street_name,
                ])->filter()->implode(', ');

                $firstName = ucwords((string) $resident->firstName);
                $middleName = ucwords((string) $resident->middleName);
                $lastName = ucwords((string) $resident->lastName);

                return [
                    'id' => $resident->id,
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'full_name' => trim($firstName . ' ' . $middleName . ' ' . $lastName),
                    'age' => $resident->age,
                    'contact_no' => $resident->contactNo,
                    'address' => $address !== '' ? $address : 'N/A',
                ];
            })
            ->values();

        return response()->json(['data' => $residents]);
    }

    public function submitBlotter(Request $request)
    {
        $plaintiffPartyType = (string) $request->input('plaintiff_party_type', 'non_resident');
        $defendantPartyType = (string) $request->input('defendant_party_type', 'non_resident');

        if ($plaintiffPartyType === 'resident' && $request->filled('plaintiff_resident_id')) {
            $resident = Resident::query()->with(['households.house.street'])->find($request->input('plaintiff_resident_id'));

            if ($resident) {
                $household = $resident->households->first();
                $house = $household?->house;
                $street = $house?->street;

                $address = collect([
                    filled($house?->house_no) ? 'House ' . $house->house_no : null,
                    $street?->street_name,
                ])->filter()->implode(', ');

                $request->merge([
                    'plaintiffName' => ucwords((string) $resident->firstName),
                    'plaintiffMiddleName' => ucwords((string) $resident->middleName),
                    'plaintiffLastName' => ucwords((string) $resident->lastName),
                    'plaintiffAge' => $resident->age,
                    'plaintiffContactNumber' => $this->normalizeNullableContactNumber($resident->contactNo),
                    'plaintiffAddress' => $address !== '' ? $address : $request->input('plaintiffAddress'),
                ]);
            }
        }

        if ($defendantPartyType === 'resident' && $request->filled('defendant_resident_id')) {
            $resident = Resident::query()->with(['households.house.street'])->find($request->input('defendant_resident_id'));

            if ($resident) {
                $household = $resident->households->first();
                $house = $household?->house;
                $street = $house?->street;

                $address = collect([
                    filled($house?->house_no) ? 'House ' . $house->house_no : null,
                    $street?->street_name,
                ])->filter()->implode(', ');

                $request->merge([
                    'defendantName' => ucwords((string) $resident->firstName),
                    'defendantMiddleName' => ucwords((string) $resident->middleName),
                    'defendantLastName' => ucwords((string) $resident->lastName),
                    'defendantAge' => $resident->age,
                    'defendantContactNumber' => $this->normalizeNullableContactNumber($resident->contactNo),
                    'defendantAddress' => $address !== '' ? $address : $request->input('defendantAddress'),
                ]);
            }
        }

        $request->validate([
            'plaintiff_party_type' => ['required', Rule::in(['resident', 'non_resident'])],
            'defendant_party_type' => ['required', Rule::in(['resident', 'non_resident'])],
            'plaintiff_resident_id' => ['nullable', 'integer', 'exists:residents,id', 'required_if:plaintiff_party_type,resident'],
            'defendant_resident_id' => ['nullable', 'integer', 'exists:residents,id', 'required_if:defendant_party_type,resident'],
            'plaintiffName' => 'required|string',
            'plaintiffLastName' => 'required|string',
            'plaintiffContactNumber' => $this->nullableContactNumberRules(),
            'defendantContactNumber' => $this->nullableContactNumberRules(),
            'witnessContactNumber' => $this->nullableContactNumberRules(),
            'blotterDescription' => 'required|string',
            'incident_date_time' => 'nullable|date',
            'blotter_type' => ['nullable', Rule::in(self::BLOTTER_TYPES)],
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ], $this->contactNumberMessages([
            'plaintiffContactNumber',
            'defendantContactNumber',
            'witnessContactNumber',
        ]) + [
            'plaintiff_resident_id.required_if' => 'Please select a complainant resident from the search results.',
            'defendant_resident_id.required_if' => 'Please select a respondent resident from the search results.',
        ]);

        $proofPath = null;

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('blotter_proofs', 'public');
        }

        $blotterType = $request->input('blotter_type', 'regular');
        $initialStatus = self::INITIAL_STATUS;
        $incidentDateTime = $request->filled('incident_date_time')
            ? Carbon::parse($request->incident_date_time)->format('Y-m-d H:i:s')
            : null;

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
            'incident_date_time' => $incidentDateTime,
            'blotter_type' => $blotterType,
            'schedule' => $request->schedule,
            'encodedBy' => Auth::id(),
            'current_status' => $initialStatus,
            'is_finished' => false,
            'finished_by' => null,
        ]);

        UpdateBlotter::create([
            'blotter_id' => $blotter->id,
            'status' => $initialStatus,
            'remarks' => $request->blotterDescription,
            'updated_by' => Auth::id(),
            'photo_path' => $proofPath,
            'date' => now(),
        ]);

        return redirect()->route('admin.blotter.index')
            ->with('success', 'Blotter created successfully.');
    }

    public function showUpdateForm($id)
    {
        $blotter = Blotter::with(['updates.updater'])->findOrFail($id);
        $history = $blotter->updates->sortByDesc('date');
        $availableStatuses = self::getAvailableStatusesForBlotter($blotter);
        $allStatuses = self::getAllStatusesForBlotterType((string) ($blotter->blotter_type ?? 'regular'));
        $statusLabels = self::getStatusLabels();
        $isTerminal = self::isTerminalStatus((string) $blotter->blotter_type, $blotter->current_status);
        $canUpdate = self::canBeUpdated((string) $blotter->blotter_type, $blotter->current_status);
        $updateBlockedReason = self::getUpdateBlockedReason($blotter);

        return view('forms.update', compact(
            'blotter',
            'availableStatuses',
            'allStatuses',
            'history',
            'statusLabels',
            'isTerminal',
            'canUpdate',
            'updateBlockedReason'
        ));
    }

    public function storeUpdate(Request $request, $id)
    {
        $blotter = Blotter::with('updates')->findOrFail($id);
        $type = (string) ($blotter->blotter_type ?? 'regular');

        if (!self::canBeUpdated($type, $blotter->current_status)) {
            return back()->with('error', self::getUpdateBlockedReason($blotter) ?? 'This blotter can no longer be updated.');
        }

        $availableStatuses = self::getAvailableStatusesForBlotter($blotter);
        if ($availableStatuses === []) {
            return back()->with('error', 'There are no further statuses available for this blotter.');
        }

        $request->validate([
            'status' => ['required', Rule::in($availableStatuses)],
            'remarks' => 'required|string',
            'photo_path' => 'nullable|mimes:png,jpg,jpeg|max:4096',
        ]);

        $selectedStatus = (string) $request->input('status');
        $isStatusTaken = $blotter->updates->contains(fn ($update) => $update->status === $selectedStatus);
        if ($isStatusTaken && $selectedStatus !== 'for_summons') {
            return back()
                ->withInput()
                ->withErrors(['status' => 'This status has already been used. Please choose another status.']);
        }

        $image = null;
        if ($request->hasFile('photo_path')) {
            $image = $request->file('photo_path')->store('blotter', 'public');
        }

        UpdateBlotter::create([
            'blotter_id' => $blotter->id,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'photo_path' => $image,
            'updated_by' => Auth::id(),
            'date' => Carbon::now()->toDateString(),
        ]);

        $isTerminal = self::isTerminalStatus($type, $request->status);

        $blotter->update([
            'current_status' => $request->status,
            'is_finished' => $isTerminal,
            'finished_by' => $isTerminal ? Auth::id() : null,
        ]);

        return back()->with('success', 'Blotter updated successfully.');
    }
}
