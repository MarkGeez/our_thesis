<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Officials</title>
    
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .official-page-title {
            font-family: 'Orbitron', sans-serif;
            color: #1e293b;
            letter-spacing: 2px;
            border-left: 5px solid #0d6efd;
            padding-left: 15px;
        }
    </style>
</head>
<body>
<div class="layer"></div>
<div class="page-flex">   
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])
        
        <main class="main users chart-page" id="skip-target">
            <div class="container-fluid p-4">
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>We could not save that change.</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex align-items-center mb-3 px-3 blotter-header">
                    <h2 class="mb-0" style="color:#000000;">Barangay Officials</h2>
                    <button
                        type="button"
                        class="btn btn-outline-primary ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#officialHistoryModal"
                    >
                        <i class="fa fa-clock-rotate-left me-1"></i> View Officials History
                    </button>
                </div>

                {{-- Render static slots with assignment controls --}}
                @include('components.officials', [
                    'positions' => $positions,
                    'officialsByPosition' => $officialsByPosition,
                    'residents' => $residents,
                ])

                <div class="modal fade" id="officialHistoryModal" tabindex="-1" aria-labelledby="officialHistoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="officialHistoryModalLabel">Officials History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="GET" action="{{ route('admin.barangayOfficials') }}" class="row g-2 align-items-end mb-3">
                                    <div class="col-sm-6 col-md-4">
                                        <label for="historyYear" class="form-label mb-1">Year</label>
                                        <select id="historyYear" name="year" class="form-select">
                                            @foreach(($historyYears ?? collect([now()->year])) as $year)
                                                <option value="{{ $year }}" {{ (int)($selectedYear ?? now()->year) === (int)$year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">Filter Year</button>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Position</th>
                                                <th>Official Name</th>
                                                <th>Term Start</th>
                                                <th>Term End</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                                <th>Logged At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(($historyRows ?? collect()) as $row)
                                                <tr>
                                                    <td>{{ $row->position }}</td>
                                                    <td>
                                                        @if($row->resident)
                                                            {{ ucwords(strtolower($row->resident->firstName . ' ' . $row->resident->lastName)) }}
                                                        @else
                                                            <span class="text-muted">Unknown / Deleted Resident</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $row->start ? \Carbon\Carbon::parse($row->start)->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $row->end ? \Carbon\Carbon::parse($row->end)->format('M d, Y') : '-' }}</td>
                                                    <td>{{ $row->details ?: '-' }}</td>
                                                    <td class="text-capitalize">{{ $row->action }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('M d, Y h:i A') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">No history records for {{ $selectedYear ?? now()->year }}.</td>
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

<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@if(request()->has('year'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var historyModal = new bootstrap.Modal(document.getElementById('officialHistoryModal'));
        historyModal.show();
    });
</script>
@endif
</body>
</html>
