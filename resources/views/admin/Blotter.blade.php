<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    
    <style>
        .modal-body section {
            margin-bottom: 24px;
        }
        .table-wrapper {
            margin: 0 3em;
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

        /* Modern Soft Status Badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid transparent;
}

/* Status Dot Indicator */
.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

/* Color Themes */
.status-pending {
    background-color: #fffbeb; /* Soft Yellow */
    color: #92400e;
    border-color: #fef3c7;
}
.status-pending .status-dot { background-color: #f59e0b; }

.status-ongoing {
    background-color: #eff6ff; /* Soft Blue */
    color: #1e40af;
    border-color: #dbeafe;
}
.status-ongoing .status-dot { background-color: #3b82f6; }

.status-closed {
    background-color: #f0fdf4; /* Soft Green */
    color: #166534;
    border-color: #dcfce7;
}
.status-closed .status-dot { background-color: #22c55e; }

.status-default {
    background-color: #f9fafb;
    color: #374151;
    border-color: #f3f4f6;
}
.status-default .status-dot { background-color: #9ca3af; }
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
                            <h2 class="mb-0 fw-bold" style="color:#000000;">My Blotter</h2>
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

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h5 class="mb-0 fw-semibold">Blotter List</h5>
                                <small class="text-muted">Track complainants, respondents, and current status</small>
                            </div>
                            <span class="badge bg-light text-dark px-3 py-2">{{ $blotters->total() }} total</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-uppercase small fw-semibold">Blotter No</th>
                                            <th class="text-uppercase small fw-semibold">Complainant</th>
                                            <th class="text-uppercase small fw-semibold">Respondent</th>
                                            <th class="text-uppercase small fw-semibold">Status</th>
                                            <th class="text-uppercase small fw-semibold text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($blotters as $blotter)
    @php
        $status = strtolower($blotter->current_status ?? '');
        // Determine the class based on status text
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
        <td class="fw-semibold text-dark">#{{ $blotter->id }}</td>
        <td>{{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</td>
        <td>{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
        
        <td>
            <div class="status-badge {{ $uiClass }}">
                <span class="status-dot"></span>
                {{ $blotter->current_status ?? 'N/A' }}
            </div>
        </td>

        <td class="text-end">
            <button class="btn btn-sm btn-outline-primary" style="border-radius: 6px; font-weight: 600;" 
                    type="button" data-bs-toggle="modal" data-bs-target="#updateBlotterModal" 
                    data-blotter-id="{{ $blotter->id }}">
                <i class="fa fa-pen me-1"></i> Update
            </button>
        </td>
    </tr>
@empty
    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($blotters->hasPages())
                            <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <small class="text-muted">Showing {{ $blotters->firstItem() }}-{{ $blotters->lastItem() }} of {{ $blotters->total() }}</small>
                                <div class="mb-0">{{ $blotters->links() }}</div>
                            </div>
                        @endif
                    </div>
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
                            // Reinitialize date picker if needed
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
                trigger.removeEventListener('mousedown', handleDateTrigger);
                trigger.addEventListener('mousedown', handleDateTrigger);
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

        initializeDatePickers();
    </script>
    
    @yield('scripts')
</body>
</html>
