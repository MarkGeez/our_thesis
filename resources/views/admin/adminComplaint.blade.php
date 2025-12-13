<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    .status-container {
    padding: 5px 10px;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    line-height: 2.5;
}

    .status-resolved {
        background-color: #28a7463f;
        border: solid 1px green;
        color: green;
    }
    .status-rejected {
        background-color: #dc35463b;
        border: solid 1px red;
        color: red;
    }
    .status-on-going {
        background-color: #ffc1073d;
        border: solid 1px #ffa500;
        color: #000;
    }
    .status-pending {
        
        color: rgb(0, 0, 0);
    }

    .complaint-card {
    max-width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #ffffff;
    margin: 5px 20px;
    padding: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.complaints-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
    justify-items: stretch;
    align-items: start;
    padding-top: 10px;
}

@media (max-width: 768px) {
    .complaints-grid {
        grid-template-columns: 1fr;
    }
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
            <div class="main-container">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="ms-3" style="color:#000000;">Complaints</h2>
                    <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#complaintModal">
                        New Complaint
                    </button>
                </div>

                <!-- Modal ng Submit Complaint -->
                <div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('admin.submit.complaint') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="complaintModalLabel">Submit Complaint</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-semibold">Address location</label>
                                        <input 
                                            type="text"
                                            name="address"
                                            id="address"
                                            value="{{ old('address') }}"
                                            class="form-control border-dark"
                                            required
                                        >
                                        @error('address')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="details" class="form-label fw-semibold">Details of complaint</label>
                                        <textarea
                                            name="details"
                                            id="details"
                                            rows="5"
                                            class="form-control border-dark"
                                            required
                                        >{{ old('details') }}</textarea>
                                        @error('details')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Submit Complaint</button>
                                    
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-4 ms-3">
                    

                    <div class="complaints-grid mt-3">
                        @foreach ($myComplaints as $complaints)
                            <div class="complaint-card">

                                <p><strong>Complainant ID:</strong> {{ $complaints->complainant_id }}</p>

                                <p><strong>Details:</strong></p>
                                <div class="announcement-text mb-2">
                                    <p style="line-height: 1.35em;">
                                        {{ $complaints->details }}
                                    </p>
                                </div>

                                <p><strong>Complaint Date:</strong> {{ date('M-d-Y g:i A', strtotime($complaints->created_at)) }}</p>

                                <p>
                                    <strong>Status:</strong>
                                    <span class="status-container status-{{ $complaints->status }}">
                                        {{ ucfirst($complaints->status) }}
                                    </span>
                                </p>

                            </div>
                        @endforeach
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
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('complaintModal');
        if (el) {
            var modal = new bootstrap.Modal(el);
            modal.show();
        }
    });
</script>
@endif


