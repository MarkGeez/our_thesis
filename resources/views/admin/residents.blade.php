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
            margin-top: 15px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .invalid-feedback {
            font-weight: 500;
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#encodeResidentModal">
                        <i class="fas fa-plus me-2"></i> Encode Resident
                    </button>
                </div>

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
                <a href="{{ route($user->role . '.residents') }}" class="btn btn-outline-secondary px-4 d-inline-flex align-items-center">
                    <i class="fas fa-times me-2"></i> Clear
                </a>
            @endif
        </div>
    </div>
</form>

                @if($residents->isEmpty())
                    <div class="container bg-light p-3 m-3 alert alert-info">No residents found.</div>
                @else
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($residents as $resident)
                                    <tr>
                                        <td>{{ $resident->id }}</td>
                                        <td> {{ ucwords(strtolower($resident->firstName)) }} {{ ucwords(strtolower($resident->middleName)) }} {{ ucwords(strtolower($resident->lastName)) }} </td>
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                                <button class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#viewResident{{ $resident->id }}">
                                                    <i class="fa fa-eye fa-fw"></i><span>View</span>
                                                </button>
                                                <button class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#updateResident{{ $resident->id }}">
                                                    <i class="fa fa-edit fa-fw"></i><span>Edit</span>
                                                </button>
                                                <form action="{{ route($user->role . '.archive.resident', $resident->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash fa-fw"></i><span>Archive</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

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

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="updateResident{{ $resident->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Resident #{{ $resident->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route($user->role . '.update.resident', $resident->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <label for="firstName{{ $resident->id }}">First Name</label>
                                                        <input type="text" id="firstName{{ $resident->id }}" name="firstName" class="form-control @error('firstName') is-invalid @enderror" value="{{ old('firstName', $resident->firstName) }}" placeholder="e.g. John" required>
                                                        
                                                        <label for="middleName{{ $resident->id }}">Middle Name</label>
                                                        <input type="text" id="middleName{{ $resident->id }}" name="middleName" class="form-control @error('middleName') is-invalid @enderror" value="{{ old('middleName', $resident->middleName) }}" placeholder="e.g. Quency" required>
                                                        
                                                        <label for="lastName{{ $resident->id }}">Last Name</label>
                                                        <input type="text" id="lastName{{ $resident->id }}" name="lastName" class="form-control @error('lastName') is-invalid @enderror" value="{{ old('lastName', $resident->lastName) }}" placeholder="e.g. Doe" required>

                                                        <hr class="mt-4">

                                                        <label for="houseNo{{ $resident->id }}">House No.</label>
                                                        <input type="text" id="houseNo{{ $resident->id }}" name="houseNo" class="form-control @error('houseNo') is-invalid @enderror" value="{{ old('houseNo', $resident->houseNo) }}" placeholder="e.g. Lot 1 Blk 2" required>

                                                        <label for="street{{ $resident->id }}">Street</label>
                                                        <input type="text" id="street{{ $resident->id }}" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street', $resident->street) }}" placeholder="e.g. Magnolia St." required>

                                                        <label for="contactNo{{ $resident->id }}">Contact No.</label>
                                                        <input type="text" id="contactNo{{ $resident->id }}" name="contactNo" class="form-control @error('contactNo') is-invalid @enderror" value="{{ old('contactNo', $resident->contactNo) }}" placeholder="e.g. 09123456789" required>

                                                        <hr class="mt-4">

                                                        <label for="birthday{{ $resident->id }}">Birthday</label>
                                                        <input type="text" id="birthday{{ $resident->id }}" name="birthday" class="form-control date-picker-edit @error('birthday') is-invalid @enderror" value="{{ old('birthday', $resident->birthday) }}" placeholder="Select birth date..." required>

                                                        <label for="age{{ $resident->id }}">Age</label>
                                                        <input type="number" id="age{{ $resident->id }}" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $resident->age) }}" placeholder="0" min="0" max="255" required readonly>

                                                        <label for="sex{{ $resident->id }}">Sex</label>
                                                        <select id="sex{{ $resident->id }}" name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                                            <option value="">Select Sex</option>
                                                            <option value="male" {{ old('sex', $resident->sex) === 'male' ? 'selected' : '' }}>Male</option>
                                                            <option value="female" {{ old('sex', $resident->sex) === 'female' ? 'selected' : '' }}>Female</option>
                                                        </select>

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

                {{-- Global Errors/Success --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
            </div>

            <div class="modal fade" id="encodeResidentModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Encode Resident</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route($user->role . '.encode.residents') }}" method="post">
                                @csrf

                               <input type="text" name="search" class="form-control" placeholder="Enter name or ID here..." value="{{ request('search') }}">

<label for="firstName">First Name</label>
<input type="text" id="firstName" name="firstName" class="form-control" value="{{ old('firstName') }}" placeholder="Enter First Name here" required>

<label for="middleName">Middle Name</label>
<input type="text" id="middleName" name="middleName" class="form-control" value="{{ old('middleName') }}" placeholder="Enter Middle Name here" required>

<label for="lastName">Last Name</label>
<input type="text" id="lastName" name="lastName" class="form-control" value="{{ old('lastName') }}" placeholder="Enter Last Name here" required>

<hr class="mt-4">

<label for="houseNo">House No.</label>
<input type="text" id="houseNo" name="houseNo" class="form-control" value="{{ old('houseNo') }}" placeholder="Enter House No. here" required>

<label for="street">Street</label>
<input type="text" id="street" name="street" class="form-control" value="{{ old('street') }}" placeholder="Enter Street Name here" required>

<label for="contactNo">Contact No.</label>
<input type="text" id="contactNo" name="contactNo" class="form-control" value="{{ old('contactNo') }}" placeholder="09xxxxxxxxx" required>

<hr class="mt-4">

<label for="birthday">Birthday</label>
<input type="text" id="birthday" name="birthday" class="form-control date-picker" value="{{ old('birthday') }}" placeholder="Click to select Birthday" required>

<label for="age">Age</label>
<input type="number" id="age" name="age" class="form-control" value="{{ old('age') }}" placeholder="0" readonly>

<hr class="mt-4">

<label for="emergencyContactName">Emergency Contact Name</label>
<input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control" value="{{ old('emergencyContactName') }}" placeholder="Enter Full Name here" required>

<label for="emergencyContactNo">Emergency Contact No.</label>
<input type="text" id="emergencyContactNo" name="emergencyContactNo" class="form-control" value="{{ old('emergencyContactNo') }}" placeholder="09xxxxxxxxx" required>

<hr class="mt-4">

<label for="educationalAttainment">Educational Attainment</label>
<input type="text" id="educationalAttainment" name="educationalAttainment" class="form-control" value="{{ old('educationalAttainment') }}" placeholder="Enter Educational Attainment here">

<label for="religion">Religion</label>
<input type="text" name="religion" class="form-control" value="{{ old('religion') }}" placeholder="Enter Religion here">
                                <label for="headOfFamily">Head of Family</label>
                                <select id="headOfFamily" name="headOfFamily" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="yes" {{ old('headOfFamily') === 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('headOfFamily') === 'no' ? 'selected' : '' }}>No</option>
                                </select>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function calculateAge(birthDate, ageInput) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
            ageInput.value = age;
        }

        flatpickr(".date-picker", {
            allowInput: true,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today",
            onChange: function (selectedDates) {
                if (selectedDates.length) {
                    calculateAge(selectedDates[0], document.getElementById("age"));
                }
            }
        });

        flatpickr(".date-picker-edit", {
            allowInput: true,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length) {
                    const modalBody = instance.input.closest(".modal-body");
                    const ageInput = modalBody.querySelector('input[name="age"]');
                    calculateAge(selectedDates[0], ageInput);
                }
            }
        });
    });
</script>
</body>
</html>