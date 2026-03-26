
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
            align-items: center;
        }

        .archive-actions form {
            margin: 0;
            display: inline-flex;
            align-items: center;
        }

        .archive-actions .btn {
            min-height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .archive-tabs {
            padding: 1rem 1rem 0 1rem;
            border-bottom: 1px solid var(--border-color);
            background: #fff;
        }

        .archive-tabs .nav-link {
            border: none;
            color: var(--text-secondary);
            font-weight: 700;
            border-radius: 10px 10px 0 0;
            padding: 0.75rem 1rem;
        }

        .archive-tabs .nav-link.active {
            color: var(--primary-color);
            background: #eff6ff;
            border-bottom: 2px solid var(--primary-color);
        }

        .tab-empty-state {
            padding: 2.5rem 1rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .archive-filter-bar {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            background: #f8fafc;
        }

        .archive-filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .archive-search-group {
            flex: 1 1 360px;
            min-width: 260px;
        }

        .archive-search-group .input-group-text {
            background: #fff;
            border-right: 0;
        }

        .archive-search-group .form-control {
            border-left: 0;
        }

        .archive-search-group .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .archive-filter-controls {
            display: flex;
            gap: 0.55rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .archive-filter-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.45px;
            margin-right: 0.1rem;
        }

        .archive-filter-select {
            min-width: 180px;
            height: 32px;
            font-size: 0.85rem;
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

        @if (session('success'))
            <div class="alert alert-success m-3" role="alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger m-3" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger m-3" role="alert">
                <div class="fw-bold mb-2">Something went wrong:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $rolePrefix = auth()->user()->role === 'subadmin' ? 'subadmin' : 'admin';
            $activeTab = request()->query('tab', 'residents');
            $activeSort = request()->query('sort', 'date_desc');
            if (!in_array($activeTab, ['residents', 'certificates', 'announcements', 'activity_logs'], true)) {
                $activeTab = 'residents';
            }

            $residentArchives = $archive->filter(function ($item) {
                return in_array(strtolower((string) $item->record_type), ['resident', 'residents'], true);
            })->values();

            $certificateArchives = $archive->filter(function ($item) {
                return in_array(strtolower((string) $item->record_type), ['certificate_request', 'certificate_requests'], true);
            })->values();

            $announcementArchives = $archive->filter(function ($item) {
                return in_array(strtolower((string) $item->record_type), ['announcement', 'announcements'], true);
            })->values();

            $activityLogArchives = $archive->filter(function ($item) {
                return in_array(strtolower((string) $item->record_type), ['active_log', 'active_logs', 'activity_log', 'activity_logs'], true);
            })->values();

            $certificateResidentIds = $certificateArchives
                ->pluck('data')
                ->filter(fn ($data) => is_array($data) && !empty($data['resident_id']))
                ->map(fn ($data) => (int) $data['resident_id'])
                ->unique()
                ->values();

            $certificateUserIds = $certificateArchives
                ->pluck('data')
                ->filter(fn ($data) => is_array($data) && !empty($data['user_id']))
                ->map(fn ($data) => (int) $data['user_id'])
                ->unique()
                ->values();

            $residentNameById = \App\Models\Resident::query()
                ->when($certificateResidentIds->isNotEmpty(), fn ($query) => $query->whereIn('id', $certificateResidentIds))
                ->get(['id', 'firstName', 'middleName', 'lastName'])
                ->mapWithKeys(function ($resident) {
                    $fullName = trim(collect([$resident->firstName, $resident->middleName, $resident->lastName])->filter()->implode(' '));
                    return [$resident->id => ($fullName !== '' ? ucwords(strtolower($fullName)) : 'N/A')];
                });

            $userNameById = \App\Models\User::query()
                ->when($certificateUserIds->isNotEmpty(), fn ($query) => $query->whereIn('id', $certificateUserIds))
                ->get(['id', 'firstName', 'middleName', 'lastName'])
                ->mapWithKeys(function ($user) {
                    $fullName = trim(collect([$user->firstName, $user->middleName, $user->lastName])->filter()->implode(' '));
                    return [$user->id => ($fullName !== '' ? ucwords(strtolower($fullName)) : 'N/A')];
                });

            $activityUserIds = $activityLogArchives
                ->pluck('data')
                ->filter(fn ($data) => is_array($data) && !empty($data['user_id']))
                ->map(fn ($data) => (int) $data['user_id'])
                ->unique()
                ->values();

            $activityUserNameById = \App\Models\User::query()
                ->when($activityUserIds->isNotEmpty(), fn ($query) => $query->whereIn('id', $activityUserIds))
                ->get(['id', 'firstName', 'middleName', 'lastName'])
                ->mapWithKeys(function ($user) {
                    $fullName = trim(collect([$user->firstName, $user->middleName, $user->lastName])->filter()->implode(' '));
                    return [$user->id => ($fullName !== '' ? ucwords(strtolower($fullName)) : 'N/A')];
                });
        @endphp

        <div class="records-container">
            @if($archive->count() > 0)
                <div class="archive-tabs">
                    <ul class="nav nav-tabs" id="archiveTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'residents' ? 'active' : '' }}" id="residents-tab" data-bs-toggle="tab" data-bs-target="#residents-pane" type="button" role="tab" aria-controls="residents-pane" aria-selected="{{ $activeTab === 'residents' ? 'true' : 'false' }}">
                                Residents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'certificates' ? 'active' : '' }}" id="certificates-tab" data-bs-toggle="tab" data-bs-target="#certificates-pane" type="button" role="tab" aria-controls="certificates-pane" aria-selected="{{ $activeTab === 'certificates' ? 'true' : 'false' }}">
                                Certificates
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'announcements' ? 'active' : '' }}" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-pane" type="button" role="tab" aria-controls="announcements-pane" aria-selected="{{ $activeTab === 'announcements' ? 'true' : 'false' }}">
                                Announcements
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'activity_logs' ? 'active' : '' }}" id="activity-logs-tab" data-bs-toggle="tab" data-bs-target="#activity-logs-pane" type="button" role="tab" aria-controls="activity-logs-pane" aria-selected="{{ $activeTab === 'activity_logs' ? 'true' : 'false' }}">
                                Activity Logs
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="archiveTabsContent">
                    <div class="tab-pane fade {{ $activeTab === 'residents' ? 'show active' : '' }}" id="residents-pane" role="tabpanel" aria-labelledby="residents-tab" tabindex="0">
                        <div class="archive-filter-bar">
                            <form method="GET" action="{{ route($rolePrefix . '.archives') }}" class="archive-filter-form">
                                <input type="hidden" name="tab" value="residents">
                                <div class="input-group input-group-sm archive-search-group">
                                    <span class="input-group-text text-muted"><i class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search residents, archived by, or details..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                                <div class="archive-filter-controls">
                                    <span class="archive-filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm archive-filter-select" onchange="this.form.submit()">
                                        <option value="date_desc" {{ $activeSort === 'date_desc' ? 'selected' : '' }}>Date: Newest</option>
                                        <option value="date_asc" {{ $activeSort === 'date_asc' ? 'selected' : '' }}>Date: Oldest</option>
                                    </select>
                                    <a href="{{ route($rolePrefix . '.archives', ['tab' => 'residents']) }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                                </div>
                            </form>
                        </div>
                        @if($residentArchives->isEmpty())
                            <div class="tab-empty-state">No archived residents found on this page.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Archive Date</th>
                                            <th scope="col">Archived By</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($residentArchives as $item)
                                            @php
                                                $residentPayload = is_array($item->data) ? $item->data : [];
                                                $firstName = trim((string) ($residentPayload['firstName'] ?? ''));
                                                $middleName = trim((string) ($residentPayload['middleName'] ?? ''));
                                                $lastName = trim((string) ($residentPayload['lastName'] ?? ''));
                                                $residentName = trim(collect([$firstName, $middleName, $lastName])->filter()->implode(' '));
                                                $residentName = $residentName !== '' ? ucwords(strtolower($residentName)) : 'N/A';
                                            @endphp
                                            <tr>
                                                <td class="resident-name-cell">{{ $residentName }}</td>
                                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    {{ $item->user
                                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                                        : 'Unknown'
                                                    }}
                                                </td>
                                                <td>
                                                    <div class="archive-actions">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#archiveDetailsModal{{ $item->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </button>
                                                        <form action="{{ route($rolePrefix . '.archive.retrieve.resident', $item->id) }}" method="post" onsubmit="return confirm('Retrieve this resident back to active records?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fa-solid fa-rotate-left"></i> Retrieve
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade {{ $activeTab === 'certificates' ? 'show active' : '' }}" id="certificates-pane" role="tabpanel" aria-labelledby="certificates-tab" tabindex="0">
                        <div class="archive-filter-bar">
                            <form method="GET" action="{{ route($rolePrefix . '.archives') }}" class="archive-filter-form">
                                <input type="hidden" name="tab" value="certificates">
                                <div class="input-group input-group-sm archive-search-group">
                                    <span class="input-group-text text-muted"><i class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search certificate ID, type, requester, or details..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                                <div class="archive-filter-controls">
                                    <span class="archive-filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm archive-filter-select" onchange="this.form.submit()">
                                        <option value="date_desc" {{ $activeSort === 'date_desc' ? 'selected' : '' }}>Date: Newest</option>
                                        <option value="date_asc" {{ $activeSort === 'date_asc' ? 'selected' : '' }}>Date: Oldest</option>
                                    </select>
                                    <a href="{{ route($rolePrefix . '.archives', ['tab' => 'certificates']) }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                                </div>
                            </form>
                        </div>
                        @if($certificateArchives->isEmpty())
                            <div class="tab-empty-state">No archived certificates found on this page.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Request ID / Type</th>
                                            <th scope="col">Requester Name</th>
                                            <th scope="col">Archive Date</th>
                                            <th scope="col">Archived By</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($certificateArchives as $item)
                                            @php
                                                $certificatePayload = is_array($item->data) ? $item->data : [];
                                                $requestId = $certificatePayload['formatted_id'] ?? ('ID #' . ($certificatePayload['id'] ?? $item->record_id));
                                                $requestType = isset($certificatePayload['certificate_type'])
                                                    ? ucwords(str_replace('_', ' ', (string) $certificatePayload['certificate_type']))
                                                    : 'N/A';

                                                $requesterName = null;
                                                if (!empty($certificatePayload['resident_id'])) {
                                                    $requesterName = $residentNameById->get((int) $certificatePayload['resident_id']);
                                                }
                                                if (!$requesterName && !empty($certificatePayload['user_id'])) {
                                                    $requesterName = $userNameById->get((int) $certificatePayload['user_id']);
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $requestId }}</div>
                                                    <small class="text-muted">{{ $requestType }}</small>
                                                </td>
                                                <td class="resident-name-cell">{{ $requesterName ?? 'N/A' }}</td>
                                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    {{ $item->user
                                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                                        : 'Unknown'
                                                    }}
                                                </td>
                                                <td>
                                                    <div class="archive-actions">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#archiveDetailsModal{{ $item->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </button>
                                                        <form action="{{ route($rolePrefix . '.archive.retrieve.certificate', $item->id) }}" method="post" onsubmit="return confirm('Retrieve this certificate request back to active records?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fa-solid fa-rotate-left"></i> Retrieve
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade {{ $activeTab === 'announcements' ? 'show active' : '' }}" id="announcements-pane" role="tabpanel" aria-labelledby="announcements-tab" tabindex="0">
                        <div class="archive-filter-bar">
                            <form method="GET" action="{{ route($rolePrefix . '.archives') }}" class="archive-filter-form">
                                <input type="hidden" name="tab" value="announcements">
                                <div class="input-group input-group-sm archive-search-group">
                                    <span class="input-group-text text-muted"><i class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search announcement title, archived by, or details..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                                <div class="archive-filter-controls">
                                    <span class="archive-filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm archive-filter-select" onchange="this.form.submit()">
                                        <option value="date_desc" {{ $activeSort === 'date_desc' ? 'selected' : '' }}>Date: Newest</option>
                                        <option value="date_asc" {{ $activeSort === 'date_asc' ? 'selected' : '' }}>Date: Oldest</option>
                                    </select>
                                    <a href="{{ route($rolePrefix . '.archives', ['tab' => 'announcements']) }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                                </div>
                            </form>
                        </div>
                        @if($announcementArchives->isEmpty())
                            <div class="tab-empty-state">No archived announcements found on this page.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Announcement</th>
                                            <th scope="col">Archived By</th>
                                            <th scope="col">Archive Date</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($announcementArchives as $item)
                                            @php
                                                $announcementPayload = is_array($item->data) ? $item->data : [];
                                                $announcementTitle = trim((string) ($announcementPayload['title'] ?? 'Untitled Announcement'));
                                            @endphp
                                            <tr>
                                                <td class="resident-name-cell">{{ $announcementTitle !== '' ? $announcementTitle : 'Untitled Announcement' }}</td>
                                                <td>
                                                    {{ $item->user
                                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                                        : 'Unknown'
                                                    }}
                                                </td>
                                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    <div class="archive-actions">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#archiveDetailsModal{{ $item->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade {{ $activeTab === 'activity_logs' ? 'show active' : '' }}" id="activity-logs-pane" role="tabpanel" aria-labelledby="activity-logs-tab" tabindex="0">
                        <div class="archive-filter-bar">
                            <form method="GET" action="{{ route($rolePrefix . '.archives') }}" class="archive-filter-form">
                                <input type="hidden" name="tab" value="activity_logs">
                                <div class="input-group input-group-sm archive-search-group">
                                    <span class="input-group-text text-muted"><i class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search activity log ID, module, action, user, or details..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                                <div class="archive-filter-controls">
                                    <span class="archive-filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm archive-filter-select" onchange="this.form.submit()">
                                        <option value="date_desc" {{ $activeSort === 'date_desc' ? 'selected' : '' }}>Date: Newest</option>
                                        <option value="date_asc" {{ $activeSort === 'date_asc' ? 'selected' : '' }}>Date: Oldest</option>
                                    </select>
                                    <a href="{{ route($rolePrefix . '.archives', ['tab' => 'activity_logs']) }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                                </div>
                            </form>
                        </div>
                        @if($activityLogArchives->isEmpty())
                            <div class="tab-empty-state">No archived activity logs found on this page.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Activity ID</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Module / Action</th>
                                            <th scope="col">Archive Date</th>
                                            <th scope="col">Archived By</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activityLogArchives as $item)
                                            @php
                                                $activityPayload = is_array($item->data) ? $item->data : [];
                                                $activityId = $activityPayload['id'] ?? $item->record_id;
                                                $moduleLabel = isset($activityPayload['module'])
                                                    ? \Illuminate\Support\Str::headline((string) $activityPayload['module'])
                                                    : 'N/A';
                                                $actionLabel = isset($activityPayload['action'])
                                                    ? \Illuminate\Support\Str::headline((string) $activityPayload['action'])
                                                    : 'N/A';
                                                $activityUserName = !empty($activityPayload['user_id'])
                                                    ? ($activityUserNameById->get((int) $activityPayload['user_id']) ?? 'N/A')
                                                    : 'N/A';
                                            @endphp
                                            <tr>
                                                <td>{{ $activityId ? 'ACTL-' . str_pad((string) $activityId, 6, '0', STR_PAD_LEFT) : 'N/A' }}</td>
                                                <td class="resident-name-cell">{{ $activityUserName }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $moduleLabel }}</div>
                                                    <small class="text-muted">{{ $actionLabel }}</small>
                                                </td>
                                                <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    {{ $item->user
                                                        ? ucwords(strtolower($item->user->firstName . ' ' . $item->user->lastName))
                                                        : 'Unknown'
                                                    }}
                                                </td>
                                                <td>
                                                    <div class="archive-actions">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#archiveDetailsModal{{ $item->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </button>
                                                        <form action="{{ route($rolePrefix . '.archive.retrieve.activity-log', $item->id) }}" method="post" onsubmit="return confirm('Retrieve this activity log back to active logs?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fa-solid fa-rotate-left"></i> Retrieve
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                @foreach($archive as $item)
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#archiveTabs button[data-bs-toggle="tab"]').forEach(function (button) {
        button.addEventListener('shown.bs.tab', function (event) {
            const targetPane = event.target.getAttribute('data-bs-target') || '';
            const tab = targetPane.replace('#', '').replace('-pane', '');
            if (!tab) {
                return;
            }

            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            window.history.replaceState({}, '', url.toString());
        });
    });
});
</script>
