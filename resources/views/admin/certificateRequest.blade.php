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

{{-- User/Resident Profile Modal --}}
<div class="modal fade" id="requesterProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Requester Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="profileLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="profileContent" style="display:none;">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center mb-3">
                                <div id="profileImageContainer" class="rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background-color: #f1f3f5;">
                                    <i class="fas fa-user" style="font-size: 60px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted"><strong>Full Name</strong></div>
                        <div class="col-7" id="profileFullName" style="text-transform: capitalize;">-</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted"><strong>Email</strong></div>
                        <div class="col-7" id="profileEmail">-</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted"><strong>Contact No.</strong></div>
                        <div class="col-7" id="profileContact">-</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted"><strong>Birthday</strong></div>
                        <div class="col-7" id="profileBirthday">-</div>
                    </div>

                    <div class="row mb-2" id="profileAgeRow" style="display:none;">
                        <div class="col-5 text-muted"><strong>Age</strong></div>
                        <div class="col-7" id="profileAge">-</div>
                    </div>

                    <div class="row mb-2" id="profileSexRow" style="display:none;">
                        <div class="col-5 text-muted"><strong>Sex</strong></div>
                        <div class="col-7" id="profileSex"  style="text-transform: capitalize;">-</div>
                    </div>

                    <div class="row mb-2" id="profileRoleRow" style="display:none;">
                        <div class="col-5 text-muted"><strong>Role</strong></div>
                        <div class="col-7 text-capitalize" id="profileRole">-</div>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Certificate Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailsLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="detailsContent" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">Request Information</h6>
                            <hr>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Request ID</small>
                            <p class="fw-bold" id="detailsId">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Certificate Type</small>
                            <p class="fw-bold text-capitalize" id="detailsType">-</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <small class="text-muted">Purpose Explanation</small>
                            <div class="alert alert-light border" id="detailsPurpose">-</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Status</small>
                            <p id="detailsStatus">-</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Submitted Date</small>
                            <p class="fw-bold" id="detailsDate">-</p>
                        </div>
                    </div>

                    <div class="row mb-3" id="additionalDetailsRow" style="display:none;">
    <div class="col-12">
        <h6 class="fw-bold text-primary">Form Details</h6>
        <hr>
        <div class="bg-light rounded p-3" id="detailsFormData">
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

// Requester profile modal
document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-requester-user-id]');
    if (btn) {
        var userId = btn.getAttribute('data-requester-user-id');
        var residentId = btn.getAttribute('data-requester-resident-id');
        
        document.getElementById('profileLoading').style.display = 'block';
        document.getElementById('profileContent').style.display = 'none';
        
        // Reset profile rows visibility
        document.getElementById('profileAgeRow').style.display = 'none';
        document.getElementById('profileSexRow').style.display = 'none';
        document.getElementById('profileRoleRow').style.display = 'none';
        
        var modal = new bootstrap.Modal(document.getElementById('requesterProfileModal'));
        modal.show();
        
        // Fetch requester data
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
                
                // Populate profile data
                document.getElementById('profileFullName').textContent = data.fullName;
                document.getElementById('profileEmail').textContent = data.email || '-';
                document.getElementById('profileContact').textContent = data.contact || '-';
                document.getElementById('profileBirthday').textContent = data.birthday || '-';
                
                // Update profile image
                var imgContainer = document.getElementById('profileImageContainer');
                if (data.profileImage) {
                    imgContainer.innerHTML = '<img src="' + data.profileImage + '" alt="Profile" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">';
                }
                
                // Show resident-specific fields if available
                if (data.age) {
                    document.getElementById('profileAge').textContent = data.age;
                    document.getElementById('profileAgeRow').style.display = 'flex';
                }
                
                if (data.sex) {
                    document.getElementById('profileSex').textContent = data.sex;
                    document.getElementById('profileSexRow').style.display = 'flex';
                }
                
                if (data.role) {
                    document.getElementById('profileRole').textContent = data.role;
                    document.getElementById('profileRoleRow').style.display = 'flex';
                }
                
                document.getElementById('profileLoading').style.display = 'none';
                document.getElementById('profileContent').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('profileLoading').innerHTML = '<div class="alert alert-danger">Failed to load profile information</div>';
            });
    }
});

// Request details modal
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
                
                // Populate details
                document.getElementById('detailsId').textContent = '#' + data.id;
                document.getElementById('detailsType').textContent = data.certificate_type;
                document.getElementById('detailsPurpose').textContent = data.purpose || 'No explanation provided';
                document.getElementById('detailsDate').textContent = data.created_at;
                
                // Status badge
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
                
                // Show form data if available
                // Show form data if available
if (data.request_data && Object.keys(data.request_data).length > 0) {
    document.getElementById('additionalDetailsRow').style.display = 'block';
    var detailsList = document.querySelector('#detailsFormData .data-list');
    detailsList.innerHTML = ''; // Clear previous content

    for (var key in data.request_data) {
        var value = data.request_data[key];
        
        // Skip empty or internal values if necessary
        if (value === null || value === undefined) value = '-';

        // Format the key: Replace underscores with spaces and capitalize
        var label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

        // Create a nice display row
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
