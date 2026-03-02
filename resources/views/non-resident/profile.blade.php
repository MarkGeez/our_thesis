<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

<style>
    /* Use !important to override the external template.min.css */
    .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1.5px solid #ced4da !important;
        border-radius: 6px !important;
        padding: 10px 12px !important;
        font-size: 14px !important;
        display: block;
        width: 100%;
    }

    .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25) !important;
        outline: 0;
    }

    .form-label {
        font-weight: 600 !important;
        margin-bottom: 6px !important;
        display: inline-block;
    }
</style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
    @include('non-resident.nonresident-sidebar', ['non-resident' => auth()->user()])

    <div class="main-wrapper">
        @include('non-resident.nonresident-header', ['non-resident' => auth()->user()])
           

<main class="main users chart-page container-fluid py-4" id="skip-target">

    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Profile Overview</h3>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">User Information</h6>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center mb-3">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background-color: #f1f3f5;">
                                        <i class="fas fa-user" style="font-size: 60px; color: #adb5bd;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Full Name</div>
                        <div class="col-7">
                            {{ ucwords($user->firstName) }}
                            {{ ucwords($user->middleName) }}
                            {{ ucwords($user->lastName) }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email</div>
                        <div class="col-7">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Contact No.</div>
                        <div class="col-7">{{ $user->contactNumber }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Birthday</div>
                        <div class="col-7">{{ \Carbon\Carbon::parse($user->birthday)->format('F d, Y') }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Role</div>
                        <div class="col-7 text-capitalize">{{ $user->role }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Proof of Identity</div>
                        <div class="col-7">
                            @if($user->proofOfIdentity)
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#proofModalNonResident">
                                    View Proof
                                </button>
                            @else
                                <span class="text-muted">No proof uploaded</span>
                            @endif
                        </div>
                    </div>

                    
                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        Edit User Info
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
    <div class="card shadow-sm h-100">
        <div class="card-header bg-secondary text-white">
            <h6 class="mb-0">Resident Information</h6>
        </div>

        <div class="card-body">
            @if($resident)
                <div class="row mb-2">
                    <div class="col-5 text-muted">Resident Name</div>
                    <div class="col-7">
                        {{ ucwords($resident->firstName ?? $user->firstName) }}
                        {{ ucwords($resident->middleName ?? $user->middleName) }}
                        {{ ucwords($resident->lastName ?? $user->lastName) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Contact No.</div>
                    <div class="col-7">{{ $resident->contactNo ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Address</div>
                    <div class="col-7">{{ $resident->houseNo ?? 'N/A' }} {{ $resident->street ?? '' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Birthday</div>
                    <div class="col-7">{{ $resident->birthday ? \Carbon\Carbon::parse($resident->birthday)->format('F d, Y') : 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Age / Sex</div>
                    <div class="col-7">{{ $resident->age ?? 'N/A' }} / <span class="text-capitalize">{{ $resident->sex ?? 'N/A' }}</span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Parent Status</div>
                    <div class="col-7 text-capitalize">{{ $resident->parent ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Enrolled</div>
                    <div class="col-7 text-capitalize">{{ $resident->enrolled ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Head of Family</div>
                    <div class="col-7 text-capitalize">{{ $resident->headOfFamily ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Education</div>
                    <div class="col-7">{{ $resident->educationalAttainment ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Religion</div>
                    <div class="col-7">{{ $resident->religion ?? 'Not specified' }}</div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Emergency Contact</div>
                    <div class="col-7">{{ $resident->emergencyContactName ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Emergency No.</div>
                    <div class="col-7">{{ $resident->emergencyContactNo ?? 'N/A' }}</div>
                </div>

            @else
                <div class="alert alert-warning mb-0">
                    No resident information retrieved.
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            @if($resident)
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editResidentModal">
                    Edit Resident Info
                </button>
            @endif
        </div>
    </div>
</div>
    </div>

   <div class="row">
        <div class="col-12">

            <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Edit User Information</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @include('profileforms.edituser')
                        </div>
                    </div>
                </div>
            </div>

            @if($resident)
                <div class="modal fade" id="editResidentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title">Edit Resident Information</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @include('profileforms.editresident')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($user->proofOfIdentity)
        <div class="modal fade" id="proofModalNonResident" tabindex="-1" aria-labelledby="proofModalNonResidentLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="proofModalNonResidentLabel">Proof of Identity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $user->proofOfIdentity) }}" alt="Proof of identity" class="img-fluid" style="max-height:70vh;object-fit:contain;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
</div>

</div>
</main>


</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
</script>