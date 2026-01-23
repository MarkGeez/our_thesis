<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    
    <style>
        .modal-body section {
            margin-bottom: 24px;
        }
        .table-wrapper {
            margin: 0 1em;
        }
        
        table th,
        table td {
            vertical-align: middle;
        }

        /* Pagination styling */
        .pagination-wrapper {
            margin: 2rem 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info {
            color: #6c757d;
            margin-right: auto;
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

        /* --- IMPROVED STATUS BADGES --- */
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

        /* Style for IDs */
        .case-number {
         
            font-size: 0.85rem;
            color: #0d6efd;
            font-weight: 600;
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
                <div class="container-fluid px-3 pb-4">
                    <div class="d-flex align-items-center flex-wrap gap-3 mb-4 blotter-header">
                        <div>
                            <p class="text-muted mb-1">Dispute records</p>
                            <h2 class="mb-0 fw-bold" style="color:#000000;">Manage Blotters</h2>
                        </div>

                        <div class="ms-auto encode-btn-wrapper">
                            <button class="btn btn-primary d-flex align-items-center shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#blotterModal">
                                <i class="fa fa-plus me-2"></i>
                                Submit Blotter
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success shadow-sm" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                     @if(session('error'))
                        <div class="alert alert-danger shadow-sm" role="alert">
                            {{ session('error') }}
                        </div>
                     @endif
                    
                    @if($blotters->isEmpty())
                        <div class="container bg-light p-3 m-3 alert alert-info">No blotter records found.</div>
                    @else
                        <div class="table-responsive table-wrapper">
                            <table class="table table-bordered table-hover bg-white shadow-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 120px;">Blotter No</th>
                                        <th>Complainant (Nagrereklamo)</th>
                                        <th>Respondent (Nirereklamo)</th>
                                        <th style="width: 150px;">Status</th>
                                        <th class="text-center" style="width: 130px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                            <td class="fw-semibold">{{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</td>
                                            <td class="fw-semibold">{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
                                            
                                            <td>
                                                <div class="status-badge {{ $uiClass }}">
                                                    <span class="status-dot"></span>
                                                    {{ $blotter->current_status ?? 'N/A' }}
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" 
                                                            type="button" data-bs-toggle="modal" data-bs-target="#viewBlotter{{ $blotter->id }}">
                                                        <i class="fa fa-eye fa-fw"></i><span>View</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary border shadow-sm d-inline-flex align-items-center gap-1" 
                                                            type="button" data-bs-toggle="modal" data-bs-target="#updateBlotterModal" 
                                                            data-blotter-id="{{ $blotter->id }}">
                                                        <i class="fa fa-pen-to-square fa-fw"></i><span>Update</span>
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
                                                                                 class="img-fluid rounded border"
                                                                                 style="max-height: 400px; object-fit: contain;">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a href="{{ Storage::url($blotter->proof) }}" 
                                                                               target="_blank" 
                                                                               class="btn btn-sm btn-outline-primary">
                                                                                <i class="fa fa-external-link-alt me-1"></i> View Full Size
                                                                            </a>
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
            // Only attach click handler to calendar icon triggers
            document.querySelectorAll('[id^="date_trigger_"]').forEach(trigger => {
                trigger.removeEventListener('click', handleDateTrigger);
                trigger.addEventListener('click', handleDateTrigger);
            });

            // Date inputs are now fully editable by typing
            // No auto-open picker behavior attached
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

        // Allow manual typing in date inputs - remove auto-open on focus/click
        // Only trigger picker when clicking the calendar icon
    </script>
    
    @yield('scripts')
</body>
</html>