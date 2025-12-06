<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
  width: 100%;
  height: 200px;
  border-radius: 10px;
  margin-bottom: 15px;
  object-fit: cover;
}

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

.announcement-text {
  background-color: #d8ebff;
  border-radius: 8px;
  padding: 15px;
  border-left: 4px solid #007BFF;
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
    @if(session("success"))
      <h6>{{ session("success") }}</h6>
    @endif
  <h2 style="color:#007BFF; margin-left: 20px;">Latest Announcements </h2>


   <div class="announcements-grid">
     @foreach($announcement as $announcements)
     <div class="announcement-card">

      @if($announcements->image)
        <img 
         src="{{ $announcements->image ? asset('storage/'.$announcements->image) : "no image uploaded" }}"
         alt="{{ $announcements->title }}"
       >
      @endif
       
       <div class="announcement-text">
         <h3>{{ $announcements->title }}</h3>

         <p class="mt-3">{{ $announcements->details }}</p>

         @if($announcements->eventTime || $announcements->eventEnd)
           <p class="mt-2"><strong>Event Start:</strong> {{ $announcements->eventTime }}</p>
           <p><strong>Event End:</strong> {{ $announcements->eventEnd }}</p>
         @endif

         <div class="announcement-meta">
           Posted by: {{ ucfirst($announcements->user->firstName) }}, {{ ucfirst($announcements->user->lastName) }}
         </div>
         <div>
          <button><a href="{{ url("admin/edit-announcement/".$announcements->id) }}">Edit announcement</a></button>
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

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>