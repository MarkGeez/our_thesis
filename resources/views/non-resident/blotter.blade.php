
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
         @include('non-resident.nonresident-sidebar', ['non-resident' => auth()->user()])

    <div class="main-wrapper">
        @include('non-resident.nonresident-header', ['non-resident' => auth()->user()])
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
        </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


