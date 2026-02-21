<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Blotter;
use App\Models\CertificateRequest;
use App\Models\GeneratedReport;
use App\Models\Street;
use Carbon\Carbon;
use Auth;

class ReportsController extends Controller
{
public function index()
{
    // show admin wrapper and report list
    $reports = GeneratedReport::with('generator:id,firstName,lastName')->latest()->get();

    // grab street names for filter dropdown
    $streets = \App\Models\Street::orderBy('street_name')->pluck('street_name');

    return view('admin.reports', compact('reports', 'streets'));
}

public function generatePopulation(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'age_group' => 'nullable|in:children,youth,adults,senior',
        'gender' => 'nullable|in:male,female',
        'street' => 'nullable|string',
        'parent' => 'nullable|in:yes,no,single',
        'civil_status' => 'nullable|in:single,married,widowed,divorced',
        'birthday_from' => 'nullable|date_format:Y-m-d',
        'birthday_to' => 'nullable|date_format:Y-m-d',
    ]);

    $query = \App\Models\Resident::query()
        ->leftJoin('household_resident', 'residents.id', '=', 'household_resident.resident_id')
        ->leftJoin('households', 'household_resident.household_id', '=', 'households.id')
        ->leftJoin('houses', 'households.house_id', '=', 'houses.id')
        ->leftJoin('streets', 'houses.street_id', '=', 'streets.id')
        ->select('residents.*', 'streets.street_name as street_name', 'houses.house_no as house_no');

    // backward compatibility for old 'filter' parameter
    if (!$request->filled('age_group') && $request->filled('filter')) {
        if ($request->filter === 'senior') {
            $request->merge(['age_group' => 'senior']);
        }
    }

    // Age group filter
    if ($request->filled('age_group')) {
        switch ($request->age_group) {
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

    // Gender
    if ($request->filled('gender')) {
        $query->where('sex', $request->gender);
    }

    // Street
    if ($request->filled('street')) {
        $query->where('streets.street_name', $request->street);
    }

    // Parent status
    if ($request->filled('parent')) {
        $query->where('parent', $request->parent);
    }

    // Civil status (column may not exist, check first)
    if ($request->filled('civil_status') && 
        
        \Schema::hasColumn('residents', 'civil_status')) {
        $query->where('civil_status', $request->civil_status);
    }

    // Birthday range filter (optional) - filters by month-day regardless of year
    if ($request->filled('birthday_from') && $request->filled('birthday_to')) {
        $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN DATE_FORMAT(?, '%m-%d') AND DATE_FORMAT(?, '%m-%d')", 
                         [$request->birthday_from, $request->birthday_to]);
    }

    $residents = $query->get();

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'population',
        'filters_used' => json_encode($request->all()),
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

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'blotter',
        'filters_used' => json_encode($request->all()),
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

    GeneratedReport::create([
        'report_name' => $request->report_name,
        'report_type' => 'certificate',
        'filters_used' => json_encode($request->all()),
        'generated_by' => Auth::id(),
        'total_records' => $certificates->count(),
    ]);

    return redirect()->back();
}

public function view($id)
{
    $report = GeneratedReport::findOrFail($id);
    $filters = json_decode($report->filters_used, true);

    if ($report->report_type == 'population') {
        $query = \App\Models\Resident::query()
            ->leftJoin('household_resident', 'residents.id', '=', 'household_resident.resident_id')
            ->leftJoin('households', 'household_resident.household_id', '=', 'households.id')
            ->leftJoin('houses', 'households.house_id', '=', 'houses.id')
            ->leftJoin('streets', 'houses.street_id', '=', 'streets.id')
            ->select('residents.*', 'streets.street_name as street_name', 'houses.house_no as house_no');

        // backward compatibility: old reports used 'filter' => 'senior'
        if (empty($filters['age_group']) && isset($filters['filter']) && $filters['filter'] === 'senior') {
            $filters['age_group'] = 'senior';
        }

        // apply age grouping logic
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

        if (!empty($filters['street'])) {
            $query->where('streets.street_name', $filters['street']);
        }

        if (!empty($filters['parent'])) {
            $query->where('parent', $filters['parent']);
        }

        if (!empty($filters['civil_status']) && \Schema::hasColumn('residents', 'civil_status')) {
            $query->where('civil_status', $filters['civil_status']);
        }

        // Apply birthday range filter if present
        if (!empty($filters['birthday_from']) && !empty($filters['birthday_to'])) {
            $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN DATE_FORMAT(?, '%m-%d') AND DATE_FORMAT(?, '%m-%d')", 
                             [$filters['birthday_from'], $filters['birthday_to']]);
        }

        $data = $query->get();
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

    // also pass list so admin wrapper can render index
    $reports = GeneratedReport::with('generator:id,firstName,lastName')->latest()->get();
    $streets = Street::orderBy('street_name')->pluck('street_name');

    return view('admin.reports', compact('reports', 'report', 'data', 'streets'));
}

public function printTemplate($id)
{
    $report = GeneratedReport::findOrFail($id);
    $filters = json_decode($report->filters_used, true);

    if ($report->report_type == 'population') {
        $query = Resident::query();

        // backward compatibility: old reports used 'filter' => 'senior'
        if (empty($filters['age_group']) && isset($filters['filter']) && $filters['filter'] === 'senior') {
            $filters['age_group'] = 'senior';
        }

        // apply age grouping logic
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

        if (!empty($filters['street'])) {
            $query->where('street', $filters['street']);
        }

        if (!empty($filters['parent'])) {
            $query->where('parent', $filters['parent']);
        }

        if (!empty($filters['civil_status']) && \Schema::hasColumn('residents', 'civil_status')) {
            $query->where('civil_status', $filters['civil_status']);
        }

        // Apply birthday range filter if present
        if (!empty($filters['birthday_from']) && !empty($filters['birthday_to'])) {
            $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN DATE_FORMAT(?, '%m-%d') AND DATE_FORMAT(?, '%m-%d')", 
                             [$filters['birthday_from'], $filters['birthday_to']]);
        }

        $data = $query->get();
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

    return view('reports.print-template', compact('report', 'data'));
}
}
