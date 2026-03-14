<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>
<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])
    <div class="main-wrapper">
        @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])
        <main class="main users chart-page" id="skip-target">
            <div class="container mt-4">
                <h2 class="mb-4"><i class="fas fa-certificate"></i> Certificate Requests</h2>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card shadow-sm mb-4">
                    <div class="card-header"><strong>Request a Certificate</strong></div>
                    <div class="card-body">
                        <form action="{{ route('subadmin.certificate.request.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Certificate Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="certificate_type" required>
                                        <option value="">Select type...</option>
                                        <option value="bonafide" {{ old('certificate_type') === 'bonafide' ? 'selected' : '' }}>Bonafide</option>
                                        <option value="indigency" {{ old('certificate_type') === 'indigency' ? 'selected' : '' }}>Indigency</option>
                                        <option value="soloparent" {{ old('certificate_type') === 'soloparent' ? 'selected' : '' }}>Solo Parent</option>
                                        <option value="senior" {{ old('certificate_type') === 'senior' ? 'selected' : '' }}>Senior Citizen</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Purpose <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="purpose" value="{{ old('purpose') }}" placeholder="e.g. Employment" required maxlength="500">
                                </div>
                                @php $res = $subadmin->resident ?? null; @endphp
                                @if(!$res)
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Your full address" maxlength="255">
                                </div>
                                @endif
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h5 class="mb-3">My Certificate Requests</h5>
                @if($requests->isEmpty())
                    <div class="alert alert-info">You have not submitted any certificate requests yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white">
                            <thead class="table-primary">
                                <tr><th>Certificate Type</th><th>Purpose</th><th>Status</th><th>Date</th><th>Remarks</th></tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                <tr>
                                    <td><span class="badge bg-info">{{ ucfirst($req->certificate_type) }}</span></td>
                                    <td>{{ Str::limit($req->purpose, 50) }}</td>
                                    <td>
                                        @switch($req->status)
                                            @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                                            @case('approved') <span class="badge bg-success">Approved</span> @break
                                            @case('picked_up') <span class="badge bg-secondary">Received</span> @break
                                            @case('declined') <span class="badge bg-danger">Declined</span> @break
                                            @default <span class="badge bg-secondary">{{ $req->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $req->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($req->status === 'approved' || $req->status === 'picked_up')
                                            <span class="text-success fw-bold"><i class="fas fa-map-marker-alt me-1"></i>You can now go to the admin's house for pickup.</span>
                                        @elseif($req->status === 'declined' && $req->decline_reason)
                                            <span class="text-muted">{{ $req->decline_reason }}</span>
                                        @else — @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($requests->hasPages())
                        <div style="padding: 18px 22px 22px 22px; background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%); border-top: 2px solid #e2e8f0; margin-top: 0;">
                            <div style="display: flex; flex-direction: column; gap: 12px; align-items: center; margin: 0;">
                                <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; justify-content: center; color: #64748b; font-size: 0.9rem;">
                                    <div style="display: flex; align-items: center; gap: 0.55rem; background: #fff; padding: 0.6rem 1rem; border-radius: 10px; border: 2px solid #e2e8f0; font-weight: 600;">
                                        <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                                        <span>
                                            Showing <span style="color: #2563eb; font-weight: 700; font-size: 1.05rem;">{{ $requests->firstItem() }}</span>
                                            to <span style="color: #2563eb; font-weight: 700; font-size: 1.05rem;">{{ $requests->lastItem() }}</span>
                                            of <span style="color: #2563eb; font-weight: 700; font-size: 1.05rem;">{{ $requests->total() }}</span> results
                                        </span>
                                    </div>
                                </div>
                                {{ $requests->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                
                @endif
            </div>
        </main>
    </div>
</div>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
