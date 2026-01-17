<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .official-header {
            font-family: 'Orbitron', sans-serif;
            color: #1e293b;
            letter-spacing: 2px;
            border-bottom: 3px solid #0d6efd;
            display: inline-block;
            margin-bottom: 30px;
        }

        .official-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            height: 100%;
        }

        .official-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .image-container {
            background: #f8f9fa;
            padding: 30px 0;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .official-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background: #dee2e6;
        }

        .official-info {
            padding: 20px;
            text-align: center;
        }

        .official-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            color: #000000;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .official-position {
           
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 15px;
            display: block;
        }

        .term-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            display: inline-block;
        }

        .term-label {
            font-weight: bold;
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            color: #94a3b8;
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
            <div class="container-fluid p-4">
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex align-items-center mb-3 px-3 blotter-header">
                    <h2 class="mb-0" style="color:#000000;">Barangay Officials</h2>
                    
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($officials as $official)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="official-card">
                                <div class="image-container">
                                    <img src="{{ $official->image ? asset('storage/'.$official->image) : 'https://ui-avatars.com/api/?name='.urlencode($official->resident->firstName).'&background=0D6EFD&color=fff&size=128' }}" 
                                         alt="Official Photo" class="official-avatar">
                                </div>
                                
                                <div class="official-info">
                                    <span class="official-position">{{ $official->position }}</span>
                                    <h3 class="official-name">Hon. {{ $official->resident->firstName }} {{ $official->resident->lastName }}</h3>
                                    
                                    <div class="term-badge mt-3">
                                        <span class="term-label">Service Term</span>
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ date('M d, Y', strtotime($official->start)) }} - {{ date('M d, Y', strtotime($official->end)) }}
                                    </div>
                                    <!--
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-id-card me-1"></i> Full Profile
                                        </button>
                                    </div>
                                -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>