<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style> .form-control, .form-select { background-color: #ffffff; border: 1.5px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 14px; } .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25); } .form-label { font-weight: 600; margin-bottom: 6px; } .input-group-text { background-color: #f1f3f5; cursor: pointer; } </style>

</head>


 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])


<div class="main-wrapper">
           
    @include('admin.admin-header', ['admin' => auth()->user()])
           

<main class="main users chart-page container-fluid py-4" id="skip-target">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                                @if($admin->profile_image)
                                    <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
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
                            {{ ucwords($admin->firstName) }}
                            {{ ucwords($admin->middleName) }}
                            {{ ucwords($admin->lastName) }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email</div>
                        <div class="col-7">{{ $admin->email }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Contact No.</div>
                        <div class="col-7">{{ $admin->contactNumber }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Birthday</div>
                        <div class="col-7">{{ \Carbon\Carbon::parse($admin->birthday)->format('F d, Y') }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Role</div>
                        <div class="col-7 text-capitalize">{{ $admin->role }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted">Proof of Identity</div>
                        <div class="col-7">
                            @if($admin->proofOfIdentity)
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#proofModalAdmin">
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
                        {{ ucwords($resident->firstName) }}
                        {{ ucwords($resident->middleName) }}
                        {{ ucwords($resident->lastName) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Contact No.</div>
                    <div class="col-7">{{ $resident->contactNo }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Address</div>
                    <div class="col-7">
                        @if($resident && $resident->households->first() && $resident->households->first()->house)
                            @php
                                $house = $resident->households->first()->house;
                                $street = optional($house)->street;
                            @endphp
                            {{ $house->house_no ?? 'N/A' }} {{ optional($street)->street_name ?? '' }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Birthday</div>
                    <div class="col-7">{{ \Carbon\Carbon::parse($resident->birthday)->format('F d, Y') }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Age / Sex</div>
                    <div class="col-7">{{ $resident->age }} / <span class="text-capitalize">{{ $resident->sex }}</span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Parent Status</div>
                    <div class="col-7 text-capitalize">{{ $resident->parent }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Enrolled</div>
                    <div class="col-7 text-capitalize">{{ $resident->enrolled }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Head of Family</div>
                    <div class="col-7 text-capitalize">{{ $resident->headOfFamily }}</div>
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
                    <div class="col-7">{{ $resident->emergencyContactName }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Emergency No.</div>
                    <div class="col-7">{{ $resident->emergencyContactNo }}</div>
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
                <button class="btn btn-sm btn-outline-success" onclick="window.location.href='{{ route('admin.family.add') }}'">
                    <i class="fas fa-user-plus me-1"></i>Add Family Member
                </button>
            @endif
        </div>
    </div>
</div>

    @if($members && $members->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Family Members ({{ $members->count() }})</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($members as $member)
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100 position-relative">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ ucwords($member->firstName) }} {{ ucwords($member->middleName ?? '') }} {{ ucwords($member->lastName) }}</h6>
                                        <small class="text-muted">{{ ucfirst($member->sex ?? 'N/A') }}</small>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                            <button type="submit" class="btn btn-outline-danger" title="Untag" onclick="return confirm('Are you sure you want to remove this family member?')">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                    </div>
                                </div>
                                
                                <div class="small">
                                    <div class="mb-1">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        {{ $member->contactNumber ?? $member->contactNo ?? 'N/A' }}
                                    </div>
                                    <div class="mb-1">
                                        <i class="fas fa-birthday-cake me-2 text-muted"></i>
                                        @if($member->birthdate || $member->birthday)
                                            {{ \Carbon\Carbon::parse($member->birthdate ?? $member->birthday)->format('F d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                    @if($member->relationship)
                                    <div class="mb-1">
                                        <i class="fas fa-heart me-2 text-muted"></i>
                                        {{ $member->relationship }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>No family members found.
    </div>
@endif

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
    {{-- @include("profileforms.addMember")
 --}}

    @if($admin->proofOfIdentity)
        <div class="modal fade" id="proofModalAdmin" tabindex="-1" aria-labelledby="proofModalAdminLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="proofModalAdminLabel">Proof of Identity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $admin->proofOfIdentity) }}" alt="Proof of identity" class="img-fluid" style="max-height:70vh;object-fit:contain;">
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