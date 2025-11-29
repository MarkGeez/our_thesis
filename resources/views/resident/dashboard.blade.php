<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
        @include('resident.resident-sidebar', ['resident' => $resident])

        <div class="main-wrapper">
           
            @include('resident.resident-header', ['resident' => $resident])
            
            <main class="main users chart-page" id="skip-target">
                <!-- Dashboard Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Welcome Section -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title">Welcome back, {{ auth()->user()->firstName }}!</h3>
                                    <p class="card-text">Here's what's happening in your community.</p>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>