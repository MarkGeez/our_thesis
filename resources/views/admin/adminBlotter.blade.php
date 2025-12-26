<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    
    <!-- Use same Bootstrap version (5.3.8) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        /* Your styles here */
    </style>
</head>

<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
        @include('admin.admin-sidebar', ['admin' => auth()->user()])

        <div class="main-wrapper">
            @include('admin.admin-header', ['admin' => auth()->user()])
            @if (session('success'))
                                <p>{{ session('success') }}</p>
                            @endif
            <main class="main users chart-page" id="skip-target">
                <!-- Put your button INSIDE the main content -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blotterModal">
                    Submit a blotter
                </button>

                <!-- Modal -->
                <div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="blotterModalLabel">Submit Blotter</h5>
                                <!-- FIX: Changed data-bs-close to data-bs-dismiss -->
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <div class="modal-body">
                                <form action="{{ route('admin.submit.blotter') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ================= DEFENDANT ================= --}}
    <h4>Defendant Information</h4>

    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="defendantAddress"
               class="form-control border border-light @error('defendantAddress') is-invalid @enderror"
               value="{{ old('defendantAddress') }}">
        @error('defendantAddress')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Contact Number</label>
        <input type="text" name="defendantContactNumber"
               class="form-control border border-light @error('defendantContactNumber') is-invalid @enderror"
               value="{{ old('defendantContactNumber') }}">
        @error('defendantContactNumber')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col">
            <label>First Name</label>
            <input type="text" name="defendantName"
                   class="form-control border border-light @error('defendantName') is-invalid @enderror"
                   value="{{ old('defendantName') }}" required>
            @error('defendantName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col">
            <label>Middle Name</label>
            <input type="text" name="defendantMiddleName"
                   class="form-control border border-light @error('defendantMiddleName') is-invalid @enderror"
                   value="{{ old('defendantMiddleName') }}">
            @error('defendantMiddleName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col">
            <label>Last Name</label>
            <input type="text" name="defendantLastName"
                   class="form-control border border-light @error('defendantLastName') is-invalid @enderror"
                   value="{{ old('defendantLastName') }}" required>
            @error('defendantLastName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 mt-2">
        <label>Age</label>
        <input type="number" name="defendantAge"
               class="form-control border border-light @error('defendantAge') is-invalid @enderror"
               value="{{ old('defendantAge') }}">
        @error('defendantAge')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <hr>

    {{-- ================= WITNESS ================= --}}
    <h4>Witness (Optional)</h4>

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="witnessName"
               class="form-control border border-light @error('witnessName') is-invalid @enderror"
               value="{{ old('witnessName') }}">
        @error('witnessName')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Contact Number</label>
        <input type="text" name="witnessContactNumber"
               class="form-control border border-light @error('witnessContactNumber') is-invalid @enderror"
               value="{{ old('witnessContactNumber') }}">
        @error('witnessContactNumber')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <hr>

    {{-- ================= CASE DETAILS ================= --}}
    <h4>Case Details</h4>

    <div class="mb-3">
        <label>Upload Proof</label>
        <input type="file" name="proof"
               class="form-control border border-light @error('proof') is-invalid @enderror">
        @error('proof')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="blotterDescription"
                  class="form-control border border-light @error('blotterDescription') is-invalid @enderror"
                  rows="5" required>{{ old('blotterDescription') }}</textarea>
        @error('blotterDescription')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Submit Blotter
    </button>
</form>

{{-- ================= MODAL AUTO-OPEN ON ERROR ================= --}}
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('blotterModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
</script>
@endif

</form>


    
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Other scripts -->
    <script src="{{ asset('template/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
</body>