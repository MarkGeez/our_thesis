<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
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

        /* Glass Page Header - Compact Version */
        .page-header-card {
            position: relative;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            box-shadow: 
                0 4px 6px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
        }

        /* Gradient background overlay */
        .page-header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(37, 99, 235, 0.3) 0%, 
                rgba(30, 64, 175, 0.2) 50%,
                rgba(37, 99, 235, 0.3) 100%);
            z-index: -1;
            border-radius: 16px;
        }

        .page-header-card h2 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .page-header-icon {
            width: 48px;
            height: 48px;
            background: rgba(37, 99, 235, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 2px solid rgba(37, 99, 235, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-color);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .page-header-icon:hover {
            transform: translateY(-3px) scale(1.05);
        }

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 500;
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
            padding: 1rem;
            font-weight: 500;
        }

        .alert i {
            font-size: 1.25rem;
        }

        /* Tab Navigation */
        .nav-tabs {
            border: none;
            background: white;
            padding: 0.75rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            gap: 0.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 8px;
            color: var(--text-secondary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background-color: #f1f5f9;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Tab Content */
        .tab-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
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

        /* Enhanced table cell styling */
        .table tbody td code {
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid #bfdbfe;
        }

        .table tbody td .btn-link {
            color: var(--text-primary);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .table tbody td .btn-link:hover {
            color: var(--primary-color);
            text-decoration: underline !important;
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

        .badge.bg-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
            color: #1e40af !important;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
            color: #1e40af !important;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-btns .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .action-btns .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-sm {
            padding: 0.4rem 0.85rem !important;
            font-size: 0.8rem !important;
        }

        .btn-xs {
            padding: 0.25rem 0.65rem !important;
            font-size: 0.75rem !important;
        }

        /* Enhanced button colors */
        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #047857 100%);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #0284c7 100%);
            border: none;
        }

        /* History button styling */
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-outline-secondary {
            border: 2px solid #94a3b8;
            color: #64748b;
        }

        .btn-outline-secondary:hover {
            background: #64748b;
            color: white;
            border-color: #64748b;
        }

        .btn-outline-info {
            border: 2px solid var(--info-color);
            color: var(--info-color);
        }

        .btn-outline-info:hover {
            background: var(--info-color);
            color: white;
        }

        /* Modal Improvements */
        .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .modal-header .modal-title {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem 1.5rem;
            background-color: #f8fafc;
            border-top: 2px solid var(--border-color);
        }

        .modal-content .form-control,
        .modal-content .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            transition: all 0.2s ease;
        }

        .modal-content .form-control:focus,
        .modal-content .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Certificate Preview Modal */
        #certificatePreviewModal .modal-dialog {
            max-width: 900px;
        }

        #certificatePreviewModal iframe {
            width: 100%;
            height: 85vh;
            border: none;
            border-radius: 8px;
        }

        /* Profile Image in Modal */
        #profileImageContainer {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #profileImageContainer img {
            border: 4px solid white;
        }

        /* Loading Spinner */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .alert-light {
            background: #f8fafc;
            border: 2px solid var(--border-color);
            border-radius: 8px;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 2px solid #fbbf24;
        }

        /* Form Details Display */
        #detailsFormData {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
        }

        #detailsFormData .data-list .mb-2 {
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        #detailsFormData .data-list .mb-2:last-child {
            border-bottom: none;
        }

        /* Empty State - override partial */
        .alert.alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            color: #1e40af;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
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

            .action-btns {
                flex-direction: column;
            }

            .action-btns .btn {
                width: 100%;
                justify-content: center;
            }

            .nav-tabs {
                flex-direction: column;
            }

            .nav-tabs .nav-link {
                width: 100%;
            }
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

        /* Pagination Styles */
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

        /* Results Info */
        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border-color);
            gap: 12px;
            flex-wrap: wrap;
        }

        .results-count {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .results-count .count-number {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.05rem;
        }

        .table-filter-bar {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
            margin: 0 1rem 1rem 1rem;
        }

        .table-filter-bar .form-control,
        .table-filter-bar .form-select {
            max-width: 230px;
        }

        @media (max-width: 576px) {
            .pagination-container {
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])
    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])
        <main class="main users chart-page" id="skip-target">
            <div class="container mt-4">
                <!-- Enhanced Glass Page Header - Compact Version -->
                

                <div class="welcome-card">
                                <h3> Certificate Requests Management</h3>
                                
                            </div>

                <!-- Success/Error Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-3"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Enhanced Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="certTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ ($activeTab ?? 'all') === 'all' ? 'active' : '' }}" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>All Requests
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ ($activeTab ?? 'all') === 'pending' ? 'active' : '' }}" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                            <i class="fas fa-clock me-2"></i>Pending
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ ($activeTab ?? 'all') === 'approved' ? 'active' : '' }}" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                            <i class="fas fa-check-circle me-2"></i>Approved
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ ($activeTab ?? 'all') === 'declined' ? 'active' : '' }}" id="declined-tab" data-bs-toggle="tab" data-bs-target="#declined" type="button" role="tab">
                            <i class="fas fa-times-circle me-2"></i>Declined
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="certTabContent">
                    <div class="tab-pane fade {{ ($activeTab ?? 'all') === 'all' ? 'show active' : '' }}" id="all" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $requests, 'requestStats' => $requestStats ?? collect(), 'tab' => 'all', 'certificateTypeOptions' => $certificateTypeOptions ?? collect()])
                    </div>
                    <div class="tab-pane fade {{ ($activeTab ?? 'all') === 'pending' ? 'show active' : '' }}" id="pending" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $pendingRequests, 'requestStats' => $requestStats ?? collect(), 'tab' => 'pending', 'certificateTypeOptions' => $certificateTypeOptions ?? collect()])
                    </div>
                    <div class="tab-pane fade {{ ($activeTab ?? 'all') === 'approved' ? 'show active' : '' }}" id="approved" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $approvedRequests, 'requestStats' => $requestStats ?? collect(), 'tab' => 'approved', 'certificateTypeOptions' => $certificateTypeOptions ?? collect()])
                    </div>
                    <div class="tab-pane fade {{ ($activeTab ?? 'all') === 'declined' ? 'show active' : '' }}" id="declined" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $declinedRequests, 'requestStats' => $requestStats ?? collect(), 'tab' => 'declined', 'certificateTypeOptions' => $certificateTypeOptions ?? collect()])
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- All modals remain the same as before --}}
{{-- I'll include them for completeness but they're unchanged --}}

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Reject Certificate Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                        <div>Are you sure you want to reject this certificate request? This action cannot be undone.</div>
                    </div>
                    <label class="form-label fw-semibold">Reason for Rejection (Optional)</label>
                    <textarea class="form-control" name="decline_reason" rows="4" placeholder="Provide a reason for declining this request..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times-circle me-1"></i>Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Certificate Preview Modal --}}
<div class="modal fade" id="certificatePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Certificate Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="certificatePreviewFrame" title="Certificate Preview"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="certificatePrintBtn" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print Certificate
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Decline Reason Modal --}}
<div class="modal fade" id="declineReasonModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Decline Reason
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border">
                    <p id="declineReasonText" class="mb-0"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Requester Profile Modal --}}
<div class="modal fade" id="requesterProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user me-2"></i>Requester Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="profileLoading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading profile...</p>
                </div>
                <div id="profileContent" style="display:none;">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center mb-3">
                                <div id="profileImageContainer" class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user" style="font-size: 60px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Full Name</small>
                            <p class="fw-semibold mb-0" id="profileFullName" style="text-transform: capitalize;">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Email</small>
                            <p class="fw-semibold mb-0" id="profileEmail">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Contact No.</small>
                            <p class="fw-semibold mb-0" id="profileContact">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Birthday</small>
                            <p class="fw-semibold mb-0" id="profileBirthday">-</p>
                        </div>
                        <div class="col-md-4" id="profileAgeRow" style="display:none;">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Age</small>
                            <p class="fw-semibold mb-0" id="profileAge">-</p>
                        </div>
                        <div class="col-md-4" id="profileSexRow" style="display:none;">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Sex</small>
                            <p class="fw-semibold mb-0 text-capitalize" id="profileSex">-</p>
                        </div>
                        <div class="col-md-4" id="profileRoleRow" style="display:none;">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Role</small>
                            <p class="fw-semibold mb-0 text-capitalize" id="profileRole">-</p>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row mb-4" id="profileHistorySection" style="display:none;">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-history me-2"></i>Request History
                            </h6>
                        </div>
                    </div>
                    <div id="profileHistoryLoading" style="display:none;" class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted small">Loading history...</p>
                    </div>
                    <div id="profileHistoryContent" style="display:none;">
                        <div class="alert alert-info mb-3">
                            <div class="row text-center g-2">
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">Total</strong>
                                    <span class="fs-6 fw-bold" id="profileTotalRequests">0</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">Approved</strong>
                                    <span class="fs-6 fw-bold text-success" id="profileApprovedCount">0</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">Declined</strong>
                                    <span class="fs-6 fw-bold text-danger" id="profileDeclinedCount">0</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">Pending</strong>
                                    <span class="fs-6 fw-bold text-warning" id="profilePendingCount">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Certificate Type</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="profileHistoryTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Request Details Modal --}}
<div class="modal fade" id="requestDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Certificate Request Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailsLoading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading request details...</p>
                </div>
                <div id="detailsContent" style="display:none;">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Request Information
                            </h6>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Request ID</small>
                            <p class="fw-bold mb-0" id="detailsId">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Certificate Type</small>
                            <p class="fw-bold text-capitalize mb-0" id="detailsType">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Status</small>
                            <div id="detailsStatus">-</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Submitted Date</small>
                            <p class="fw-bold mb-0" id="detailsDate">-</p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Purpose Explanation</small>
                            <div class="alert alert-light border" id="detailsPurpose">-</div>
                        </div>
                    </div>
                    <div class="row" id="additionalDetailsRow" style="display:none;">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-clipboard-list me-2"></i>Form Details
                            </h6>
                            <div id="detailsFormData">
                                <div class="data-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// All JavaScript remains the same as before
document.querySelectorAll('[data-reject-id]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.getAttribute('data-reject-id');
        var form = document.getElementById('rejectForm');
        form.action = '{{ route("admin.certificate.reject", ["id" => 0]) }}'.replace(/\/0$/, '/' + id);
    });
});

document.querySelectorAll('[data-preview-id]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.getAttribute('data-preview-id');
        var url = '{{ route("admin.certificate.preview", ["id" => 0]) }}'.replace(/\/0$/, '/' + id);
        document.getElementById('certificatePreviewFrame').src = url;
        document.getElementById('certificatePrintBtn').setAttribute('data-current-id', id);
        new bootstrap.Modal(document.getElementById('certificatePreviewModal')).show();
    });
});

document.getElementById('certificatePrintBtn').addEventListener('click', function() {
    var frame = document.getElementById('certificatePreviewFrame');
    try {
        var doc = frame.contentDocument || frame.contentWindow.document;
        var form = doc.getElementById('certEditForm');
        if (form) {
            form.submit();
        } else {
            var id = this.getAttribute('data-current-id');
            if (id) window.open('{{ route("admin.certificate.generate", ["id" => 0]) }}'.replace(/\/0$/, '/' + id), '_blank');
        }
    } catch (e) {
        var id = this.getAttribute('data-current-id');
        if (id) window.open('{{ route("admin.certificate.generate", ["id" => 0]) }}'.replace(/\/0$/, '/' + id), '_blank');
    }
});

document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-bs-target="#declineReasonModal"][data-reason]');
    if (btn) {
        var reason = btn.getAttribute('data-reason') || 'No reason provided.';
        document.getElementById('declineReasonText').textContent = reason;
    }
});

document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-requester-user-id]');
    if (btn) {
        var userId = btn.getAttribute('data-requester-user-id');
        var residentId = btn.getAttribute('data-requester-resident-id');
        
        document.getElementById('profileLoading').style.display = 'block';
        document.getElementById('profileContent').style.display = 'none';
        
        document.getElementById('profileAgeRow').style.display = 'none';
        document.getElementById('profileSexRow').style.display = 'none';
        document.getElementById('profileRoleRow').style.display = 'none';
        document.getElementById('profileHistorySection').style.display = 'none';
        document.getElementById('profileHistoryLoading').style.display = 'none';
        document.getElementById('profileHistoryContent').style.display = 'none';
        
        var modal = new bootstrap.Modal(document.getElementById('requesterProfileModal'));
        modal.show();
        
        var endpoint = residentId ? 
            '{{ route("admin.resident.info", ["id" => "__ID__"]) }}'.replace('__ID__', residentId) :
            '{{ route("admin.user.info", ["id" => "__ID__"]) }}'.replace('__ID__', userId);
        
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('profileLoading').innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
                    return;
                }
                
                document.getElementById('profileFullName').textContent = data.fullName;
                document.getElementById('profileEmail').textContent = data.email || '-';
                document.getElementById('profileContact').textContent = data.contact || '-';
                document.getElementById('profileBirthday').textContent = data.birthday || '-';
                
                var imgContainer = document.getElementById('profileImageContainer');
                if (data.profileImage) {
                    imgContainer.innerHTML = '<img src="' + data.profileImage + '" alt="Profile" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">';
                }
                
                if (data.age) {
                    document.getElementById('profileAge').textContent = data.age;
                    document.getElementById('profileAgeRow').style.display = 'block';
                }
                
                if (data.sex) {
                    document.getElementById('profileSex').textContent = data.sex;
                    document.getElementById('profileSexRow').style.display = 'block';
                }
                
                if (data.role) {
                    document.getElementById('profileRole').textContent = data.role;
                    document.getElementById('profileRoleRow').style.display = 'block';
                }
                
                document.getElementById('profileLoading').style.display = 'none';
                document.getElementById('profileContent').style.display = 'block';
                
                // Fetch and display history
                document.getElementById('profileHistorySection').style.display = 'block';
                document.getElementById('profileHistoryLoading').style.display = 'block';
                
                fetch('{{ route("admin.certificate.history", ["userId" => "__USERID__"]) }}'.replace('__USERID__', userId))
                    .then(response => response.json())
                    .then(historyData => {
                        document.getElementById('profileTotalRequests').textContent = historyData.total;
                        document.getElementById('profileApprovedCount').textContent = historyData.approved;
                        document.getElementById('profileDeclinedCount').textContent = historyData.declined;
                        document.getElementById('profilePendingCount').textContent = historyData.pending;
                        
                        var tbody = document.getElementById('profileHistoryTableBody');
                        tbody.innerHTML = '';
                        
                        if (historyData.requests.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted small">No request history found</td></tr>';
                        } else {
                            historyData.requests.forEach(function(req) {
                                var statusBadge = '';
                                switch(req.status) {
                                    case 'pending':
                                        statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                                        break;
                                    case 'approved':
                                        statusBadge = '<span class="badge bg-success">Approved</span>';
                                        break;
                                    case 'picked_up':
                                        statusBadge = '<span class="badge bg-secondary">Picked up</span>';
                                        break;
                                    case 'declined':
                                        statusBadge = '<span class="badge bg-danger">Declined</span>';
                                        break;
                                }
                                
                                var row = '<tr>' +
                                    '<td class="small">' + req.created_at + '</td>' +
                                    '<td class="small"><span class="text-capitalize">' + req.certificate_type + '</span></td>' +
                                    '<td class="small">' + (req.purpose || '-') + '</td>' +
                                    '<td>' + statusBadge + '</td>' +
                                    '</tr>';
                                tbody.innerHTML += row;
                            });
                        }
                        
                        document.getElementById('profileHistoryLoading').style.display = 'none';
                        document.getElementById('profileHistoryContent').style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('profileHistoryLoading').innerHTML = '<div class="alert alert-danger alert-sm mb-0">Failed to load history</div>';
                    });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('profileLoading').innerHTML = '<div class="alert alert-danger">Failed to load profile information</div>';
            });
    }
});

document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-view-request-id]');
    if (btn) {
        var requestId = btn.getAttribute('data-view-request-id');
        
        document.getElementById('detailsLoading').style.display = 'block';
        document.getElementById('detailsContent').style.display = 'none';
        
        var modal = new bootstrap.Modal(document.getElementById('requestDetailsModal'));
        modal.show();
        
        fetch('{{ url("/admin/certificate-request-details") }}/' + requestId)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('detailsLoading').innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
                    return;
                }
                
                document.getElementById('detailsId').textContent = '#' + data.id;
                document.getElementById('detailsType').textContent = data.certificate_type;
                document.getElementById('detailsPurpose').textContent = data.purpose || 'No explanation provided';
                document.getElementById('detailsDate').textContent = data.created_at;
                
                var statusBadge = '';
                switch(data.status) {
                    case 'pending':
                        statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                        break;
                    case 'approved':
                        statusBadge = '<span class="badge bg-success">Approved</span>';
                        break;
                    case 'picked_up':
                        statusBadge = '<span class="badge bg-secondary">Picked up</span>';
                        break;
                    case 'declined':
                        statusBadge = '<span class="badge bg-danger">Declined</span>';
                        break;
                    default:
                        statusBadge = '<span class="badge bg-secondary">' + data.status + '</span>';
                }
                document.getElementById('detailsStatus').innerHTML = statusBadge;
                
                if (data.request_data && Object.keys(data.request_data).length > 0) {
                    document.getElementById('additionalDetailsRow').style.display = 'block';
                    var detailsList = document.querySelector('#detailsFormData .data-list');
                    detailsList.innerHTML = '';
                    for (var key in data.request_data) {
                        var value = data.request_data[key];
                        if (value === null || value === undefined) value = '-';
                        var label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        var item = document.createElement('div');
                        item.className = 'mb-2 pb-2 border-bottom';
                        item.innerHTML = `
                            <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">${label}</small>
                            <span class="fw-medium">${typeof value === 'object' ? JSON.stringify(value) : value}</span>
                        `;
                        detailsList.appendChild(item);
                    }
                } else {
                    document.getElementById('additionalDetailsRow').style.display = 'none';
                }
                
                document.getElementById('detailsLoading').style.display = 'none';
                document.getElementById('detailsContent').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('detailsLoading').innerHTML = '<div class="alert alert-danger">Failed to load request details</div>';
            });
    }
});
</script>
