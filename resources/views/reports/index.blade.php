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
        <div class="col-md-4">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalPopulationReport">
                <div class="card-body py-4">
                    <i class="fas fa-people-group fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold mb-1">Population Report</h5>
                    <p class="text-muted small mb-0">Demographic and resident profile summaries</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalBlotterReport">
                <div class="card-body py-4">
                    <i class="fas fa-scale-balanced fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold mb-1">Blotter Report</h5>
                    <p class="text-muted small mb-0">Finished case records within selected dates</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center action-card" data-bs-toggle="modal" data-bs-target="#modalCertificateReport">
                <div class="card-body py-4">
                    <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold mb-1">Certificate Report</h5>
                    <p class="text-muted small mb-0">Released certificate request records</p>
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
                                    default => 'report-type-population',
                                };
                            @endphp
                            <tr>
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
        </div>
    @endif
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
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" value="{{ old('report_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Age Group</label>
                            <select name="age_group" class="form-select">
                                <option value="">All</option>
                                <option value="children" {{ old('age_group') == 'children' ? 'selected' : '' }}>Children (0-12)</option>
                                <option value="youth" {{ old('age_group') == 'youth' ? 'selected' : '' }}>Youth (13-17)</option>
                                <option value="adults" {{ old('age_group') == 'adults' ? 'selected' : '' }}>Adults (18-59)</option>
                                <option value="senior" {{ old('age_group') == 'senior' ? 'selected' : '' }}>Senior Citizens (60+)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">All</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Street</label>
                            <select name="street" class="form-select">
                                <option value="">All</option>
                                @foreach($streets as $streetName)
                                    <option value="{{ $streetName }}" {{ old('street') == $streetName ? 'selected' : '' }}>
                                        {{ $streetName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Parent Status</label>
                            <select name="parent" class="form-select">
                                <option value="">All</option>
                                <option value="yes" {{ old('parent') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('parent') == 'no' ? 'selected' : '' }}>No</option>
                                <option value="single" {{ old('parent') == 'single' ? 'selected' : '' }}>Single Parent</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Civil Status</label>
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
                            <label class="form-label fw-semibold">Birthday From</label>
                            <input type="date" name="birthday_from" class="form-control" value="{{ old('birthday_from') }}">
                            <small class="text-muted d-block mt-1">Start of birthday period (e.g., Jan 1)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Birthday To</label>
                            <input type="date" name="birthday_to" class="form-control" value="{{ old('birthday_to') }}">
                            <small class="text-muted d-block mt-1">End of birthday period (e.g., Dec 31)</small>
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
                    <h5 class="modal-title"><i class="fas fa-scale-balanced me-2 text-warning"></i>Generate Blotter Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_from" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_to" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Only blotter cases marked as finished are included.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white px-4">Generate Report</button>
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
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Report Title <span class="text-danger">*</span></label>
                            <input type="text" name="report_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_from" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">To Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_to" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Only certificate requests with picked up status are included.</small>
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

@if ($errors->any() && old('report_form_type'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalMap = {
                population: 'modalPopulationReport',
                blotter: 'modalBlotterReport',
                certificate: 'modalCertificateReport'
            };
            const targetModalId = modalMap['{{ old('report_form_type') }}'];
            if (!targetModalId) return;
            const modalElement = document.getElementById(targetModalId);
            if (!modalElement || typeof bootstrap === 'undefined') return;
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        });
    </script>
@endif
