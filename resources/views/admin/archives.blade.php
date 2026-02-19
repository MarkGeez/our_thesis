
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .table-filter-bar {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
            padding: 1rem 1rem 0 1rem;
        }

        .table-filter-bar .form-control,
        .table-filter-bar .form-select {
            max-width: 240px;
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
                <form method="GET" action="{{ route('admin.archives') }}" class="table-filter-bar">
                    <input type="text" name="search" class="form-control" placeholder="Search records..." value="{{ request('search') }}">
                    <select name="sort" class="form-select">
                        <option value="date_desc" {{ request('sort', 'date_desc') === 'date_desc' ? 'selected' : '' }}>Date: Newest First</option>
                        <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Date: Oldest First</option>
                        <option value="type_asc" {{ request('sort') === 'type_asc' ? 'selected' : '' }}>Type: A-Z</option>
                        <option value="type_desc" {{ request('sort') === 'type_desc' ? 'selected' : '' }}>Type: Z-A</option>
                        <option value="archived_by_asc" {{ request('sort') === 'archived_by_asc' ? 'selected' : '' }}>Archived By: A-Z</option>
                        <option value="archived_by_desc" {{ request('sort') === 'archived_by_desc' ? 'selected' : '' }}>Archived By: Z-A</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="{{ route('admin.archives') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
                <div class="table-responsive">
                    <table id="archivesTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Archived Type</th>
                                <th scope="col">Archived By</th>
                                <th scope="col">Archived Date</th>
                                <th scope="col">Original Record Details</th>
                            </tr>
                        </thead>
                        <tbody id="archivesTableBody">
                            @foreach($archive as $item)
                            <tr>
                                <td>
                                    <span class="archive-type">{{ ucfirst($item->record_type) }}</span>
                                </td>
                                <td>
                                    {{ $item->user
                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                        : 'Unknown'
                                    }}
                                </td>

                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    @if(is_array($item->data) && count($item->data) > 0)
                                        <div class="archive-details">
                                            @foreach($item->data as $key => $value)
                                                <div><span class="key">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}:</span> {{ is_array($value) ? json_encode($value) : $value }}</div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No details available</span>
                                    @endif
                                </td>
                            </tr>
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
