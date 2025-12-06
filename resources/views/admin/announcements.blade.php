
<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.announcementImage{
    height: 120px;
    width:220px;
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
                <h1>active annnouncements</h1>
                <a class="btn btn-info" href="{{ url('admin/create-announcement') }}">create announcement</a>

    <table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Image</th>
            <th>Details</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Created At:</th>
            <th>Uploaded By:</th>
            <th>Actions:</th>
        </tr>
    </thead>
    <tbody>
        @foreach($announcements as $announcement)
        <tr>
            <td>{{ $announcement->title }}</td>
            <td>
    @if($announcement->image)
        <img class="announcementImage" src="{{ asset('storage/'. $announcement->image) }}" alt="">
    @else
        No image uploaded  
    @endif
    </td>
            <td>{{ $announcement->details }}</td>
            <td>{{ $announcement->eventTime ? date("M-d-Y", strtotime($announcement->eventTime)). 'at' . date("g:i A", strtotime($announcement->eventTime)): "no start date" }}</td>
            <td>{{ $announcement->eventEnd ? date("M-d-Y", strtotime($announcement->eventEnd)). 'at' . date("g:i A", strtotime($announcement->eventEnd)) : "no end date" }}</td>
            <td>{{ $announcement->postedAt }}</td>
            <td> {{ ucfirst($announcement->user->firstName) }}, {{ ucfirst($announcement->user->lastName) }}</td>
            <td colspan="2"><a class="btn btn-info" href="{{ url('admin/edit-announcement/'. $announcement->id) }}">Edit</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<h1>Announcement Archive</h1>


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
