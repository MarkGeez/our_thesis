<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Blotter;
use App\Models\CertificateRequest;
use App\Models\Complaints;
use App\Models\GeneratedReport;
use App\Models\Street;
use App\Models\House;
use App\Models\Household;
use App\Models\FamilyMember;
use App\Models\ActiveLog;
use App\Models\Official;
use App\Models\Archive;
use App\Models\Announcement;
use App\Models\Feedbacks;
use App\Services\ActiveLogRecordDetails;
use Carbon\Carbon;
use Auth;

class ReportsController extends Controller
{
private function applyInclusiveDateRange($query, string $column, ?string $from, ?string $to)
{
    if (!empty($from) && !empty($to)) {
        $query->whereBetween($column, [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay(),
        ]);
    } elseif (!empty($from)) {
        $query->whereDate($column, '>=', $from);
    } elseif (!empty($to)) {
        $query->whereDate($column, '<=', $to);
    }

    return $query;
}

public function index()
{
    // show admin wrapper and report list
    $reports = GeneratedReport::with('generator:id,firstName,lastName')
        ->latest()
        ->paginate(10)
        ->appends(request()->query());

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
    $activityUsers = \App\Models\User::query()
        ->whereIn('id', ActiveLog::query()->select('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $activityModules = ActiveLog::query()
        ->whereNotNull('module')
        ->where('module', '!=', '')
        ->select('module')
        ->distinct()
        ->orderBy('module')
        ->pluck('module');
    $activityActions = ActiveLog::query()
        ->whereNotNull('action')
        ->where('action', '!=', '')
        ->select('action')
        ->distinct()
        ->orderBy('action')
        ->pluck('action');
    $officialPositions = Official::query()
        ->whereNotNull('position')
        ->where('position', '!=', '')
        ->select('position')
        ->distinct()
        ->orderBy('position')
        ->pluck('position');
    $archiveTypes = Archive::query()
        ->whereNotNull('record_type')
        ->where('record_type', '!=', '')
        ->select('record_type')
        ->distinct()
        ->orderBy('record_type')
        ->pluck('record_type');
    $archiveUsers = \App\Models\User::query()
        ->whereIn('id', Archive::query()->select('archived_by')->whereNotNull('archived_by')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $announcementUsers = \App\Models\User::query()
        ->whereIn('id', Announcement::query()->select('user_id')->whereNotNull('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $feedbackUsers = \App\Models\User::query()
        ->whereIn('id', Feedbacks::query()->select('user_id')->whereNotNull('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);

    return view('admin.reports', compact('reports', 'streets', 'streetOptions', 'houseOptions', 'houseHeadOptions', 'activityUsers', 'activityModules', 'activityActions', 'officialPositions', 'archiveTypes', 'archiveUsers', 'announcementUsers', 'feedbackUsers'));
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

    if ($residents->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No population records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'population',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $residents->count(),
    ]);

    return redirect()->back()->with('success', 'Population report generated successfully.');
}

public function generateBlotter(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'blotter_status' => 'nullable|in:all,pending,ongoing,closed,barangayBlotter,first,second,third,brgyHearing,coldCase,criminalCase,referredToPnp,resolved',
        'blotter_type' => 'nullable|in:all,regular,vawc',
        'complainant_name' => 'nullable|string|max:150',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $filters['blotter_status'] = $filters['blotter_status'] ?? 'all';
    $filters['blotter_type'] = $filters['blotter_type'] ?? 'all';
    $blotters = $this->buildBlotterReportQuery($filters)->get();

    if ($blotters->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No blotter records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'blotter',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $blotters->count(),
    ]);

    return redirect()->back()->with('success', 'Blotter report generated successfully.');
}

public function generateCertificate(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'certificate_status' => 'required|in:All,Pending,Approved,Declined',
        'certificate_type' => 'required|in:All,bonafide,indigency,soloparent,senior,Bonafide,Indigency,Solo-Parent,Senior',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
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

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $request->date_from,
        $request->date_to
    );

    $certificates = $query->get();
    $filters = $request->except(['_token', 'report_form_type']);

    if ($certificates->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No certificate requests matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'certificate',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $certificates->count(),
    ]);

    return redirect()->back()->with('success', 'Certificate report generated successfully.');
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

    if ($data->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No household records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'household',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $data->count(),
    ]);

    return redirect()->back()->with('success', 'Household report generated successfully.');
}

public function generateComplaint(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'complaint_status' => 'nullable|in:all,pending,on-going,resolved,rejected',
        'complainant_name' => 'nullable|string|max:150',
        'respondent_name' => 'nullable|string|max:150',
        'address' => 'nullable|string|max:255',
        'keyword' => 'nullable|string|max:255',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $filters['complaint_status'] = $filters['complaint_status'] ?? 'all';
    $complaints = $this->buildComplaintReportQuery($filters)->get();

    if ($complaints->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No complaint records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'complaint',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $complaints->count(),
    ]);

    return redirect()->back()->with('success', 'Complaint report generated successfully.');
}

public function generateActivity(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'module' => 'nullable|string|max:150',
        'action' => 'nullable|string|max:150',
        'record_id' => 'nullable|integer|min:1',
        'keyword' => 'nullable|string|max:255',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $logs = $this->buildActivityReportQuery($filters)->get();

    if ($logs->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No activity log records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'activity',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $logs->count(),
    ]);

    return redirect()->back()->with('success', 'Activity log report generated successfully.');
}

public function generateOfficials(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'position' => 'nullable|string|max:150',
        'resident_name' => 'nullable|string|max:150',
        'term_status' => 'nullable|in:all,active,upcoming,completed,no_term',
        'term_start_from' => 'nullable|date',
        'term_start_to' => 'nullable|date|after_or_equal:term_start_from',
        'term_end_from' => 'nullable|date',
        'term_end_to' => 'nullable|date|after_or_equal:term_end_from',
        'keyword' => 'nullable|string|max:255',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $filters['term_status'] = $filters['term_status'] ?? 'all';
    $officials = $this->buildOfficialsReportQuery($filters)->get();

    if ($officials->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No barangay official records matched the selected term filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'officials',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $officials->count(),
    ]);

    return redirect()->back()->with('success', 'Barangay officials report generated successfully.');
}

public function generateArchives(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'record_type' => 'nullable|string|max:150',
        'archived_by' => 'nullable|exists:users,id',
        'record_id' => 'nullable|integer|min:1',
        'reason' => 'nullable|string|max:255',
        'keyword' => 'nullable|string|max:255',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $archives = $this->buildArchivesReportQuery($filters)->get();

    if ($archives->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No archived records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'archives',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $archives->count(),
    ]);

    return redirect()->back()->with('success', 'Archives report generated successfully.');
}

public function generateAnnouncements(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'title' => 'nullable|string|max:100',
        'details_keyword' => 'nullable|string|max:255',
        'has_image' => 'nullable|in:all,yes,no',
        'event_start_from' => 'nullable|date',
        'event_start_to' => 'nullable|date|after_or_equal:event_start_from',
        'event_end_from' => 'nullable|date',
        'event_end_to' => 'nullable|date|after_or_equal:event_end_from',
        'published_from' => 'nullable|date',
        'published_to' => 'nullable|date|after_or_equal:published_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $filters['has_image'] = $filters['has_image'] ?? 'all';
    $announcements = $this->buildAnnouncementsReportQuery($filters)->get();

    if ($announcements->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No announcement records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'announcements',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $announcements->count(),
    ]);

    return redirect()->back()->with('success', 'Announcements report generated successfully.');
}

public function generateFeedback(Request $request)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'user_id' => 'nullable|exists:users,id',
        'message_keyword' => 'nullable|string|max:255',
        'submitted_from' => 'nullable|date',
        'submitted_to' => 'nullable|date|after_or_equal:submitted_from',
    ]);

    $filters = $request->except(['_token', 'report_form_type']);
    $feedback = $this->buildFeedbackReportQuery($filters)->get();

    if ($feedback->isEmpty()) {
        return redirect()->back()->withInput()->with('error', 'Report generation failed. No feedback records matched the selected filters.');
    }

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'feedback',
        'filters_used' => json_encode($filters),
        'generated_by' => Auth::id(),
        'total_records' => $feedback->count(),
    ]);

    return redirect()->back()->with('success', 'Feedback report generated successfully.');
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

private function buildBlotterReportQuery(array $filters)
{
    $query = Blotter::query()->with([
        'updates' => function ($q) {
            $q->orderBy('date')->orderBy('id');
        },
    ]);
    $status = $filters['blotter_status'] ?? 'all';
    $type = $filters['blotter_type'] ?? 'all';

    if (!empty($filters['complainant_name'])) {
        $search = trim((string) $filters['complainant_name']);
        $query->where(function ($q) use ($search) {
            $q->where('plaintiffName', 'like', '%' . $search . '%')
                ->orWhere('plaintiffMiddleName', 'like', '%' . $search . '%')
                ->orWhere('plaintiffLastName', 'like', '%' . $search . '%')
                ->orWhereRaw("CONCAT_WS(' ', plaintiffName, plaintiffMiddleName, plaintiffLastName) like ?", ['%' . $search . '%']);
        });
    }

    if ($status !== 'all') {
        if ($status === 'pending') {
            $query->whereIn('current_status', ['barangayBlotter', 'first', 'second', 'third']);
        } elseif ($status === 'ongoing') {
            $query->where('current_status', 'brgyHearing');
        } elseif ($status === 'closed') {
            $query->whereIn('current_status', ['coldCase', 'criminalCase', 'referredToPnp', 'resolved']);
        } else {
            $query->where('current_status', $status);
        }
    }

    if ($type !== 'all') {
        $query->where('blotter_type', $type);
    }

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['date_from'] ?? null,
        $filters['date_to'] ?? null
    );

    return $query->latest();
}

private function buildComplaintReportQuery(array $filters)
{
    $query = Complaints::query()->with([
        'complainant:id,firstName,middleName,lastName',
        'respondent:id,firstName,middleName,lastName',
    ]);

    $status = $filters['complaint_status'] ?? 'all';
    if ($status !== 'all') {
        $query->where('status', $status);
    }

    if (!empty($filters['complainant_name'])) {
        $search = trim((string) $filters['complainant_name']);
        $query->where('complainantName', 'like', '%' . $search . '%');
    }

    if (!empty($filters['respondent_name'])) {
        $search = trim((string) $filters['respondent_name']);
        $query->whereHas('respondent', function ($q) use ($search) {
            $q->where('firstName', 'like', '%' . $search . '%')
                ->orWhere('middleName', 'like', '%' . $search . '%')
                ->orWhere('lastName', 'like', '%' . $search . '%')
                ->orWhereRaw("CONCAT_WS(' ', firstName, middleName, lastName) like ?", ['%' . $search . '%']);
        });
    }

    if (!empty($filters['address'])) {
        $query->where('address', 'like', '%' . trim((string) $filters['address']) . '%');
    }

    if (!empty($filters['keyword'])) {
        $search = trim((string) $filters['keyword']);
        $query->where(function ($q) use ($search) {
            $q->where('details', 'like', '%' . $search . '%')
                ->orWhere('remarks', 'like', '%' . $search . '%');
        });
    }

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['date_from'] ?? null,
        $filters['date_to'] ?? null
    );

    return $query->latest();
}

private function buildActivityReportQuery(array $filters)
{
    $query = ActiveLog::query()->with([
        'user:id,firstName,lastName',
    ]);

    if (!empty($filters['user_id'])) {
        $query->where('user_id', $filters['user_id']);
    }

    if (!empty($filters['module'])) {
        $query->where('module', 'like', '%' . trim((string) $filters['module']) . '%');
    }

    if (!empty($filters['action'])) {
        $query->where('action', 'like', '%' . trim((string) $filters['action']) . '%');
    }

    if (!empty($filters['record_id'])) {
        $query->where('record_id', (int) $filters['record_id']);
    }

    if (!empty($filters['keyword'])) {
        $search = trim((string) $filters['keyword']);
        $query->where(function ($q) use ($search) {
            $q->where('description', 'like', '%' . $search . '%')
                ->orWhere('module', 'like', '%' . $search . '%')
                ->orWhere('action', 'like', '%' . $search . '%');
        });
    }

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['date_from'] ?? null,
        $filters['date_to'] ?? null
    );

    return $query->latest();
}

private function buildOfficialsReportQuery(array $filters)
{
    $query = Official::query()->with([
        'resident:id,firstName,middleName,lastName',
    ]);

    if (!empty($filters['position'])) {
        $query->where('position', $filters['position']);
    }

    if (!empty($filters['resident_name'])) {
        $search = trim((string) $filters['resident_name']);
        $query->whereHas('resident', function ($q) use ($search) {
            $q->where('firstName', 'like', '%' . $search . '%')
                ->orWhere('middleName', 'like', '%' . $search . '%')
                ->orWhere('lastName', 'like', '%' . $search . '%')
                ->orWhereRaw("CONCAT_WS(' ', firstName, middleName, lastName) like ?", ['%' . $search . '%']);
        });
    }

    $today = now()->toDateString();
    $termStatus = $filters['term_status'] ?? 'all';
    if ($termStatus === 'active') {
        $query->whereDate('start', '<=', $today)
            ->whereDate('end', '>=', $today);
    } elseif ($termStatus === 'upcoming') {
        $query->whereDate('start', '>', $today);
    } elseif ($termStatus === 'completed') {
        $query->whereDate('end', '<', $today);
    } elseif ($termStatus === 'no_term') {
        $query->where(function ($q) {
            $q->whereNull('start')
                ->orWhereNull('end');
        });
    }

    if (!empty($filters['term_start_from']) && !empty($filters['term_start_to'])) {
        $query->whereBetween('start', [$filters['term_start_from'], $filters['term_start_to']]);
    } elseif (!empty($filters['term_start_from'])) {
        $query->whereDate('start', '>=', $filters['term_start_from']);
    } elseif (!empty($filters['term_start_to'])) {
        $query->whereDate('start', '<=', $filters['term_start_to']);
    }

    if (!empty($filters['term_end_from']) && !empty($filters['term_end_to'])) {
        $query->whereBetween('end', [$filters['term_end_from'], $filters['term_end_to']]);
    } elseif (!empty($filters['term_end_from'])) {
        $query->whereDate('end', '>=', $filters['term_end_from']);
    } elseif (!empty($filters['term_end_to'])) {
        $query->whereDate('end', '<=', $filters['term_end_to']);
    }

    if (!empty($filters['keyword'])) {
        $search = trim((string) $filters['keyword']);
        $query->where(function ($q) use ($search) {
            $q->where('details', 'like', '%' . $search . '%')
                ->orWhere('position', 'like', '%' . $search . '%');
        });
    }

    return $query
        ->orderByRaw('CASE WHEN start IS NULL THEN 1 ELSE 0 END')
        ->orderByDesc('start')
        ->latest('id');
}

private function buildArchivesReportQuery(array $filters)
{
    $query = Archive::query()->with([
        'user:id,firstName,lastName',
    ]);

    if (!empty($filters['record_type'])) {
        $query->where('record_type', $filters['record_type']);
    }

    if (!empty($filters['archived_by'])) {
        $query->where('archived_by', (int) $filters['archived_by']);
    }

    if (!empty($filters['record_id'])) {
        $query->where('record_id', (int) $filters['record_id']);
    }

    if (!empty($filters['reason'])) {
        $query->where('reason', 'like', '%' . trim((string) $filters['reason']) . '%');
    }

    if (!empty($filters['keyword'])) {
        $search = trim((string) $filters['keyword']);
        $query->where(function ($q) use ($search) {
            $q->where('record_type', 'like', '%' . $search . '%')
                ->orWhere('reason', 'like', '%' . $search . '%')
                ->orWhere('data', 'like', '%' . $search . '%');
        });
    }

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['date_from'] ?? null,
        $filters['date_to'] ?? null
    );

    return $query->latest();
}

private function buildAnnouncementsReportQuery(array $filters)
{
    $query = Announcement::query()->with([
        'user:id,firstName,lastName',
    ]);

    if (!empty($filters['user_id'])) {
        $query->where('user_id', (int) $filters['user_id']);
    }

    if (!empty($filters['title'])) {
        $query->where('title', 'like', '%' . trim((string) $filters['title']) . '%');
    }

    if (!empty($filters['details_keyword'])) {
        $query->where('details', 'like', '%' . trim((string) $filters['details_keyword']) . '%');
    }

    $hasImage = $filters['has_image'] ?? 'all';
    if ($hasImage === 'yes') {
        $query->whereNotNull('image')->where('image', '!=', '');
    } elseif ($hasImage === 'no') {
        $query->where(function ($q) {
            $q->whereNull('image')->orWhere('image', '');
        });
    }

    $this->applyInclusiveDateRange(
        $query,
        'eventTime',
        $filters['event_start_from'] ?? null,
        $filters['event_start_to'] ?? null
    );

    $this->applyInclusiveDateRange(
        $query,
        'eventEnd',
        $filters['event_end_from'] ?? null,
        $filters['event_end_to'] ?? null
    );

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['published_from'] ?? null,
        $filters['published_to'] ?? null
    );

    return $query->latest();
}

private function buildFeedbackReportQuery(array $filters)
{
    $query = Feedbacks::query()->with([
        'user:id,firstName,lastName',
    ]);

    if (!empty($filters['user_id'])) {
        $query->where('user_id', (int) $filters['user_id']);
    }

    if (!empty($filters['message_keyword'])) {
        $query->where('message', 'like', '%' . trim((string) $filters['message_keyword']) . '%');
    }

    $this->applyInclusiveDateRange(
        $query,
        'created_at',
        $filters['submitted_from'] ?? null,
        $filters['submitted_to'] ?? null
    );

    return $query->latest();
}

public function view($id)
{
    $report = GeneratedReport::findOrFail($id);
    $filters = is_array($report->filters_used) ? $report->filters_used : (json_decode($report->filters_used, true) ?? []);

    if ($report->report_type == 'population') {
        $data = $this->buildPopulationReportQuery($filters)->get();
    }

    if ($report->report_type == 'blotter') {
        $data = $this->buildBlotterReportQuery($filters)->get();
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
        $this->applyInclusiveDateRange(
            $query,
            'created_at',
            $filters['date_from'] ?? null,
            $filters['date_to'] ?? null
        );

        $data = $query->get();
    }

    if ($report->report_type == 'complaint') {
        $data = $this->buildComplaintReportQuery($filters)->get();
    }

    if ($report->report_type == 'activity') {
        $data = ActiveLogRecordDetails::enrich(
            $this->buildActivityReportQuery($filters)->get()
        );
    }

    if ($report->report_type == 'officials') {
        $data = $this->buildOfficialsReportQuery($filters)->get();
    }

    if ($report->report_type == 'archives') {
        $data = $this->buildArchivesReportQuery($filters)->get();
    }

    if ($report->report_type == 'announcements') {
        $data = $this->buildAnnouncementsReportQuery($filters)->get();
    }

    if ($report->report_type == 'feedback') {
        $data = $this->buildFeedbackReportQuery($filters)->get();
    }

    if ($report->report_type == 'household') {
        $data = $this->getHouseholdReportData($filters);
    }

    // also pass list so admin wrapper can render index
    $reports = GeneratedReport::with('generator:id,firstName,lastName')
        ->latest()
        ->paginate(10)
        ->appends(request()->query());
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
    $activityUsers = \App\Models\User::query()
        ->whereIn('id', ActiveLog::query()->select('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $activityModules = ActiveLog::query()
        ->whereNotNull('module')
        ->where('module', '!=', '')
        ->select('module')
        ->distinct()
        ->orderBy('module')
        ->pluck('module');
    $activityActions = ActiveLog::query()
        ->whereNotNull('action')
        ->where('action', '!=', '')
        ->select('action')
        ->distinct()
        ->orderBy('action')
        ->pluck('action');
    $officialPositions = Official::query()
        ->whereNotNull('position')
        ->where('position', '!=', '')
        ->select('position')
        ->distinct()
        ->orderBy('position')
        ->pluck('position');
    $archiveTypes = Archive::query()
        ->whereNotNull('record_type')
        ->where('record_type', '!=', '')
        ->select('record_type')
        ->distinct()
        ->orderBy('record_type')
        ->pluck('record_type');
    $archiveUsers = \App\Models\User::query()
        ->whereIn('id', Archive::query()->select('archived_by')->whereNotNull('archived_by')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $announcementUsers = \App\Models\User::query()
        ->whereIn('id', Announcement::query()->select('user_id')->whereNotNull('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);
    $feedbackUsers = \App\Models\User::query()
        ->whereIn('id', Feedbacks::query()->select('user_id')->whereNotNull('user_id')->distinct())
        ->orderBy('lastName')
        ->orderBy('firstName')
        ->get(['id', 'firstName', 'lastName']);

    return view('admin.reports', compact('reports', 'report', 'data', 'streets', 'streetOptions', 'houseOptions', 'houseHeadOptions', 'activityUsers', 'activityModules', 'activityActions', 'officialPositions', 'archiveTypes', 'archiveUsers', 'announcementUsers', 'feedbackUsers'));
}

public function printTemplate($id)
{
    $report = GeneratedReport::findOrFail($id);
    \App\Services\ActiveLogger::log(
        'Reports',
        'printed',
        $report->id,
        'Printed a report'
    );
    $filters = is_array($report->filters_used) ? $report->filters_used : (json_decode($report->filters_used, true) ?? []);

    if ($report->report_type == 'population') {
        $data = $this->buildPopulationReportQuery($filters)->get();
    }

    if ($report->report_type == 'blotter') {
        $data = $this->buildBlotterReportQuery($filters)->get();
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
        $this->applyInclusiveDateRange(
            $query,
            'created_at',
            $filters['date_from'] ?? null,
            $filters['date_to'] ?? null
        );

        $data = $query->get();
    }

    if ($report->report_type == 'complaint') {
        $data = $this->buildComplaintReportQuery($filters)->get();
    }

    if ($report->report_type == 'activity') {
        $data = ActiveLogRecordDetails::enrich(
            $this->buildActivityReportQuery($filters)->get()
        );
    }

    if ($report->report_type == 'officials') {
        $data = $this->buildOfficialsReportQuery($filters)->get();
    }

    if ($report->report_type == 'archives') {
        $data = $this->buildArchivesReportQuery($filters)->get();
    }

    if ($report->report_type == 'announcements') {
        $data = $this->buildAnnouncementsReportQuery($filters)->get();
    }

    if ($report->report_type == 'feedback') {
        $data = $this->buildFeedbackReportQuery($filters)->get();
    }

    if ($report->report_type == 'household') {
        $data = $this->getHouseholdReportData($filters);
    }

    return view('reports.print-template', compact('report', 'data'));
}
}
