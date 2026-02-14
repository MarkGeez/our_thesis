<?php

namespace App\Http\Controllers;

use App\Models\Blotter;
use App\Models\Certificate;
use App\Models\CertificateRequest;
use App\Models\ActiveLog;
use App\Models\Resident;
use App\Models\Household;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    /**
     * Show the reports page with filter options
     */
    public function index(): View
    {
        $admin = Auth::user();
        return view('admin.reports', compact('admin'));
    }

    /**
     * Generate Blotter Reports
     */
    public function generateBlotterReport(Request $request)
    {
        $query = Blotter::query();

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply optional filters
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('current_status', $request->status);
        }
        if ($request->filled('complainant')) {
            $query->where('plaintiffName', 'LIKE', '%' . $request->complainant . '%');
        }
        if ($request->filled('respondent')) {
            $query->where('defendantName', 'LIKE', '%' . $request->respondent . '%');
        }

        $reports = $query->orderBy('created_at', 'desc')->get()->map(function ($report) {
            $report->complainant_tag = trim((string) $report->plaintiffName);
            $report->respondent_tag = trim((string) $report->defendantName);
            return $report;
        });

        if ($request->input('export') === 'pdf') {
            return $this->exportBlotterPdf($reports);
        }

        return response()->json([
            'success' => true,
            'data' => $reports,
            'count' => $reports->count(),
            'type' => 'blotter'
        ]);
    }

    /**
     * Generate Certificate Reports
     */
    public function generateCertificateReport(Request $request)
    {
        $query = CertificateRequest::with('user');

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply optional filters
        if ($request->filled('certificate_type') && $request->certificate_type !== 'all') {
            $query->where('certificate_type', $request->certificate_type);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        if ($request->input('export') === 'pdf') {
            return $this->exportCertificatePdf($reports);
        }

        return response()->json([
            'success' => true,
            'data' => $reports,
            'count' => $reports->count(),
            'type' => 'certificate'
        ]);
    }

    /**
     * Generate Active Logs Reports
     */
    public function generateActiveLogReport(Request $request)
    {
        $query = ActiveLog::with('user');

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply optional filters
        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id') && $request->user_id !== 'all') {
            $query->where('user_id', $request->user_id);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        if ($request->input('export') === 'pdf') {
            return $this->exportActiveLogPdf($reports);
        }

        return response()->json([
            'success' => true,
            'data' => $reports,
            'count' => $reports->count(),
            'type' => 'active_log'
        ]);
    }

    /**
     * Generate Population Reports
     */
    public function generatePopulationReport(Request $request)
    {
        $query = Resident::query();

        // Apply optional filters
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('sex', $request->gender);
        }

        if ($request->filled('age_from')) {
            $query->where('age', '>=', (int) $request->age_from);
        }
        if ($request->filled('age_to')) {
            $query->where('age', '<=', (int) $request->age_to);
        }

        if ($request->filled('show_birthdays') === 'true') {
            // If filtering for birthdays in a specific month
            if ($request->filled('birthday_month')) {
                $query->whereRaw('MONTH(birthday) = ?', [$request->birthday_month]);
            }
        }

        $reports = $query->orderBy('firstName', 'asc')->get();

        if ($request->input('export') === 'pdf') {
            return $this->exportPopulationPdf($reports);
        }

        return response()->json([
            'success' => true,
            'data' => $reports,
            'count' => $reports->count(),
            'type' => 'population'
        ]);
    }

    /**
     * Generate Household Reports
     */
    public function generateHouseholdReport(Request $request)
    {
        $query = Household::with('house.street', 'residents')->has('residents');

        // Apply optional filters
        if ($request->filled('house_number')) {
            $houseName = $request->house_number;
            $query->whereHas('house', function ($q) use ($houseName) {
                $q->where('house_no', 'LIKE', '%' . $houseName . '%');
            });
        }

        if ($request->filled('street')) {
            $streetName = trim((string) $request->street);
            $query->whereHas('house.street', function ($q) use ($streetName) {
                $q->where('street_name', 'LIKE', '%' . $streetName . '%');
            });
        }

        $reports = $query->orderBy('id', 'asc')->get();

        if ($request->input('export') === 'pdf') {
            return $this->exportHouseholdPdf($reports);
        }

        return response()->json([
            'success' => true,
            'data' => $reports,
            'count' => $reports->count(),
            'type' => 'household'
        ]);
    }

    /**
     * Export Blotter Report to PDF
     */
    protected function exportBlotterPdf($reports)
    {
        $html = $this->generateBlotterHtml($reports);
        
        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isSslVerifyPeerEnabled', false)
            ->download('blotter-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Certificate Report to PDF
     */
    protected function exportCertificatePdf($reports)
    {
        $html = $this->generateCertificateHtml($reports);
        
        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isSslVerifyPeerEnabled', false)
            ->download('certificate-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Active Log Report to PDF
     */
    protected function exportActiveLogPdf($reports)
    {
        $html = $this->generateActiveLogHtml($reports);
        
        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isSslVerifyPeerEnabled', false)
            ->download('active-log-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Population Report to PDF
     */
    protected function exportPopulationPdf($reports)
    {
        $html = $this->generatePopulationHtml($reports);
        
        return Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isSslVerifyPeerEnabled', false)
            ->download('population-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Household Report to PDF
     */
    protected function exportHouseholdPdf($reports)
    {
        $html = $this->generateHouseholdHtml($reports);
        
        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isSslVerifyPeerEnabled', false)
            ->download('household-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate HTML for Blotter Report
     */
    protected function generateBlotterHtml($reports)
    {
        return view('admin.reports.blotter-pdf', ['reports' => $reports])->render();
    }

    /**
     * Generate HTML for Certificate Report
     */
    protected function generateCertificateHtml($reports)
    {
        return view('admin.reports.certificate-pdf', ['reports' => $reports])->render();
    }

    /**
     * Generate HTML for Active Log Report
     */
    protected function generateActiveLogHtml($reports)
    {
        return view('admin.reports.active-log-pdf', ['reports' => $reports])->render();
    }

    /**
     * Generate HTML for Population Report
     */
    protected function generatePopulationHtml($reports)
    {
        return view('admin.reports.population-pdf', ['reports' => $reports])->render();
    }

    /**
     * Generate HTML for Household Report
     */
    protected function generateHouseholdHtml($reports)
    {
        return view('admin.reports.household-pdf', ['reports' => $reports])->render();
    }

    /**
     * Get filter options (for AJAX requests)
     */
    public function getFilterOptions($reportType)
    {
        $options = [];

        switch ($reportType) {
            case 'blotter':
                $options = [
                    'statuses' => Blotter::distinct('current_status')->pluck('current_status'),
                    'complainants' => Blotter::whereNotNull('plaintiffName')
                        ->distinct('plaintiffName')
                        ->pluck('plaintiffName')
                        ->filter(),
                    'respondents' => Blotter::whereNotNull('defendantName')
                        ->distinct('defendantName')
                        ->pluck('defendantName')
                        ->filter(),
                ];
                break;

            case 'certificate':
                $options = [
                    'types' => collect(CertificateRequest::TYPES)
                        ->map(fn ($type) => ['value' => $type, 'label' => Str::headline($type)])
                        ->values(),
                    'statuses' => ['pending', 'approved', 'declined'],
                ];
                break;

            case 'active_log':
                $options = [
                    'actions' => ActiveLog::distinct('action')->pluck('action'),
                    'users' => User::where('role', '!=', null)->get(['id', 'firstName', 'lastName']),
                ];
                break;

            case 'population':
                $options = [
                    'genders' => ['male', 'female'],
                ];
                break;

            case 'household':
                $options = [
                    'streets' => House::query()
                        ->with('street:id,street_name')
                        ->get()
                        ->pluck('street.street_name')
                        ->filter()
                        ->unique()
                        ->values(),
                ];
                break;
        }

        return response()->json($options);
    }
}
