<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode Resident</title>

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
            overflow: hidden;
        }

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
            margin: 0 0 1rem 0;
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

        .resident-date-group .input-group-text {
            background-color: #f1f3f5;
            border: 1.5px solid #ced4da;
            cursor: pointer;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 1;
            cursor: pointer;
        }

        .resident-date-group > .form-control[type="date"] {
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
        }

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

        .table-filter-bar {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
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

        .action-btns .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .pagination-container {
            padding: 2rem;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
            border-top: 2px solid var(--border-color);
        }

        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 600;
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
            padding: 0.625rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
        }

        .pagination .page-link:hover:not(.disabled) {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-color: var(--primary-color);
            color: white;
        }

        .stats-row {
            padding: 0 2rem 1rem 2rem;
        }

        .stats-row .card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .modal-content .form-control, 
        .modal-content .form-select {
            border: 2px solid #dddddd !important;
            box-shadow: none !important;
            border-radius: 6px;
        }

        .modal-content .form-control:focus,
        .modal-content .form-select:focus {
            border: 2px solid #0056b3 !important;
            box-shadow: 0 0 0 0.15rem rgba(0,123,255,0.2) !important;
            outline: none !important;
        }

        .modal-content label {
            font-weight: 600;
            margin-top: 12px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .invalid-feedback {
            font-weight: 500;
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
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <h2>
                            <span class="page-header-icon"><i class="fas fa-users"></i></span>
                            Resident Management
                        </h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#encodeResidentModal">
                            <i class="fas fa-plus me-2"></i>Encode Resident
                        </button>
                    </div>
                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mx-4 mt-3 mb-0" role="alert" style="border-radius: 8px; border-left: 5px solid #198754;">
                        <i class="fas fa-check-circle me-3" style="font-size: 1.5rem;"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm mx-4 mt-3 mb-0" role="alert" style="border-radius: 8px; border-left: 5px solid #dc3545;">
                        <i class="fas fa-exclamation-circle me-3" style="font-size: 1.5rem;"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm mx-4 mt-3 mb-0" role="alert" style="border-radius: 8px; border-left: 5px solid #dc3545;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Please correct the following errors:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="stats-row">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Total Residents</div>
                                        <div class="fs-4 fw-bold">{{ $residentCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fa-solid fa-person"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Male Residents</div>
                                        <div class="fs-4 fw-bold">{{ $maleCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #e83e8c;">
                                        <i class="fa-solid fa-person-dress"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Female Residents</div>
                                        <div class="fs-4 fw-bold">{{ $femaleCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fa-solid fa-person-cane"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Senior Citizens</div>
                                        <div class="fs-4 fw-bold">{{ $seniorCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Search Form --}}
                <div class="search-section">
                    <form action="{{ route($user->role . '.residents') }}" method="get">
                        <input type="hidden" name="sex_filter" value="{{ request('sex_filter', 'all') }}">
                        <input type="hidden" name="sort" value="{{ request('sort', 'id_desc') }}">
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Search Resident</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" placeholder="Enter name or ID here..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">Search</button>
                                @if(request('search'))
                                    <a href="{{ route($user->role . '.residents') }}" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-times me-2"></i>Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                @if($residents->isEmpty())
                    <div class="table-container">
                        <div class="alert alert-info">No residents found.</div>
                    </div>
                @else
                    <div class="table-container">
                        <div class="results-info">
                            <div class="results-count">
                                Records: <span class="count-number">{{ $residents->total() }}</span>
                            </div>
                            <form method="GET" action="{{ route($user->role . '.residents') }}" class="table-filter-bar">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <div class="filter-group">
                                    <span class="filter-label">Sex</span>
                                    <select name="sex_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('sex_filter', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                        <option value="male" {{ request('sex_filter') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ request('sex_filter') === 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <span class="filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="id_desc" {{ request('sort', 'id_desc') === 'id_desc' ? 'selected' : '' }}>ID: Newest</option>
                                        <option value="id_asc" {{ request('sort') === 'id_asc' ? 'selected' : '' }}>ID: Oldest</option>
                                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                    </select>
                                </div>
                                <a href="{{ route($user->role . '.residents', array_filter(['search' => request('search')])) }}" class="btn btn-link btn-sm text-secondary text-decoration-none">
                                    <i class="fa fa-undo me-1"></i>Reset
                                </a>
                            </form>
                        </div>

                        <div class="table-responsive table-wrapper">
                            <table class="table table-bordered table-hover bg-white">
                                <thead class="table-primary text-nowrap">
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($residents as $resident)
                                        <tr>
                                            <td class="align-middle">{{ $resident->id }}</td>
                                            <td class="align-middle"> {{ ucwords(strtolower($resident->firstName)) }} {{ ucwords(strtolower($resident->middleName)) }} {{ ucwords(strtolower($resident->lastName)) }} </td>
                                            <td class="text-center text-nowrap">
                                                <div class="d-flex justify-content-center align-items-center gap-2 action-btns">
                                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewResident{{ $resident->id }}">
                                                        <i class="fa fa-eye"></i><span>View</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateResident{{ $resident->id }}">
                                                        <i class="fa fa-edit"></i><span>Edit</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addOfficial{{ $resident->id }}">
                                                        <i class="fa fa-user-tie"></i><span>{{ $resident->official ? 'Edit Official' : 'Set Official' }}</span>
                                                    </button>
                                                    <form action="{{ route($user->role . '.archive.resident', $resident->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-trash"></i><span>Inactive</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                    {{-- Modal: View Resident --}}
                                    {{-- View Modal --}}
                                        <div class="modal fade" id="viewResident{{ $resident->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-person-badge me-2"></i>Resident Details #{{ $resident->id }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    
                                                    <div class="modal-body p-4">
                                                        <section class="mb-4">
                                                            <h6 class="mb-4 text-uppercase fw-bold text-primary" style="letter-spacing:0.5px; border-left:4px solid #0d6efd; padding-left:10px;">
                                                                Personal Information
                                                            </h6>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                                                    <div class="img-container mb-2">
                                                                        <img src="{{ asset('storage/' . $resident->image_path) }}" 
                                                                            alt="Profile Picture" 
                                                                            class="img-thumbnail rounded shadow-sm"
                                                                            style="width: 100%; max-width: 200px; height: 200px; object-fit: cover;">
                                                                              @if(auth()->user()->profile_image)
                                                                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="img-thumbnail rounded shadow-sm"
                                                                            style="width: 100%; max-width: 200px; height: 200px; object-fit: cover;">
                                                                                @else
                                                                                    <img src="{{ asset('images/default_profile.jpg') }}" alt="User name" class="img-thumbnail rounded shadow-sm"
                                                                            style="width: 100%; max-width: 200px; height: 200px; object-fit: cover;">
                                                                                @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="row g-3">
                                                                        <div class="col-12">
                                                                            <div class="fw-semibold text-secondary small text-uppercase">Full Name</div>
                                                                            <div class="fs-5 fw-bold text-dark"> 
                                                                                {{ ucwords(strtolower($resident->firstName)) }} {{ ucwords(strtolower($resident->middleName)) }} {{ ucwords(strtolower($resident->lastName)) }} 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="fw-semibold text-secondary small text-uppercase">Age / Sex</div>
                                                                            <div class="fs-6">{{ $resident->age }} yrs old, {{ ucfirst($resident->sex) }}</div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="fw-semibold text-secondary small text-uppercase">Birthday</div>
                                                                            <div class="fs-6">{{ \Carbon\Carbon::parse($resident->birthday)->format('M d, Y') }}</div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="fw-semibold text-secondary small text-uppercase">Contact Number</div>
                                                                            <div class="fs-6">{{ $resident->contactNo }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--  
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                                                                        <div class="fw-semibold text-secondary small text-uppercase">Residential Address</div>
                                                                        <div class="fs-6"> House No. {{ $resident->houseNo }}, {{ ucwords(strtolower($resident->street)) }} </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                    --}}
                                                            @php
                                                                $assignedHousehold = $resident->households->first();
                                                                $assignedHouse = $assignedHousehold ? $assignedHousehold->house : null;
                                                                $assignedStreet = $assignedHouse ? $assignedHouse->street : null;
                                                            @endphp

                                                            <div class="row mt-3 g-3">
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded border-start border-primary border-3 h-100">
                                                                        <div class="fw-semibold text-secondary small text-uppercase">Assigned House</div>
                                                                        <div class="fs-6">
                                                                            {{ $assignedHouse ? 'House No. ' . $assignedHouse->house_no : 'N/A' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded border-start border-primary border-3 h-100">
                                                                        <div class="fw-semibold text-secondary small text-uppercase">Assigned Street</div>
                                                                        <div class="fs-6">
                                                                            {{ $assignedStreet ? $assignedStreet->street_name : 'N/A' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <hr class="my-4 text-muted opacity-25">

                                                        <section>
                                                            <h6 class="mb-3 text-uppercase fw-bold text-primary" style="letter-spacing:0.5px; border-left:4px solid #0d6efd; padding-left:10px;">
                                                                Family & Status
                                                            </h6>
                                                            <div class="row g-3 px-2">
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Head of Family</div>
                                                                    <div class="fs-6 fw-medium">{{ ucfirst($resident->headOfFamily) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Parent Status</div>
                                                                    <div class="fs-6 fw-medium">{{ ucfirst($resident->parent) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Currently Enrolled</div>
                                                                    <div class="fs-6 fw-medium">{{ ucfirst($resident->enrolled) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Educational Attainment</div>
                                                                    <div class="fs-6 fw-medium">{{ $resident->educationalAttainment ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Religion</div>
                                                                    <div class="fs-6 fw-medium">{{ $resident->religion ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary small text-uppercase">Emergency Contact</div>
                                                                    <div class="fs-6 fw-medium text-danger"> 
                                                                        {{ ucwords(strtolower($resident->emergencyContactName ?? 'N/A')) }} 
                                                                        <span class="text-dark d-block small">{{ $resident->emergencyContactNo ?? 'N/A' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                    
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    {{-- Modal: Add as Official --}}
                                    <div class="modal fade" id="addOfficial{{ $resident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $resident->official ? 'Update Official Status' : 'Set as Barangay Official' }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ $resident->official ? route('admin.update.official', $resident->official->id) : route('admin.add.official', $resident->id) }}" method="POST">
                                                        @csrf
                                                        @if($resident->official)
                                                            @method('PUT')
                                                        @endif
                                                        
                                                        <label>Select Position</label>
                                                        <select name="position" class="form-select" required>
                                                            <option value="Barangay Chairman" {{ $resident->official && $resident->official->position === 'Barangay Chairman' ? 'selected' : '' }}>Barangay Chairman</option>
                                                            <option value="Barangay Secretary" {{ $resident->official && $resident->official->position === 'Barangay Secretary' ? 'selected' : '' }}>Barangay Secretary</option>
                                                            <option value="Barangay Treasurer" {{ $resident->official && $resident->official->position === 'Barangay Treasurer' ? 'selected' : '' }}>Barangay Treasurer</option>
                                                            <option value="Kagawad 1" {{ $resident->official && $resident->official->position === 'Kagawad 1' ? 'selected' : '' }}>Kagawad 1</option>
                                                            <option value="Kagawad 2" {{ $resident->official && $resident->official->position === 'Kagawad 2' ? 'selected' : '' }}>Kagawad 2</option>
                                                            <option value="Kagawad 3" {{ $resident->official && $resident->official->position === 'Kagawad 3' ? 'selected' : '' }}>Kagawad 3</option>
                                                            <option value="Kagawad 4" {{ $resident->official && $resident->official->position === 'Kagawad 4' ? 'selected' : '' }}>Kagawad 4</option>
                                                            <option value="Kagawad 5" {{ $resident->official && $resident->official->position === 'Kagawad 5' ? 'selected' : '' }}>Kagawad 5</option>
                                                            <option value="Kagawad 6" {{ $resident->official && $resident->official->position === 'Kagawad 6' ? 'selected' : '' }}>Kagawad 6</option>
                                                            <option value="Kagawad 7" {{ $resident->official && $resident->official->position === 'Kagawad 7' ? 'selected' : '' }}>Kagawad 7</option>
                                                            <option value="SK Chairman" {{ $resident->official && $resident->official->position === 'SK Chairman' ? 'selected' : '' }}>SK Chairman</option>
                                                            <option value="SK Kagawad 1" {{ $resident->official && $resident->official->position === 'SK Kagawad 1' ? 'selected' : '' }}>SK Kagawad 1</option>
                                                            <option value="SK Kagawad 2" {{ $resident->official && $resident->official->position === 'SK Kagawad 2' ? 'selected' : '' }}>SK Kagawad 2</option>
                                                            <option value="SK Kagawad 3" {{ $resident->official && $resident->official->position === 'SK Kagawad 3' ? 'selected' : '' }}>SK Kagawad 3</option>
                                                            <option value="SK Kagawad 4" {{ $resident->official && $resident->official->position === 'SK Kagawad 4' ? 'selected' : '' }}>SK Kagawad 4</option>
                                                            <option value="SK Kagawad 5" {{ $resident->official && $resident->official->position === 'SK Kagawad 5' ? 'selected' : '' }}>SK Kagawad 5</option>
                                                            <option value="SK Kagawad 6" {{ $resident->official && $resident->official->position === 'SK Kagawad 6' ? 'selected' : '' }}>SK Kagawad 6</option>
                                                            <option value="SK Kagawad 7" {{ $resident->official && $resident->official->position === 'SK Kagawad 7' ? 'selected' : '' }}>SK Kagawad 7</option>
                                                        </select>

                                                        <label>Term Description</label>
                                                        <input type="text" name="details" class="form-control" placeholder="e.g. 2023-2026 Term" value="{{ $resident->official ? $resident->official->details : '' }}" required>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Start Date</label>
                                                                <input type="text" name="start" class="form-control datetime-picker" placeholder="Select Start Date" value="{{ $resident->official ? $resident->official->start : '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>End Date</label>
                                                                <input type="text" name="end" class="form-control datetime-picker" placeholder="Select End Date" value="{{ $resident->official ? $resident->official->end : '' }}" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-end mt-4">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success">{{ $resident->official ? 'Update Official' : 'Save Official' }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal: Edit Resident --}}
                                    <div class="modal fade" id="updateResident{{ $resident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Resident #{{ $resident->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route($user->role . '.update.resident', $resident->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>First Name</label>
                                                                <input type="text" name="firstName" class="form-control" value="{{ old('firstName', $resident->firstName) }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Middle Name</label>
                                                                <input type="text" name="middleName" class="form-control" value="{{ old('middleName', $resident->middleName) }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Last Name</label>
                                                                <input type="text" name="lastName" class="form-control" value="{{ old('lastName', $resident->lastName) }}" required>
                                                            </div>
                                                        </div>
@php
    $household = $resident->households->first();
    $houseId   = $household?->house_id;
    $streetId  = $household?->house?->street_id;
@endphp

<label>Street</label>
<select
    class="form-control street-select"
    data-selected-street="{{ $streetId }}"
    data-selected-house="{{ $houseId }}"
>
    <option value="">-- Select Street --</option>
    @foreach ($streets as $street)
        <option value="{{ $street->id }}">
            {{ $street->street_name }}
        </option>
    @endforeach
</select>

<label class="mt-3">House Number</label>
<select name="house_id" class="form-control house-select">
    <option value="">-- Select House Number --</option>
</select>



                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Birthday</label>
                                                                <div class="input-group resident-date-group w-100">
                                                                    <input
                                                                        type="date"
                                                                        name="birthday"
                                                                        class="form-control resident-date-input"
                                                                        data-age-target="ageEdit{{ $resident->id }}"
                                                                        data-raw="{{ old('birthday', $resident->birthday) }}"
                                                                        value="{{ old('birthday', $resident->birthday) }}"
                                                                        required
                                                                    >
                                                                    <span class="input-group-text resident-date-open">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Age</label>
                                                                <input type="number" id="ageEdit{{ $resident->id }}" name="age" class="form-control bg-light" value="{{ old('age', $resident->age) }}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Sex</label>
                                                                <select name="sex" class="form-select" required>
                                                                    <option value="male" {{ old('sex', $resident->sex) === 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('sex', $resident->sex) === 'female' ? 'selected' : '' }}>Female</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Contact No.</label>
                                                                <input type="text" name="contactNo" class="form-control" value="{{ old('contactNo', $resident->contactNo) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Head of Family</label>
                                                                <select name="headOfFamily" class="form-select" required>
                                                                    <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Parent Status</label>
                                                                <select name="parent" class="form-select" required>
                                                                    <option value="yes" {{ old('parent', $resident->parent) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('parent', $resident->parent) === 'no' ? 'selected' : '' }}>No</option>
                                                                    <option value="single" {{ old('parent', $resident->parent) === 'single' ? 'selected' : '' }}>Single Parent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Currently Enrolled</label>
                                                                <select name="enrolled" class="form-select" required>
                                                                    <option value="yes" {{ old('enrolled', $resident->enrolled) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('enrolled', $resident->enrolled) === 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Educational Attainment</label>
                                                                <input type="text" name="educationalAttainment" class="form-control" value="{{ old('educationalAttainment', $resident->educationalAttainment) }}" placeholder="e.g., College Graduate">
                                                            </div>
                                                        </div>

                                                        <label>Religion</label>
                                                        <input type="text" name="religion" class="form-control" value="{{ old('religion', $resident->religion) }}" placeholder="e.g., Roman Catholic">

                                                        <label for="age{{ $resident->id }}">Age</label>
                                                        <input type="number" id="age{{ $resident->id }}" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $resident->age) }}" placeholder="0" min="0" max="255" required readonly>

                                                        <label for="sex{{ $resident->id }}">Sex</label>
                                                        <select id="sex{{ $resident->id }}" name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                                            <option value="">Select Sex</option>
                                                            <option value="male" {{ old('sex', $resident->sex) === 'male' ? 'selected' : '' }}>Male</option>
                                                            <option value="female" {{ old('sex', $resident->sex) === 'female' ? 'selected' : '' }}>Female</option>
                                                        </select>
                                                        <div class="row mt-3"> <div class="col-md-4 text-center"> <label class="d-block mb-2">Current Photo</label> <img id="previewImage{{ $resident->id }}" src="{{ asset('storage/' . $resident->image_path) }}" class="img-fluid rounded shadow-sm mb-2" style="width: 150px; height: 150px; object-fit: cover;" alt="Resident Photo" > </div>
<div class="col-md-8">
    <label for="image_path{{ $resident->id }}">Update Photo</label>
    <input
        type="file"
        id="image_path{{ $resident->id }}"
        name="image_path"
        class="form-control"
        accept="image/png, image/jpg, image/jpeg"
        onchange="previewResidentImage(event, '{{ $resident->id }}')"
    >
    <small class="text-muted d-block mt-1">
        JPG or PNG. Max 2MB.
    </small>
</div>

</div>

                                                        <hr class="mt-4">

                                                        <label for="emergencyContactName{{ $resident->id }}">Emergency Contact Name</label>
                                                        <input type="text" id="emergencyContactName{{ $resident->id }}" name="emergencyContactName" class="form-control @error('emergencyContactName') is-invalid @enderror" value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" placeholder="Enter full name" required>

                                                        <label for="emergencyContactNo{{ $resident->id }}">Emergency Contact No.</label>
                                                        <input type="text" id="emergencyContactNo{{ $resident->id }}" name="emergencyContactNo" class="form-control @error('emergencyContactNo') is-invalid @enderror" value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" placeholder="e.g. 09123456789" required>

                                                        <hr class="mt-4">

                                                        <label for="parent{{ $resident->id }}">Parent Status</label>
                                                        <select id="parent{{ $resident->id }}" name="parent" class="form-select @error('parent') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('parent', $resident->parent) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('parent', $resident->parent) === 'no' ? 'selected' : '' }}>No</option>
                                                            <option value="single" {{ old('parent', $resident->parent) === 'single' ? 'selected' : '' }}>Single Parent</option>
                                                        </select>

                                                        <label for="enrolled{{ $resident->id }}">Currently Enrolled</label>
                                                        <select id="enrolled{{ $resident->id }}" name="enrolled" class="form-select @error('enrolled') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('enrolled', $resident->enrolled) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('enrolled', $resident->enrolled) === 'no' ? 'selected' : '' }}>No</option>
                                                        </select>

                                                        <label for="educationalAttainment{{ $resident->id }}">Educational Attainment</label>
                                                        <input type="text" id="educationalAttainment{{ $resident->id }}" name="educationalAttainment" class="form-control @error('educationalAttainment') is-invalid @enderror" value="{{ old('educationalAttainment', $resident->educationalAttainment) }}" placeholder="e.g. College Graduate">

                                                        <label for="religion{{ $resident->id }}">Religion</label>
                                                        <input type="text" id="religion{{ $resident->id }}" name="religion" class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion', $resident->religion) }}" placeholder="e.g. Catholic">

                                                        <label for="headOfFamily{{ $resident->id }}">Head of Family</label>
                                                        <select id="headOfFamily{{ $resident->id }}" name="headOfFamily" class="form-select @error('headOfFamily') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Emergency Contact Name</label>
                                                                <input type="text" name="emergencyContactName" class="form-control" value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Emergency Contact No.</label>
                                                                <input type="text" name="emergencyContactNo" class="form-control" value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="text-end mt-4 pt-3 border-top">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary px-4">Update Resident</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($residents->hasPages())
                        <div class="pagination-container">
                            <div class="pagination-wrapper">
                                <div class="pagination-info">
                                    Showing {{ $residents->firstItem() }} to {{ $residents->lastItem() }} of {{ $residents->total() }} results
                                </div>
                                {{ $residents->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Modal: Create New Resident --}}
            <div class="modal fade" id="encodeResidentModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Encode Resident</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route($user->role . '.encode.residents') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <!-- First Name -->
    <label>First Name</label>
    <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" 
           placeholder="Enter First Name" value="{{ old('firstName') }}" required>
    @error('firstName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Middle Name -->
    <label>Middle Name</label>
    <input type="text" name="middleName" class="form-control @error('middleName') is-invalid @enderror" 
           placeholder="Enter Middle Name" value="{{ old('middleName') }}" required>
    @error('middleName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Last Name -->
    <label>Last Name</label>
    <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" 
           placeholder="Enter Last Name" value="{{ old('lastName') }}" required>
    @error('lastName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Birthday -->
    <label>Birthday</label>
    <div class="input-group resident-date-group w-100">
        <input
            type="date"
            id="birthdayCreate"
            name="birthday"
            class="form-control resident-date-input @error('birthday') is-invalid @enderror"
            data-age-target="ageCreate"
            data-raw="{{ old('birthday') }}"
            value="{{ old('birthday') }}"
            required
        >
        <span class="input-group-text resident-date-open">
            <i class="fa fa-calendar"></i>
        </span>
    </div>
    @error('birthday')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Age -->
    <label>Age</label>
    <input type="number" id="ageCreate" name="age" class="form-control bg-light @error('age') is-invalid @enderror" 
           value="{{ old('age') }}" readonly>
    @error('age')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <label>Street</label>
    <!-- Street -->
   <select class="form-control street-select">
    <option value="">-- Select Street --</option>
    @foreach ($streets as $street)
        <option value="{{ $street->id }}">{{ $street->street_name }}</option>
    @endforeach
</select>
<label>House Number</label>
<select name="house_id" class="form-control house-select">
    <option value="">-- Select House Number --</option>
</select>


    <!-- Contact No - REMOVED DUPLICATE, KEPT THIS ONE -->
    <label for="contactNo">Contact No.</label>
    <input type="text" id="contactNo" name="contactNo" class="form-control @error('contactNo') is-invalid @enderror" 
           value="{{ old('contactNo') }}" placeholder="09xxxxxxxxx" required>
    @error('contactNo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Sex (Added missing field) -->
    <label for="sex">Sex</label>
    <select id="sex" name="sex" class="form-select @error('sex') is-invalid @enderror">
        <option value="">Select Sex</option>
        <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
    </select>
    @error('sex')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Parent Status (Added missing field) -->
    <label for="parent">Parent Status</label>
    <select id="parent" name="parent" class="form-select @error('parent') is-invalid @enderror">
        <option value="">Select Parent Status</option>
        <option value="yes" {{ old('parent') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('parent') === 'no' ? 'selected' : '' }}>No</option>
        <option value="single" {{ old('parent') === 'single' ? 'selected' : '' }}>Single Parent</option>
    </select>
    @error('parent')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Enrolled (Added missing field) -->
    <label for="enrolled">Enrolled in School</label>
    <select id="enrolled" name="enrolled" class="form-select @error('enrolled') is-invalid @enderror">
        <option value="">Select Enrollment Status</option>
        <option value="yes" {{ old('enrolled') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('enrolled') === 'no' ? 'selected' : '' }}>No</option>
    </select>
    @error('enrolled')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Image -->
    <label for="image_path">Profile Image</label>
    <input type="file" name="image_path" id="image_path" class="form-control @error('image_path') is-invalid @enderror" 
           accept="image/png, image/jpg, image/jpeg">
    @error('image_path')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Emergency Contact Name -->
    <label for="emergencyContactName">Emergency Contact Name</label>
    <input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control @error('emergencyContactName') is-invalid @enderror" 
           value="{{ old('emergencyContactName') }}" placeholder="Enter Full Name here" required>
    @error('emergencyContactName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Emergency Contact No -->
    <label for="emergencyContactNo">Emergency Contact No.</label>
    <input type="text" id="emergencyContactNo" name="emergencyContactNo" class="form-control @error('emergencyContactNo') is-invalid @enderror" 
           value="{{ old('emergencyContactNo') }}" placeholder="09xxxxxxxxx" required>
    @error('emergencyContactNo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Educational Attainment -->
    <label for="educationalAttainment">Educational Attainment</label>
    <input type="text" id="educationalAttainment" name="educationalAttainment" class="form-control @error('educationalAttainment') is-invalid @enderror" 
           value="{{ old('educationalAttainment') }}" placeholder="Enter Educational Attainment here">
    @error('educationalAttainment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Religion -->
    <label for="religion">Religion</label>
    <input type="text" name="religion" class="form-control @error('religion') is-invalid @enderror" 
           value="{{ old('religion') }}" placeholder="Enter Religion here">
    @error('religion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Head of Family -->
    <label for="headOfFamily">Head of Family</label>
    <select id="headOfFamily" name="headOfFamily" class="form-select @error('headOfFamily') is-invalid @enderror" required>
        <option value="">Select Option</option>
        <option value="yes" {{ old('headOfFamily') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('headOfFamily') === 'no' ? 'selected' : '' }}>No</option>
    </select>
    @error('headOfFamily')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- REMOVED DUPLICATE CONTACT NO FIELD THAT WAS HERE -->

    <div class="text-end mt-4 pt-3 border-top">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary px-4">Save Resident</button>
    </div>
</form>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    
    const houses = @json($houses);

    function populateHouseDropdown(streetSelect) {
        const streetId = streetSelect.value;
        const modalBody = streetSelect.closest('.modal-body');
        const houseSelect = modalBody.querySelector('.house-select');
        const selectedHouseId = streetSelect.dataset.selectedHouse;

        houseSelect.innerHTML = '<option value="">-- Select House Number --</option>';

        if (!streetId) return;

        houses.forEach(house => {
            if (String(house.street_id) === String(streetId)) {
                const option = document.createElement('option');
                option.value = house.id;
                option.textContent = house.house_no;

                if (String(house.id) === String(selectedHouseId)) {
                    option.selected = true;
                }

                houseSelect.appendChild(option);
            }
        });
    }

    // Street change (encode + edit)
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('street-select')) return;
        populateHouseDropdown(e.target);
    });

    // Edit modal auto-load
    document.addEventListener('shown.bs.modal', function (e) {
        const streetSelect = e.target.querySelector('.street-select');
        if (!streetSelect) return;

        const savedStreet = streetSelect.dataset.selectedStreet;
        if (savedStreet) {
            streetSelect.value = savedStreet;
            populateHouseDropdown(streetSelect);
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
        // Universal Age Calculator
        function calculateAge(birthDate, targetInputId) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
            document.getElementById(targetInputId).value = age;
        }

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

        document.querySelectorAll('.resident-date-input').forEach(function (input) {
            const raw = input.getAttribute('data-raw') || input.value;
            const formatted = normalizeToYmd(raw);
            if (formatted) input.value = formatted;
            input.max = normalizeToYmd(new Date()) || input.max;
        });

        document.querySelectorAll('.resident-date-open').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const wrapper = trigger.closest('.input-group');
                const input = wrapper ? wrapper.querySelector('.resident-date-input') : null;
                openPicker(input);
            });
        });

        document.querySelectorAll('.resident-date-input').forEach(function (input) {
            input.addEventListener('change', function () {
                if (!input.value) return;
                const targetId = input.getAttribute('data-age-target');
                if (!targetId) return;
                const parsed = new Date(input.value);
                if (isNaN(parsed)) return;
                calculateAge(parsed, targetId);
            });
        });

        // --- NEW: Initialize Flatpickr for Official Assignment dates ---
        flatpickr(".datetime-picker", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,         
            altFormat: "F j, Y", 
            allowInput: true
        });
    });
    function previewResidentImage(event, id) { const image = document.getElementById('previewImage' + id); const file = event.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = function (e) { image.src = e.target.result; }; reader.readAsDataURL(file); }
</script>

</body>
</html>
