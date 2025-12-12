
<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
.announcement-card {
  max-width: 100%;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #ffffff;
  margin: 5px 20px; 
  padding: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.announcement-card img {
  display: block;
  margin: 0 auto 15px;
  width: auto;
  max-width: 400px;
  height: 200px;
  border-radius: 10px;
  object-fit: cover;
}

/*
 .announcement-card img {
width: auto;
height: 200px;
border-radius: 10px;
margin-bottom: 15px;
object-fit: cover;
}
*/

.announcements-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
  justify-items: stretch;
  align-items: start;
  padding-top: 10px;
}

.announcement-meta {
  font-size: 13px;
  color: #666;
  margin-top: 8px;
  padding-top: 10px;
  border-top: 1px solid #eee;
}

.announcement-actions {
  display: flex;
  gap: 10px;
  margin-top: 15px;
  align-items: center;
}

.announcement-actions form {
  margin: 0;
}

.announcement-text {
  background-color: #f0efef;
  border-radius: 8px;
  padding: 15px;

  box-shadow:
    inset 0 3px 6px rgba(255, 255, 255, 0.6),
    inset 0 -3px 6px rgba(0, 0, 0, 0.25),
    inset 0 8px 20px rgba(0, 0, 0, 0.2),
    inset 0 -8px 20px rgba(0, 0, 0, 0.15);

  line-height: 1.5px;
}


@media (max-width: 768px) {
  .announcements-grid {
    grid-template-columns: 1fr; 
  }
  .announcement-card img {
    height: 240px;
  }
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
   
  <div class="d-flex justify-content-between align-items-center">
  <h2 style="color:#000000; margin-left: 20px;">Active Announcements</h2>
  <button type="button" class="btn btn-primary me-3"
        data-bs-toggle="modal"
        data-bs-target="#createAnnouncement">
    Create Announcement <i class="fa-solid fa-plus"></i>
</button>

</div>

  @if(session("success"))
<div id="successAlert" class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm"
     style="max-width: 325px; box-shadow: 0 4px 12px rgb(5, 94, 12);">
    <h6>{{ session("success") }}</h6>
</div>

<script>
    setTimeout(function() {
        const alertBox = document.getElementById("successAlert");
        if (alertBox) {
            alertBox.style.display = "none";
        }
    }, 10000);
</script>
@endif



   <div class="announcements-grid">
     @foreach($announcement as $announcements)
     <div class="announcement-card">

      @if($announcements->image)
        <img 
         src="{{ $announcements->image ? asset('storage/'.$announcements->image) : "no image uploaded" }}"
         alt="{{ $announcements->title }}"
       >
      @endif
       
       
         <h3 class=" fw-bold mb-2">{{ $announcements->title }}</h3>
    <div class="announcement-text" >
         <p class="mt-1 " style="line-height: 1.25em;">{{ $announcements->details }}</p>

         @if($announcements->eventTime || $announcements->eventEnd)
           <p class="mt-2 mb-2"><strong>Event Start:</strong> {{ $announcements->eventTime }}</p>
           <p><strong>Event End:</strong> {{ $announcements->eventEnd }}</p>
         @endif
</div>  
         <div class="announcement-meta">
           Posted by: {{ ucfirst($announcements->user->firstName) }}, {{ ucfirst($announcements->user->lastName) }}
         </div>
         <div class="announcement-actions">
          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAnnouncement{{ $announcements->id }}">
              <i class="fa-solid fa-edit"></i> Edit
          </button>
                          
          <form action="{{ route('admin.announcement.archive', $announcements->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('archive this announcement?')">
              <i class="fa-solid fa-archive"></i> Archive
            </button>
          </form>
         </div>
         
       
     </div>


    <!-- Modal -->
<div class="modal fade" id="editAnnouncement{{ $announcements->id }}" tabindex="-1" aria-labelledby="editAnnouncementLabel{{ $announcements->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementLabel{{ $announcements->id }}">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.update.announcement', $announcements->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="title{{ $announcements->id }}">Title</label>
                    <input class="form-control" type="text" name="title" id="title{{ $announcements->id }}" value="{{ $announcements->title }}" required>

                    <label for="details{{ $announcements->id }}">Details</label>
                    <textarea class="form-control" name="details" id="details{{ $announcements->id }}" cols="40" rows="10">{{ old('details', $announcements->details) }}</textarea>

                   <label for="eventTime{{ $announcements->id }}">Event Start</label>
<input class="form-control datetime-picker" 
       type="text" 
       name="eventTime" 
       id="eventTime{{ $announcements->id }}" 
       value="{{ old('eventTime', $announcements->eventTime ? date('Y-m-d H:i', strtotime($announcements->eventTime)) : '') }}">

<label for="eventEnd{{ $announcements->id }}">Event End</label>
<input class="form-control datetime-picker" 
       type="text" 
       name="eventEnd" 
       id="eventEnd{{ $announcements->id }}" 
       value="{{ old('eventEnd', $announcements->eventEnd ? date('Y-m-d H:i', strtotime($announcements->eventEnd)) : '') }}">

                    <button type="submit" class="btn btn-success mt-3">Update Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>


     @endforeach
   </div>

</div>
</div> 
    
</main>

</div>
</div> 
@include('admin.create-announcement')

<script>
document.addEventListener("DOMContentLoaded", function() {
    flatpickr(".datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i", // 24-hour format for submission
        altInput: true,
        altFormat: "F j, Y h:i K", // user sees AM/PM
        time_24hr: false
    });
});
</script>


<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
