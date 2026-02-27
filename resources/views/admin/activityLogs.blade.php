<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        .main.users.chart-page {
            background-color: var(--light-bg);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
            color: #000;
            border-radius: 15px;
            padding: 30px;
            margin: 20px;
        }

        .welcome-card h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
            font-family: "Oswald", sans-serif;
        }

        .records-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 0 1rem;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 1rem;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .table thead th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            color: var(--text-primary) !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border: none !important;
            white-space: nowrap;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .badge-pill-soft {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .badge-module {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .badge-action {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0c4a6e;
        }

        .description-cell {
            max-width: 320px;
            white-space: normal;
            word-break: break-word;
        }

        .pagination-container {
            padding: 18px 22px 22px 22px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
            border-top: 2px solid var(--border-color);
        }

        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
            margin: 0;
        }

        .pagination-info-text {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            background: #fff;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            border: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .pagination-info-text i {
            color: var(--primary-color);
        }
    </style>

</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">  
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="main-container">
                <div class="welcome-card">
                    <h3>Activity Logs Management</h3>
                </div>

                @if (session('success'))
                    <div class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm"
                         style="max-width: 325px; box-shadow: 0 4px 12px rgb(5, 94, 12);">
                        <h6>{{ session('success') }}</h6>
                    </div>
                @endif

                <div class="records-container">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Module</th>
                                        <th>Action</th>
                                        <th>Description</th>
                                        <th>Record ID</th>
                                        <th>Time Logged</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $logs->total() - (($logs->currentPage() - 1) * $logs->perPage() + $loop->index) }}</td>
                                            <td>
                                                @php
                                                    $u = $log->user;
                                                    $full = $u ? trim(($u->firstName ?? '').' '.($u->lastName ?? '')) : '';
                                                @endphp
                                                {{ $full !== '' ? ucwords($full) : ucwords($u->name ?? 'N/A') }}
                                            </td>
                                            <td>
                                                <span class="badge-pill-soft badge-module">{{ ucfirst($log->module) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge-pill-soft badge-action">{{ ucwords(strtolower($log->action)) }}</span>
                                            </td>
                                            <td class="description-cell">{{ $log->resolved_description ?? $log->description }}</td>
                                            <td>{{ $log->record_id ?? '-' }}</td>
                                            <td>{{ $log->created_at->format('M d, Y g:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No activity logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($logs->hasPages())
                            <div class="pagination-container">
                                <div class="pagination-wrapper">
                                    <div class="pagination-info-text">
                                        <i class="fa-solid fa-list-check"></i>
                                        <span>
                                            Showing <strong>{{ $logs->firstItem() }}</strong>
                                            to <strong>{{ $logs->lastItem() }}</strong>
                                            of <strong>{{ $logs->total() }}</strong> results
                                        </span>
                                    </div>
                                    {{ $logs->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-5 text-center">
                            <p class="text-muted mb-0">No activity logs found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
