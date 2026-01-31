
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
    .main-wrapper { background-color: #f8f9fa; min-height: 100vh; }
    .page-title { font-family: 'Orbitron', sans-serif; font-weight: 700; color: #1e293b; }
    
    .street-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
        background: #ffffff;
    }
    
    .street-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-label { font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
</style>



</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])



<div class="main-wrapper">
    @include('admin.admin-header', ['admin' => auth()->user()])

    <main class="main users chart-page" id="skip-target">
        <div class="container-fluid px-4">
            
             <div class="d-flex justify-content-between align-items-center">
  <h2 style="color:#000000; margin: 20px 45px;">Household Management</h2>
  

</div>

            <div class="row g-4">
                @foreach ($street as $streets)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card street-card h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box">
                                    <i class="fas fa-road"></i>
                                </div>
                               
                            </div>
                            
                            <h5 class="card-title fw-bold mb-1">{{ $streets->street_name }}</h5>
                            <div class="mb-4">
                                <span class="stat-label d-block">Total Houses</span>
                                <span class="stat-value">{{ $streets->houses_count }}</span>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('admin.households.streets', $streets->id) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    View Houses <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </main>
</div>
</div> 



<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


