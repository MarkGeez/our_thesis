<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        /* Custom styles here */
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">  
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target"> <div class="main-container">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="color:#000000; margin: 20px 45px;">User Records</h2>
    </div>

    <form action="{{ route($user->role . '.users') }}" method="get" class="mb-3" style="margin: 0 3em;">
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

    <div class="table-responsive" style="margin: 0 3em;">
        <table class="table table-bordered table-striped-row table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($userList as $user)
                    <tr>
                        <td>{{ $user->id }}</td>

                        <td>
                            {{ ucwords(strtolower($user->firstName)) }}
                            {{ ucwords(strtolower($user->lastName)) }}
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>
                            <span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            @php
                                $statusClass = [
                                    'active' => 'bg-success',
                                    'inactive' => 'bg-secondary',
                                    'blocked' => 'bg-danger',
                                ][$user->status] ?? 'bg-secondary';
                            @endphp

                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-3" style="margin-left: 3em;">
        {{ $userList->links() }}
    </div>

    @else
        <div class="bg-light m-3 p-3 shadowed">
            <p class="ms-5 mt-3">No users found.</p>
        </div>
    @endif

</div>

</main>
    </div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>