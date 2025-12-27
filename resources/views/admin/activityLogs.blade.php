<head>
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
            <div class="main-container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 style="color:#000000; margin: 20px 45px;">Activity Logs</h2>
                </div>

                @if (session('success'))
                    <div class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm"
                         style="max-width: 325px; box-shadow: 0 4px 12px rgb(5, 94, 12);">
                        <h6>{{ session('success') }}</h6>
                    </div>
                @endif

                @if($logs->count() > 0)
                    <div class="table-responsive" style="margin: 0 3em;">
                        <table class="table table-bordered table-striped-row table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>Record ID</th>
                                    <th>When</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>
                                            @php
                                                $u = $log->user;
                                                $full = $u ? trim(($u->firstName ?? '').' '.($u->lastName ?? '')) : '';
                                            @endphp
                                            {{ $full !== '' ? ucwords($full) : ucwords($u->name ?? 'N/A') }}
                                        </td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ ucfirst($log->module) }}</td>
                                        
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->record_id ?? '—' }}</td>
                                        <td>{{ $log->created_at->format('M-d-Y g:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No activity logs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-light m-3 p-3 shadowed">
                        <p class="ms-5 mt-3">No activity logs found.</p>
                    </div>
                @endif

                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </main>
    </div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
