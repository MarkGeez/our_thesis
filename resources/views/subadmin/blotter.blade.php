<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    .modal-body section {
            margin-bottom: 24px;
        }
        .table-wrapper {
            margin: 0 3em;
        }

        .modal-body h6 {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #4b5563;
            margin-bottom: 12px;
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
        }

        .info-label {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .info-value {
            color: #111827;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .info-box .row:last-child .info-value {
            margin-bottom: 0;
        }

        .modal-body .form-group {
            margin-bottom: 1.25rem;
        }

        .modal-body label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .edit-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1f2937;
            margin: 20px 0 12px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #f3f4f6;
        }

        @media (max-width: 576px) {
            .blotter-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .blotter-header h2 {
                margin-bottom: 0;
            }

            .blotter-header .encode-btn-wrapper {
                width: 100%;
            }

            .blotter-header .encode-btn-wrapper button {
                width: 100%;
            }
        }
</style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])



<div class="main-wrapper">
           
    @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])
    <main class="main users chart-page" id="skip-target">
                <div class="d-flex align-items-center mb-3 px-3 blotter-header">
                    <h2 class="mb-0" style="color:#000000;">My Blotter</h2>
                    
                    
                    
                    <div class="ms-auto encode-btn-wrapper me-4">
                        @include('forms.blotter', [
                            'plaintiff' => view('forms.hidden')->render(),
                            'button' => '<i class="fa fa-plus me-1"></i> Submit Blotter'
                        ])
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success m-3" role="alert">
                          {{ session('success') }}
                    </div>
                @endif

                <div class="container-fluid px-3">
                    @include('forms.display')
                </div>
            </main>

</div>
</div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>

