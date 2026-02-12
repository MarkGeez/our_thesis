<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .action-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            border-color: #0d6efd;
        }
        .action-card i {
            transition: transform 0.3s ease;
        }
        .action-card:hover i {
            transform: scale(1.1);
        }
        .modal-header {
            background-color: #f8f9fa;
        }
        .purpose-other-input {
            border-left: 3px solid #0d6efd;
        }
        /* Custom gray border for text inputs and selects */
.form-control, 
.form-select {
    border: 1px solid #ced4da !important;
}


.form-check-input {
    border: 2px solid #adb5bd !important; 
}
.form-control:focus, 
.form-select:focus,
.form-check-input:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
}


.other-text-input {
    border: 1px solid #ced4da !important;
    border-left: 3px solid #0d6efd !important; 
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
            <div class="container mt-4">
                <h2 class="mb-4"><i class="fas fa-file-lines"></i> My Certificate Requests</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm action-card" data-bs-toggle="modal" data-bs-target="#modalBonafide">
                            <div class="card-body py-4">
                                <i class="fas fa-id-card fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">Bonafide</h5>
                                <p class="text-muted small my-2">General Residency Certificate</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm action-card" data-bs-toggle="modal" data-bs-target="#modalIndigency">
                            <div class="card-body py-4">
                                <i class="fas fa-hand-holding-heart fa-3x text-success mb-3"></i>
                                <h5 class="fw-bold">Indigency</h5>
                                <p class="text-muted small my-2">Financial & Burial Assistance</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm action-card" data-bs-toggle="modal" data-bs-target="#modalSoloParent">
                            <div class="card-body py-4">
                                <i class="fas fa-user-friends fa-3x text-info mb-3"></i>
                                <h5 class="fw-bold">Solo Parent</h5>
                                <p class="text-muted small my-2">Affidavit of Solo Parent</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm action-card" data-bs-toggle="modal" data-bs-target="#modalSenior">
                            <div class="card-body py-4">
                                <i class="fas fa-blind fa-3x text-warning mb-3"></i>
                                <h5 class="fw-bold">Senior Citizen</h5>
                                <p class="text-muted small my-2">Senior Residency Certificate</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3">My Recent Requests</h5>
                @if($requests->isEmpty())
                    <div class="alert alert-info shadow-sm">You have not submitted any certificate requests yet.</div>
                                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white shadow-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th>Certificate Type</th>
                                    <th>Purpose</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Approved/Rejected By</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                    <tr>
                                        <td><span class="">{{ ucfirst($req->certificate_type) }}</span></td>
                                        <td>{{ Str::limit($req->purpose, 50) }}</td>
                                        <td><small>{{ $req->address ?? '—' }}</small></td>
                                        <td>
                                            @switch($req->status)
                                                @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                                                @case('approved') <span class="badge bg-success">Approved</span> @break
                                                @case('picked_up') <span class="badge bg-secondary">Picked up</span> @break
                                                @case('declined') <span class="badge bg-danger">Declined</span> @break
                                                @default <span class="badge bg-secondary">{{ $req->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($req->approver)
                                                <small>{{ ucwords(strtolower($req->approver->firstName . ' ' . $req->approver->lastName)) }}</small>
                                                <br>
                                                <small class="text-muted">{{ $req->approved_at?->format('M d, Y H:i') ?? '-' }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($req->status === 'approved' || $req->status === 'picked_up')
                                                <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i>Ready for pickup.</span>
                                            @elseif($req->status === 'declined' && $req->decline_reason)
                                                <span class="text-muted small">{{ $req->decline_reason }}</span>
                                            @else — @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalBonafide" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.certificate.request.store') }}" method="POST">
            @csrf
            <input type="hidden" name="certificate_type" value="bonafide">
            <input type="hidden" name="purpose" value="Bonafide Certification">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-id-card me-2 text-primary"></i>Request Bonafide Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3">
                        <label class="form-label fw-bold">Postal Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required placeholder="Enter complete postal address">
                    </div>

                    <p class="small text-muted mb-3">Select the purpose(s) for this certification:</p>
                    <div class="purpose-group">
                        @php
                        $bonafidePurposes = [
                            'bonafide' => 'Bonafide Resident',
                            'medical' => 'Medical Treatment',
                            'hospital' => 'Hospitalization',
                            'postal' => 'Application for Postal ID',
                            'school' => 'School Reference',
                            'referral' => 'Referral',
                            'transaction' => 'Transaction in Bank',
                            'overseas' => 'Overseas Travel Papers',
                            'Ccalamity' => 'Processing for Calamity or Disaster Aid',
                            'sss' => 'S.S.S. Reference'
                        ];
                        @endphp
                        @foreach($bonafidePurposes as $key => $label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="request_data[{{ $key }}]" value="1" id="b_{{ $key }}">
                                <label class="form-check-label" for="b_{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                        <div class="form-check mb-2">
                            <input class="form-check-input purpose-others-toggle" type="checkbox" name="request_data[others]" value="1" id="b_others">
                            <label class="form-check-label" for="b_others">Others</label>
                        </div>
                        <input type="text" class="form-control mt-2 d-none other-text-input" name="request_data[others_specify]" placeholder="Please specify your purpose">
                    </div>

                    <div class="mt-4">
                        <label class="form-label fw-bold">Explain Your Purpose <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="purpose" rows="4" required placeholder="Please explain why you need this certificate and how you will use it..."></textarea>
                        <small class="text-muted">This will help the barangay officials better understand your request.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalIndigency" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.certificate.request.store') }}" method="POST">
            @csrf
            <input type="hidden" name="certificate_type" value="indigency">
            <input type="hidden" name="purpose" value="Indigency Certification">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-hand-holding-heart me-2 text-success"></i>Request Indigency Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                
                <div class="modal-body">

                    <div class="mt-3">
                        <label class="form-label fw-bold">Postal Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required placeholder="Enter complete postal address">
                    </div>

                    <p class="small text-muted mb-3">Select the purpose(s) for this certification:</p>
                    <div class="purpose-group">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="request_data[medical]" value="1" id="i_medical">
                            <label class="form-check-label" for="i_medical">Medical Assistance</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="request_data[educational]" value="1" id="i_educational">
                            <label class="form-check-label" for="i_educational">Educational Assistance</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="request_data[burial]" value="1" id="i_burial">
                            <label class="form-check-label" for="i_burial">Burial Assistance</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="request_data[financial]" value="1" id="i_financial">
                            <label class="form-check-label" for="i_financial">Financial Assistance</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input purpose-others-toggle" type="checkbox" name="request_data[others]" value="1" id="i_others">
                            <label class="form-check-label" for="i_others">Others</label>
                        </div>
                        <input type="text" class="form-control mt-2 d-none other-text-input" name="request_data[others_specify]" placeholder="Specify other indigency purpose">
                    </div>

                    <div class="mt-4">
                        <label class="form-label fw-bold">Explain Your Purpose <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="purpose" rows="4" required placeholder="Please explain why you need this certificate and how you will use it..."></textarea>
                        <small class="text-muted">This will help the barangay officials better understand your request.</small>
                    </div>

                    
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success w-100">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalSoloParent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.certificate.request.store') }}" method="POST">
            @csrf
            <input type="hidden" name="certificate_type" value="soloparent">
            <input type="hidden" name="purpose" value="Solo Parent Certification">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-friends me-2 text-info"></i>Affidavit of Solo Parent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label class="form-label">Number of Children</label>
                            <input type="number" id="solo_child_count" class="form-control" min="1" required>
                        </div>
                        <div class="col-12" id="solo_child_container"></div>
                        <div class="col-md-6">
                            <label class="form-label">Separated from</label>
                            <input type="text" name="request_data[separated_from]" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Since (Date)</label>
                            <input type="date" name="request_data[since]" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Current Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" required placeholder="Enter complete postal address">
                        </div>
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold">Explain Your Purpose <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="purpose" rows="4" required placeholder="Please explain why you need this affidavit and how you will use it..."></textarea>
                            <small class="text-muted">This will help the barangay officials better understand your request.</small>
                        </div>
                        <div class="col-12 mt-3">
    <label class="form-label fw-bold">Affidavit Statements</label>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" 
               name="request_data[whereabouts]" 
               value="1" id="soloCheck1" >
        <label class="form-check-label" for="soloCheck1">
            That I have no knowledge of the whereabouts of the father of my child/ children.
        </label>
    </div>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" 
               name="request_data[separated]" 
               value="1" id="soloCheck2" >
        <label class="form-check-label" for="soloCheck2">
            That I had separated from my partner, and at the present time, I have no husband/partner and 
            <br>
            as a Solo Parent, I am taking full custody and care of my child/ children mentioned in this affidavit.
        </label>
    </div>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" 
               name="request_data[attest_truth]" 
               value="1" id="soloCheck3" >
        <label class="form-check-label" for="soloCheck3">
            That this is being executed to attest to the truth of the foregoing facts and circumstances and
            <br> for whatever legal intents and purpose this instrument may serve.
        </label>
    </div>
</div>

                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-info text-white w-100">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalSenior" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.certificate.request.store') }}" method="POST">
            @csrf
            <input type="hidden" name="certificate_type" value="senior">
            <input type="hidden" name="purpose" value="Senior Citizen Residency">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-blind me-2 text-warning"></i>Senior Citizen Certification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required placeholder="Enter complete postal address">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Former Address</label>
                        <input type="text" name="form_data[former_address]" class="form-control" placeholder="Where did you live before?">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Explain Your Purpose <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="purpose" rows="4" required placeholder="Please explain why you need this certificate and how you will use it..."></textarea>
                        <small class="text-muted">This will help the barangay officials better understand your request.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-warning w-100 text-white">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("change", function (e) {
        // Toggle "Others" input visibility for checkboxes
        if (e.target.classList.contains("purpose-others-toggle")) {
            const modalBody = e.target.closest(".modal-body");
            const otherInput = modalBody.querySelector(".other-text-input");
            if (e.target.checked) {
                otherInput.classList.remove("d-none");
                otherInput.required = true;
                otherInput.focus();
            } else {
                otherInput.classList.add("d-none");
                otherInput.required = false;
                otherInput.value = "";
            }
        }
    });

    // Handle children fields in Solo Parent Modal
    document.getElementById('solo_child_count')?.addEventListener('input', function () {
        const container = document.getElementById('solo_child_container');
        container.innerHTML = '';
        const count = parseInt(this.value);
        if(isNaN(count)) return;

        for (let i = 1; i <= count; i++) {
            container.innerHTML += `
                <div class="card p-3 bg-light mb-2 border-0 shadow-sm">
                    <div class="row">
                        <div class="col-md-7">
                            <label class="small fw-bold">Child ${i} Name</label>
                            <input type="text" name="form_data[children][${i}][name]" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold">Birth Date</label>
                            <input type="date" name="form_data[children][${i}][dob]" class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>`;
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
