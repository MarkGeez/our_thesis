<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --success-color: #059669;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
            --info-color: #0ea5e9;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --glass-white: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-primary);
        }

        /* Main Container */
        .main.users.chart-page {
            background-color: var(--light-bg);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .container {
            max-width: 1400px;
        }

        /* Glass Page Header */
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
            color: black;
            border-radius: 15px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .welcome-card h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
            font-family: "Oswald", sans-serif;
        }

        .welcome-card p {
            font-size: 1.1rem;
            opacity: 0.95;
        }
        /* Section Headers */
        .section-header {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
           
            margin: 1.5rem;
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

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 500;
            margin: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            color: #1e40af;
            border-radius: 12px;
            padding: 1.25rem;
            font-weight: 500;
            text-align: center;
        }

        .alert i {
            font-size: 1.25rem;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 1.5rem;
        }

        /* Table Styling */
        .table-responsive {
            padding: 2rem;
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
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .badge i {
            font-size: 0.85rem;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
            color: #92400e !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
            color: #065f46 !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
            color: #991b1b !important;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important;
            color: #475569 !important;
        }

        /* Remarks Styling */
        .remarks-success {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .remarks-muted {
            padding: 0.5rem 1rem;
            background: #f8fafc;
            border-left: 3px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Empty State */
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

        .empty-state h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        /* Certificate Type Badge */
        .cert-type-badge {
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
            color: var(--primary-color);
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid #bfdbfe;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header-card {
                padding: 1.5rem;
            }

            .page-header-card h2 {
                font-size: 1.5rem;
            }

            .table-responsive {
                padding: 1rem;
            }

            .section-header {
                padding: 0.75rem 1rem;
            }
        }
    </style>
</head>
<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])
    <div class="main-wrapper">
        @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])
        <main class="main users chart-page" id="skip-target">
            <div class="container mt-4">
                <!-- Glass Page Header -->
                <div class="welcome-card">
                                <h3>My Certificate Request</h3>
                                
                            </div>

                <!-- Success Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Alert -->
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

                <!-- Certificate Forms Section -->
                <div class="section-header">
                    <h5>
                        <i class="fas fa-file-circle-plus"></i>
                        Request New Certificate
                    </h5>
                </div>

               <div class="request-header" style="margin: 1.5rem;">@include('components.certificateForms', ['formRoute' => 'subadmin.certificate.request.store'])</div>
                <!-- Recent Requests Section -->
                <div class="section-header mt-5">
                    <h5>
                        <i class="fas fa-clock-rotate-left"></i>
                        My Recent Requests
                    </h5>
                </div>

                @if($requests->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>No Requests Yet</h5>
                        <p class="text-muted">You haven't submitted any certificate requests. Use the form above to request your first certificate.</p>
                    </div>
                @else
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Certificate Type</th>
                                        <th>Purpose</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Updated By</th>
                                        <th>Date Requested</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $req)
                                        <tr>
                                            <td>
                                                <span class="cert-type-badge">
                                                    {{ ucfirst(str_replace('_', ' ', $req->certificate_type)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    {{ Str::limit($req->purpose, 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $req->address ?? '—' }}</small>
                                            </td>
                                            <td>
                                                @switch($req->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock"></i>
                                                            Pending
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i>
                                                            Approved
                                                        </span>
                                                        @break
                                                    @case('picked_up')
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-box"></i>
                                                            Picked Up
                                                        </span>
                                                        @break
                                                    @case('declined')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i>
                                                            Declined
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($req->approver)
                                                    <div class="small">
                                                        <div class="fw-semibold text-dark">
                                                            {{ ucwords(strtolower($req->approver->firstName . ' ' . $req->approver->lastName)) }}
                                                        </div>
                                                        <div class="text-muted" style="font-size: 0.8rem;">
                                                            <i class="far fa-clock me-1"></i>
                                                            {{ $req->approved_at?->format('M d, Y h:i A') ?? '-' }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <div class="fw-semibold">{{ $req->created_at->format('M d, Y') }}</div>
                                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $req->created_at->format('h:i A') }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($req->status === 'approved')
                                                    <span class="remarks-success">
                                                        <i class="fas fa-check-circle"></i>
                                                        Ready for pickup at admin's house
                                                    </span>
                                                @elseif($req->status === 'picked_up')
                                                    <span class="remarks-success">
                                                        <i class="fas fa-check-double"></i>
                                                        Successfully picked up
                                                    </span>
                                                @elseif($req->status === 'declined' && $req->decline_reason)
                                                    <div class="remarks-muted">
                                                        {{ $req->decline_reason }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
</script>