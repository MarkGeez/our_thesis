<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    
    <style>
        .status-container {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.8;
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
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .complaint-id {
            font-size: 13px;
            color: #555;
        }

        .complaint-date {
            font-size: 12px;
            color: #777;
        }

        .complaint-details {
            font-size: 14px;
            line-height: 1.5;
            color: #222;
            background-color: #f9fafb;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .complaint-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
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
        .remarks-box {
            background-color: #f1f5f9;
            border-left: 4px solid #0d6efd;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #222;
            line-height: 1.5;
        }

        .remarks-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 4px;
            display: block;
        }

        .complaint-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    </style>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('subadmin.subadmin-sidebar', ['subadmin' => $subadmin])

    <div class="main-wrapper">
        @include('subadmin.subadmin-header', ['subadmin' => $subadmin])
        
        <main class="main users chart-page" id="skip-target">
            <div class="main-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="ms-3" style="color:#000000;">My Complaints</h2>
                    <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#complaintModal">
                        Create Complaint <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <!-- Modal ng Submit Complaint -->
                <div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('subadmin.submit.complaint') }}" method="POST">
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

                <div class="m-4 ms-3">
                    <div class="complaints-grid mt-3">
                        @foreach ($myComplaints as $complaints)
                            <div class="complaint-card">
                                <div class="complaint-header">
                                    <span class="complaint-id">Complaint ID: {{ $complaints->complainant_id }}</span>
                                    <span class="complaint-date">
                                        {{ date('M d, Y g:i A', strtotime($complaints->created_at)) }}
                                    </span>
                                </div>
                                
                                <div class="complaint-details">
                                        <span class="remarks-label">Complaint Details</span>hr
                                        {{ $complaints->details }}
                                    </div>
                                    
                                    <div class="complaint-footer">
                                        <div class="d-flex align-items-center gap-2">
                                            <strong>Status</strong>
                                            <span class="status-container status-{{ $complaints->status }}">
                                                {{ ucfirst($complaints->status) }}
                                            </span>
                                        </div>
                                        
                                        @if($complaints->remarks)
                                            <div class="remarks-box w-100">
                                                <span class="remarks-label">Official Remarks</span>
                                                {{ $complaints->remarks }}
                                            </div>
                                        @endif
                                    </div>
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

