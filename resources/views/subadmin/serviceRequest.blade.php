<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .card-ghost { border: 1px solid #e9ecef; border-radius: 14px; }
        .badge-status { font-size: 0.75rem; letter-spacing: 0.02em; }
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])

    <div class="main-wrapper">
        @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="container-fluid py-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div>
                        <h2 class="h4 mb-0">Service Requests</h2>
                        <p class="text-muted small mb-0">Monitor and act on borrowing requests.</p>
                    </div>
                    <a class="btn btn-outline-primary" href="{{ route('subadmin.subadminServices') }}">
                        <i class="fa fa-toolbox me-2"></i>Manage services
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card card-ghost shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-uppercase text-muted">Requests</h6>
                                    <span class="badge bg-secondary">{{ $serviceRequests->total() }} total</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Service</th>
                                                <th>Schedule</th>
                                                                                                <th>Purpose</th>

                                                <th>Status</th>
                                                <th>Requester</th>
                                                <th class="text-end">Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($serviceRequests as $request)
                                                @php
                                                    $statusColors = [
                                                        'PENDING' => 'bg-warning text-dark',
                                                        'APPROVED' => 'bg-success',
                                                        'DECLINED' => 'bg-danger',
                                                        'RETURNED' => 'bg-secondary',
                                                    ];
                                                    $scheduleText = $request->request_schedule
                                                        ? date('M d, Y', strtotime($request->request_schedule))
                                                        : 'Not set';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold">{{ $request->service->name ?? 'Removed service' }}</div>
                                                        <div class="text-muted small">Purpose: {{ $request->purpose }}</div>
                                                        <div class="text-muted small">Qty: {{ $request->quantity_requested ?? 1 }}</div>
                                                    </td>
                                                    <td class="text-muted small">{{ $scheduleText }}</td>
                                                    <td>
                                                        <span class="badge badge-status {{ $statusColors[$request->status] ?? 'bg-light text-dark' }}">{{ $request->status }}</span>
                                                    </td>
                                                    <td class="small">
                                                        {{ ($request->user->firstName ?? 'Unknown') . ' ' . ($request->user->lastName ?? '') }}
                                                    </td>
                                                    <td>
                                                        <form class="d-flex flex-column flex-lg-row gap-2 justify-content-end" method="POST" action="{{ route('subadmin.serviceRequest.status', $request) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status" class="form-select form-select-sm" aria-label="Status">
                                                                @foreach (['PENDING', 'APPROVED', 'DECLINED', 'RETURNED'] as $status)
                                                                    <option value="{{ $status }}" @selected($request->status === $status)>{{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks" value="{{ old('remarks', $request->remarks) }}">
                                                            <button class="btn btn-sm btn-primary" type="submit">Save</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No requests yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    {{ $serviceRequests->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card card-ghost shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="mb-3 text-uppercase text-muted">Add service / equipment</h6>
                                <form method="POST" action="{{ route('subadmin.services.store') }}" enctype="multipart/form-data" class="vstack gap-3">
                                    @csrf
                                    <div>
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                    </div>
                                    <div>
                                        <label class="form-label">Description</label>
                                        <textarea name="description" rows="3" class="form-control" required>{{ old('description') }}</textarea>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" min="0" name="quantity" value="{{ old('quantity', 0) }}" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Availability</label>
                                            <select name="serviceAvailability" class="form-select" required>
                                                @foreach (['AVAILABLE', 'UNAVAILABLE'] as $availability)
                                                    <option value="{{ $availability }}" @selected(old('serviceAvailability') === $availability)>{{ ucfirst(strtolower($availability)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">Image (optional)</label>
                                        <input type="file" name="image" accept="image/*" class="form-control">
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Save service</button>
                                    </div>
                                </form>
                            </div>
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

