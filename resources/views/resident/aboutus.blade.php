
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
  </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
    @include('resident.resident-sidebar', ['resident' => $resident])



<div class="main-wrapper">
           
    @include('resident.resident-header', ['resident' => $resident])
            <main class="main users chart-page" id="skip-target">
                <div class="container">
          <h1 class="main-title">About Us</h1>
          <hr>
          
          <!-- Barangay Officials Section -->
          <div class="section-title">
            <div class="d-flex justify-content-center mb-3">
              <h4 class="h4">Barangay Officials</h4>
            </div>
          </div>
          
          
          
          <!-- Developers Section -->
          <div class="section-title">
            <div class="d-flex justify-content-center mb-3">
              <h4 class="h4">Developers</h4>
            </div>
          </div>
          
          <div class="d-flex flex-wrap gap-3 justify-content-center">
            <div class="card">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="Teodoro Alipio">
              <div class="card-body">
                <h5 class="card-title">Teodoro Alipio III</h5>
                <p class="card-text"></p>
              </div>
            </div>
            
            <div class="card">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="Humar Belen">
              <div class="card-body">
                <h5 class="card-title">Humar Belen</h5>
                <p class="card-text"></p>
              </div>
            </div>
            
            <div class="card">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="John Stephen Fajardo">
              <div class="card-body">
                <h5 class="card-title">John Stephen Fajardo</h5>
                <p class="card-text"></p>
              </div>
            </div>
            
            <div class="card">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="Mark Graelan Gee">
              <div class="card-body">
                <h5 class="card-title">Mark Graelan Gee</h5>
                <p class="card-text"></p>
              </div>
            </div>
            
            <div class="card">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="Justin Ramos">
              <div class="card-body">
                <h5 class="card-title">Justin Jeremie Ramos</h5>
                <p class="card-text"></p>
              </div>
            </div>
          </div>
        </div>
            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>



