<head>
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
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

        /* Improved Modal Styles */
        .complaint-modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }

        .complaint-modal .modal-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            border-radius: 16px 16px 0 0;
            padding: 24px;
        }

        .complaint-modal .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .complaint-modal .modal-body {
            padding: 28px;
            background-color: #f8f9fa;
        }

        .complaint-modal .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .complaint-modal .form-label i {
            font-size: 16px;
            color: #0d6efd;
        }

        .complaint-modal .form-control,
        .complaint-modal .form-textarea {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: white;
        }

        .complaint-modal .form-control:focus,
        .complaint-modal .form-textarea:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        .complaint-modal textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-size: 14px;
            line-height: 1.5;
        }

        .char-counter {
            font-size: 12px;
            color: #6c757d;
            margin-top: 6px;
            text-align: right;
        }

        .char-counter.warning {
            color: #ff9800;
        }

        .char-counter.danger {
            color: #d32f2f;
        }

        .complaint-modal .modal-footer {
            background-color: #f8f9fa;
            border: none;
            padding: 20px 28px;
            border-radius: 0 0 16px 16px;
            gap: 12px;
        }

        .complaint-modal .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 28px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .complaint-modal .btn-outline-secondary {
            border: 2px solid #dee2e6;
            color: #6c757d;
        }

        .complaint-modal .btn-outline-secondary:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
            color: #495057;
        }

        .complaint-modal .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            padding: 10px 32px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .complaint-modal .btn-primary:hover {
            background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(13, 110, 253, 0.3);
        }

        .complaint-modal .btn-primary:active {
            transform: translateY(0);
        }

        .form-group-wrapper {
            margin-bottom: 22px;
        }

        .form-group-wrapper:last-child {
            margin-bottom: 0;
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
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="main-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="ms-3" style="color:#000000;">My Complaints</h2>
                    <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#complaintModal">
                        Create Complaint <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <!-- Modal ng Submit Complaint -->
                <div class="modal fade complaint-modal" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('admin.submit.complaint') }}" method="POST" id="complaintForm">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="complaintModalLabel">
                                        <i class="fas fa-file-alt"></i>
                                        Submit a Complaint
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group-wrapper">
                                        <label for="address" class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Incident Location
                                        </label>
                                        <input 
                                            type="text"
                                            name="address"
                                            id="address"
                                            value="{{ old('address') }}"
                                            class="form-control"
                                            placeholder="Enter the specific address or location of the incident"
                                            required
                                        >
                                        @error('address')
                                            <div class="text-danger small mt-2" style="font-size: 12px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-wrapper">
                                        <label for="details" class="form-label">
                                            <i class="fas fa-pen-fancy"></i>
                                            Complaint Details
                                        </label>
                                        <textarea
                                            name="details"
                                            id="details"
                                            class="form-control"
                                            placeholder="Please provide detailed information about your complaint, including what happened, when it occurred, and any relevant details..."
                                            required
                                            maxlength="1000"
                                        >{{ old('details') }}</textarea>
                                        <div class="char-counter">
                                            <span id="charCount">0</span> / 1000 characters
                                        </div>
                                        @error('details')
                                            <div class="text-danger small mt-2" style="font-size: 12px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-paper-plane"></i> Submit Complaint
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="m-4 ms-3">
                    <div class="complaints-grid mt-3">
                        @if ($myComplaints->count() > 0)
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
                                                {{ ucfirst($complaints->status === 'pending' ? 'processing' : $complaints->status) }}
                                            </span>
                                        </div>
                                        
                                        @if($complaints->remarks)
                                            @php
                                                $remarksText = $complaints->remarks ?? '';
                                                $lines = preg_split("/\r\n|\n|\r/", $remarksText);
                                                $formattedLines = [];
                                                foreach ($lines as $line) {
                                                    $line = trim($line);
                                                    if ($line === '') {
                                                        $formattedLines[] = $line;
                                                        continue;
                                                    }
                                                    if (preg_match('/^(.*? - )([^:]+)(: .*)$/', $line, $matches)) {
                                                        $formattedLines[] = $matches[1] . \Illuminate\Support\Str::title($matches[2]) . $matches[3];
                                                    } else {
                                                        $formattedLines[] = $line;
                                                    }
                                                }
                                                $formattedRemarks = implode(PHP_EOL, $formattedLines);
                                            @endphp
                                            <div class="remarks-box w-100">
                                                <span class="remarks-label">Official Remarks</span>
                                                {!! nl2br(e($formattedRemarks)) !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
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

<script>
    // Character counter for details textarea
    const detailsTextarea = document.getElementById('details');
    const charCount = document.getElementById('charCount');
    
    if (detailsTextarea && charCount) {
        detailsTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            const counter = charCount.parentElement;
            counter.classList.remove('warning', 'danger');
            
            if (count >= 900) {
                counter.classList.add('danger');
            } else if (count >= 800) {
                counter.classList.add('warning');
            }
        });
        
        // Initialize counter on page load if form has old data
        charCount.textContent = detailsTextarea.value.length;
        if (detailsTextarea.value.length >= 800) {
            charCount.parentElement.classList.add(detailsTextarea.value.length >= 900 ? 'danger' : 'warning');
        }
    }
</script>

