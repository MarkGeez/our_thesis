<style>
    .resident-dropdown {
        position: absolute;
        z-index: 1050;
        background: white;
        border: 1px solid #dee2e6;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 4px;
    }

    .resident-option {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f1f1f1;
        font-size: 14px;
    }

    .resident-option:hover {
        background-color: #f8f9fa;
        color: #007bff;
    }

    .new-head-container {
        border-left: 3px solid #0d6efd;
        padding-left: 15px;
        background-color: #f0f7ff;
        padding-bottom: 10px;
        border-radius: 5px;
    }

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
@php
    $householdId = optional($resident->households->first())->id;
@endphp
<form action="{{ route(auth()->user()->role . '.update.ownInfo', $resident->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-body">
        @php
            $currentHouse = optional($resident->households->first())->house;
            $currentStreetId = optional($currentHouse)->street_id;
            $currentHouseId = optional($currentHouse)->id;

            $religionOptions = [
                'Unknown',
                    'Not Available',
                    'Roman Catholic',
                    'Iglesia ni Cristo',
                    'Born Again Christian',
                    'Baptist',
                    'Methodist',
                    'Lutheran',
                    'Presbyterian',
                    'Anglican',
                    'Seventh-day Adventist',
                    "Jehovah's Witnesses",
                    'Church of Christ',
                    'Philippine Independent Church or Aglipayan Church',
                    'Church of Jesus Christ of Latter-day Saints',
                    'Islam',
            
                    'Lumad indigenous religions',
                    'Anitism',
                    'Buddhism',
                    'Hinduism',
                    'Judaism',
                    "Baha'i Faith",
                    'Taoism',
                    'Confucianism',
                    'Atheist',
                    'Agnostic',
                    'Non-religious',
                    'Others',
            ];

            $educationOptions = [
                'Unknown',
                'No Formal Education',
                'Day Care',
                'Kindergarten',
                'Elementary Level',
                'Elementary Graduate',
                'Junior High School Level',
                'Junior High School Graduate',
                'Senior High School Level',
                'Senior High School Graduate',
                'Technical Vocational Education and Training Graduate',
                'TESDA Certificate holder',
                'College Level',
                'Associate Degree',
                "Bachelor's Degree",
                'Post Baccalaureate Certificate',
                'Professional Degree (Medicine, Law, Dentistry, Veterinary Medicine)',
                "Master's Degree Graduate",
                'Doctorate Degree Graduate',
                'Alternative Learning System Graduate',
                'Special Education',
            ];
        @endphp

        {{--  <h6 class="text-muted mb-3">Address Information</h6>--}}

     

        <h6 class="text-muted mb-3">Personal Information</h6>

        <div class="row mb-3">
            <div class="col-md-6">
                  <label class="form-label">Contact Number <span style="font-size: 12px; color: #6c757d; font-weight: 400;">Updates in user profile</span></label>
                  <input type="text" name="contactNo" id="contactNo" class="form-control form-control-lg"
                      value="{{ old('contactNo', $resident->contactNo) }}" >
                  <div id="contactNoError" class="invalid-feedback"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Birthday <span style="font-size: 12px; color: #6c757d; font-weight: 400;">Updates in user profile</span></label>
                <div class="input-group">
                    <input type="date" name="birthday" id="resident_birthday"
                           class="form-control form-control-lg" readonly
                           max="{{ now()->subDay()->format('Y-m-d') }}"
                           value="{{ old('birthday', $resident->birthday) }}" readonly>
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
                       value="{{ old('age', $resident->age) }}" required readonly>
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
                       value="{{ old('emergencyContactName', $resident->emergencyContactName) }}">
            </div>

            <div class="col-md-6">
                  <label class="form-label">Emergency Contact No.</label>
                  <input type="text" name="emergencyContactNo" id="emergencyContactNo" class="form-control form-control-lg"
                      value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" >
                  <div id="emergencyContactNoError" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Educational Attainment</label>
                @php
                    $selectedEducation = old('educationalAttainment', $resident->educationalAttainment ?? 'Unknown');
                    if (!in_array($selectedEducation, $educationOptions, true)) {
                        $selectedEducation = 'Unknown';
                    }
                @endphp
                <select name="educationalAttainment" class="form-select form-control-lg">
                    @foreach ($educationOptions as $option)
                        <option value="{{ $option }}" {{ $selectedEducation === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Head of Family</label>
                @if($resident->headOfFamily === 'yes')
                    <select
                        name="headOfFamily"
                        id="headOfFamilySelect_{{ $resident->id }}"
                        class="form-select form-control-lg head-of-family-trigger"
                        data-resident-id="{{ $resident->id }}"
                        data-original-value="{{ $resident->headOfFamily }}"
                        required
                    >
                        <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                    </select>
                @else
                    <input type="hidden" name="headOfFamily" value="no">
                    <input type="text" class="form-control form-control-lg" value="{{ ucfirst(old('headOfFamily', $resident->headOfFamily)) }}" readonly>
                @endif
            </div>
        </div>

        @if($resident->headOfFamily === 'yes')
            <div class="row mb-3 new-head-container" id="newHeadContainer_{{ $resident->id }}" style="display: none;">
                <div class="col-md-12">
                    <label class="form-label">Select New Head of Family</label>
                    <div class="mb-0 position-relative search-box-container"
                         data-resident-id="{{ $resident->id }}"
                         data-household-id="{{ $householdId }}">
                        <div class="input-group">
                            <input type="text"
                                   class="form-control new-head-search-input"
                                   placeholder="Enter resident name then press Enter or click Search"
                                   autocomplete="off">
                            <button type="button" class="btn btn-outline-primary new-head-search-btn">
                                Search
                            </button>
                        </div>

                        <input type="hidden" name="new_head_id" class="new-head-id-input" value="{{ old('new_head_id') }}">
                        <div class="resident-dropdown new-head-dropdown d-none"></div>
                        <div class="form-text">
                            Search only residents from the same household who are not currently a head of family.
                            <span class="text-danger">Make sure to search residents from the same household before entering for a new head.</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Religion</label>
                @php
                    $selectedReligion = old('religion', $resident->religion ?? 'Unknown');
                    if (!in_array($selectedReligion, $religionOptions, true)) {
                        $selectedReligion = 'Unknown';
                    }
                @endphp
                <select name="religion" class="form-select form-control-lg">
                    @foreach ($religionOptions as $option)
                        <option value="{{ $option }}" {{ $selectedReligion === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    // Contact number validation for resident
    document.addEventListener('DOMContentLoaded', function () {
        const contactNoInput = document.getElementById('contactNo');
        const contactNoError = document.getElementById('contactNoError');
        if (contactNoInput && contactNoError) {
            contactNoInput.addEventListener('input', () => {
                contactNoInput.value = contactNoInput.value.replace(/[^0-9]/g, '');
                if (contactNoInput.value.length > 11) {
                    contactNoInput.value = contactNoInput.value.slice(0, 11);
                }
                if (contactNoInput.value.length !== 11) {
                    contactNoError.textContent = "Must be exactly 11 digits.";
                } else {
                    contactNoError.textContent = "";
                }
            });
        }
        const emergencyContactNoInput = document.getElementById('emergencyContactNo');
        const emergencyContactNoError = document.getElementById('emergencyContactNoError');
        if (emergencyContactNoInput && emergencyContactNoError) {
            emergencyContactNoInput.addEventListener('input', () => {
                emergencyContactNoInput.value = emergencyContactNoInput.value.replace(/[^0-9]/g, '');
                if (emergencyContactNoInput.value.length > 11) {
                    emergencyContactNoInput.value = emergencyContactNoInput.value.slice(0, 11);
                }
                if (emergencyContactNoInput.value.length !== 11) {
                    emergencyContactNoError.textContent = "Must be exactly 11 digits.";
                } else {
                    emergencyContactNoError.textContent = "";
                }
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const headCandidateResidents = @json($headCandidateResidents ?? []);
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

        function formatName(value) {
            return value ? value.charAt(0).toUpperCase() + value.slice(1).toLowerCase() : '';
        }

        function closeNewHeadDropdown(container) {
            const dropdown = container.querySelector('.new-head-dropdown');
            if (!dropdown) {
                return;
            }

            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
        }

        function clearNewHeadSelection(container) {
            const searchInput = container.querySelector('.new-head-search-input');
            const hiddenInput = container.querySelector('.new-head-id-input');

            if (searchInput) {
                searchInput.value = '';
            }

            if (hiddenInput) {
                hiddenInput.value = '';
            }

            closeNewHeadDropdown(container);
        }

        function updateNewHeadVisibility(select) {
            const resId = select.dataset.residentId;
            const originalValue = select.dataset.originalValue;
            const container = document.getElementById(`newHeadContainer_${resId}`);

            if (!container) {
                return;
            }

            if (originalValue === 'yes' && select.value === 'no') {
                container.style.display = 'flex';
            } else {
                container.style.display = 'none';
                clearNewHeadSelection(container);
            }
        }

        function runNewHeadSearch(container) {
            const searchInput = container.querySelector('.new-head-search-input');
            const dropdown = container.querySelector('.new-head-dropdown');
            const hiddenInput = container.querySelector('.new-head-id-input');
            const currentResidentId = Number(container.dataset.residentId);
            const householdId = Number(container.dataset.householdId);
            const query = (searchInput.value || '').toLowerCase().trim();

            if (!dropdown || !hiddenInput) {
                return;
            }

            dropdown.innerHTML = '';
            hiddenInput.value = '';

            if (!query || !householdId) {
                closeNewHeadDropdown(container);
                return;
            }

            const matches = headCandidateResidents.filter(function (person) {
                const residentId = Number(person.id);
                const householdIds = Array.isArray(person.householdIds)
                    ? person.householdIds.map(Number)
                    : [];

                if (residentId === currentResidentId) return false;
                if (String(person.headOfFamily).toLowerCase() === 'yes') return false;
                if (!householdIds.includes(householdId)) return false;

                const fullName = (
                    `${person.lastName} ${person.firstName} ${person.middleName ?? ''}`
                ).toLowerCase();

                return fullName.includes(query) || residentId.toString().includes(query);
            }).slice(0, 8);

            if (matches.length === 0) {
                dropdown.innerHTML = '<div class="p-2 text-muted">No eligible non-head residents found</div>';
                dropdown.classList.remove('d-none');
                return;
            }

            matches.forEach(function (person) {
                const option = document.createElement('div');
                const last = formatName(person.lastName);
                const first = formatName(person.firstName);
                const middle = formatName(person.middleName);

                option.className = 'resident-option';
                option.textContent = `${last}, ${first}${middle ? ' ' + middle : ''} (ID: ${person.id})`;

                option.addEventListener('click', function () {
                    searchInput.value = option.textContent;
                    hiddenInput.value = person.id;
                    closeNewHeadDropdown(container);
                });

                dropdown.appendChild(option);
            });

            dropdown.classList.remove('d-none');
        }

        document.querySelectorAll('.head-of-family-trigger').forEach(function (select) {
            updateNewHeadVisibility(select);

            select.addEventListener('change', function () {
                updateNewHeadVisibility(select);
            });
        });

        document.querySelectorAll('.search-box-container').forEach(function (container) {
            const searchInput = container.querySelector('.new-head-search-input');
            const searchButton = container.querySelector('.new-head-search-btn');
            const hiddenInput = container.querySelector('.new-head-id-input');
            const form = container.closest('form');

            if (!searchInput || !searchButton || !hiddenInput) {
                return;
            }

            searchButton.addEventListener('click', function () {
                runNewHeadSearch(container);
            });

            searchInput.addEventListener('input', function () {
                hiddenInput.value = '';
                closeNewHeadDropdown(container);
            });

            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    runNewHeadSearch(container);
                }
            });

            if (form) {
                form.addEventListener('submit', function (e) {
                    const wrapper = container.closest('[id^="newHeadContainer_"]');
                    const isVisible = wrapper && wrapper.style.display !== 'none';

                    if (isVisible && !hiddenInput.value) {
                        e.preventDefault();
                        alert('Please select a new Head of Family from the dropdown.');
                        searchInput.focus();
                    }
                });
            }
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.search-box-container')) {
                document.querySelectorAll('.search-box-container').forEach(closeNewHeadDropdown);
            }
        });
    });
</script>
