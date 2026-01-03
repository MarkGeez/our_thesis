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

        <main class="main users chart-page" id="skip-target">
            <form action="{{ route($user->role . '.users')}}" method="get">
                <input type="text" name="search">    
             </form>
        @if($userList->count() > 0)
        <h3>Found {{ $userList->total() }} users</h3>
        
        @foreach ($userList as $user)
            <div>
                <strong>ID:</strong> {{ $user->id }}<br>
                <strong>Name:</strong> {{ $user->firstName }} {{ $user->lastName }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Role:</strong> {{ $user->role }}<br>
                <strong>Status:</strong> {{ $user->status }}<br>
                <hr>
            </div>
        @endforeach

      
        @else
        <p>No users found.</p>
        @endif
        </main>
    </div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>