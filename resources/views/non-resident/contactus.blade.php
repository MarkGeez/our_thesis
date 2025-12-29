
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
        <style>
    .main-container {
      box-shadow: 10px 10px 16px -5px rgba(0,0,0,0.23);
      -webkit-box-shadow: 10px 10px 16px -5px rgba(0,0,0,0.23);
      -moz-box-shadow: 10px 10px 16px -5px rgba(0,0,0,0.23);
      padding: 20px;
      border-radius: 8px;
      background-color: #ffffff;
    }
    .main-container h4 {
      margin-top: 0;
      color: #333;
    }
    .main-container p {
      margin-top: 20px;
      color: #555;
    }
    .announcement-container {
      margin-top: 20px;
      padding: 15px;
      border-left: 4px solid #007BFF;
      background-color: #f9f9f9;
    }
    .announcement-container p {
      margin-bottom: 30px;
      color: #444;
    }
    .announcement-container img {
      width: 100%;
      border-radius: 8px;
      display: block;
      margin: 0 auto;
    }
    .latest-events p {
      margin-bottom: 20px;
    }
    .latest-events img {
      width: 80%;
      border-radius: 8px;
      margin-top: 20px;
      display: block;
      margin: 0 auto;
    }
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
         @include('non-resident.nonresident-sidebar')
    <div class="main-wrapper">
        @include('non-resident.nonresident-header', ['non-resident' => auth()->user()])
            <main class="main users chart-page" id="skip-target">
                <!--Dito lalagay main content-->

                <div class="container">
          <h1 class="main-title">Contact Us</h1>
          <hr>
          
          <!-- Barangay Officials Section -->
          <div class="section-title">
            
          </div>
           
            <div class="d-flex justify-content-center mb-3">
              <h4 class="h4">Barangay 249 Zone 23, Tondo, Manila</h4>
            </div>

           

          <div class="main-container">
            <h4 class="card-title mb-4 text-center">
        <i class="fa-solid fa-address-book me-2 text-primary"></i>Get in Touch
      </h4>
      <p class="mb-3">
        <i class="fa-solid fa-map-marker-alt text-danger me-2"></i>
        JX8H+H57, Yakal St, Tondo, Manila, 1008 Metro Manila
      </p>
      <p class="mb-3">
        <i class="fa-solid fa-phone text-success me-2"></i>
        0999-123-4567
      </p>
      <p>
        <i class="fa-solid fa-envelope text-warning me-2 mb-3"></i>
        brgy249@email.com
      </p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.6974750090753!2d120.9780723024629!3d14.6163018517375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5fa20b91ee9%3A0x4fc85db2949a910d!2sBarangay%20249%20Tondo!5e0!3m2!1sen!2sph!4v1759393446597!5m2!1sen!2sph"
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            
      
          </div>
        </div>

       

      </div>
            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>



