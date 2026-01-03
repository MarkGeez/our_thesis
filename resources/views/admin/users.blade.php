<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

                <div class="d-flex align-items-center justify-content-between mb-4 px-4">
                    <h2 class="mb-0 text-dark">User Records</h2>
                </div>

                <form action="{{ route($user->role . '.users') }}" method="get" class="px-4 mb-3">
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Search users" 
                            value="{{ request('search') }}"
                        >
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>

                @if($userList->count() > 0)
                    <div class="px-4 mb-2 text-muted">
                        Found {{ $userList->total() }} users
                    </div>

                    <div class="table-responsive px-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-center">Update Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userList as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>
                                            {{ ucwords(strtolower($list->firstName)) }}
                                            {{ ucwords(strtolower($list->lastName)) }}
                                        </td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ ucfirst($list->role) }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'active' => 'bg-success',
                                                    'inactive' => 'bg-secondary',
                                                    'blocked' => 'bg-danger',
                                                ][$list->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($list->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route($user->role . '.update.role', $list->id) }}" method="post" class="d-flex align-items-center gap-2 justify-content-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="role" class="form-select form-select-sm" style="min-width: 130px;">
                                                    <option value="admin" {{ $list->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="subadmin" {{ $list->role === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                                    <option value="resident" {{ $list->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                                    <option value="non-resident" {{ $list->role === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 mt-3">
                        {{ $userList->links() }}
                    </div>
                @else
                    <div class="alert alert-info mx-4 mt-3">
                        No users found.
                    </div>
                @endif

            </div>
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>