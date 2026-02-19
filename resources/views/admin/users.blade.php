<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
        --success-color: #059669;
        --warning-color: #f59e0b;
        --danger-color: #dc2626;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--light-bg);
        color: var(--text-primary);
    }

    /* Main Container Styling */
    .main.users.chart-page {
        background-color: var(--light-bg);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .main-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 0;
        margin: 0 1.5rem;
    }

    /* Header Section */
    .page-header {
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
            
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        margin-bottom: 0;
    }

    .page-header h2 {
        color: rgb(0, 0, 0);
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-header-icon {
        width: 48px;
        height: 48px;
         background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Search Section */
    .search-section {
        background: #f8fafc;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .search-section .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-section .input-group-text {
        background-color: white;
        border-right: none;
        color: var(--text-secondary);
    }

    .search-section .form-control {
        border-left: none;
        padding: 0.625rem 1rem;
    }

    .search-section .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }

    /* Table Styling */
    .table-container {
        padding: 2rem;
    }

    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .results-count {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .results-count .count-number {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: var(--text-primary);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .status-badge i {
        font-size: 0.9rem;
    }

    .status-approved {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-declined {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    /* Button Styling */
    .btn {
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-sm {
        padding: 0.4rem 0.85rem;
        font-size: 0.8rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    /* Image Previews */
    .image-preview {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .image-preview-profile {
        border-radius: 50%;
    }

    /* Status Radio Buttons */
    .status-radio-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .status-radio-option {
        position: relative;
    }

    .btn-check:checked + .status-radio-label {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .status-radio-label {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.25rem 0.75rem;
        border: 2px solid transparent;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .status-radio-label i {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }

    .status-radio-label span {
        font-weight: 600;
        font-size: 0.875rem;
    }

    .btn-check:checked + .btn-outline-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #047857 100%) !important;
        border-color: var(--success-color) !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-warning {
        background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%) !important;
        border-color: var(--warning-color) !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%) !important;
        border-color: var(--danger-color) !important;
        color: white !important;
    }

    /* Pagination Styling */
     .pagination-container {
        padding: 2rem;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-radius: 0 0 16px 16px;
        border-top: 2px solid var(--border-color);
    }

    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .pagination-info-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        border: 2px solid var(--border-color);
        font-weight: 600;
    }

    .pagination-info-text i {
        color: var(--primary-color);
    }

    .pagination-info-numbers {
        color: var(--primary-color);
        font-weight: 700;
    }

    /* Pagination Navigation */
    .pagination {
        margin: 0;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.625rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0;
        background: white;
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
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        transform: scale(1.1);
        position: relative;
        z-index: 1;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* First and Last Page Buttons */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-weight: 700;
        padding: 0.625rem 1.25rem;
    }

    .pagination .page-item:first-child .page-link {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .pagination .page-item:last-child .page-link {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .pagination .page-item:first-child .page-link:hover:not(.disabled),
    .pagination .page-item:last-child .page-link:hover:not(.disabled) {
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    }

    /* Quick Jump Section */
    .pagination-quick-jump {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        border: 2px solid var(--border-color);
    }

    .pagination-quick-jump label {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .pagination-quick-jump input {
        width: 80px;
        padding: 0.5rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        text-align: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .pagination-quick-jump input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .pagination-quick-jump button {
        padding: 0.5rem 1rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .pagination-quick-jump button:hover {
        background: var(--secondary-color);
        transform: scale(1.05);
    }

    /* Per Page Selector */
    .pagination-per-page {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        border: 2px solid var(--border-color);
    }

    .pagination-per-page label {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .pagination-per-page select {
        padding: 0.5rem 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .pagination-per-page select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .pagination-container {
            padding: 1.5rem 1rem;
        }

        .pagination-wrapper {
            gap: 1rem;
        }

        .pagination {
            gap: 0.35rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            min-width: 38px;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0.5rem 0.875rem;
        }

        .pagination-info {
            font-size: 0.8rem;
        }

        .pagination-quick-jump,
        .pagination-per-page {
            width: 100%;
            justify-content: center;
        }

        .pagination-quick-jump input {
            width: 70px;
        }
    }

    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            min-width: 34px;
        }

        .pagination-info-text {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }


    /* Modal Improvements */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .modal-header.bg-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
    }

    .modal-header.bg-info {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1.25rem 1.5rem;
        background-color: #f8fafc;
        border-top: 2px solid var(--border-color);
    }

    /* Alert Styling */
    .alert-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #3b82f6;
        color: #1e40af;
        border-radius: 12px;
        padding: 1.25rem;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            margin: 0 0.75rem;
            border-radius: 12px;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .table-container {
            padding: 1rem;
            overflow-x: auto;
        }

        .status-radio-group {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
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
            <div class="main-container">
                <!-- Enhanced Header -->
                <div class="page-header">
                    <h2>
                        <div class="page-header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        User Records Management
                    </h2>
                </div>

                <!-- Search Section -->
                <div class="search-section">
                    <form action="{{ route($user->role . '.users') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-8">
                                <label class="form-label">Search User</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Search by name or ID..." 
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route($user->role . '.users') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                @if($userList->count() > 0)
                    <!-- Table Container -->
                    <div class="table-container">
                        <div class="results-info">
                            <div class="results-count">
                                <i class="fas fa-user-check me-2 text-primary"></i>
                                Found <span class="count-number">{{ $userList->total() }}</span> user{{ $userList->total() !== 1 ? 's' : '' }}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Profile</th>
                                        <th>ID Proof</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userList as $list)
                                        <tr>
                                            <td><strong>#{{ $list->id }}</strong></td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ ucwords(strtolower($list->firstName)) }}
                                                    {{ ucwords(strtolower($list->lastName)) }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $list->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($list->role) }}</span>
                                            </td>
                                            <td>
                                                @if($list->profile_image)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('storage/' . $list->profile_image) }}" 
                                                             alt="Profile" 
                                                             class="image-preview image-preview-profile">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-secondary" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#profileImgModal{{ $list->id }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">No image</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($list->proofOfIdentity)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('storage/' . $list->proofOfIdentity) }}" 
                                                             alt="ID Proof" 
                                                             class="image-preview">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-secondary" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#proofModal{{ $list->id }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">No upload</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusConfig = [
                                                        'approved' => ['class' => 'status-approved', 'icon' => 'fa-check-circle', 'text' => 'Approved'],
                                                        'pending' => ['class' => 'status-pending', 'icon' => 'fa-clock', 'text' => 'Pending'],
                                                        'rejected' => ['class' => 'status-declined', 'icon' => 'fa-times-circle', 'text' => 'Declined'],
                                                        'declined' => ['class' => 'status-declined', 'icon' => 'fa-times-circle', 'text' => 'Declined']
                                                    ];
                                                    $status = $statusConfig[$list->status] ?? $statusConfig['pending'];
                                                @endphp
                                                <span class="status-badge {{ $status['class'] }}">
                                                    <i class="fas {{ $status['icon'] }}"></i>
                                                    {{ $status['text'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-success btn-action" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#statusModal{{ $list->id }}">
                                                        <i class="fas fa-sync-alt"></i> Status
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary btn-action" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#roleModal{{ $list->id }}">
                                                        <i class="fas fa-user-cog"></i> Role
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Profile Image Modal --}}
                                        @if($list->profile_image)
                                        <div class="modal fade" id="profileImgModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-user-circle me-2"></i>Profile Image
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center p-4">
                                                        <img src="{{ asset('storage/' . $list->profile_image) }}" 
                                                             alt="Profile" 
                                                             class="img-fluid rounded" 
                                                             style="max-height:70vh;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Proof Modal --}}
                                        @if($list->proofOfIdentity)
                                        <div class="modal fade" id="proofModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-id-card me-2"></i>Proof of Identity
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center p-4">
                                                        <img src="{{ asset('storage/' . $list->proofOfIdentity) }}" 
                                                             alt="ID Proof" 
                                                             class="img-fluid rounded" 
                                                             style="max-height:70vh;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Status Update Modal --}}
                                        <div class="modal fade" id="statusModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-user-check me-2"></i>Update User Status
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route($user->role . '.update.status', $list->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-muted small">USER</label>
                                                                <div class="fw-bold fs-5">
                                                                    {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label class="form-label fw-semibold mb-3">Select New Status</label>
                                                                <div class="status-radio-group">
                                                                    <div class="status-radio-option">
                                                                        <input type="radio" class="btn-check" name="status" 
                                                                               id="approve{{ $list->id }}" value="approved" 
                                                                               {{ $list->status == 'approved' ? 'checked' : '' }}>
                                                                        <label class="status-radio-label btn-outline-success" for="approve{{ $list->id }}">
                                                                            <i class="fas fa-check-circle"></i>
                                                                            <span>Approve</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="status-radio-option">
                                                                        <input type="radio" class="btn-check" name="status" 
                                                                               id="pending{{ $list->id }}" value="pending" 
                                                                               {{ $list->status == 'pending' ? 'checked' : '' }}>
                                                                        <label class="status-radio-label btn-outline-warning" for="pending{{ $list->id }}">
                                                                            <i class="fas fa-clock"></i>
                                                                            <span>Pending</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="status-radio-option">
                                                                        <input type="radio" class="btn-check" name="status" 
                                                                               id="decline{{ $list->id }}" value="declined" 
                                                                               {{ $list->status == 'declined' || $list->status == 'rejected' ? 'checked' : '' }}>
                                                                        <label class="status-radio-label btn-outline-danger" for="decline{{ $list->id }}">
                                                                            <i class="fas fa-times-circle"></i>
                                                                            <span>Decline</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-save me-1"></i>Update Status
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Role Update Modal --}}
                                        <div class="modal fade" id="roleModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-user-cog me-2"></i>Update User Role
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route($user->role . '.update.role', $list->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-muted small">USER</label>
                                                                <div class="fw-bold fs-5">
                                                                    {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label class="form-label fw-semibold">
                                                                    New Role 
                                                                    <span class="badge bg-secondary ms-2">Current: {{ ucfirst($list->role) }}</span>
                                                                </label>
                                                                <select name="role" class="form-select form-select-lg">
                                                                    <option value="admin" {{ $list->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                    <option value="subadmin" {{ $list->role === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                                                    <option value="resident" {{ $list->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                                                    <option value="non-resident" {{ $list->role === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-info text-white">
                                                                <i class="fas fa-save me-1"></i>Update Role
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Enhanced Pagination -->
@if($userList->count() > 0)
<div class="pagination-container">
    <div class="pagination-wrapper">
        <!-- Pagination Info -->
        <div class="pagination-info">
            <div class="pagination-info-text">
                <i class="fas fa-list-ol"></i>
                Showing 
                <span class="pagination-info-numbers">{{ $userList->firstItem() ?? 0 }}</span>
                to 
                <span class="pagination-info-numbers">{{ $userList->lastItem() ?? 0 }}</span>
                of 
                <span class="pagination-info-numbers">{{ $userList->total() }}</span>
                entries
            </div>
        </div>

        <!-- Main Pagination -->
        <nav aria-label="User list pagination">
            <ul class="pagination">
                {{-- First Page Link --}}
                @if ($userList->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-angle-double-left"></i>
                            <span class="d-none d-sm-inline ms-1">First</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->url(1) }}" rel="first">
                            <i class="fas fa-angle-double-left"></i>
                            <span class="d-none d-sm-inline ms-1">First</span>
                        </a>
                    </li>
                @endif

                {{-- Previous Page Link --}}
                @if ($userList->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $userList->currentPage();
                    $lastPage = $userList->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp

                {{-- Show first page if not in range --}}
                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->url(1) }}">1</a>
                    </li>
                    @if ($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                {{-- Page Numbers --}}
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $userList->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Show last page if not in range --}}
                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->url($lastPage) }}">{{ $lastPage }}</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($userList->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->nextPageUrl() }}" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif

                {{-- Last Page Link --}}
                @if ($userList->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $userList->url($userList->lastPage()) }}" rel="last">
                            <span class="d-none d-sm-inline me-1">Last</span>
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <span class="d-none d-sm-inline me-1">Last</span>
                            <i class="fas fa-angle-double-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Additional Controls -->
       
    </div>
</div>
@endif
                @endif
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>