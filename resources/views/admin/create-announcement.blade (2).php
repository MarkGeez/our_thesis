  <head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .card {
      width: 12rem;
    }
    .section-title {
      margin-bottom: 20px;
    }
     #details{
        resize:none;
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
    
<div class="announcemntForm">
<form action="{{ route('admin.submit.announcement') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <label for="title">Enter a title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required>
    @error('title')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <label for="image">Upload An Image</label>
    <input type="file" name="image" id="image">
    <br><br>
    @error('image')
        <span>{{ $message }}</span>
    @enderror
    <label for="details">Add extra details</label>
    <textarea name="details" id="details" cols="40" rows="10" required>{{ old('details') }}</textarea>
    @error('details')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <label for="eventTime">Event Start Date/Time:</label>
    <input type="datetime-local" name="eventTime" id="eventTime" value="{{ old('eventTime') }}">
   
    <br><br>

    <label for="eventEnd">Event End Date/Time:</label>
    <input type="datetime-local" name="eventEnd" id="eventEnd" value="{{ old('eventEnd') }}">

    <br><br>


    <button type="submit">Post Announcement</button>

</form>
</div>

<div>
    @foreach($announcement as $ann)
    <div>
       <h1>{{ $ann->title }}</h1>
      <p>{{ $ann->details }}</p>
       <p> {{ $ann->user->firstName . ',' . $ann->user->lastName }}</p>
               <h1>{{ $ann->title }}</h1>
        @if($ann->image)
            <img src="{{ asset('storage/'.$ann->image) }}" alt="{{ $ann->title }}" style="max-width:300px; height:auto; display:block; margin-bottom:8px;">
        @else
            <img src="{{ asset('template/img/default-announcement.png') }}" alt="No image" style="max-width:300px; height:auto; display:block; margin-bottom:8px;">
        @endif
        <p>{{ $ann->details }}</p>
        <p>{{ $ann->user->firstName }}, {{ $ann->user->lastName }}</p>
    </div>
    @endforeach
</div>
</main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>

