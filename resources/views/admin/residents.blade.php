<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode Resident</title>

    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .modal-content .form-control, 
        .modal-content .form-select {
            border: 2px solid #dddddd !important;
            box-shadow: none !important;
            border-radius: 6px;
        }

        .modal-content .form-control:focus,
        .modal-content .form-select:focus {
            border: 2px solid #0056b3 !important;
            box-shadow: 0 0 0 0.15rem rgba(0,123,255,0.2) !important;
            outline: none !important;
        }

        .modal-content label {
            font-weight: 600;
            margin-top: 12px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .invalid-feedback {
            font-weight: 500;
        }
        
        .action-btns .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>
<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Resident List</h1>
                    @if (session('success'))
                        <p>{{session('success')}}</p>
                    @endif
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#encodeResidentModal">
                        <i class="fas fa-plus me-2"></i> Encode Resident
                    </button>
                </div>

                {{-- Search Form --}}
                <form action="{{ route($user->role . '.residents') }}" method="get" class="mb-4">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Search Resident</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control" placeholder="Enter name or ID here..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-auto d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Search</button>
                            @if(request('search'))
                                <a href="{{ route($user->role . '.residents') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                @if($residents->isEmpty())
                    <div class="alert alert-info">No residents found.</div>
                @else
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover bg-white">
                            <thead class="table-primary text-nowrap">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($residents as $resident)
                                    <tr>
                                        <td class="align-middle">{{ $resident->id }}</td>
                                        <td class="align-middle"> {{ ucwords(strtolower($resident->firstName)) }} {{ ucwords(strtolower($resident->middleName)) }} {{ ucwords(strtolower($resident->lastName)) }} </td>
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center align-items-center gap-2 action-btns">
                                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewResident{{ $resident->id }}">
                                                    <i class="fa fa-eye"></i><span>View</span>
                                                </button>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateResident{{ $resident->id }}">
                                                    <i class="fa fa-edit"></i><span>Edit</span>
                                                </button>
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addOfficial{{ $resident->id }}">
                                                    <i class="fa fa-user-tie"></i><span>{{ $resident->official ? 'Edit Official' : 'Set Official' }}</span>
                                                </button>
                                                <form action="{{ route($user->role . '.archive.resident', $resident->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i><span>Inactive</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal: View Resident --}}
                                    {{-- View Modal --}}
                                        <div class="modal fade" id="viewResident{{ $resident->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Resident Details #{{ $resident->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <section class="mb-4">
                                                            <h6 class="mb-3 text-uppercase fw-bold" style="letter-spacing:0.5px; border-left:4px solid #0d6efd; padding-left:10px;">Personal Information</h6>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Full Name</div>
                                                                    <div class="fs-6"> {{ ucwords(strtolower($resident->firstName)) }} {{ ucwords(strtolower($resident->middleName)) }} {{ ucwords(strtolower($resident->lastName)) }} </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Age</div>
                                                                    <div class="fs-6">{{ $resident->age }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Sex</div>
                                                                    <div class="fs-6">{{ ucfirst($resident->sex) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Birthday</div>
                                                                    <div class="fs-6">{{ \Carbon\Carbon::parse($resident->birthday)->format('M d, Y') }}</div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="fw-semibold text-secondary">Address</div>
                                                                    <div class="fs-6"> House No. {{ $resident->houseNo }}<br> {{ ucwords(strtolower($resident->street)) }} </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Contact Number</div>
                                                                    <div class="fs-6">{{ $resident->contactNo }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="fw-semibold text-secondary">Age</div>
                                                                <div class="fs-6">{{ $resident->age }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="fw-semibold text-secondary">Sex</div>
                                                                <div class="fs-6">{{ ucfirst($resident->sex) }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="fw-semibold text-secondary">Birthday</div>
                                                                <div class="fs-6">{{ \Carbon\Carbon::parse($resident->birthday)->format('M d, Y') }}</div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="fw-semibold text-secondary">Address</div>
                                                                <div class="fs-6"> House No. {{ $resident->houseNo }}<br> {{ ucwords(strtolower($resident->street)) }} </div>
                                                            </div>
                                                            <img src="{{ asset('storage/' . $resident->image_path) }}" alt="profile picture">                                                            <div class="col-md-6">
                                                                <div class="fw-semibold text-secondary">Contact Number</div>
                                                                <div class="fs-6">{{ $resident->contactNo }}</div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                        </section>

                                                        <section class="mb-4">
                                                            <h6 class="mb-3 text-uppercase fw-bold" style="letter-spacing:0.5px; border-left:4px solid #0d6efd; padding-left:10px;">Family & Status</h6>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Head of Family</div>
                                                                    <div class="fs-6">{{ ucfirst($resident->headOfFamily) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Parent Status</div>
                                                                    <div class="fs-6">{{ ucfirst($resident->parent) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Currently Enrolled</div>
                                                                    <div class="fs-6">{{ ucfirst($resident->enrolled) }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Educational Attainment</div>
                                                                    <div class="fs-6">{{ $resident->educationalAttainment ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Religion</div>
                                                                    <div class="fs-6">{{ $resident->religion ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="fw-semibold text-secondary">Emergency Contact</div>
                                                                    <div class="fs-6"> {{ ucwords(strtolower($resident->emergencyContactName ?? 'N/A')) }} ({{ $resident->emergencyContactNo ?? 'N/A' }}) </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    {{-- Modal: Add as Official --}}
                                    <div class="modal fade" id="addOfficial{{ $resident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $resident->official ? 'Update Official Status' : 'Set as Barangay Official' }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ $resident->official ? route('admin.update.official', $resident->official->id) : route('admin.add.official', $resident->id) }}" method="POST">
                                                        @csrf
                                                        @if($resident->official)
                                                            @method('PUT')
                                                        @endif
                                                        
                                                        <label>Select Position</label>
                                                        <select name="position" class="form-select" required>
                                                            <option value="Chairman" {{ $resident->official && $resident->official->position === 'Chairman' ? 'selected' : '' }}>Barangay Chairman</option>
                                                            <option value="Kagawad" {{ $resident->official && $resident->official->position === 'Kagawad' ? 'selected' : '' }}>Kagawad</option>
                                                            <option value="Secretary" {{ $resident->official && $resident->official->position === 'Secretary' ? 'selected' : '' }}>Secretary</option>
                                                            <option value="Treasurer" {{ $resident->official && $resident->official->position === 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
                                                            <option value="Sk Chairman" {{ $resident->official && $resident->official->position === 'Sk Chairman' ? 'selected' : '' }}>SK Chairman</option>
                                                            <option value="Sk Kagawad" {{ $resident->official && $resident->official->position === 'Sk Kagawad' ? 'selected' : '' }}>SK Kagawad</option>
                                                        </select>

                                                        <label>Term Description</label>
                                                        <input type="text" name="details" class="form-control" placeholder="e.g. 2023-2026 Term" value="{{ $resident->official ? $resident->official->details : '' }}">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Start Date</label>
                                                                <input type="text" name="start" class="form-control datetime-picker" placeholder="Select Start Date" value="{{ $resident->official ? $resident->official->start : '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>End Date</label>
                                                                <input type="text" name="end" class="form-control datetime-picker" placeholder="Select End Date" value="{{ $resident->official ? $resident->official->end : '' }}" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-end mt-4">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success">{{ $resident->official ? 'Update Official' : 'Save Official' }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal: Edit Resident --}}
                                    <div class="modal fade" id="updateResident{{ $resident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Resident #{{ $resident->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route($user->role . '.update.resident', $resident->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>First Name</label>
                                                                <input type="text" name="firstName" class="form-control" value="{{ old('firstName', $resident->firstName) }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Middle Name</label>
                                                                <input type="text" name="middleName" class="form-control" value="{{ old('middleName', $resident->middleName) }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Last Name</label>
                                                                <input type="text" name="lastName" class="form-control" value="{{ old('lastName', $resident->lastName) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>House No.</label>
                                                                <input type="text" name="houseNo" class="form-control" value="{{ old('houseNo', $resident->houseNo) }}" required>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label>Street</label>
                                                                <input type="text" name="street" class="form-control" value="{{ old('street', $resident->street) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Birthday</label>
                                                                <input type="text" name="birthday" class="form-control date-picker-edit" data-age-target="ageEdit{{ $resident->id }}" value="{{ old('birthday', $resident->birthday) }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Age</label>
                                                                <input type="number" id="ageEdit{{ $resident->id }}" name="age" class="form-control bg-light" value="{{ old('age', $resident->age) }}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Sex</label>
                                                                <select name="sex" class="form-select" required>
                                                                    <option value="male" {{ old('sex', $resident->sex) === 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('sex', $resident->sex) === 'female' ? 'selected' : '' }}>Female</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Contact No.</label>
                                                                <input type="text" name="contactNo" class="form-control" value="{{ old('contactNo', $resident->contactNo) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Head of Family</label>
                                                                <select name="headOfFamily" class="form-select" required>
                                                                    <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Parent Status</label>
                                                                <select name="parent" class="form-select" required>
                                                                    <option value="yes" {{ old('parent', $resident->parent) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('parent', $resident->parent) === 'no' ? 'selected' : '' }}>No</option>
                                                                    <option value="single" {{ old('parent', $resident->parent) === 'single' ? 'selected' : '' }}>Single Parent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Currently Enrolled</label>
                                                                <select name="enrolled" class="form-select" required>
                                                                    <option value="yes" {{ old('enrolled', $resident->enrolled) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('enrolled', $resident->enrolled) === 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Educational Attainment</label>
                                                                <input type="text" name="educationalAttainment" class="form-control" value="{{ old('educationalAttainment', $resident->educationalAttainment) }}" placeholder="e.g., College Graduate">
                                                            </div>
                                                        </div>

                                                        <label>Religion</label>
                                                        <input type="text" name="religion" class="form-control" value="{{ old('religion', $resident->religion) }}" placeholder="e.g., Roman Catholic">

                                                        <label for="age{{ $resident->id }}">Age</label>
                                                        <input type="number" id="age{{ $resident->id }}" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $resident->age) }}" placeholder="0" min="0" max="255" required readonly>

                                                        <label for="sex{{ $resident->id }}">Sex</label>
                                                        <select id="sex{{ $resident->id }}" name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                                            <option value="">Select Sex</option>
                                                            <option value="male" {{ old('sex', $resident->sex) === 'male' ? 'selected' : '' }}>Male</option>
                                                            <option value="female" {{ old('sex', $resident->sex) === 'female' ? 'selected' : '' }}>Female</option>
                                                        </select>
                                                        <input type="file" name="image_path" accept="image/jpeg,image/png">

                                                        <hr class="mt-4">

                                                        <label for="emergencyContactName{{ $resident->id }}">Emergency Contact Name</label>
                                                        <input type="text" id="emergencyContactName{{ $resident->id }}" name="emergencyContactName" class="form-control @error('emergencyContactName') is-invalid @enderror" value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" placeholder="Enter full name" required>

                                                        <label for="emergencyContactNo{{ $resident->id }}">Emergency Contact No.</label>
                                                        <input type="text" id="emergencyContactNo{{ $resident->id }}" name="emergencyContactNo" class="form-control @error('emergencyContactNo') is-invalid @enderror" value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" placeholder="e.g. 09123456789" required>

                                                        <hr class="mt-4">

                                                        <label for="parent{{ $resident->id }}">Parent Status</label>
                                                        <select id="parent{{ $resident->id }}" name="parent" class="form-select @error('parent') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('parent', $resident->parent) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('parent', $resident->parent) === 'no' ? 'selected' : '' }}>No</option>
                                                            <option value="single" {{ old('parent', $resident->parent) === 'single' ? 'selected' : '' }}>Single Parent</option>
                                                        </select>

                                                        <label for="enrolled{{ $resident->id }}">Currently Enrolled</label>
                                                        <select id="enrolled{{ $resident->id }}" name="enrolled" class="form-select @error('enrolled') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('enrolled', $resident->enrolled) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('enrolled', $resident->enrolled) === 'no' ? 'selected' : '' }}>No</option>
                                                        </select>

                                                        <label for="educationalAttainment{{ $resident->id }}">Educational Attainment</label>
                                                        <input type="text" id="educationalAttainment{{ $resident->id }}" name="educationalAttainment" class="form-control @error('educationalAttainment') is-invalid @enderror" value="{{ old('educationalAttainment', $resident->educationalAttainment) }}" placeholder="e.g. College Graduate">

                                                        <label for="religion{{ $resident->id }}">Religion</label>
                                                        <input type="text" id="religion{{ $resident->id }}" name="religion" class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion', $resident->religion) }}" placeholder="e.g. Catholic">

                                                        <label for="headOfFamily{{ $resident->id }}">Head of Family</label>
                                                        <select id="headOfFamily{{ $resident->id }}" name="headOfFamily" class="form-select @error('headOfFamily') is-invalid @enderror" required>
                                                            <option value="">Select Option</option>
                                                            <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Emergency Contact Name</label>
                                                                <input type="text" name="emergencyContactName" class="form-control" value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Emergency Contact No.</label>
                                                                <input type="text" name="emergencyContactNo" class="form-control" value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="text-end mt-4 pt-3 border-top">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary px-4">Update Resident</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Modal: Create New Resident --}}
            <div class="modal fade" id="encodeResidentModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Encode Resident</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route($user->role . '.encode.residents') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <!-- First Name -->
    <label>First Name</label>
    <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" 
           placeholder="Enter First Name" value="{{ old('firstName') }}" required>
    @error('firstName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Middle Name -->
    <label>Middle Name</label>
    <input type="text" name="middleName" class="form-control @error('middleName') is-invalid @enderror" 
           placeholder="Enter Middle Name" value="{{ old('middleName') }}" required>
    @error('middleName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Last Name -->
    <label>Last Name</label>
    <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" 
           placeholder="Enter Last Name" value="{{ old('lastName') }}" required>
    @error('lastName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Birthday -->
    <label>Birthday</label>
    <input type="text" id="birthdayCreate" name="birthday" class="form-control date-picker @error('birthday') is-invalid @enderror" 
           placeholder="Select Birthday" value="{{ old('birthday') }}" required>
    @error('birthday')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Age -->
    <label>Age</label>
    <input type="number" id="ageCreate" name="age" class="form-control bg-light @error('age') is-invalid @enderror" 
           value="{{ old('age') }}" readonly>
    @error('age')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- House No -->
    <label for="houseNo">House No.</label>
    <input type="text" id="houseNo" name="houseNo" class="form-control @error('houseNo') is-invalid @enderror" 
           value="{{ old('houseNo') }}" placeholder="Enter House No. here" required>
    @error('houseNo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Street -->
    <label for="street">Street</label>
    <input type="text" id="street" name="street" class="form-control @error('street') is-invalid @enderror" 
           value="{{ old('street') }}" placeholder="Enter Street Name here" required>
    @error('street')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Contact No - REMOVED DUPLICATE, KEPT THIS ONE -->
    <label for="contactNo">Contact No.</label>
    <input type="text" id="contactNo" name="contactNo" class="form-control @error('contactNo') is-invalid @enderror" 
           value="{{ old('contactNo') }}" placeholder="09xxxxxxxxx" required>
    @error('contactNo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Sex (Added missing field) -->
    <label for="sex">Sex</label>
    <select id="sex" name="sex" class="form-select @error('sex') is-invalid @enderror">
        <option value="">Select Sex</option>
        <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
    </select>
    @error('sex')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Parent Status (Added missing field) -->
    <label for="parent">Parent Status</label>
    <select id="parent" name="parent" class="form-select @error('parent') is-invalid @enderror">
        <option value="">Select Parent Status</option>
        <option value="yes" {{ old('parent') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('parent') === 'no' ? 'selected' : '' }}>No</option>
        <option value="single" {{ old('parent') === 'single' ? 'selected' : '' }}>Single Parent</option>
    </select>
    @error('parent')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Enrolled (Added missing field) -->
    <label for="enrolled">Enrolled in School</label>
    <select id="enrolled" name="enrolled" class="form-select @error('enrolled') is-invalid @enderror">
        <option value="">Select Enrollment Status</option>
        <option value="yes" {{ old('enrolled') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('enrolled') === 'no' ? 'selected' : '' }}>No</option>
    </select>
    @error('enrolled')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Image -->
    <label for="image_path">Profile Image</label>
    <input type="file" name="image_path" id="image_path" class="form-control @error('image_path') is-invalid @enderror" 
           accept="image/png, image/jpg, image/jpeg">
    @error('image_path')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Emergency Contact Name -->
    <label for="emergencyContactName">Emergency Contact Name</label>
    <input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control @error('emergencyContactName') is-invalid @enderror" 
           value="{{ old('emergencyContactName') }}" placeholder="Enter Full Name here" required>
    @error('emergencyContactName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Emergency Contact No -->
    <label for="emergencyContactNo">Emergency Contact No.</label>
    <input type="text" id="emergencyContactNo" name="emergencyContactNo" class="form-control @error('emergencyContactNo') is-invalid @enderror" 
           value="{{ old('emergencyContactNo') }}" placeholder="09xxxxxxxxx" required>
    @error('emergencyContactNo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <hr class="mt-4">

    <!-- Educational Attainment -->
    <label for="educationalAttainment">Educational Attainment</label>
    <input type="text" id="educationalAttainment" name="educationalAttainment" class="form-control @error('educationalAttainment') is-invalid @enderror" 
           value="{{ old('educationalAttainment') }}" placeholder="Enter Educational Attainment here">
    @error('educationalAttainment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Religion -->
    <label for="religion">Religion</label>
    <input type="text" name="religion" class="form-control @error('religion') is-invalid @enderror" 
           value="{{ old('religion') }}" placeholder="Enter Religion here">
    @error('religion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Head of Family -->
    <label for="headOfFamily">Head of Family</label>
    <select id="headOfFamily" name="headOfFamily" class="form-select @error('headOfFamily') is-invalid @enderror" required>
        <option value="">Select Option</option>
        <option value="yes" {{ old('headOfFamily') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('headOfFamily') === 'no' ? 'selected' : '' }}>No</option>
    </select>
    @error('headOfFamily')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- REMOVED DUPLICATE CONTACT NO FIELD THAT WAS HERE -->

    <div class="text-end mt-4 pt-3 border-top">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary px-4">Save Resident</button>
    </div>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Universal Age Calculator
        function calculateAge(birthDate, targetInputId) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
            document.getElementById(targetInputId).value = age;
        }

        // Initialize Flatpickr for Create Modal
        flatpickr(".date-picker", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            onChange: function (selectedDates) {
                if (selectedDates.length) calculateAge(selectedDates[0], "ageCreate");
            }
        });

        // Initialize Flatpickr for Edit Modals
        flatpickr(".date-picker-edit", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                const targetId = instance.element.getAttribute('data-age-target');
                if (selectedDates.length) calculateAge(selectedDates[0], targetId);
            }
        });

        // --- NEW: Initialize Flatpickr for Official Assignment dates ---
        flatpickr(".datetime-picker", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,         
            altFormat: "F j, Y", 
            allowInput: true
        });
    });
</script>
</body>
</html>