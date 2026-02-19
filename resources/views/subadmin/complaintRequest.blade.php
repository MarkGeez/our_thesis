<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
        <div class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm" style="max-width: 325px;">
            <h6>{{ session('success') }}</h6>
        </div>
        @endif

        @if($complaints->count() > 0)
        <div class="complaints-table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 shadow-sm bg-white">
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

                    <tbody class="align-middle">
                        @foreach ($complaints as $complaint)
                        <tr>
                            <td class="text-center fw-bold">{{ $complaint->id }}</td>
                            <td>
                                <span class="fw-semibold">{{ ucwords(str_replace(',', '', $complaint->complainantName)) }}</span>
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
                                    <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#complaintActionModal{{ $complaint->id }}">
                                        Manage
                                    </button>
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
                                                <p class="fw-bold">{{ ucwords(str_replace(',', '', $complaint->complainantName)) }}</p>
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
                                        <div class="p-3 bg-light rounded italic small">
                                            {!! $complaint->remarks ? nl2br(e($complaint->remarks)) : 'No remarks yet.' !!}
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
                                                <input type="radio" class="btn-check" name="status" id="res{{ $complaint->id }}" value="resolved" {{ $complaint->status == 'resolved' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success" for="res{{ $complaint->id }}">Resolved</label>

                                                <input type="radio" class="btn-check" name="status" id="on{{ $complaint->id }}" value="on-going" {{ $complaint->status == 'on-going' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning" for="on{{ $complaint->id }}">On-going</label>

                                                <input type="radio" class="btn-check" name="status" id="rej{{ $complaint->id }}" value="rejected" {{ $complaint->status == 'rejected' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="rej{{ $complaint->id }}">Rejected</label>
                                            </div>

                                            <div class="form-group">
                                                <label class="fw-bold mb-2">Internal Remarks</label>
                                                <textarea name="remarks" class="form-control" rows="4" placeholder="Enter resolution details...">{{ old('remarks', $complaint->remarks) }}</textarea>
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
            <p class="text-muted mb-0">No complaints records found.</p>
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
