<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --success-color: #059669;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
            --info-color: #0ea5e9;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        body {
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-primary);
        }

        .main.users.chart-page {
            background-color: var(--light-bg);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .container {
            max-width: 1300px;
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
            border-radius: 15px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.25rem;
        }

        .welcome-card h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-card p {
            margin: 0.5rem 0 0 0;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .table-section {
            padding: 1.25rem;
        }

        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-color);
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .results-count {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .results-count .count-number {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.05rem;
        }

        .table-filter-bar {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .table-filter-bar .form-control,
        .table-filter-bar .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            height: 38px;
        }

        .table-filter-bar .form-control:focus,
        .table-filter-bar .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
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
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        .role-admin {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .role-superadmin {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: #5b21b6;
        }

        .role-subadmin {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            color: #155e75;
        }

        .role-resident {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .role-non-resident {
            background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
            color: #9a3412;
        }

        .action-form {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .action-form .form-select {
            min-width: 185px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .btn-update {
            border: none;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.45rem 0.8rem;
        }

        .btn-update:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .empty-state {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            color: #1e40af;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .welcome-card h3 {
                font-size: 1.45rem;
            }

            .table-section {
                padding: 1rem;
            }

            .action-form {
                flex-direction: column;
                align-items: stretch;
            }

            .action-form .form-select,
            .action-form button {
                width: 100%;
            }
        }
    </style>
</head>
@include('superadmin.superadmin-header', ['superadmin' => auth()->user()])
<div class="layer"></div>
<div class="main users chart-page">
    <div class="container">
        <div class="welcome-card">
            <h3>
                <i class="fas fa-users-cog text-primary"></i>
                Superadmin User Management
            </h3>
            <p>Review all users and update roles using the controls below.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content-card">
            <div class="table-section">
                <div class="table-filter-bar">
                    <div class="flex-grow-1" style="min-width: 240px;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="userSearchInput" class="form-control border-start-0 ps-0" placeholder="Search name, email, or role...">
                        </div>
                    </div>

                    <div style="min-width: 180px;">
                        <select id="roleFilter" class="form-select form-select-sm">
                            <option value="all">All Roles</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                            <option value="subadmin">Sub-admin</option>
                            <option value="resident">Resident</option>
                            <option value="non-resident">Non-resident</option>
                        </select>
                    </div>

                    <button type="button" id="resetFiltersBtn" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-undo me-1"></i>Reset
                    </button>
                </div>

                <div class="results-info">
                    <div class="results-count">
                        Records: <span class="count-number" id="visibleUserCount">{{ $users->count() }}</span>
                    </div>
                </div>

                @if($users->isEmpty())
                    <div class="empty-state">
                        No users found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Current Role</th>
                                    <th class="text-center">Update Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $listedUser)
                                    @php
                                        $fullName = ucwords(trim($listedUser->firstName . ' ' . $listedUser->middleName . ' ' . $listedUser->lastName));
                                    @endphp
                                    <tr data-role="{{ $listedUser->role }}">
                                        <td class="fw-semibold">{{ $fullName }}</td>
                                        <td>{{ $listedUser->email ?? '-' }}</td>
                                        <td>
                                            <span class="role-badge role-{{ $listedUser->role }}">
                                                <i class="fas fa-user-tag"></i>
                                                {{ ucfirst($listedUser->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($listedUser->role === 'superadmin')
                                                <span class="text-muted small fw-semibold">No actions available</span>
                                            @else
                                                <form action="{{ route('superadmin.updateRole', $listedUser->id) }}" method="POST" class="action-form justify-content-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="role" class="form-select form-select-sm" required>
                                                        <option value="admin" {{ $listedUser->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="subadmin" {{ $listedUser->role === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                                        <option value="resident" {{ $listedUser->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                                        <option value="non-resident" {{ $listedUser->role === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-update btn-sm">
                                                        <i class="fas fa-save me-1"></i>Update
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script>
    (function () {
        var searchInput = document.getElementById('userSearchInput');
        var roleFilter = document.getElementById('roleFilter');
        var resetBtn = document.getElementById('resetFiltersBtn');
        var table = document.getElementById('usersTable');
        var counter = document.getElementById('visibleUserCount');
        var rows = table ? Array.from(table.querySelectorAll('tbody tr')) : [];

        function applyFilters() {
            var query = (searchInput.value || '').trim().toLowerCase();
            var selectedRole = roleFilter.value;
            var visible = 0;

            rows.forEach(function (row) {
                var rowText = row.innerText.toLowerCase();
                var rowRole = row.getAttribute('data-role');
                var matchesSearch = rowText.indexOf(query) !== -1;
                var matchesRole = selectedRole === 'all' || rowRole === selectedRole;
                var show = matchesSearch && matchesRole;

                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (counter) counter.textContent = visible;
        }

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        if (roleFilter) {
            roleFilter.addEventListener('change', applyFilters);
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                searchInput.value = '';
                roleFilter.value = 'all';
                applyFilters();
            });
        }
    })();
</script>
