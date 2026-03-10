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
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
    }

    .main.users.chart-page {
        background-color: var(--light-bg);
        min-height: 100vh;
        padding: 2rem 0;
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
        color: #000;
        border-radius: 15px;
        padding: 30px;
        margin: 20px;
    }

    .welcome-card h3 {
        font-size: 2rem;
        margin-bottom: 10px;
        font-weight: 700;
        font-family: "Oswald", sans-serif;
    }

    .complaints-table-wrapper { padding: 0 1rem 1rem 1rem; }
    .table-responsive { width: 100%; overflow-x: auto; padding: 0.5rem 1rem 0 1rem; }

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
        text-align: center;
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

    .table tbody td:first-child {
        font-weight: 700;
        color: var(--primary-color);
    }

    .details-column {
        width: 350px;
        min-width: 300px;
    }

    .truncate-details {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #4a5568;
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .action-btns .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .action-btns .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.9rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .badge.bg-warning { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important; color: #92400e !important; }
    .badge.bg-success { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important; color: #065f46 !important; }
    .badge.bg-danger { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important; color: #991b1b !important; }
    .badge.bg-secondary { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important; color: #475569 !important; }

    .preserved-text {
        white-space: pre-wrap;
        word-wrap: break-word;
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .section-divider {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    .pagination-container {
        padding: 18px 22px 22px 22px;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-top: 2px solid var(--border-color);
        margin: 0 1rem;
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

    .pagination-info-text i { color: var(--primary-color); }

    .pagination .page-link {
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.58rem 0.95rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s ease;
        background: #fff;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-color: var(--primary-color);
        color: #fff;
    }

    .pagination .page-link:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }

    .btn-group > .btn-check:checked + .btn { z-index: 2; color: #fff; }
    .btn-check:checked + .btn-outline-success { background-color: #198754 !important; }
    .btn-check:checked + .btn-outline-warning { background-color: #ffc107 !important; color: #000 !important; }
    .btn-check:checked + .btn-outline-danger { background-color: #dc3545 !important; }

    .records-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 0 1rem;
    }

    .nav-tabs {
        border: none;
        background: #fff;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        gap: 0.5rem;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px;
        color: var(--text-secondary);
        font-weight: 600;
        padding: 0.65rem 1rem;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background-color: #f1f5f9;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: #fff;
    }

    .table-filter-bar {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        margin-top: 1.5rem;
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
    }

    .table-filter-bar .form-control:focus,
    .table-filter-bar .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
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
            <div class="main-container">

                <div class="welcome-card">
                    <h3>Complaints Records Management</h3>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mx-4 mt-3 mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @php $activeTab = $activeTab ?? 'all'; @endphp
                <div class="records-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('subadmin.complaintRequest', array_merge(request()->except(['tab', 'page']), ['tab' => 'all'])) }}" class="nav-link {{ $activeTab === 'all' ? 'active' : '' }}">
                                <i class="fas fa-list me-2"></i>All Complaints
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('subadmin.complaintRequest', array_merge(request()->except(['tab', 'page']), ['tab' => 'pending'])) }}" class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}">
                                <i class="fas fa-clock me-2"></i>Pending
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('subadmin.complaintRequest', array_merge(request()->except(['tab', 'page']), ['tab' => 'on-going'])) }}" class="nav-link {{ $activeTab === 'on-going' ? 'active' : '' }}">
                                <i class="fas fa-spinner me-2"></i>On-going
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('subadmin.complaintRequest', array_merge(request()->except(['tab', 'page']), ['tab' => 'rejected'])) }}" class="nav-link {{ $activeTab === 'rejected' ? 'active' : '' }}">
                                <i class="fas fa-times-circle me-2"></i>Rejected
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('subadmin.complaintRequest', array_merge(request()->except(['tab', 'page']), ['tab' => 'resolved'])) }}" class="nav-link {{ $activeTab === 'resolved' ? 'active' : '' }}">
                                <i class="fas fa-check-circle me-2"></i>Resolved
                            </a>
                        </li>
                    </ul>

                    <div class="complaints-table-wrapper">
                        <form method="GET" action="{{ route('subadmin.complaintRequest') }}" class="table-filter-bar">
                            <input type="hidden" name="tab" value="{{ $activeTab }}">
                            <div class="flex-grow-1" style="min-width: 250px;">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search complainant or details..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="filter-group">
                                    <span class="filter-label d-none d-md-inline">Status:</span>
                                    <select name="status_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('status_filter', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                                        <option value="pending" {{ request('status_filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="on-going" {{ request('status_filter') === 'on-going' ? 'selected' : '' }}>On-going</option>
                                        <option value="resolved" {{ request('status_filter') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="rejected" {{ request('status_filter') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                <a href="{{ route('subadmin.complaintRequest', ['tab' => $activeTab]) }}" class="btn btn-link btn-sm text-secondary text-decoration-none px-2" title="Reset Filters">
                                    <i class="fa fa-undo me-1"></i>Reset
                                </a>
                            </div>
                        </form>
                        @if($complaints->count() > 0)
                        <div class="table-responsive">
                            <table id="complaintTable" class="table table-bordered table-hover mb-0 shadow-sm bg-white">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 80px;">ID</th>
                                        <th>Complainant</th>
                                        <th>Contact</th>
                                        <th class="details-column text-start">Brief Details</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody id="complaintTableBody" class="align-middle">
                                    @foreach ($complaints as $complaint)
                                    @php
                                        $complainantDisplayName = $complaint->complainant
                                            ? ucwords(strtolower(trim(($complaint->complainant->firstName ?? '') . ' ' . ($complaint->complainant->middleName ?? '') . ' ' . ($complaint->complainant->lastName ?? ''))))
                                            : ucwords(str_replace(',', ' ', (string) $complaint->complainantName));
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-bold">{{ $complaint->id }}</td>
                                        <td>
                                            @if(!empty($complaint->complainant_id))
                                                <button
                                                    type="button"
                                                    class="btn btn-link text-decoration-none p-0 fw-semibold"
                                                    data-complainant-id="{{ $complaint->complainant_id }}"
                                                    data-complainant-name="{{ $complainantDisplayName }}"
                                                >
                                                    {{ $complainantDisplayName }}
                                                </button>
                                            @else
                                                <span class="fw-semibold">{{ $complainantDisplayName }}</span>
                                            @endif
                                            <div class="text-muted small">ID: {{ $complaint->complainant_id }}</div>
                                        </td>
                                        <td>{{ $complaint->user->contactNumber ?? $complaint->complainant->contactNumber ?? 'N/A' }}</td>
                                        <td class="details-column">
                                            <div class="truncate-details" title="{{ $complaint->details }}">
                                                {{ $complaint->details }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = [
                                                    'on-going' => 'bg-warning text-dark',
                                                    'resolved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                ][$complaint->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                                {{ ucfirst($complaint->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-btns">
                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#complaintViewModal{{ $complaint->id }}">
                                                    <i class="fa-solid fa-eye"></i> View Full Details
                                                </button>
                                                @if($complaint->status !== 'resolved')
                                                    <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#complaintActionModal{{ $complaint->id }}">
                                                        Manage
                                                    </button>
                                                @else
                                                    <span class="btn btn-sm btn-outline-secondary disabled px-3" aria-disabled="true">
                                                        Locked
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="complaintViewModal{{ $complaint->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header border-0 bg-light">
                                                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-file-invoice me-2"></i>Complaint #{{ $complaint->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="section-divider">People Involved</div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Complainant Name</small>
                                                        <p class="fw-bold">{{ $complainantDisplayName }}</p>
                                                    </div>
                                                    <div class="col-md-6 border-start">
                                                        <small class="text-muted">Respondent ID</small>
                                                        <p class="fw-bold text-danger">{{ $complaint->respondent_id ?? 'None' }}</p>
                                                    </div>
                                                </div>

                                                <div class="section-divider">Full Details</div>
                                                <div class="mb-4">
                                                    <div class="preserved-text">{{ $complaint->details }}</div>
                                                </div>

                                                <div class="section-divider">Location</div>
                                                <p class="px-2 text-muted mb-4"><i class="fa-solid fa-location-dot me-1"></i> {{ $complaint->address }}</p>

                                                <div class="section-divider">Admin Remarks</div>
                                                @php
                                                    $remarksText = $complaint->remarks ?? '';
                                                    $lines = preg_split("/\r\n|\n|\r/", $remarksText);
                                                    $formattedLines = [];
                                                    foreach ($lines as $line) {
                                                        $line = trim($line);
                                                        if ($line === '') {
                                                            $formattedLines[] = $line;
                                                            continue;
                                                        }
                                                        if (preg_match('/^(.*? - )([^:]+)(: .*)$/', $line, $matches)) {
                                                            $formattedLines[] = $matches[1] . \Illuminate\Support\Str::title($matches[2]) . $matches[3];
                                                        } else {
                                                            $formattedLines[] = $line;
                                                        }
                                                    }
                                                    $formattedRemarks = implode(PHP_EOL, $formattedLines);
                                                @endphp
                                                <div class="p-3 bg-light rounded italic small">
                                                    {!! $formattedRemarks !== '' ? nl2br(e($formattedRemarks)) : 'No remarks yet.' !!}
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="modal fade" id="complaintActionModal{{ $complaint->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Update Complaint #{{ $complaint->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('subadmin.update.complaint', $complaint->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4">
                                                    <label class="fw-bold mb-3 d-block">Select New Status</label>
                                                    <div class="btn-group w-100 mb-4" role="group">
                                                        <input type="radio" class="btn-check complaint-status-radio" name="status" id="res{{ $complaint->id }}" value="resolved" required>
                                                        <label class="btn btn-outline-success" for="res{{ $complaint->id }}">Resolved</label>

                                                        <input type="radio" class="btn-check complaint-status-radio" name="status" id="on{{ $complaint->id }}" value="on-going" required>
                                                        <label class="btn btn-outline-warning" for="on{{ $complaint->id }}">On-going</label>

                                                        <input type="radio" class="btn-check complaint-status-radio" name="status" id="rej{{ $complaint->id }}" value="rejected" required>
                                                        <label class="btn btn-outline-danger" for="rej{{ $complaint->id }}">Rejected</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="fw-bold mb-2">Internal Remarks</label>
                                                        <textarea name="remarks" class="form-control complaint-remarks-input" rows="4" placeholder="Select a status first, then enter resolution details..." disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary px-4 shadow">Save Update</button>
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
                    @if($complaints->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                <div class="pagination-info-text">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>
                                        Showing <span style="color: #2563eb; font-weight: 700;">{{ $complaints->firstItem() }}</span>
                                        to <span style="color: #2563eb; font-weight: 700;">{{ $complaints->lastItem() }}</span>
                                        of <span style="color: #2563eb; font-weight: 700;">{{ $complaints->total() }}</span> results
                                    </span>
                                </div>
                            </div>
                            {{ $complaints->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="bg-light m-3 p-5 text-center rounded border">
                        <p class="text-muted mb-0">No complaints records found for the current filters. Adjust the filters above or use Reset to return to all records.</p>
                    </div>
                    @endif
                    </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="requesterProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user me-2"></i>Complainant Information
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
                                <i class="fas fa-history me-2"></i>Complaint History
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
                                    <strong class="d-block small">Pending</strong>
                                    <span class="fs-6 fw-bold text-warning" id="profilePendingCount">0</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">On-going</strong>
                                    <span class="fs-6 fw-bold text-primary" id="profileOngoingCount">0</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <strong class="d-block small">Resolved</strong>
                                    <span class="fs-6 fw-bold text-success" id="profileResolvedCount">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Address</th>
                                        <th>Details</th>
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

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const actionModals = document.querySelectorAll('[id^="complaintActionModal"]');

        actionModals.forEach(function (modalEl) {
            const statusRadios = modalEl.querySelectorAll('.complaint-status-radio');
            const remarksInput = modalEl.querySelector('.complaint-remarks-input');

            if (!remarksInput || statusRadios.length === 0) return;

            const syncRemarksState = function () {
                const hasSelectedStatus = Array.from(statusRadios).some(radio => radio.checked);
                remarksInput.disabled = !hasSelectedStatus;
                if (hasSelectedStatus) {
                    remarksInput.placeholder = 'Enter resolution details...';
                } else {
                    remarksInput.placeholder = 'Select a status first, then enter resolution details...';
                }
            };

            statusRadios.forEach(function (radio) {
                radio.addEventListener('change', syncRemarksState);
            });

            modalEl.addEventListener('shown.bs.modal', syncRemarksState);
            syncRemarksState();
        });

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[data-complainant-id]');
            if (!btn) return;

            const userId = btn.getAttribute('data-complainant-id');
            const fallbackName = btn.getAttribute('data-complainant-name') || 'N/A';

            document.getElementById('profileLoading').style.display = 'block';
            document.getElementById('profileContent').style.display = 'none';
            document.getElementById('profileAgeRow').style.display = 'none';
            document.getElementById('profileSexRow').style.display = 'none';
            document.getElementById('profileRoleRow').style.display = 'none';
            document.getElementById('profileHistorySection').style.display = 'none';
            document.getElementById('profileHistoryLoading').style.display = 'none';
            document.getElementById('profileHistoryContent').style.display = 'none';
            document.getElementById('profileImageContainer').innerHTML = '<i class="fas fa-user" style="font-size: 60px; color: #adb5bd;"></i>';

            const modal = new bootstrap.Modal(document.getElementById('requesterProfileModal'));
            modal.show();

            const endpoint = "{{ route('subadmin.complaints.profile', ['userId' => '__ID__']) }}".replace('__ID__', userId);
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('profileLoading').innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
                        return;
                    }

                    document.getElementById('profileFullName').textContent = data.fullName || fallbackName;
                    document.getElementById('profileEmail').textContent = data.email || '-';
                    document.getElementById('profileContact').textContent = data.contact || '-';
                    document.getElementById('profileBirthday').textContent = data.birthday || '-';

                    if (data.profileImage) {
                        document.getElementById('profileImageContainer').innerHTML =
                            '<img src="' + data.profileImage + '" alt="Profile" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">';
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
                    document.getElementById('profileHistorySection').style.display = 'block';
                    document.getElementById('profileHistoryLoading').style.display = 'block';

                    const history = data.history || {};
                    document.getElementById('profileTotalRequests').textContent = history.total || 0;
                    document.getElementById('profilePendingCount').textContent = history.pending || 0;
                    document.getElementById('profileOngoingCount').textContent = history.on_going || 0;
                    document.getElementById('profileResolvedCount').textContent = history.resolved || 0;

                    const tbody = document.getElementById('profileHistoryTableBody');
                    tbody.innerHTML = '';
                    const rows = history.requests || [];
                    if (rows.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted small">No complaint history found</td></tr>';
                    } else {
                        rows.forEach(function (req) {
                            const statusBadge = req.status === 'resolved'
                                ? '<span class="badge bg-success">Resolved</span>'
                                : req.status === 'on-going'
                                    ? '<span class="badge bg-warning text-dark">On-going</span>'
                                    : req.status === 'rejected'
                                        ? '<span class="badge bg-danger">Rejected</span>'
                                        : '<span class="badge bg-secondary">Pending</span>';

                            const row = '<tr>' +
                                '<td class="small">' + (req.created_at || '-') + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                '<td class="small">' + (req.address || '-') + '</td>' +
                                '<td class="small">' + ((req.details || '-').length > 100 ? (req.details || '-').slice(0, 100) + '...' : (req.details || '-')) + '</td>' +
                                '</tr>';
                            tbody.innerHTML += row;
                        });
                    }

                    document.getElementById('profileHistoryLoading').style.display = 'none';
                    document.getElementById('profileHistoryContent').style.display = 'block';
                })
                .catch(() => {
                    document.getElementById('profileLoading').innerHTML = '<div class="alert alert-danger">Failed to load complainant profile.</div>';
                });
        });
    });
</script>
