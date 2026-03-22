
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">

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

        .archive-type {
            display: inline-flex;
            align-items: center;
            padding: 0.42rem 0.8rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: capitalize;
        }

        .archive-details {
            font-size: 0.85rem;
            color: #374151;
            line-height: 1.5;
        }

        .archive-details .key {
            font-weight: 700;
            color: #1f2937;
        }

        .archive-actions {
            display: flex;
            gap: 0.45rem;
            flex-wrap: wrap;
        }

        .resident-name-cell {
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
        }

        .modal-details-row {
            border-bottom: 1px solid #f1f5f9;
            padding: 0.55rem 0;
        }

        .modal-details-row:last-child {
            border-bottom: none;
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
                <!--Dito lalagay main content-->
    <div class="main-container">
        <div class="welcome-card">
            <h3>Archived records</h3>
        </div>

        <div class="records-container">
            @if($archive->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Archived Type</th>
                                <th scope="col">Resident Name</th>
                                <th scope="col">Archived By</th>
                                <th scope="col">Archived Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archive as $item)
                            @php
                                $residentName = null;

                                if ($item->record_type === 'resident' && is_array($item->data)) {
                                    $firstName = trim((string) ($item->data['firstName'] ?? ''));
                                    $middleName = trim((string) ($item->data['middleName'] ?? ''));
                                    $lastName = trim((string) ($item->data['lastName'] ?? ''));

                                    $residentName = trim(collect([$firstName, $middleName, $lastName])->filter()->implode(' '));
                                    $residentName = $residentName !== '' ? ucwords(strtolower($residentName)) : null;
                                }
                            @endphp
                            <tr>
                                <td>
                                    <span class="archive-type">{{ ucfirst($item->record_type) }}</span>
                                </td>
                                <td class="resident-name-cell">
                                    @if($item->record_type === 'resident')
                                        {{ $residentName ?? 'N/A' }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->user
                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                        : 'Unknown'
                                    }}
                                </td>

                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <div class="archive-actions">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#archiveDetailsModal{{ $item->id }}"
                                        >
                                            <i class="fa fa-eye"></i> View Details
                                        </button>

                                        @if($item->record_type === 'resident')
                                            <form action="{{ route('admin.archive.retrieve.resident', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Retrieve this archived resident? It will be restored to the active residents table.')">
                                                    <i class="fa fa-undo"></i> Retrieve
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="archiveDetailsModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Archived {{ ucfirst($item->record_type) }} Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if(is_array($item->data) && count($item->data) > 0)
                                                <div class="archive-details">
                                                    @foreach($item->data as $key => $value)
                                                        <div class="modal-details-row">
                                                            <span class="key">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}:</span>
                                                            {{ is_array($value) ? json_encode($value) : ($value !== null && $value !== '' ? $value : 'N/A') }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">No details available.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($archive->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-wrapper">
                            <div class="pagination-info-text">
                                <i class="fa-solid fa-list-check"></i>
                                <span>
                                    Showing <strong>{{ $archive->firstItem() }}</strong>
                                    to <strong>{{ $archive->lastItem() }}</strong>
                                    of <strong>{{ $archive->total() }}</strong> results
                                </span>
                            </div>
                            {{ $archive->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @else
                <div class="p-5 text-center">
                    <p class="text-muted mb-0">No archived records found.</p>
                </div>
            @endif
        </div>
</main>

</div>
</div> 
@include('admin.create-announcement')


<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

