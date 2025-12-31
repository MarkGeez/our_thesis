<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .card-ghost { border: 1px solid #e9ecef; border-radius: 14px; }
        .service-img { width: 56px; height: 56px; object-fit: cover; border-radius: 10px; }
        .badge-status { font-size: 0.75rem; letter-spacing: 0.02em; }
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="container-fluid py-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <h2 class="h4 mb-0">Services & Equipment</h2>
                        <p class="text-muted small mb-0">Request items and manage the catalog.</p>
                    </div>
                    <a class="btn btn-outline-primary" href="{{ route('admin.serviceRequest') }}">
                        <i class="fa fa-inbox me-2"></i>Review requests
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
                    <div class="col-xl-5">
                        <div class="card card-ghost shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-3">Submit a request</h6>
                                <form method="POST" action="{{ route('admin.service.request.store') }}" class="vstack gap-3">
                                    @csrf
                                    <div>
                                        <label class="form-label">Service / equipment</label>
                                        <select name="service_type_id" class="form-select" required>
                                            <option value="" disabled selected>Select an item</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}" @disabled(strtoupper($service->serviceAvailability) !== 'AVAILABLE')>
                                                    {{ $service->name }} — {{ ucfirst(strtolower($service->serviceAvailability)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" min="1" name="quantity_requested" value="{{ old('quantity_requested', 1) }}" class="form-control" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Schedule date</label>
                                            <input type="date" name="request_schedule" value="{{ old('request_schedule') }}" class="form-control" min="{{ now()->toDateString() }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">Purpose</label>
                                        <textarea name="purpose" rows="2" class="form-control" required>{{ old('purpose') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label">Notes (optional)</label>
                                        <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control" placeholder="Anything to note?">
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Submit request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-xl-7">
                        <div class="card card-ghost shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-uppercase text-muted mb-0">Available services</h6>
                                    <span class="badge bg-secondary">{{ $services->count() }} items</span>
                                </div>
                                <div class="vstack gap-3">
                                    @forelse ($services as $service)
                                        <div class="d-flex align-items-start gap-3 border rounded-3 p-3">
                                            @if ($service->image_path)
                                                <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="service-img">
                                            @else
                                                <div class="service-img d-inline-flex align-items-center justify-content-center bg-light text-secondary">
                                                    <i class="fa fa-box"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="fw-semibold">{{ $service->name }}</div>
                                                        <div class="text-muted small">{{ $service->description }}</div>
                                                    </div>
                                                    @php
                                                        $availability = strtoupper($service->serviceAvailability);
                                                        $badgeClass = $availability === 'AVAILABLE' ? 'bg-success' : ($availability === 'BORROWED' ? 'bg-warning text-dark' : 'bg-secondary');
                                                    @endphp
                                                    <span class="badge badge-status {{ $badgeClass }}">{{ ucfirst(strtolower($service->serviceAvailability)) }}</span>
                                                </div>
                                                <div class="text-muted small">Quantity available: {{ $service->quantity ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted small">No services available right now.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="card card-ghost shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-uppercase text-muted mb-0">My requests</h6>
                                    <span class="badge bg-secondary">{{ $requests->count() }} total</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Service</th>
                                                <th>Schedule</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($requests as $request)
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
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">No requests yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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

