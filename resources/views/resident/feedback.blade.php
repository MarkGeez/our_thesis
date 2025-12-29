
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
    
    .card {
      width: 12rem;
    }
    .section-title {
      margin-bottom: 20px;
    }
    .feedback-wrapper {
  max-width: 700px;
  margin: 0 auto;
}

.feedback-card {
  background: #ffffff;
  border-radius: 10px;
  padding: 24px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.feedback-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
}

.feedback-header i {
  font-size: 22px;
}

.feedback-desc {
  font-size: 14px;
  color: #666;
  margin-bottom: 20px;
}

.feedback-card textarea {
  resize: none;
}

.feedback-actions {
  text-align: right;
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
              <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="ms-3" style="color:#000000;">Feedback</h2>
                    
                </div>
             <div class="container">
              
              <hr>

              <div class="feedback-wrapper">
                <div class="feedback-card">

                  <div class="feedback-header">
                    <i class="fa-solid fa-comment-dots text-primary"></i>
                    <h5 class="mb-0">Send your feedback</h5>
                  </div>

                  <p class="feedback-desc">
                    Share your concerns, suggestions, or experience. Your input helps improve the service.
                  </p>

                  @if (session('success'))
                    <div class="alert alert-success py-2">
                      {{ session('success') }}
                    </div>
                  @endif

                  <form method="post" action="{{ route('resident.submit.feedback') }}">
                    @csrf

                    <div class="mb-3">
                      <label for="feedbackMessage" class="form-label">
                        Your message
                      </label>
                      <div class="mb-3"> <label class="form-label">From</label> <input type="text" class="form-control" value="{{ ucfirst($resident->firstName) }} {{ ucfirst($resident->lastName) }} (You)" disabled> </div>
                      <textarea
                        class="form-control"
                        id="feedbackMessage"
                        name="message"
                        rows="5"
                        placeholder="Type your feedback here"
                      ></textarea>

                      @error('message')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="feedback-actions">
                      <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-1"></i>
                        Submit feedback
                      </button>
                    </div>
                  </form>
                   @if (session('success'))
                    <div class="alert alert-success py-2">
                      {{ session('success') }}
                    </div>
                  @endif
                </div>
                
              </div>
            </div>

            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>



