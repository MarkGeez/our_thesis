<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .modal-content .form-control, .modal-content .form-select { border: 2px solid #dddddd !important; border-radius: 6px; }
        .action-btns .btn { display: inline-flex; align-items: center; gap: 5px; }
        #certificatePreviewModal .modal-dialog { max-width: 900px; }
        #certificatePreviewModal iframe { width: 100%; height: 85vh; border: none; }
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
                <h2 class="mb-4"><i class="fas fa-certificate"></i> Certificate Requests</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-3"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <ul class="nav nav-tabs mb-3" id="certTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">Approved</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="declined-tab" data-bs-toggle="tab" data-bs-target="#declined" type="button" role="tab">Declined</button>
                    </li>
                </ul>

                <div class="tab-content" id="certTabContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $requests, 'requestStats' => $requestStats ?? collect()])
                    </div>
                    <div class="tab-pane fade" id="pending" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $requests->where('status', 'pending'), 'requestStats' => $requestStats ?? collect()])
                    </div>
                    <div class="tab-pane fade" id="approved" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $requests->whereIn('status', ['approved', 'picked_up']), 'requestStats' => $requestStats ?? collect()])
                    </div>
                    <div class="tab-pane fade" id="declined" role="tabpanel">
                        @include('admin.partials.certificate-requests-table', ['filteredRequests' => $requests->where('status', 'declined'), 'requestStats' => $requestStats ?? collect()])
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Reject modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Certificate Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Are you sure you want to reject this certificate request?</p>
                    <label class="form-label">Reason (optional)</label>
                    <textarea class="form-control" name="decline_reason" rows="3" placeholder="Optional reason for declining..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Certificate preview modal (within main file) --}}
<div class="modal fade" id="certificatePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Certificate Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="certificatePreviewFrame" title="Certificate Preview"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="certificatePrintBtn" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print (use data from preview)
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Decline reason modal --}}
<div class="modal fade" id="declineReasonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Decline Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="declineReasonText" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Request history modal --}}
<div class="modal fade" id="requestHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Certificate Request History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="historyLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="historyContent" style="display:none;">
                    <div class="alert alert-info mb-3">
                        <strong>Total Requests:</strong> <span id="totalRequests">0</span> |
                        <strong>Approved:</strong> <span id="approvedCount">0</span> |
                        <strong>Declined:</strong> <span id="declinedCount">0</span> |
                        <strong>Pending:</strong> <span id="pendingCount">0</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Certificate Type</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                            </tbody>
                        </table>
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

// Decline reason modal content
document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-bs-target="#declineReasonModal"][data-reason]');
    if (btn) {
        var reason = btn.getAttribute('data-reason') || 'No reason provided.';
        document.getElementById('declineReasonText').textContent = reason;
    }
});

// Request history modal
document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-history-user-id]');
    if (btn) {
        var userId = btn.getAttribute('data-history-user-id');
        document.getElementById('historyLoading').style.display = 'block';
        document.getElementById('historyContent').style.display = 'none';
        
        var modal = new bootstrap.Modal(document.getElementById('requestHistoryModal'));
        modal.show();
        
        fetch('{{ route("admin.certificate.history", ["userId" => "__USERID__"]) }}'.replace('__USERID__', userId))
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalRequests').textContent = data.total;
                document.getElementById('approvedCount').textContent = data.approved;
                document.getElementById('declinedCount').textContent = data.declined;
                document.getElementById('pendingCount').textContent = data.pending;
                
                var tbody = document.getElementById('historyTableBody');
                tbody.innerHTML = '';
                
                if (data.requests.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center">No request history found</td></tr>';
                } else {
                    data.requests.forEach(function(req) {
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
                            '<td>' + req.created_at + '</td>' +
                            '<td><span>' + req.certificate_type + '</span></td>' +
                            '<td>' + req.purpose + '</td>' +
                            '<td>' + statusBadge + '</td>' +
                            '</tr>';
                        tbody.innerHTML += row;
                    });
                }
                
                document.getElementById('historyLoading').style.display = 'none';
                document.getElementById('historyContent').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('historyLoading').innerHTML = '<div class="alert alert-danger">Failed to load history</div>';
            });
    }
});
</script>
