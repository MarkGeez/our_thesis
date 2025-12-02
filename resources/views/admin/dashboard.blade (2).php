
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
   
    @include('admin.admin-sidebar', ['admin' => $admin])



<div class="main-wrapper">
           
    @include('admin.admin-header', ['admin' => $admin])
            <main class="main users chart-page" id="skip-target">
                <!--Dito lalagay main content-->

    <h1>admin</h1>
    @foreach($announcement as $ann)
    <div>
-        <h1>{{ $ann->title }}</h1>
-        <p>{{ $ann->details }}</p>
-        <p> {{ $ann->user->firstName . ',' . $ann->user->lastName }}</p>
+        <h1>{{ $ann->title }}</h1>
+        @if($ann->image)
+            <img src="{{ asset('storage/'.$ann->image) }}" alt="{{ $ann->title }}" style="max-width:300px; height:auto; display:block; margin-bottom:8px;">
+        @else
+            <img src="{{ asset('template/img/default-announcement.png') }}" alt="No image" style="max-width:300px; height:auto; display:block; margin-bottom:8px;">
+        @endif
+        <p>{{ $ann->details }}</p>
+        <p>{{ $ann->user->firstName }}, {{ $ann->user->lastName }}</p>
    </div>
    @endforeach
 </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>

