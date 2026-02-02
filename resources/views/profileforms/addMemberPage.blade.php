<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Family Member</title>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .form-control, .form-select {
            background-color: #ffffff;
            border: 1.5px solid #ced4da;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        @php
            $user = auth()->user();
            $role = $user->role;
        @endphp

        @if($role === 'admin')
            @include('admin.admin-sidebar', ['admin' => $user])
        @elseif($role === 'subadmin')
            @include('subadmin.subadmin-sidebar', ['subadmin' => $user])
        @elseif($role === 'resident')
            @include('resident.resident-sidebar', ['resident' => $user])
        @endif

        <div class="main-wrapper">
            @if($role === 'admin')
                @include('admin.admin-header', ['admin' => $user])
            @elseif($role === 'subadmin')
                @include('subadmin.subadmin-header', ['subadmin' => $user])
            @elseif($role === 'resident')
                @include('resident.resident-header', ['resident' => $user])
            @endif

            <main class="main users chart-page container-fluid py-4" id="skip-target">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route($role . '.profile') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Profile
                        </a>
                    </div>
                </div>

                @include('profileforms.addMember')
            </main>
        </div>
    </div>

    <script src="{{ asset('template/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
