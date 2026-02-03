<style>
    .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1.5px solid #adb5bd !important;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25) !important;
        outline: 0;
    }

    .input-group-text {
        background-color: #f1f3f5;
        border: 1.5px solid #adb5bd !important;
        cursor: pointer;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
    }
</style>

<form action="{{ route(auth()->user()->role . '.update.ownInfo', $resident->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-body">
        @php
            $currentHouse = optional($resident->households->first())->house;
            $currentStreetId = optional($currentHouse)->street_id;
            $currentHouseId = optional($currentHouse)->id;
        @endphp

        {{--  <h6 class="text-muted mb-3">Address Information</h6>--}}

     

        <h6 class="text-muted mb-3">Personal Information</h6>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contactNo" class="form-control form-control-lg"
                       value="{{ old('contactNo', $resident->contactNo) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Birthday</label>
                <div class="input-group">
                    <input type="date" name="birthday" id="resident_birthday"
                           class="form-control form-control-lg" required
                           value="{{ old('birthday', $resident->birthday) }}">
                    <span class="input-group-text" id="resident_openDate">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control form-control-lg"
                       value="{{ old('age', $resident->age) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Sex</label>
                <select name="sex" class="form-select form-control-lg" required>
                    <option value="">Select</option>
                    <option value="male" {{ old('sex', $resident->sex) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('sex', $resident->sex) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Parent Status</label>
                <select name="parent" class="form-select form-control-lg" required>
                    <option value="">Select</option>
                    <option value="yes" {{ old('parent', $resident->parent) == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('parent', $resident->parent) == 'no' ? 'selected' : '' }}>No</option>
                    <option value="single" {{ old('parent', $resident->parent) == 'single' ? 'selected' : '' }}>Single</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Enrolled</label>
                <select name="enrolled" class="form-select form-control-lg" required>
                    <option value="">Select</option>
                    <option value="yes" {{ old('enrolled', $resident->enrolled) == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('enrolled', $resident->enrolled) == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <h6 class="text-muted mb-3">Other Details</h6>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Emergency Contact Name</label>
                <input type="text" name="emergencyContactName" class="form-control form-control-lg"
                       value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Emergency Contact No.</label>
                <input type="text" name="emergencyContactNo" class="form-control form-control-lg"
                       value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Educational Attainment</label>
                <input type="text" name="educationalAttainment" class="form-control form-control-lg"
                       value="{{ old('educationalAttainment', $resident->educationalAttainment) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Head of Family</label>
                <select name="headOfFamily" class="form-select form-control-lg" required>
                    <option value="">Select</option>
                    <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('headOfFamily', $resident->headOfFamily) == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Religion</label>
                <input type="text" name="religion" class="form-control form-control-lg"
                       value="{{ old('religion', $resident->religion) }}">
            </div>
        </div>
    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resBirthday = document.getElementById('resident_birthday');
        const resOpenDate = document.getElementById('resident_openDate');
        const rawDate = "{{ old('birthday', $resident->birthday) }}";
        
        // Birthday handling
        if (rawDate && resBirthday) {
            const d = new Date(rawDate);
            if (!isNaN(d)) {
                resBirthday.value = d.getFullYear() + '-' + 
                                   String(d.getMonth() + 1).padStart(2, '0') + '-' + 
                                   String(d.getDate()).padStart(2, '0');
            }
        }
        
        if (resOpenDate && resBirthday) {
            resOpenDate.addEventListener('click', function () {
                if (resBirthday.showPicker) {
                    resBirthday.showPicker();
                } else {
                    resBirthday.focus();
                }
            });
        }

        // Street and House dropdown relationship
        const houses = @json($houses ?? []);
        const residentId = "{{ $resident->id }}";
        const streetSelect = document.getElementById('edit_street_id_' + residentId);
        const houseSelect = document.getElementById('edit_house_id_' + residentId);
        const currentHouseId = "{{ old('house_id', $currentHouseId) }}";

        if (streetSelect && houseSelect) {
            // Function to populate house dropdown
            function populateHouses(streetId, selectedHouseId = null) {
                houseSelect.innerHTML = '<option value="">-- Select House Number --</option>';
                
                if (!streetId) return;

                houses.forEach(house => {
                    if (String(house.street_id) === String(streetId)) {
                        const option = document.createElement('option');
                        option.value = house.id;
                        option.textContent = house.house_no;
                        
                        // Select the current house if it matches
                        if (selectedHouseId && String(house.id) === String(selectedHouseId)) {
                            option.selected = true;
                        }
                        
                        houseSelect.appendChild(option);
                    }
                });
            }

            // Initialize houses on page load if street is already selected
            if (streetSelect.value) {
                populateHouses(streetSelect.value, currentHouseId);
            }

            // Update houses when street changes
            streetSelect.addEventListener('change', function () {
                populateHouses(this.value);
            });
        }
    });
</script>