<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">


</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="container mt-4">
                <h2 class="mb-4"><i class="fas fa-file-lines"></i> My Certificate Requests</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @include('components.certificateForms', ['formRoute' => 'admin.certificate.request.store'])

                <h5 class="mb-3">My Recent Requests</h5>
                @if($requests->isEmpty())
                    <div class="alert alert-info shadow-sm">You have not submitted any certificate requests yet.</div>
                                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white shadow-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th>Certificate Type</th>
                                    <th>Purpose</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Approved/Rejected By</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                    <tr>
                                        <td><span class="">{{ ucfirst($req->certificate_type) }}</span></td>
                                        <td>{{ Str::limit($req->purpose, 50) }}</td>
                                        <td><small>{{ $req->address ?? '—' }}</small></td>
                                        <td>
                                            @switch($req->status)
                                                @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                                                @case('approved') <span class="badge bg-success">Approved</span> @break
                                                @case('picked_up') <span class="badge bg-secondary">Picked up</span> @break
                                                @case('declined') <span class="badge bg-danger">Declined</span> @break
                                                @default <span class="badge bg-secondary">{{ $req->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($req->approver)
                                                <small>{{ ucwords(strtolower($req->approver->firstName . ' ' . $req->approver->lastName)) }}</small>
                                                <br>
                                                <small class="text-muted">{{ $req->approved_at?->format('M d, Y H:i') ?? '-' }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($req->status === 'approved')
                                                <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i>Ready for pickup. Go to the admin's house.</span>
                                            @elseif($req->status === 'picked_up')
                                                <span class="text-success small fw-bold"><i class="fas fa-check-double me-1"></i>Successfully picked up.</span>
                                            @elseif($req->status === 'declined' && $req->decline_reason)
                                                <span class="text-muted small">{{ $req->decline_reason }}</span>
                                            @else — @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
