<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Blotter;
use App\Models\CertificateRequest;
use App\Models\GeneratedReport;
use App\Models\Street;
use App\Models\House;
use App\Models\Household;
use App\Models\FamilyMember;
use Auth;

class ReportsController extends Controller
{
public function index()
{
    // show admin wrapper and report list
    $reports = GeneratedReport::with('generator:id,firstName,lastName')->latest()->get();

    // grab street names for filter dropdown
    $streets = \App\Models\Street::orderBy('street_name')->pluck('street_name');
    $streetOptions = Street::orderBy('street_name')->get(['id', 'street_name']);
    $houseOptions = House::with('street:id,street_name')
        ->orderBy('house_no')
        ->get(['id', 'street_id', 'house_no', 'property_type']);
    $houseHeadOptions = Resident::query()
        ->whereHas('households', function ($q) {
            $q->where('household_resident.is_household_head', true);
        })
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'middleName', 'lastName']);

    return view('admin.reports', compact('reports', 'streets', 'streetOptions', 'houseOptions', 'houseHeadOptions'));
}

public function generatePopulation(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'age_group' => 'nullable|in:children,youth,adults,senior',
        'gender' => 'nullable|in:male,female',
        'street_id' => 'nullable|exists:streets,id',
        'house_id' => 'nullable|exists:houses,id',
        'street' => 'nullable|string', // backward compatibility
        'house_no' => 'nullable|string|max:50', // backward compatibility
        'parent' => 'nullable|in:yes,no,single',
        'civil_status' => 'nullable|in:single,married,widowed,divorced',
        'birthday_from' => 'nullable|date_format:Y-m-d',
        'birthday_to' => 'nullable|date_format:Y-m-d',
    ]);
    $filters = $request->except(['_token', 'report_form_type']);
    $query = $this->buildPopulationReportQuery($filters);
    $residents = $query->get();

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'population',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $residents->count(),
    ]);

    return redirect()->back();
}

public function generateBlotter(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'date_from' => 'required|date',
        'date_to' => 'required|date'
    ]);

    // only include blotters that have been marked finished
    $query = Blotter::where('is_finished', true);

    $query->whereBetween('created_at', [
        $request->date_from,
        $request->date_to
    ]);

    $blotters = $query->get();
    $filters = $request->except(['_token', 'report_form_type']);

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'blotter',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $blotters->count(),
    ]);

    return redirect()->back();
}

public function generateCertificate(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'certificate_status' => 'required|in:All,Pending,Approved,Declined',
        'certificate_type' => 'required|in:All,bonafide,indigency,soloparent,senior,Bonafide,Indigency,Solo-Parent,Senior',
        'date_from' => 'required|date',
        'date_to' => 'required|date'
    ]);

    $query = CertificateRequest::with(['user:id,firstName,middleName,lastName', 'resident:id,firstName,middleName,lastName']);

    // Normalize certificate status (map display values to database values)
    if ($request->certificate_status !== 'All') {
        $statusMap = [
            'Pending' => 'pending',
            'Approved' => 'approved',
            'Declined' => 'declined'
        ];
        $status = $statusMap[$request->certificate_status] ?? strtolower($request->certificate_status);
        $query->where('status', $status);
    }

    // Normalize certificate type (map display values to database values)
    if ($request->certificate_type !== 'All') {
        $typeMap = [
            'Bonafide' => 'bonafide',
            'Indigency' => 'indigency',
            'Solo-Parent' => 'soloparent',
            'Senior' => 'senior'
        ];
        $type = $typeMap[$request->certificate_type] ?? strtolower($request->certificate_type);
        $query->where('certificate_type', $type);
    }

    $query->whereBetween('created_at', [
        $request->date_from,
        $request->date_to
    ]);

    $certificates = $query->get();
    $filters = $request->except(['_token', 'report_form_type']);

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'certificate',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $certificates->count(),
    ]);

    return redirect()->back();
}

public function generateHousehold(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'report_scope' => 'nullable|in:summary,family_members',
        'street_id' => 'nullable|exists:streets,id',
        'house_id' => 'nullable|exists:houses,id',
        'household_head_id' => 'nullable|exists:residents,id',
        'has_head' => 'nullable|in:yes,no',
        'min_members' => 'nullable|integer|min:0',
        'max_members' => 'nullable|integer|min:0|gte:min_members',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $data = $this->getHouseholdReportData($filters);

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'household',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $data->count(),
    ]);

    return redirect()->back();
}

private function resolveHouseholdReportScope(array $filters): string
{
    return ($filters['report_scope'] ?? 'summary') === 'family_members' ? 'family_members' : 'summary';
}

private function getHouseholdReportData(array $filters)
{
    $scope = $this->resolveHouseholdReportScope($filters);
    return $scope === 'family_members'
        ? $this->buildHouseholdFamilyMembersQuery($filters)->get()
        : $this->buildHouseholdReportQuery($filters)->get();
}

private function buildHouseholdReportQuery(array $filters)
{
    $query = Household::query()
        ->with([
            'house:id,street_id,house_no,property_type',
            'house.street:id,street_name',
            'residents:id,firstName,middleName,lastName',
        ])
        ->withCount([
            'residents as household_resident_count',
            'residents as head_count' => function ($q) {
                $q->where('household_resident.is_household_head', true);
            },
            'familyMembers as family_members_count',
        ]);

    if (!empty($filters['street_id'])) {
        $query->whereHas('house', function ($q) use ($filters) {
            $q->where('street_id', $filters['street_id']);
        });
    }

    if (!empty($filters['house_id'])) {
        $query->where('house_id', $filters['house_id']);
    }

    if (!empty($filters['property_type'])) {
        $query->whereHas('house', function ($q) use ($filters) {
            $q->where('property_type', $filters['property_type']);
        });
    }

    if (!empty($filters['has_head'])) {
        if ($filters['has_head'] === 'yes') {
            $query->whereHas('residents', function ($q) {
                $q->where('household_resident.is_household_head', true);
            });
        } else {
            $query->whereDoesntHave('residents', function ($q) {
                $q->where('household_resident.is_household_head', true);
            });
        }
    }

    if (!empty($filters['household_head_id'])) {
        $query->whereHas('residents', function ($q) use ($filters) {
            $q->where('residents.id', $filters['household_head_id'])
                ->where('household_resident.is_household_head', true);
        });
    }

    $minMembers = isset($filters['min_members']) && $filters['min_members'] !== '' ? (int) $filters['min_members'] : null;
    $maxMembers = isset($filters['max_members']) && $filters['max_members'] !== '' ? (int) $filters['max_members'] : null;

    if ($minMembers !== null || $maxMembers !== null) {
        if ($minMembers !== null) {
            $query->having('family_members_count', '>=', $minMembers);
        }
        if ($maxMembers !== null) {
            $query->having('family_members_count', '<=', $maxMembers);
        }
    }

    return $query->latest();
}

private function buildHouseholdFamilyMembersQuery(array $filters)
{
    $query = FamilyMember::query()
        ->with([
            'resident:id,firstName,middleName,lastName',
            'user:id,firstName,middleName,lastName',
            'household:id,house_id',
            'household.house:id,street_id,house_no,property_type',
            'household.house.street:id,street_name',
        ]);

    if (!empty($filters['street_id'])) {
        $query->whereHas('household.house', function ($q) use ($filters) {
            $q->where('street_id', $filters['street_id']);
        });
    }

    if (!empty($filters['house_id'])) {
        $query->whereHas('household', function ($q) use ($filters) {
            $q->where('house_id', $filters['house_id']);
        });
    }

    if (!empty($filters['household_head_id'])) {
        $headResident = Resident::select('id', 'user_id')->find($filters['household_head_id']);
        if ($headResident && $headResident->user_id) {
            $query->where('encoded_by', $headResident->user_id);
        } else {
            $query->whereRaw('1 = 0');
        }
    }

    return $query->latest();
}

private function buildPopulationReportQuery(array $filters)
{
    $query = Resident::query()->with([
        'households.house.street:id,street_name',
    ]);

    // backward compatibility for old reports that used 'filter' => 'senior'
    if (empty($filters['age_group']) && (($filters['filter'] ?? null) === 'senior')) {
        $filters['age_group'] = 'senior';
    }

    if (!empty($filters['age_group'])) {
        switch ($filters['age_group']) {
            case 'children':
                $query->whereBetween('age', [0, 12]);
                break;
            case 'youth':
                $query->whereBetween('age', [13, 17]);
                break;
            case 'adults':
                $query->whereBetween('age', [18, 59]);
                break;
            case 'senior':
                $query->where('age', '>=', 60);
                break;
        }
    }

    if (!empty($filters['gender'])) {
        $query->where('sex', $filters['gender']);
    }

    if (!empty($filters['street_id'])) {
        $query->whereHas('households.house', function ($q) use ($filters) {
            $q->where('street_id', $filters['street_id']);
        });
    } elseif (!empty($filters['street'])) {
        $query->whereHas('households.house.street', function ($q) use ($filters) {
            $q->where('street_name', $filters['street']);
        });
    }

    if (!empty($filters['house_id'])) {
        $query->whereHas('households.house', function ($q) use ($filters) {
            $q->where('id', $filters['house_id']);
        });
    } elseif (!empty($filters['house_no'])) {
        $query->whereHas('households.house', function ($q) use ($filters) {
            $q->where('house_no', $filters['house_no']);
        });
    }

    if (!empty($filters['parent'])) {
        $query->where('parent', $filters['parent']);
    }

    if (!empty($filters['civil_status']) && \Schema::hasColumn('residents', 'civil_status')) {
        $query->where('civil_status', $filters['civil_status']);
    }

    if (!empty($filters['birthday_from']) && !empty($filters['birthday_to'])) {
        $query->whereRaw(
            "DATE_FORMAT(birthday, '%m-%d') BETWEEN DATE_FORMAT(?, '%m-%d') AND DATE_FORMAT(?, '%m-%d')",
            [$filters['birthday_from'], $filters['birthday_to']]
        );
    }

    return $query;
}

public function view($id)
{
    $report = GeneratedReport::findOrFail($id);
    $filters = is_array($report->filters_used) ? $report->filters_used : (json_decode($report->filters_used, true) ?? []);

    if ($report->report_type == 'population') {
        $data = $this->buildPopulationReportQuery($filters)->get();
    }

    if ($report->report_type == 'blotter') {
        $data = Blotter::where('is_finished', true)
            ->whereBetween('created_at', [
                $filters['date_from'],
                $filters['date_to']
            ])->get();
    }

    if ($report->report_type == 'certificate') {
        $query = CertificateRequest::with(['user:id,firstName,middleName,lastName', 'resident:id,firstName,middleName,lastName']);

        // Apply status filter
        if (!empty($filters['certificate_status']) && $filters['certificate_status'] !== 'All') {
            $statusMap = [
                'Pending' => 'pending',
                'Approved' => 'approved',
                'Declined' => 'declined'
            ];
            $status = $statusMap[$filters['certificate_status']] ?? strtolower($filters['certificate_status']);
            $query->where('status', $status);
        }

        // Apply type filter
        if (!empty($filters['certificate_type']) && $filters['certificate_type'] !== 'All') {
            $typeMap = [
                'Bonafide' => 'bonafide',
                'Indigency' => 'indigency',
                'Solo-Parent' => 'soloparent',
                'Senior' => 'senior'
            ];
            $type = $typeMap[$filters['certificate_type']] ?? strtolower($filters['certificate_type']);
            $query->where('certificate_type', $type);
        }

        // Apply date range filter
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('created_at', [
                $filters['date_from'],
                $filters['date_to']
            ]);
        }

        $data = $query->get();
    }

    if ($report->report_type == 'household') {
        $data = $this->getHouseholdReportData($filters);
    }

    // also pass list so admin wrapper can render index
    $reports = GeneratedReport::with('generator:id,firstName,lastName')->latest()->get();
    $streets = Street::orderBy('street_name')->pluck('street_name');
    $streetOptions = Street::orderBy('street_name')->get(['id', 'street_name']);
    $houseOptions = House::with('street:id,street_name')
        ->orderBy('house_no')
        ->get(['id', 'street_id', 'house_no', 'property_type']);
    $houseHeadOptions = Resident::query()
        ->whereHas('households', function ($q) {
            $q->where('household_resident.is_household_head', true);
        })
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'middleName', 'lastName']);

    return view('admin.reports', compact('reports', 'report', 'data', 'streets', 'streetOptions', 'houseOptions', 'houseHeadOptions'));
}

public function printTemplate($id)
{
    $report = GeneratedReport::findOrFail($id);
    $filters = is_array($report->filters_used) ? $report->filters_used : (json_decode($report->filters_used, true) ?? []);

    if ($report->report_type == 'population') {
        $data = $this->buildPopulationReportQuery($filters)->get();
    }

    if ($report->report_type == 'blotter') {
        $data = Blotter::where('is_finished', true)
            ->whereBetween('created_at', [
                $filters['date_from'],
                $filters['date_to']
            ])->get();
    }

    if ($report->report_type == 'certificate') {
        $query = CertificateRequest::with(['user:id,firstName,middleName,lastName', 'resident:id,firstName,middleName,lastName']);

        // Apply status filter
        if (!empty($filters['certificate_status']) && $filters['certificate_status'] !== 'All') {
            $statusMap = [
                'Pending' => 'pending',
                'Approved' => 'approved',
                'Declined' => 'declined'
            ];
            $status = $statusMap[$filters['certificate_status']] ?? strtolower($filters['certificate_status']);
            $query->where('status', $status);
        }

        // Apply type filter
        if (!empty($filters['certificate_type']) && $filters['certificate_type'] !== 'All') {
            $typeMap = [
                'Bonafide' => 'bonafide',
                'Indigency' => 'indigency',
                'Solo-Parent' => 'soloparent',
                'Senior' => 'senior'
            ];
            $type = $typeMap[$filters['certificate_type']] ?? strtolower($filters['certificate_type']);
            $query->where('certificate_type', $type);
        }

        // Apply date range filter
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('created_at', [
                $filters['date_from'],
                $filters['date_to']
            ]);
        }

        $data = $query->get();
    }

    if ($report->report_type == 'household') {
        $data = $this->getHouseholdReportData($filters);
    }

    return view('reports.print-template', compact('report', 'data'));
}
}
