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
    $reports = GeneratedReport::latest()->get();

    // grab street names for filter dropdown
    $streets = \App\Models\Street::orderBy('street_name')->pluck('street_name');

    return view('admin.reports', compact('reports', 'streets'));
}

public function generatePopulation(Request $request)
{
    $request->validate([
        'report_name' => 'required',
        'date_from' => 'required|date',
        'date_to' => 'required|date',
        'age_group' => 'nullable|in:children,youth,adults,senior',
        'gender' => 'nullable|in:male,female',
        'street' => 'nullable|string',
        'parent' => 'nullable|in:yes,no,single',
        'civil_status' => 'nullable|in:single,married,widowed,divorced',
    ]);

    $query = Resident::query();

    // Date Range Filter (created_at)
    $query->whereBetween('created_at', [
        $request->date_from,
        $request->date_to
    ]);

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
        $query->where('street', $request->street);
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
        'date_from' => 'required|date',
        'date_to' => 'required|date'
    ]);

    $query = CertificateRequest::where('status', 'released');

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
        $query = Resident::whereBetween('created_at', [
            $filters['date_from'],
            $filters['date_to']
        ]);

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
        $data = CertificateRequest::where('status', 'released')
            ->whereBetween('created_at', [
                $filters['date_from'],
                $filters['date_to']
            ])->get();
    }

    // also pass list so admin wrapper can render index
    $reports = GeneratedReport::latest()->get();
    $streets = Street::orderBy('street_name')->pluck('street_name');

    return view('admin.reports', compact('reports', 'report', 'data', 'streets'));
}
}
