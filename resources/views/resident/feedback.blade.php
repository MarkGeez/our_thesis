
    <head>
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
                <!--Dito lalagay main content-->

                <div class="container">
          <h1 class="main-title">Feedback</h1>
          <hr>
          
        <form action=""> 
        <div class="main-container">
          <div class="m-4">
            <h5 class="mb-3"><i class="fa-solid fa-comment-dots me-2 text-primary"></i>Send Us Your Feedback</h5>
            <form>
              <div class="mb-3">
                <label for="feedbackMessage" class="form-label">Your Message:</label>
                <textarea class="form-control" id="feedbackMessage" rows="4" placeholder="Enter your feedback or concerns here..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-paper-plane me-1"></i> Submit Feedback
              </button>
            </form>
          </div>
        </div>
        </form>
      </div>
            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>



