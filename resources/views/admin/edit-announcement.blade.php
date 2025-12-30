
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    .announcement-form {
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.announcement-form form label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
}

.announcement-form input[type="text"],
.announcement-form input[type="file"],
.announcement-form input[type="datetime-local"],
.announcement-form textarea {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-bottom: 15px;
    background-color: #f7f7f7;
}

.announcement-form textarea {
    resize: vertical;
}

.announcement-form span {
    color: #d00;
    font-size: 13px;
    margin-top: -10px;
    display: block;
    margin-bottom: 10px;
}

.announcement-form button {
    width: 100%;
    padding: 12px;
    background-color: #0069d9;
    color: #fff;
    font-size: 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.announcement-form button:hover {
    background-color: #0056b3;
}

.modal-content .form-control {
  border: 2px solid #dddddd !important;
  box-shadow: none !important;
}

.modal-content .form-control:focus {
  border: 2px solid #0056b3 !important;
  box-shadow: 0 0 0 0.15rem rgba(0,123,255,0.2) !important;
  outline: none !important;
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

<div class="announcement-form">
    <div id="localSuccessMessage" style="display:none;max-width:600px;margin:20px auto;padding:12px;background:#d4edda;color:#155724;border-radius:6px;border:1px solid #c3e6cb;text-align:center;"> Announcement posted successfully. </div>
<H1 >EDIT ANNOUNCEMENT</H1>
<a  class="btn btn-danger" href="{{ route('admin.dashboard') }}">Cancel</a>


    

<form action="{{ route('admin.update.announcement', $announcement->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    
    <label for="title">Enter a title</label>
    <input type="text" name="title" id="title" value="{{ $announcement->title }}" required>
    @error('title')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    
    <label for="details">Add extra details</label>
    <textarea name="details" id="details" cols="40" rows="10" >{{ old('details', $announcement->details) }}</textarea>
    @error('details')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <label for="eventTime">Event Start Date/Time:</label>
<div class="d-flex align-items-center gap-2">
    <small class="text-muted">
        Current: {{ $announcement->eventTime ? date('M/d/Y', strtotime($announcement->eventTime)) . ' at ' . date('g:i A', strtotime($announcement->eventTime)) : 'Not set' }}
    </small>
</div>
<input type="datetime-local" 
       name="eventTime" 
       id="eventTime" 
       value="{{old('eventTime', $announcement->eventTime ? date('Y-m-D\TH:i', strtotime($announcement->eventime)) : "")}}">
<br><br>

<label for="eventEnd">Event End Date/Time:</label>
<div class="d-flex align-items-center gap-2">
    <small class="text-muted">
        Current: {{ $announcement->eventEnd ? date('M/d/Y', strtotime($announcement->eventEnd)) . ' at '. date('g:i A', strtotime($announcement->eventEnd)) : 'Not set' }}
    </small>
</div>
<input type="datetime-local" 
       name="eventEnd" 
       id="eventEnd" 
       value="{{ old('eventEnd', $announcement->eventEnd ? date('Y-m-d\TH:i', strtotime($announcement->eventEnd)) : '') }}">


    <button type="submit">Update Announcement</button>
    <div id="localSuccessMessage" style="display:none;max-width:600px;margin:20px auto;padding:12px;background:#d4edda;color:#155724;border-radius:6px;border:1px solid #c3e6cb;text-align:center;"> Announcement posted successfully. </div>

</form>
</div>

<div class="display-announcement">
    

</div>
</main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script> document.addEventListener("DOMContentLoaded", function() { const form = document.querySelector("form"); const msg = document.getElementById("localSuccessMessage"); form.addEventListener("submit", function() { msg.style.display = "block"; setTimeout(function() { msg.style.opacity = "0"; msg.style.transition = "opacity 0.6s"; setTimeout(() => msg.remove(), 600); }, 2000); }); }); </script>


