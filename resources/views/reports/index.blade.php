<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
        --success-color: #059669;
        --warning-color: #f59e0b;
        --info-color: #0ea5e9;
        --danger-color: #dc2626;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
    }

    .reports-container {
        padding: 1.5rem;
    }

    .welcome-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.5),
            inset 0 -1px 0 rgba(255, 255, 255, 0.1),
            inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
        color: #111827;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 1.5rem;
    }

    .welcome-card h3 {
        font-size: 2rem;
        margin-bottom: 10px;
        font-weight: 700;
        font-family: "Oswald", sans-serif;
    }

    .section-header {
        background: #fff;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin: 1.25rem 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--primary-color);
    }

    .section-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-header h5 i {
        color: var(--primary-color);
    }

    .action-card {
        cursor: pointer;
        transition: all 0.25s ease;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.15);
        border-color: #bfdbfe;
    }

    .action-card i {
        transition: transform 0.3s ease;
    }

    .action-card:hover i {
        transform: scale(1.08);
    }

    .table-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-responsive {
        padding: 1.5rem;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
        color: var(--text-primary) !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none !important;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .table tbody td {
        padding: 0.9rem 0.75rem;
        vertical-align: middle;
    }

    .report-type-badge {
        border-radius: 999px;
        padding: 0.4rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .report-type-population {
        color: #1e40af;
        background: #dbeafe;
    }

    .report-type-blotter {
        color: #9a3412;
        background: #ffedd5;
    }

    .report-type-certificate {
        color: #065f46;
        background: #d1fae5;
    }

    .report-type-complaint {
        color: #9a3412;
        background: #ffedd5;
    }

    .report-type-household {
        color: #4c1d95;
        background: #ede9fe;
    }

    .report-type-activity {
        color: #134e4a;
        background: #ccfbf1;
    }

    .report-type-officials {
        color: #1d4ed8;
        background: #dbeafe;
    }

    .report-type-archives {
        color: #92400e;
        background: #ffedd5;
    }

    .report-type-announcements {
        color: #0c4a6e;
        background: #e0f2fe;
    }

    .report-type-feedback {
        color: #365314;
        background: #ecfccb;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-control,
    .form-select {
        border: 1px solid #cbd5e1;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }

    .input-group-text {
        background-color: #f1f3f5;
        border: 1.5px solid #ced4da;
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 1;
        cursor: pointer;
    }

    .input-group > .form-control[type="date"] {
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
    }

    .optional-hint {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
    }

    .report-filter-toggle {
        width: 100%;
        border: 1px solid #cbd5e1;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        color: #1e293b;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 700;
    }

    .report-filter-toggle:hover,
    .report-filter-toggle:focus {
        border-color: #93c5fd;
        color: #0f172a;
        background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.08);
    }

    .report-filter-chevron {
        transition: transform 0.2s ease;
    }

    .report-filter-toggle:not(.collapsed) .report-filter-chevron {
        transform: rotate(180deg);
    }

    .report-filter-panel {
        margin-top: 0.85rem;
        padding: 1rem;
        border: 1px solid #dbeafe;
        border-radius: 14px;
        background: #f8fbff;
    }

    .pagination-container {
        padding: 18px 22px 22px 22px;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-top: 2px solid var(--border-color);
    }

    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;
        margin: 0;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .pagination-info-text {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        background: #fff;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 2px solid var(--border-color);
        font-weight: 600;
    }

    .pagination-info-text i {
        color: var(--primary-color);
    }

    .pagination-info-numbers {
        color: var(--text-primary);
        font-weight: 700;
    }

    .pagination {
        margin: 0;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination .page-link {
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.58rem 0.95rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s ease;
        background: #fff;
        min-width: 44px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-link:hover:not(.disabled) {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-color: var(--primary-color);
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
        transform: scale(1.06);
        position: relative;
        z-index: 1;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .reports-container {
            padding: 1rem;
        }

        .welcome-card h3 {
            font-size: 1.5rem;
        }

        .table-responsive {
            padding: 0.75rem;
        }

        .pagination-container {
            padding-left: 14px;
            padding-right: 14px;
        }
    }
</style>

<div class="reports-container">
    <div class="welcome-card">
        <h3>Report Generation Center</h3>
        <p class="mb-0 text-muted">Choose a report type, apply filters, and generate printable analytics records.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-circle-exclamation me-3"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-circle me-3 mt-1"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="section-header">
        <h5>
            <i class="fas fa-file-circle-plus"></i>
            Generate New Report
        </h5>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalPopulationReport">
                <div class="card-body py-4">
                    <i class="fas fa-people-group fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold mb-1">Population Report</h5>
                    <p class="text-muted small mb-0">Demographic and resident profile summaries</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalBlotterReport">
                <div class="card-body py-4">
                    <i class="fas fa-scale-balanced fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold mb-1">Blotter Report</h5>
                    <p class="text-muted small mb-0">All or filtered blotter cases by status and complainant</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalCertificateReport">
                <div class="card-body py-4">
                    <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold mb-1">Certificate Report</h5>
                    <p class="text-muted small mb-0">Released certificate request records</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalHouseholdReport">
                <div class="card-body py-4">
                    <i class="fas fa-house-user fa-3x mb-3" style="color:#7c3aed;"></i>
                    <h5 class="fw-bold mb-1">Household Report</h5>
                    <p class="text-muted small mb-0">Household, house head, and family member summaries</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalComplaintReport">
                <div class="card-body py-4">
                    <i class="fas fa-comments fa-3x mb-3" style="color:#ea580c;"></i>
                    <h5 class="fw-bold mb-1">Complaint Report</h5>
                    <p class="text-muted small mb-0">Complaint records by status, names, and date range</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalActivityReport">
                <div class="card-body py-4">
                    <i class="fas fa-history fa-3x mb-3" style="color:#0f766e;"></i>
                    <h5 class="fw-bold mb-1">Activity Log Report</h5>
                    <p class="text-muted small mb-0">Audit trail records by user, module, action, and date</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalOfficialsReport">
                <div class="card-body py-4">
                    <i class="fas fa-users-gear fa-3x mb-3" style="color:#1d4ed8;"></i>
                    <h5 class="fw-bold mb-1">Officials List Reports</h5>
                    <p class="text-muted small mb-0">Barangay officials by position and term timeline</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalArchivesReport">
                <div class="card-body py-4">
                    <i class="fas fa-box-archive fa-3x mb-3" style="color:#b45309;"></i>
                    <h5 class="fw-bold mb-1">Archives Report</h5>
                    <p class="text-muted small mb-0">Archived records by type, reason, and date range</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalAnnouncementsReport">
                <div class="card-body py-4">
                    <i class="fas fa-bullhorn fa-3x mb-3" style="color:#0369a1;"></i>
                    <h5 class="fw-bold mb-1">Announcements Report</h5>
                    <p class="text-muted small mb-0">Published announcements by author, event date, and content</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalFeedbackReport">
                <div class="card-body py-4">
                    <i class="fas fa-message fa-3x mb-3" style="color:#4d7c0f;"></i>
                    <h5 class="fw-bold mb-1">Feedback Report</h5>
                    <p class="text-muted small mb-0">Feedback submissions by resident and date</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-header mt-5">
        <h5>
            <i class="fas fa-clock-rotate-left"></i>
            Generated Reports
        </h5>
    </div>

    @if($reports->isEmpty())
        <div class="empty-state bg-white rounded-4 shadow-sm">
            <i class="fas fa-folder-open"></i>
            <h5 class="mb-2 text-dark">No Reports Yet</h5>
            <p class="mb-0">Generate your first report using any card above.</p>
        </div>
    @else
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Report Title</th>
                            <th>Type</th>
                            <th>Generated By</th>
                            <th>Date Generated</th>
                            <th>Total Records</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            @php
                                $typeClass = match (strtolower($report->report_type)) {
                                    'population' => 'report-type-population',
                                    'blotter' => 'report-type-blotter',
                                    'certificate' => 'report-type-certificate',
                                    'complaint' => 'report-type-complaint',
                                    'activity' => 'report-type-activity',
                                    'officials' => 'report-type-officials',
                                    'archives' => 'report-type-archives',
                                    'announcements' => 'report-type-announcements',
                                    'feedback' => 'report-type-feedback',
                                    'household' => 'report-type-household',
                                    default => 'report-type-population',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span class="fw-semibold text-primary">{{ $report->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $report->report_name }}</div>
                                </td>
                                <td>
                                    <span class="report-type-badge {{ $typeClass }}">
                                        {{ ucfirst($report->report_type) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $generatorName = $report->generator
                                            ? ucwords(strtolower(trim($report->generator->firstName . ' ' . $report->generator->lastName)))
                                            : ('User #' . $report->generated_by);
                                    @endphp
                                    <span class="text-muted">{{ $generatorName }}</span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-semibold">{{ $report->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted">{{ $report->created_at->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ number_format($report->total_records) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.reports.view', $report->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($reports instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $reports->hasPages())
                <div class="pagination-container">
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            <div class="pagination-info-text">
                                <i class="fa-solid fa-list-check"></i>
                                <span>
                                    Showing <span class="pagination-info-numbers">{{ $reports->firstItem() }}</span>
                                    to <span class="pagination-info-numbers">{{ $reports->lastItem() }}</span>
                                    of <span class="pagination-info-numbers">{{ $reports->total() }}</span> results
                                </span>
                            </div>
                        </div>
                        {{ $reports->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

<div class="modal fade" id="modalOfficialsReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.officials') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="officials">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-users-gear me-2" style="color:#1d4ed8;"></i>Generate Officials List Reports</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Position <span class="text-muted">(Optional)</span></label>
                            <select name="position" class="form-select">
                                <option value="">All Positions</option>
                                @foreach(($officialPositions ?? collect()) as $position)
                                    <option value="{{ $position }}" {{ (string) old('position') === (string) $position ? 'selected' : '' }}>
                                        {{ $position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Official Name <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="resident_name" class="form-control" value="{{ old('resident_name') }}" placeholder="e.g. Juan Dela Cruz">
                        </div>{{-- 
                        <div class="col-md-6">
                      
                            <label class="form-label fw-semibold">Term Status <span class="text-muted">(Optional)</span></label>
                            <select name="term_status" class="form-select">
                                <option value="all" {{ old('term_status', 'all') === 'all' ? 'selected' : '' }}>All Terms</option>
                                <option value="active" {{ old('term_status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="upcoming" {{ old('term_status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="completed" {{ old('term_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="no_term" {{ old('term_status') === 'no_term' ? 'selected' : '' }}>No Term Dates</option>
                            </select>
                        </div>      
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Keyword in Position/Notes <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}" placeholder="Search term notes or position">
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-hourglass-half me-1"></i>Term Start Range (Optional)</label>
                        </div> --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="term_start_from"
                                    class="form-control report-date-input"
                                    value="{{ old('term_start_from') }}"
                                    data-raw="{{ old('term_start_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="term_start_to"
                                    class="form-control report-date-input"
                                    value="{{ old('term_start_to') }}"
                                    data-raw="{{ old('term_start_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-flag-checkered me-1"></i>Term End Range (Optional)</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="term_end_from"
                                    class="form-control report-date-input"
                                    value="{{ old('term_end_from') }}"
                                    data-raw="{{ old('term_end_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="term_end_to"
                                    class="form-control report-date-input"
                                    value="{{ old('term_end_to') }}"
                                    data-raw="{{ old('term_end_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#1d4ed8;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalArchivesReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.archives') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="archives">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-box-archive me-2" style="color:#b45309;"></i>Generate Archives Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Archive Type <span class="text-muted">(Optional)</span></label>
                            <select name="record_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach(($archiveTypes ?? collect()) as $archiveType)
                                    <option value="{{ $archiveType }}" {{ (string) old('record_type') === (string) $archiveType ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', strtolower((string) $archiveType))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Archived By <span class="text-muted">(Optional)</span></label>
                            <select name="archived_by" class="form-select">
                                <option value="">All Users</option>
                                @foreach(($archiveUsers ?? collect()) as $archiveUser)
                                    <option value="{{ $archiveUser->id }}" {{ (string) old('archived_by') === (string) $archiveUser->id ? 'selected' : '' }}>
                                        {{ ucwords(strtolower(trim(($archiveUser->firstName ?? '') . ' ' . ($archiveUser->lastName ?? '')))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>{{--
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Record ID <span class="text-muted">(Optional)</span></label>
                            <input type="number" min="1" name="record_id" class="form-control" value="{{ old('record_id') }}" placeholder="e.g. 102">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Reason <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="reason" class="form-control" value="{{ old('reason') }}" placeholder="Archive reason contains...">
                        </div>  
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keyword in Type/Reason/Details <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}" placeholder="Search archive details">
                        </div>--}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_from"
                                    class="form-control report-date-input"
                                    value="{{ old('date_from') }}"
                                    data-raw="{{ old('date_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_to"
                                    class="form-control report-date-input"
                                    value="{{ old('date_to') }}"
                                    data-raw="{{ old('date_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave filters blank to include all archived records.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#b45309;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalAnnouncementsReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.announcements') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="announcements">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-bullhorn me-2" style="color:#0369a1;"></i>Generate Announcements Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Published By <span class="text-muted">(Optional)</span></label>
                            <select name="user_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach(($announcementUsers ?? collect()) as $announcementUser)
                                    <option value="{{ $announcementUser->id }}" {{ (string) old('user_id') === (string) $announcementUser->id ? 'selected' : '' }}>
                                        {{ ucwords(strtolower(trim(($announcementUser->firstName ?? '') . ' ' . ($announcementUser->lastName ?? '')))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title Contains <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Cleanup Drive">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Details Keyword <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="details_keyword" class="form-control" value="{{ old('details_keyword') }}" placeholder="Search announcement details">
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-calendar-days me-1"></i>Event Start Range (Optional)</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="event_start_from"
                                    class="form-control report-date-input"
                                    value="{{ old('event_start_from') }}"
                                    data-raw="{{ old('event_start_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="event_start_to"
                                    class="form-control report-date-input"
                                    value="{{ old('event_start_to') }}"
                                    data-raw="{{ old('event_start_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-calendar-check me-1"></i>Event End Range (Optional)</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="event_end_from"
                                    class="form-control report-date-input"
                                    value="{{ old('event_end_from') }}"
                                    data-raw="{{ old('event_end_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="event_end_to"
                                    class="form-control report-date-input"
                                    value="{{ old('event_end_to') }}"
                                    data-raw="{{ old('event_end_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-clock me-1"></i>Published Date Range (Optional)</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Published From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="published_from"
                                    class="form-control report-date-input"
                                    value="{{ old('published_from') }}"
                                    data-raw="{{ old('published_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Published To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="published_to"
                                    class="form-control report-date-input"
                                    value="{{ old('published_to') }}"
                                    data-raw="{{ old('published_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave filters blank to include all announcement records.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#0369a1;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalFeedbackReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.feedback') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="feedback">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-message me-2" style="color:#4d7c0f;"></i>Generate Feedback Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Submitted By <span class="text-muted">(Optional)</span></label>
                            <select name="user_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach(($feedbackUsers ?? collect()) as $feedbackUser)
                                    <option value="{{ $feedbackUser->id }}" {{ (string) old('user_id') === (string) $feedbackUser->id ? 'selected' : '' }}>
                                        {{ ucwords(strtolower(trim(($feedbackUser->firstName ?? '') . ' ' . ($feedbackUser->lastName ?? '')))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            {{--  <label class="form-label fw-semibold">Message Keyword <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="message_keyword" class="form-control" value="{{ old('message_keyword') }}" placeholder="Search text in feedback message">--}}
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Submitted From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="submitted_from"
                                    class="form-control report-date-input"
                                    value="{{ old('submitted_from') }}"
                                    data-raw="{{ old('submitted_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Submitted To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="submitted_to"
                                    class="form-control report-date-input"
                                    value="{{ old('submitted_to') }}"
                                    data-raw="{{ old('submitted_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave filters blank to include all feedback records.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#4d7c0f;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalActivityReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.activity') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="activity">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-history me-2" style="color:#0f766e;"></i>Generate Activity Log Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>{{--  
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">User <span class="text-muted">(Optional)</span></label>
                            <select name="user_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach(($activityUsers ?? collect()) as $activityUser)
                                    <option value="{{ $activityUser->id }}" {{ (string) old('user_id') === (string) $activityUser->id ? 'selected' : '' }}>
                                        {{ ucwords(strtolower(trim(($activityUser->firstName ?? '') . ' ' . ($activityUser->lastName ?? '')))) }} (ID: {{ $activityUser->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>--}}
                        {{--  <div class="col-md-6">
                            <label class="form-label fw-semibold">Record ID <span class="text-muted">(Optional)</span></label>
                            <input type="number" min="1" name="record_id" class="form-control" value="{{ old('record_id') }}" placeholder="e.g. 102">
                        </div>--}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Module <span class="text-muted">(Optional)</span></label>
                            <select name="module" class="form-select">
                                <option value="">All Modules</option>
                                @foreach(($activityModules ?? collect()) as $module)
                                    <option value="{{ $module }}" {{ (string) old('module') === (string) $module ? 'selected' : '' }}>
                                        {{ $module }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Action <span class="text-muted">(Optional)</span></label>
                            <select name="action" class="form-select">
                                <option value="">All Actions</option>
                                @foreach(($activityActions ?? collect()) as $action)
                                    <option value="{{ $action }}" {{ (string) old('action') === (string) $action ? 'selected' : '' }}>
                                        {{ ucwords(strtolower((string) $action)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{--  <div class="col-12">
                            <label class="form-label fw-semibold">Keyword (Description/Module/Action) <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}" placeholder="Search text">
                        </div>--}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_from"
                                    class="form-control report-date-input"
                                    value="{{ old('date_from') }}"
                                    data-raw="{{ old('date_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_to"
                                    class="form-control report-date-input"
                                    value="{{ old('date_to') }}"
                                    data-raw="{{ old('date_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave filters blank to include all activity log records.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#0f766e;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalComplaintReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.complaint') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="complaint">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-comments me-2" style="color:#ea580c;"></i>Generate Complaint Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status <span class="text-muted">(Optional)</span></label>
                            <select name="complaint_status" class="form-select">
                                <option value="all" {{ old('complaint_status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="pending" {{ old('complaint_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="on-going" {{ old('complaint_status') === 'on-going' ? 'selected' : '' }}>On-going</option>
                                <option value="resolved" {{ old('complaint_status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ old('complaint_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Complainant Name <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="complainant_name" class="form-control" value="{{ old('complainant_name') }}" placeholder="e.g. Juan Dela Cruz">
                        </div>
                        {{--  <div class="col-md-6">
                            <label class="form-label fw-semibold">Respondent Name <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="respondent_name" class="form-control" value="{{ old('respondent_name') }}" placeholder="e.g. Pedro Santos">
                        </div>--}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address contains...">
                        </div>{{--  
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keyword in Details/Remarks <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}" placeholder="Search complaint details or remarks">
                        </div>--}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_from"
                                    class="form-control report-date-input"
                                    value="{{ old('date_from') }}"
                                    data-raw="{{ old('date_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_to"
                                    class="form-control report-date-input"
                                    value="{{ old('date_to') }}"
                                    data-raw="{{ old('date_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#ea580c;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalPopulationReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.population') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="population">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-people-group me-2 text-primary"></i>Generate Population Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Age Group <span class="text-muted">(Optional)</span></label>
                            <select name="age_group" class="form-select">
                                <option value="">All</option>
                                <option value="children" {{ old('age_group') == 'children' ? 'selected' : '' }}>Children (0-12)</option>
                                <option value="youth" {{ old('age_group') == 'youth' ? 'selected' : '' }}>Youth (13-17)</option>
                                <option value="adults" {{ old('age_group') == 'adults' ? 'selected' : '' }}>Adults (18-59)</option>
                                <option value="senior" {{ old('age_group') == 'senior' ? 'selected' : '' }}>Senior Citizens (60+)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender <span class="text-muted">(Optional)</span></label>
                            <select name="gender" class="form-select">
                                <option value="">All</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Resident Type <span class="text-muted">(Optional)</span></label>
                            <select name="resident_type" class="form-select">
                                <option value="">All</option>
                                <option value="voter" {{ old('resident_type') == 'voter' ? 'selected' : '' }}>Voter</option>
                                <option value="senior_citizen" {{ old('resident_type') == 'senior_citizen' ? 'selected' : '' }}>Senior Citizen</option>
                                <option value="pwd" {{ old('resident_type') == 'pwd' ? 'selected' : '' }}>PWD</option>
                                <option value="solo_parent" {{ old('resident_type') == 'solo_parent' ? 'selected' : '' }}>Solo Parent</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Street <span class="text-muted">(Optional)</span></label>
                            <select name="street_id" class="form-select" id="populationStreetFilter">
                                <option value="">All</option>
                                @foreach(($streetOptions ?? collect()) as $street)
                                    <option value="{{ $street->id }}" {{ (string) old('street_id') === (string) $street->id ? 'selected' : '' }}>
                                        {{ $street->street_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">House Number <span class="text-muted">(Optional)</span></label>
                            <select name="house_id" class="form-select" id="populationHouseFilter">
                                <option value="">All</option>
                                @foreach(($houseOptions ?? collect()) as $house)
                                    <option
                                        value="{{ $house->id }}"
                                        data-street-id="{{ $house->street_id }}"
                                        {{ (string) old('house_id') === (string) $house->id ? 'selected' : '' }}
                                    >
                                        {{ $house->house_no }} - {{ $house->street->street_name ?? 'No Street' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Parent Status <span class="text-muted">(Optional)</span></label>
                            <select name="parent" class="form-select">
                                <option value="">All</option>
                                <option value="yes" {{ old('parent') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('parent') == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Civil Status <span class="text-muted">(Optional)</span></label>
                            <select name="civil_status" class="form-select">
                                <option value="">All</option>
                                <option value="single" {{ old('civil_status') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('civil_status') == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="widowed" {{ old('civil_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="divorced" {{ old('civil_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                            </select>
                        </div>
                        <div class="col-12 border-top pt-3 mt-2">
                            <label class="form-label fw-semibold text-muted"><i class="fas fa-cake-candles me-1"></i>Birthday Range (Optional)</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Birthday From <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="birthday_from"
                                    class="form-control report-date-input"
                                    value="{{ old('birthday_from') }}"
                                    data-raw="{{ old('birthday_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <small class="text-muted d-block mt-1">Start of birthday period (e.g., Jan 1)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Birthday To <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="birthday_to"
                                    class="form-control report-date-input"
                                    value="{{ old('birthday_to') }}"
                                    data-raw="{{ old('birthday_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <small class="text-muted d-block mt-1">End of birthday period (e.g., Dec 31)</small>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave birthday dates blank to include all birthdays/dates.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalBlotterReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.reports.blotter') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="blotter">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-scale-balanced me-2 text-danger"></i>Generate Blotter Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank. Leave date fields untouched to include all dates.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status <span class="text-muted">(Optional)</span></label>
                            <select name="blotter_status" class="form-select">
                                <option value="all" {{ old('blotter_status', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                <option value="pending" {{ old('blotter_status') === 'pending' ? 'selected' : '' }}>Pending (Filed to For Summons)</option>
                                <option value="ongoing" {{ old('blotter_status') === 'ongoing' ? 'selected' : '' }}>Ongoing (Barangay Protection Order)</option>
                                <option value="closed" {{ old('blotter_status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="filed" {{ old('blotter_status') === 'filed' ? 'selected' : '' }}>Filed</option>
                                <option value="first_hearing" {{ old('blotter_status') === 'first_hearing' ? 'selected' : '' }}>First Hearing</option>
                                <option value="second_hearing" {{ old('blotter_status') === 'second_hearing' ? 'selected' : '' }}>Second Hearing</option>
                                <option value="third_hearing" {{ old('blotter_status') === 'third_hearing' ? 'selected' : '' }}>Third Hearing</option>
                                <option value="for_summons" {{ old('blotter_status') === 'for_summons' ? 'selected' : '' }}>For Summons</option>
                                <option value="criminal_civil_case" {{ old('blotter_status') === 'criminal_civil_case' ? 'selected' : '' }}>Criminal Case/Civil Case</option>
                                <option value="referred_to_pnp" {{ old('blotter_status') === 'referred_to_pnp' ? 'selected' : '' }}>Referred to PNP</option>
                                <option value="certificate_to_file_action" {{ old('blotter_status') === 'certificate_to_file_action' ? 'selected' : '' }}>Certificate to File Action</option>
                                <option value="barangay_protection_order" {{ old('blotter_status') === 'barangay_protection_order' ? 'selected' : '' }}>Barangay Protection Order</option>
                                <option value="resolved" {{ old('blotter_status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Blotter Type <span class="text-muted">(Optional)</span></label>
                            <select name="blotter_type" class="form-select">
                                <option value="all" {{ old('blotter_type', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                <option value="regular" {{ old('blotter_type') === 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="vawc" {{ old('blotter_type') === 'vawc' ? 'selected' : '' }}>VAWC</option>
                                <option value="katarungang_pambarangay" {{ old('blotter_type') === 'katarungang_pambarangay' ? 'selected' : '' }}>Katarungang Pambarangay</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Complainant Name <span class="text-muted">(Optional)</span></label>
                            <input
                                type="text"
                                name="complainant_name"
                                class="form-control"
                                value="{{ old('complainant_name') }}"
                                placeholder="e.g. Juan Dela Cruz"
                            >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_from"
                                    class="form-control report-date-input"
                                    value="{{ old('date_from') }}"
                                    data-raw="{{ old('date_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_to"
                                    class="form-control report-date-input"
                                    value="{{ old('date_to') }}"
                                    data-raw="{{ old('date_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Leave dates blank to include all blotters. Use status and complainant filters as needed.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger text-white px-4">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalCertificateReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.reports.certificate') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="certificate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-certificate me-2 text-success"></i>Generate Certificate Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 py-2">
                        <span class="optional-hint">
                            Fields marked as <strong>(Optional)</strong> can be left blank.
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Certificate Status <span class="text-danger">*</span></label>
                            <select type="text" name="certificate_status" class="form-control" required>
                                <option value="">-- Select Status --</option>
                                <option value="All" selected>All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Declined">Declined</option>
                                <option value="Approved">Approved</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Certificate Type <span class="text-danger">*</span></label>
                            <select type="text" name="certificate_type" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                <option value="All" selected>All Types</option>
                                <option value="Bonafide">Bonafide</option>
                                <option value="Indigency">Indigency</option>
                                <option value="Solo-Parent">Solo-Parent</option>
                                <option value="Senior">Senior</option>
                                
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_from"
                                    class="form-control report-date-input"
                                    value="{{ old('date_from') }}"
                                    data-raw="{{ old('date_from') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-muted">(Optional)</span></label>
                            <div class="input-group w-100">
                                <input
                                    type="date"
                                    name="date_to"
                                    class="form-control report-date-input"
                                    value="{{ old('date_to') }}"
                                    data-raw="{{ old('date_to') }}"
                                >
                                <span class="input-group-text report-date-open">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Only certificate requests with selected status are included.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalHouseholdReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.reports.household') }}" method="POST">
            @csrf
            <input type="hidden" name="report_form_type" value="household">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-house-user me-2" style="color:#7c3aed;"></i>Generate Household Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Report View <span class="text-muted">(Optional)</span></label>
                            <select name="report_scope" class="form-select" id="householdReportScope">
                                <option value="summary" {{ old('report_scope', 'family_members') === 'summary' ? 'selected' : '' }}>Household Summary</option>
                                <option value="family_members" {{ old('report_scope', 'family_members') === 'family_members' ? 'selected' : '' }}>Tagged Family Members (by Head)</option>
                            </select>
                            <small class="text-muted d-block mt-1">Use this to generate a particular family under one house head.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Street <span class="text-muted">(Optional)</span></label>
                            <select name="street_id" class="form-select" id="householdStreetFilter">
                                <option value="">All</option>
                                @foreach(($streetOptions ?? collect()) as $street)
                                    <option value="{{ $street->id }}" {{ (string) old('street_id') === (string) $street->id ? 'selected' : '' }}>
                                        {{ $street->street_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">House <span class="text-muted">(Optional)</span></label>
                            <select name="house_id" class="form-select" id="householdHouseFilter">
                                <option value="">All</option>
                                @foreach(($houseOptions ?? collect()) as $house)
                                    <option
                                        value="{{ $house->id }}"
                                        data-street-id="{{ $house->street_id }}"
                                        {{ (string) old('house_id') === (string) $house->id ? 'selected' : '' }}
                                    >
                                        {{ $house->house_no }} - {{ $house->street->street_name ?? 'No Street' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 household-summary-only">
                            <label class="form-label fw-semibold">House Head Presence <span class="text-muted">(Optional)</span></label>
                            <select name="has_head" class="form-select">
                                <option value="">All</option>
                                <option value="yes" {{ old('has_head') === 'yes' ? 'selected' : '' }}>With House Head</option>
                                <option value="no" {{ old('has_head') === 'no' ? 'selected' : '' }}>Without House Head</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Specific House Head <span class="text-muted">(Optional)</span></label>
                            <select name="household_head_id" class="form-select">
                                <option value="">All</option>
                                @foreach(($houseHeadOptions ?? collect()) as $head)
                                    <option value="{{ $head->id }}" {{ (string) old('household_head_id') === (string) $head->id ? 'selected' : '' }}>
                                        {{ ucwords(strtolower(trim(($head->firstName ?? '') . ' ' . ($head->middleName ?? '') . ' ' . ($head->lastName ?? '')))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 household-summary-only">
                            <label class="form-label fw-semibold">Minimum Family Members <span class="text-muted">(Optional)</span></label>
                            <input type="number" min="0" name="min_members" class="form-control" value="{{ old('min_members') }}" placeholder="e.g. 1">
                        </div>
                        <div class="col-md-6 household-summary-only">
                            <label class="form-label fw-semibold">Maximum Family Members <span class="text-muted">(Optional)</span></label>
                            <input type="number" min="0" name="max_members" class="form-control" value="{{ old('max_members') }}" placeholder="e.g. 10">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white" style="background:#7c3aed;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if ($errors->any() && old('report_form_type'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalMap = {
                population: 'modalPopulationReport',
                blotter: 'modalBlotterReport',
                certificate: 'modalCertificateReport',
                complaint: 'modalComplaintReport',
                activity: 'modalActivityReport',
                officials: 'modalOfficialsReport',
                archives: 'modalArchivesReport',
                announcements: 'modalAnnouncementsReport',
                feedback: 'modalFeedbackReport',
                household: 'modalHouseholdReport'
            };
            const targetModalId = modalMap['{{ old('report_form_type') }}'];
            if (!targetModalId) return;
            const modalElement = document.getElementById(targetModalId);
            if (!modalElement || typeof bootstrap === 'undefined') return;
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function normalizeToYmd(raw) {
            if (!raw) return '';
            const d = new Date(raw);
            if (isNaN(d)) return '';
            return d.getFullYear() + '-' +
                String(d.getMonth() + 1).padStart(2, '0') + '-' +
                String(d.getDate()).padStart(2, '0');
        }

        function openPicker(inputEl) {
            if (!inputEl) return;
            if (inputEl.showPicker) inputEl.showPicker();
            else inputEl.focus();
        }

        document.querySelectorAll('.report-date-input').forEach(function (input) {
            const raw = input.getAttribute('data-raw') || input.value;
            const formatted = normalizeToYmd(raw);
            if (formatted) input.value = formatted;
        });

        document.querySelectorAll('.report-date-open').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const wrapper = trigger.closest('.input-group');
                const input = wrapper ? wrapper.querySelector('.report-date-input') : null;
                openPicker(input);
            });
        });

        function buildDateRangeToggle(config) {
            const modal = document.getElementById(config.modalId);
            if (!modal) return;

            const row = modal.querySelector('.modal-body .row.g-3');
            if (!row) return;

            const startInput = row.querySelector(`input[name="${config.startField}"]`);
            const endInput = row.querySelector(`input[name="${config.endField}"]`);
            if (!startInput || !endInput) return;

            let startBlock = startInput.closest('[class*="col-"]');
            const endBlock = endInput.closest('[class*="col-"]');
            if (!startBlock || !endBlock) return;

            if (config.includePreviousHeader) {
                const previousBlock = startBlock.previousElementSibling;
                if (previousBlock && previousBlock.matches('[class*="col-"]')) {
                    startBlock = previousBlock;
                }
            }

            const toggleCol = document.createElement('div');
            toggleCol.className = 'col-12';

            const collapseId = `${config.modalId}DateFilters`;
            const toggleButton = document.createElement('button');
            toggleButton.type = 'button';
            toggleButton.className = 'btn report-filter-toggle collapsed';
            toggleButton.setAttribute('data-bs-toggle', 'collapse');
            toggleButton.setAttribute('data-bs-target', `#${collapseId}`);
            toggleButton.setAttribute('aria-expanded', 'false');
            toggleButton.setAttribute('aria-controls', collapseId);
            toggleButton.innerHTML = `<span><i class="fas fa-calendar-range me-2 text-primary"></i>${config.label}</span><i class="fas fa-chevron-down report-filter-chevron"></i>`;

            const collapseCol = document.createElement('div');
            collapseCol.className = 'col-12';

            const collapseEl = document.createElement('div');
            collapseEl.className = 'collapse report-filter-collapse';
            collapseEl.id = collapseId;

            const panel = document.createElement('div');
            panel.className = 'report-filter-panel';

            const innerRow = document.createElement('div');
            innerRow.className = 'row g-3';

            panel.appendChild(innerRow);
            collapseEl.appendChild(panel);
            toggleCol.appendChild(toggleButton);
            collapseCol.appendChild(collapseEl);

            row.insertBefore(toggleCol, startBlock);
            row.insertBefore(collapseCol, startBlock);

            let current = startBlock;
            while (current) {
                const next = current.nextElementSibling;
                innerRow.appendChild(current);
                if (current === endBlock) {
                    break;
                }
                current = next;
            }

            if (config.includeNextInfo) {
                const nextBlock = collapseCol.nextElementSibling;
                if (nextBlock && nextBlock.matches('[class*="col-"]') && nextBlock.querySelector('small.text-muted') && !nextBlock.querySelector('input, select, textarea')) {
                    innerRow.appendChild(nextBlock);
                }
            }

            const hasValue = Array.from(collapseEl.querySelectorAll('.report-date-input')).some(function (input) {
                return Boolean((input.value || input.getAttribute('data-raw') || '').trim());
            });

            if (hasValue && typeof bootstrap !== 'undefined') {
                bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false }).show();
            }
        }

        [
            {
                modalId: 'modalOfficialsReport',
                startField: 'term_start_from',
                endField: 'term_end_to',
                label: 'Term Date Range Filters'
            },
            {
                modalId: 'modalArchivesReport',
                startField: 'date_from',
                endField: 'date_to',
                label: 'Date Range Filters',
                includeNextInfo: true
            },
            {
                modalId: 'modalAnnouncementsReport',
                startField: 'event_start_from',
                endField: 'published_to',
                label: 'Date Range Filters',
                includePreviousHeader: true,
                includeNextInfo: true
            },
            {
                modalId: 'modalFeedbackReport',
                startField: 'submitted_from',
                endField: 'submitted_to',
                label: 'Date Range Filters',
                includeNextInfo: true
            },
            {
                modalId: 'modalActivityReport',
                startField: 'date_from',
                endField: 'date_to',
                label: 'Date Range Filters',
                includeNextInfo: true
            },
            {
                modalId: 'modalComplaintReport',
                startField: 'date_from',
                endField: 'date_to',
                label: 'Date Range Filters'
            },
            {
                modalId: 'modalPopulationReport',
                startField: 'birthday_from',
                endField: 'birthday_to',
                label: 'Birthday Range Filters',
                includePreviousHeader: true,
                includeNextInfo: true
            },
            {
                modalId: 'modalBlotterReport',
                startField: 'date_from',
                endField: 'date_to',
                label: 'Date Range Filters',
                includeNextInfo: true
            },
            {
                modalId: 'modalCertificateReport',
                startField: 'date_from',
                endField: 'date_to',
                label: 'Date Range Filters',
                includeNextInfo: true
            }
        ].forEach(buildDateRangeToggle);

        const streetSelect = document.getElementById('householdStreetFilter');
        const houseSelect = document.getElementById('householdHouseFilter');
        const populationStreetSelect = document.getElementById('populationStreetFilter');
        const populationHouseSelect = document.getElementById('populationHouseFilter');
        const householdScopeSelect = document.getElementById('householdReportScope');
        const householdHeadSelect = document.querySelector("select[name='household_head_id']");
        const summaryOnlyBlocks = Array.from(document.querySelectorAll('.household-summary-only'));

        function toggleHouseholdMode() {
            if (!householdScopeSelect) return;
            const mode = householdScopeSelect.value || 'summary';
            const isFamilyMembersMode = mode === 'family_members';

            if (householdHeadSelect) {
                householdHeadSelect.required = false;
            }

            summaryOnlyBlocks.forEach(function (el) {
                el.style.display = isFamilyMembersMode ? 'none' : '';
                el.querySelectorAll('input, select').forEach(function (field) {
                    field.disabled = isFamilyMembersMode;
                });
            });
        }

        if (householdScopeSelect) {
            householdScopeSelect.addEventListener('change', toggleHouseholdMode);
            toggleHouseholdMode();
        }

        function bindStreetHouseFilter(streetEl, houseEl) {
            if (!streetEl || !houseEl) return;
            const houseOptions = Array.from(houseEl.querySelectorAll('option[data-street-id]'));

            function filterHouseOptions() {
                const streetId = streetEl.value;
                const currentValue = houseEl.value;
                let currentStillVisible = false;

                houseOptions.forEach(function (option) {
                    const matches = !streetId || option.getAttribute('data-street-id') === streetId;
                    option.hidden = !matches;
                    if (matches && option.value === currentValue) {
                        currentStillVisible = true;
                    }
                });

                if (streetId && !currentStillVisible) {
                    houseEl.value = '';
                }
            }

            streetEl.addEventListener('change', filterHouseOptions);
            filterHouseOptions();
        }

        bindStreetHouseFilter(streetSelect, houseSelect);
        bindStreetHouseFilter(populationStreetSelect, populationHouseSelect);

        function getDefaultReportTitle(label) {
            const now = new Date();
            const formattedDate = now.toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
            return label + ' Report - ' + formattedDate;
        }

        function autoFillReportTitle(modalId, label) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            function applyDefaultIfEmpty() {
                const titleInput = modal.querySelector("input[name='report_name']");
                if (!titleInput) return;
                if (!titleInput.value || !titleInput.value.trim()) {
                    titleInput.value = getDefaultReportTitle(label);
                }
            }

            modal.addEventListener('show.bs.modal', applyDefaultIfEmpty);
            applyDefaultIfEmpty();
        }

        autoFillReportTitle('modalPopulationReport', 'Population');
        autoFillReportTitle('modalBlotterReport', 'Blotter');
        autoFillReportTitle('modalCertificateReport', 'Certificate');
        autoFillReportTitle('modalComplaintReport', 'Complaint');
        autoFillReportTitle('modalActivityReport', 'Activity Logs');
        autoFillReportTitle('modalOfficialsReport', 'Officials List Reports');
        autoFillReportTitle('modalArchivesReport', 'Archives');
        autoFillReportTitle('modalAnnouncementsReport', 'Announcements');
        autoFillReportTitle('modalFeedbackReport', 'Feedback');
        autoFillReportTitle('modalHouseholdReport', 'Household');
    });
</script>
