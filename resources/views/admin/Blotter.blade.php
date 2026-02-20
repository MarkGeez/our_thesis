<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
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

        .main.users.chart-page {
            background-color: var(--light-bg);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .main-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 0;
            margin: 0 1.5rem;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.9);
        }

        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
            color: #000;
            padding: 26px 26px;
        }

        .page-header-inner {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 260px;
        }

        .page-header-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.45);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: var(--primary-color);
            flex: 0 0 auto;
        }

        .page-header-title {
            margin: 0;
            font-weight: 700;
            font-size: 1.6rem;
            color: #000;
            line-height: 1.1;
        }

        .page-header-subtitle {
            margin: 4px 0 0 0;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .page-header-actions {
            margin-left: auto;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            font-weight: 600;
            padding: 0.625rem 1.1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.22);
        }

        .btn-outline-primary {
            border-width: 2px;
        }

        .content-wrap {
            padding: 18px 22px 0 22px;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .table-container {
            padding: 18px 22px 22px 22px;
        }

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
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            margin-bottom: 1.5rem;
            margin-top: 0.5rem;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table-filter-bar .form-control,
        .table-filter-bar .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            height: 38px;
            max-width: 220px;
        }

        .table-filter-bar .form-control:focus,
        .table-filter-bar .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        table th,
        table td {
            vertical-align: middle;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.92rem;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .btn-sm {
            padding: 0.42rem 0.85rem;
            font-size: 0.82rem;
            border-radius: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            white-space: nowrap;
        }

        .btn-action i {
            font-size: 0.9rem;
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

        .modal-body section {
            margin-bottom: 24px;
        }

        .modal-body h6 {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #4b5563;
            margin-bottom: 12px;
            border-left: 4px solid var(--primary-color);
            padding-left: 10px;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
        }

        .info-label {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .info-value {
            color: #111827;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .info-box .row:last-child .info-value {
            margin-bottom: 0;
        }

        .modal-body .form-group {
            margin-bottom: 1.25rem;
        }

        .modal-body label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.12);
        }

        .edit-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1f2937;
            margin: 20px 0 12px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #f3f4f6;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff9db;
            color: #856404;
            border-color: #ffecb5;
        }
        .status-pending .status-dot { background-color: #fab005; }

        .status-ongoing {
            background-color: #e7f5ff;
            color: #1864ab;
            border-color: #d0ebff;
        }
        .status-ongoing .status-dot { background-color: #228be6; }

        .status-closed {
            background-color: #ebfbee;
            color: #2b8a3e;
            border-color: #d3f9d8;
        }
        .status-closed .status-dot { background-color: #40c057; }

        .status-default {
            background-color: #f8f9fa;
            color: #495057;
            border-color: #e9ecef;
        }
        .status-default .status-dot { background-color: #adb5bd; }

        .case-number {
            font-size: 0.85rem;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .table-wrapper {
            margin: 0;
        }

        /* Timeline styles for status history in modal */
        .timeline {
            position: relative;
            padding-left: 18px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #0d6efd, #79a7ff);
            opacity: 0.35;
        }

        .timeline-item {
            position: relative;
            padding: 0.75rem 0 0.75rem 14px;
            border-bottom: 1px dashed #e5e7eb;
        }

        .timeline-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2px;
            top: 1.1rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
            background: #0d6efd;
        }

        .timeline-body {
            background: #f9fbff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.65rem 0.85rem;
            box-shadow: 0 6px 12px rgba(15, 23, 42, 0.03);
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 0.35rem;
            flex-wrap: wrap;
        }

        .timeline-meta {
            font-size: 0.8rem;
            color: #6b7280;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .timeline-remarks {
            font-size: 0.9rem;
            color: #111827;
            margin-bottom: 0.4rem;
            white-space: pre-wrap;
        }

        .timeline-photo {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .timeline-photo img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .timeline-badge {
            padding: 0.2rem 0.75rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .timeline-badge.pending { background: #fff7e6; color: #b45309; border: 1px solid #fde68a; }
        .timeline-badge.ongoing { background: #e0f2fe; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .timeline-badge.closed { background: #ecfdf3; color: #15803d; border: 1px solid #bbf7d0; }
        .timeline-badge.scheduled { background: #eff6ff; color: #1e3a8a; border: 1px solid #dbeafe; }
        .timeline-badge.cold { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
        .timeline-badge.resolved { background: #eefcf6; color: #0f766e; border: 1px solid #c5f3e5; }

        .history-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            background: #fff;
        }

        @media (max-width: 576px) {
            .main-container {
                margin: 0 0.75rem;
            }

            .page-header {
                padding: 18px 18px;
            }

            .content-wrap,
            .table-container,
            .pagination-container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .page-header-actions {
                width: 100%;
                margin-left: 0;
            }

            .page-header-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .action-buttons {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>

    <div class="page-flex">
        @include('admin.admin-sidebar', ['admin' => auth()->user()])

        <div class="main-wrapper">
            @include('admin.admin-header', ['admin' => auth()->user()])

            <main class="main users chart-page" id="skip-target">
                <div class="main-container">
                    <div class="page-header">
                        <div class="page-header-inner">
                            <div class="page-header-left">
                                <div class="page-header-icon">
                                    <i class="fa-solid fa-file-circle-exclamation"></i>
                                </div>
                                <div>
                                    <h2 class="page-header-title">Manage Blotters</h2>
                                    <p class="page-header-subtitle">Dispute records</p>
                                </div>
                            </div>

                            <div class="page-header-actions">
                                <button class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#blotterModal">
                                    <i class="fa fa-plus"></i>
                                    <span>Submit Blotter</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-wrap">
                        @if (session('success'))
                            <div class="alert alert-success shadow-sm mb-3" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger shadow-sm mb-3" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    @if($blotters->isEmpty())
                        <div class="content-wrap pt-0">
                            <div class="alert alert-info mb-4">
                                No blotter records found.
                            </div>
                        </div>
                    @else
                        <div class="table-container pt-0">
                            <div class="results-info">
                                <div class="results-count">
                                    Records: <span class="count-number">{{ $blotters->total() }}</span>
                                </div>
                                <form method="GET" action="{{ route('admin.blotter.index') }}" class="table-filter-bar">
                                    <div class="flex-grow-1" style="min-width: 250px;">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted">
                                                <i class="fa fa-search"></i>
                                            </span>
                                            <input type="text" name="search"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Search complainant, respondent, or status..."
                                                value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary px-3">Apply</button>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <div class="filter-group">
                                            <span class="filter-label d-none d-md-inline">Status:</span>
                                            <select name="status_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="all" {{ request('status_filter', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                                                <option value="pending" {{ request('status_filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="ongoing" {{ request('status_filter') === 'ongoing' ? 'selected' : '' }}>On-going</option>
                                                <option value="closed" {{ request('status_filter') === 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                        </div>

                                        <div class="filter-group">
                                            <span class="filter-label d-none d-md-inline">Sort:</span>
                                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="id_desc" {{ request('sort', 'id_desc') === 'id_desc' ? 'selected' : '' }}>ID: Newest</option>
                                                <option value="id_asc" {{ request('sort') === 'id_asc' ? 'selected' : '' }}>ID: Oldest</option>
                                                <option value="complainant_asc" {{ request('sort') === 'complainant_asc' ? 'selected' : '' }}>Complainant: A-Z</option>
                                                <option value="complainant_desc" {{ request('sort') === 'complainant_desc' ? 'selected' : '' }}>Complainant: Z-A</option>
                                                <option value="status_asc" {{ request('sort') === 'status_asc' ? 'selected' : '' }}>Status: A-Z</option>
                                                <option value="status_desc" {{ request('sort') === 'status_desc' ? 'selected' : '' }}>Status: Z-A</option>
                                            </select>
                                        </div>

                                        <div class="vr mx-1 d-none d-md-block"></div>
                                        <a href="{{ route('admin.blotter.index') }}"
                                           class="btn btn-link btn-sm text-secondary text-decoration-none px-2"
                                           title="Reset Filters">
                                            <i class="fa fa-undo me-1"></i>Reset
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive table-wrapper">
                                <table id="blotterTable" class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 120px;">Blotter No</th>
                                            <th>Complainant (Nagrereklamo)</th>
                                            <th>Respondent (Nirereklamo)</th>
                                            <th style="width: 150px;">Status</th>
                                            <th class="text-center" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="blotterTableBody">
                                        @foreach($blotters as $blotter)
                                            @php
                                                $status = strtolower($blotter->current_status ?? '');
                                                if (str_contains($status, 'pending')) {
                                                    $uiClass = 'status-pending';
                                                } elseif (str_contains($status, 'ongoing')) {
                                                    $uiClass = 'status-ongoing';
                                                } elseif (str_contains($status, 'closed')) {
                                                    $uiClass = 'status-closed';
                                                } else {
                                                    $uiClass = 'status-default';
                                                }
                                            @endphp

                                            <tr>
                                                <td class="case-number">#{{ $blotter->id }}</td>
                                                <td>{{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</td>
                                                <td>{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
                                                <td>
                                                    <div class="status-badge {{ $uiClass }}">
                                                        <span class="status-dot"></span>
                                                        {{ $blotter->current_status ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-buttons">
                                                        <button class="btn btn-sm btn-primary btn-action"
                                                                type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewBlotter{{ $blotter->id }}">
                                                            <i class="fa fa-eye"></i>
                                                            <span>View</span>
                                                        </button>

                                                        <button class="btn btn-sm btn-outline-primary btn-action shadow-sm"
                                                                type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#updateBlotterModal"
                                                                data-blotter-id="{{ $blotter->id }}">
                                                            <i class="fa fa-pen-to-square"></i>
                                                            <span>Update</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="viewBlotter{{ $blotter->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Blotter Details #{{ $blotter->id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <section>
                                                                <h6>Complainant Information</h6>
                                                                <div class="info-box">
                                                                    <div class="row gy-3">
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Full Name</div>
                                                                            <div class="info-value">{{ $blotter->plaintiffName }} {{ $blotter->plaintiffMiddleName }} {{ $blotter->plaintiffLastName }}</div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Age</div>
                                                                            <div class="info-value">{{ $blotter->plaintiffAge ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="info-label">Address</div>
                                                                            <div class="info-value">{{ $blotter->plaintiffAddress ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Contact Number</div>
                                                                            <div class="info-value">{{ $blotter->plaintiffContactNumber ?? 'N/A' }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            <section>
                                                                <h6>Respondent Information</h6>
                                                                <div class="info-box">
                                                                    <div class="row gy-3">
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Full Name</div>
                                                                            <div class="info-value">{{ $blotter->defendantName }} {{ $blotter->defendantMiddleName }} {{ $blotter->defendantLastName }}</div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Age</div>
                                                                            <div class="info-value">{{ $blotter->defendantAge ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="info-label">Address</div>
                                                                            <div class="info-value">{{ $blotter->defendantAddress ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Contact Number</div>
                                                                            <div class="info-value">{{ $blotter->defendantContactNumber ?? 'N/A' }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            @if($blotter->witnessName)
                                                                <section>
                                                                    <h6>Witness Information</h6>
                                                                    <div class="info-box">
                                                                        <div class="row gy-3">
                                                                            <div class="col-sm-6">
                                                                                <div class="info-label">Witness Name</div>
                                                                                <div class="info-value">{{ $blotter->witnessName }}</div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="info-label">Contact Number</div>
                                                                                <div class="info-value">{{ $blotter->witnessContactNumber ?? 'N/A' }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @endif

                                                            <section>
                                                                <h6>Incident Description</h6>
                                                                <div class="info-box">
                                                                    <div class="info-label mb-1">Details</div>
                                                                    <div class="info-value" style="white-space: pre-line; line-height: 1.6;">
                                                                        {{ $blotter->blotterDescription }}
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            @if($blotter->proof)
                                                                <section>
                                                                    <h6>Evidence / Proof Submitted</h6>
                                                                    <div class="info-box">
                                                                        <div class="row gy-2">
                                                                            <div class="col-12">
                                                                                <img src="{{ Storage::url($blotter->proof) }}"
                                                                                     alt="Evidence for blotter #{{ $blotter->id }}"
                                                                                     class="img-fluid rounded border evidence-img"
                                                                                     style="max-height: 400px; object-fit: contain; cursor: pointer;"
                                                                                     onclick="showImageModal('{{ Storage::url($blotter->proof) }}', '#{{ $blotter->id }}')"
                                                                                     title="Click to view full size">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <small class="text-muted">
                                                                                    <i class="fa fa-info-circle me-1"></i> Click image to view full size
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @endif

                                                            <section>
                                                                <h6>Status Information</h6>
                                                                <div class="info-box">
                                                                    <div class="row gy-2">
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Current Status</div>
                                                                            <div class="status-badge {{ $uiClass }}">
                                                                                <span class="status-dot"></span>
                                                                                {{ $blotter->current_status ?? 'N/A' }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="info-label">Date Filed</div>
                                                                            <div class="info-value">{{ $blotter->created_at->format('M d, Y h:i A') }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            @if($blotter->updates->count() > 0)
                                                                <section>
                                                                    <h6>Status History</h6>
                                                                    <div class="history-list timeline">
                                                                        @foreach ($blotter->updates as $hist)
                                                                            @php
                                                                                $normalized = strtolower($hist->status ?? '');
                                                                                $badgeClass = match(true) {
                                                                                    str_contains($normalized, 'first')      => 'pending',
                                                                                    str_contains($normalized, 'second')     => 'pending',
                                                                                    str_contains($normalized, 'third')      => 'pending',
                                                                                    str_contains($normalized, 'brgyHearing')=> 'ongoing',
                                                                                    str_contains($normalized, 'coldCase')   => 'closed',
                                                                                    str_contains($normalized, 'criminalCase') => 'closed',
                                                                                    default                                 => 'pending',
                                                                                };
                                                                            @endphp
                                                                            <div class="timeline-item">
                                                                                <span class="timeline-dot"></span>
                                                                                <div class="timeline-body">
                                                                                    <div class="timeline-header">
                                                                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                                            @php
                                                                                                $displayLabel = $statusLabels[$hist->status] ?? ucwords(str_replace('_', ' ', $hist->status));
                                                                                            @endphp
                                                                                            <span class="timeline-badge {{ $badgeClass }}">{{ $displayLabel }}</span>
                                                                                        </div>
                                                                                        <span class="badge bg-light text-dark border">Case #{{ $blotter->id }}</span>
                                                                                    </div>
                                                                                    <div class="timeline-remarks">{{ $hist->remarks }}</div>
                                                                                    @php
                                                                                        $updaterName = null;
                                                                                        if ($hist->updater) {
                                                                                            $updaterName = trim(($hist->updater->firstName ?? '') . ' ' . ($hist->updater->lastName ?? ''));
                                                                                            if ($updaterName === '') {
                                                                                                $updaterName = $hist->updater->email ?? null;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="timeline-meta">
                                                                                        <span><i class="fa fa-calendar me-1 text-primary"></i>{{ $hist->created_at->format('M d, Y h:i A') }}</span>
                                                                                        <span><i class="fa fa-user-shield me-1 text-primary"></i>{{ ucwords($updaterName ?? 'Unknown') }}</span>
                                                                                    </div>
                                                                                    @if (!empty($hist->photo_path) && $hist->photo_path !== null && trim($hist->photo_path) !== '')
                                                                                        <div class="timeline-photo mt-2">
                                                                                            <img src="{{ Storage::url($hist->photo_path) }}" 
                                                                                                 alt="Status proof for blotter {{ $blotter->id }}"
                                                                                                 style="cursor: pointer;"
                                                                                                 onclick="showImageModal('{{ Storage::url($hist->photo_path) }}', '#{{ $blotter->id }}')"
                                                                                                 title="Click to view full size">
                                                                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="showImageModal('{{ Storage::url($hist->photo_path) }}', '#{{ $blotter->id }}')">
                                                                                                <i class="fa fa-search-plus me-1"></i>View evidence
                                                                                            </button>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </section>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($blotters->hasPages())
                            <div class="pagination-container">
                                <div class="pagination-wrapper">
                                    <div class="pagination-info">
                                        <div class="pagination-info-text">
                                            <i class="fa-solid fa-list-check"></i>
                                            <span>
                                                Showing <span class="pagination-info-numbers">{{ $blotters->firstItem() }}</span>
                                                to <span class="pagination-info-numbers">{{ $blotters->lastItem() }}</span>
                                                of <span class="pagination-info-numbers">{{ $blotters->total() }}</span> results
                                            </span>
                                        </div>
                                    </div>

                                    {{ $blotters->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <div>
                                    <h5 class="modal-title fw-bold" id="blotterModalLabel">Submit Blotter</h5>
                                    <small class="text-muted">Provide the incident details and parties involved.</small>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-3">
                                @include('forms.blotter')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateBlotterModal" tabindex="-1" aria-labelledby="updateBlotterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <div>
                                    <h5 class="modal-title fw-bold" id="updateBlotterModalLabel">Update Blotter Status</h5>
                                    <small class="text-muted">Track the progress and current status of the dispute.</small>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-3">
                                <div id="updateBlotterContent">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="text-muted mt-2">Loading update form...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content bg-dark">
                            <div class="modal-header border-0 bg-dark text-white">
                                <h5 class="modal-title" id="imageViewerModalLabel">Evidence - Blotter <span id="modalBlotterId"></span></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex align-items-center justify-content-center p-0" style="background-color: #1a1a1a;">
                                <img id="modalImage" src="" alt="Evidence" class="img-fluid" style="max-height: 90vh; max-width: 100%; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>

    <script>
        const updateBlotterModal = document.getElementById('updateBlotterModal');
        if (updateBlotterModal) {
            updateBlotterModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const blotterId = button.getAttribute('data-blotter-id');
                const contentDiv = document.getElementById('updateBlotterContent');

                if (blotterId && contentDiv) {
                    fetch(`{{ route('admin.blotter.update.form', ':id') }}`.replace(':id', blotterId))
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML = html;
                            initializeDatePickers();
                        })
                        .catch(error => {
                            console.error('Error loading update form:', error);
                            contentDiv.innerHTML = '<div class="alert alert-danger">Error loading form. Please try again.</div>';
                        });
                }
            });
        }

        function initializeDatePickers() {
            document.querySelectorAll('[id^="date_trigger_"]').forEach(trigger => {
                trigger.removeEventListener('click', handleDateTrigger);
                trigger.addEventListener('click', handleDateTrigger);
            });
        }

        function handleDateTrigger(event) {
            event.preventDefault();
            const dateInput = this.previousElementSibling;
            if (dateInput && typeof dateInput.showPicker === 'function') {
                dateInput.showPicker();
            } else if (dateInput) {
                dateInput.focus();
            }
        }

        function showImageModal(imageUrl, blotterId) {
            const modal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalBlotterId').textContent = blotterId;
            modal.show();
        }
    </script>

    @yield('scripts')
</body>
</html>
