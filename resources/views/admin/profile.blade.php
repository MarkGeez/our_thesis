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

        @include('components.displayFamily');

        <div class="card-footer text-end">
            <button 
                type="button" 
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#addFamilyMemberModal">
                <i class="fas fa-user-plus me-2"></i>Add Family Member
            </button>
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

    <!-- Add Family Member Modal -->
    <div class="modal fade" id="addFamilyMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add Family Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" ></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route(auth()->user()->role . '.family.store') }}" id="addFamilyForm">
                        @csrf
                        <!-- Debug: Route is {{ route(auth()->user()->role . '.family.store') }} -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required placeholder="Enter first name">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter middle name">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required placeholder="Enter last name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="birthday" name="birthdate" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                <select class="form-select" id="sex" name="sex" required>
                                    <option value="" selected disabled>Select sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter contact number">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="relationship" class="form-label">Relationship</label>
                                <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Enter relationship">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" form="addFamilyForm" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Add Family Member
                    </button>
                </div>
            </div>
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
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
</script>