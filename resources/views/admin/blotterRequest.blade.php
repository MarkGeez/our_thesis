<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .table-wrapper {
            margin: 0 3em;
        }

        table th,
        table td {
            vertical-align: middle;
        }

        .badge-status {
            padding: 6px 10px;
            font-size: 12px;
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
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
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
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .edit-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1f2937;
            margin: 20px 0 12px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #f3f4f6;
        }

        @media (max-width: 576px) {
            .blotter-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .blotter-header h2 {
                margin-bottom: 0;
            }

            .blotter-header .encode-btn-wrapper {
                width: 100%;
            }

            .blotter-header .encode-btn-wrapper button {
                width: 100%;
            }
        }

        /* Pagination styling */
        .pagination-wrapper {
            margin: 2rem 3em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info {
            color: #6c757d;
            margin-right: auto;
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
                <div class="d-flex align-items-center mb-3 px-3 blotter-header">
                    <h2 class="mb-0" style="color:#000000;">Blotter Requests</h2>
                    <div class="ms-auto encode-btn-wrapper me-4">
                        @include('forms.blotter', [
                            'plaintiff' => view('forms.unhidden')->render(),
                            'button' => '<i class="fa fa-plus me-1"></i> Encode blotter'
                        ])
                    </div>
                </div>

                @if($blotters->isEmpty())
                    <div class="container bg-light p-3 m-3 alert alert-info">No blotter requests found.</div>
                @else
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Submitted By</th>
                                    <th>Defendant</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Proof</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blotters as $blotter)
                                    <tr>
                                        <td>{{ $blotter->id }}</td>
                                        <td>{{ $blotter->user->firstName ?? '' }} {{ $blotter->user->lastName ?? '' }}</td>
                                        <td>{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
                                        <td>{{ Str::limit($blotter->blotterDescription, 50) }}</td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'CLOSED'    => 'danger',
                                                    'SCHEDULED' => 'primary',
                                                    'RESOLVED'  => 'success',
                                                    'PENDING'   => 'warning text-dark',
                                                ];
                                                $statusClass = $statusClasses[strtoupper($blotter->status)] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-status bg-{{ $statusClass }}">
                                                {{ ucfirst(strtolower($blotter->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($blotter->proof)
                                                <a href="{{ asset('storage/'.$blotter->proof) }}" target="_blank">
                                                    <i class="fa fa-file"></i> View
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $blotter->created_at->format('M d, Y') }}</td>
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                                <button class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#viewBlotter{{ $blotter->id }}">
                                                    <i class="fa fa-eye fa-fw"></i><span>View</span>
                                                </button>
                                                <button class="btn btn-sm btn-secondary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#updateBlotter{{ $blotter->id }}">
                                                    <i class="fa fa-edit fa-fw"></i><span>Edit</span>
                                                </button>
                                                <button class="btn btn-sm btn-info d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#statusBlotter{{ $blotter->id }}">
                                                    <i class="fa fa-flag fa-fw"></i><span>Status</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- View Modal --}}
                                    <div class="modal fade" id="viewBlotter{{ $blotter->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Blotter Details #{{ $blotter->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <section>
                                                        <h6>Defendant Information</h6>
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
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @include('forms.update')
                                    @include('forms.status')
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($blotters->hasPages())
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                Showing {{ $blotters->firstItem() }} to {{ $blotters->lastItem() }} of {{ $blotters->total() }} results
                            </div>
                            {{ $blotters->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @endif
            </div>
        </main>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modalEl = null;

            @if(old('updateBlotterId'))
                modalEl = document.getElementById('updateBlotter{{ old('updateBlotterId') }}');
            @elseif(old('statusBlotterId'))
                modalEl = document.getElementById('statusBlotter{{ old('statusBlotterId') }}');
            @endif

            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        });
    </script>
@endif

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>