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

    .auth-alert {
        border-radius: 8px;
        padding: 0.45rem 0.65rem;
        margin-top: 0.35rem;
        font-size: 0.72rem;
        line-height: 1.4;
        display: flex;
        align-items: flex-start;
        gap: 0.45rem;
        border: 1px solid transparent;
        font-weight: 500;
    }

    .auth-alert-error {
        background: rgba(239, 68, 68, 0.22);
        color: #fef2f2;
        border-color: rgba(239, 68, 68, 0.55);
    }

    .resident-option-name {
        font-weight: 600;
    }

    .resident-option-meta {
        font-size: 0.82rem;
        color: #6c757d;
    }

    .resident-dropdown-message {
        font-size: 0.9rem;
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
            $currentHouseholdId = optional($resident->households->first())->id;
            $isCurrentHead = ($resident->headOfFamily ?? null) === 'yes';

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
              <input type="text" class="form-control form-control-lg"
                  value="{{ optional($resident->user)->contactNumber ?? $resident->contactNo ?? 'N/A' }}" readonly>
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
                <input type="tel" name="emergencyContactNo" class="form-control form-control-lg"
                       value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" inputmode="numeric" pattern="^09\d{9}$" maxlength="11" placeholder="09170000000">
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
                @if ($isCurrentHead)
                    <select
                        name="headOfFamily"
                        class="form-select form-control-lg profile-head-of-family-trigger"
                        data-original-value="{{ $resident->headOfFamily }}"
                        data-resident-id="{{ $resident->id }}"
                    >
                        <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('headOfFamily', $resident->headOfFamily) === 'no' ? 'selected' : '' }}>No</option>
                    </select>
                @else
                    <input type="hidden" name="headOfFamily" value="no">
                    <input type="text" class="form-control form-control-lg" value="No" readonly>
                    <small class="text-muted d-block mt-2">Only the current household head can transfer head status.</small>
                @endif
            </div>
        </div>

        @if ($isCurrentHead)
            <div
                class="border rounded p-3 mt-2 mb-3 profile-new-head-search-container d-none"
                data-resident-id="{{ $resident->id }}"
                data-household-id="{{ $currentHouseholdId }}"
                data-house-id="{{ $currentHouseId }}"
            >
                <label class="form-label" for="profile_new_head_search_{{ $resident->id }}">Select New Head of Family</label>
                <div class="input-group mb-2">
                    <input
                        type="text"
                        id="profile_new_head_search_{{ $resident->id }}"
                        class="form-control profile-new-head-search-input"
                        placeholder="Search a resident from the same household or house"
                        autocomplete="off"
                    >
                    <button type="button" class="btn btn-outline-primary profile-new-head-search-btn">Search</button>
                </div>
                <div class="form-text mb-2">
                    This only appears when a current head changes from `Yes` to `No`.
                </div>
                <input type="hidden" name="new_head_id" class="profile-new-head-id-input" value="{{ old('new_head_id') }}">
                <div class="list-group profile-new-head-results d-none"></div>
                @error('new_head_id')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
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
    document.addEventListener('DOMContentLoaded', function () {
        const headCandidateResidents = @json($headCandidateResidents ?? []);
        const resBirthday = document.getElementById('resident_birthday');
        const resOpenDate = document.getElementById('resident_openDate');
        const rawDate = "{{ old('birthday', $resident->birthday) }}";
        const profileHeadSelect = document.querySelector('.profile-head-of-family-trigger');
        const newHeadContainer = document.querySelector('.profile-new-head-search-container');
        
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

        function normalize(value) {
            return String(value || '').trim().toLowerCase();
        }

        function formatBirthday(value) {
            if (!value) {
                return 'Birthday: N/A';
            }

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
                return 'Birthday: N/A';
            }

            return 'Birthday: ' + date.toLocaleDateString(undefined, {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
        }

        function formatAge(value) {
            return value ? 'Age: ' + value : 'Age: N/A';
        }

        function formatSex(value) {
            return 'Sex: ' + (value ? String(value).charAt(0).toUpperCase() + String(value).slice(1) : 'N/A');
        }

        function formatContact(value) {
            return 'Contact: ' + (value || 'N/A');
        }

        function buildSearchTerms(person) {
            return [
                person.firstName,
                person.middleName,
                person.lastName,
                [person.firstName, person.middleName, person.lastName].filter(Boolean).join(' '),
            ].map(normalize).filter(Boolean);
        }

        function updateNewHeadVisibility() {
            if (!profileHeadSelect || !newHeadContainer) {
                return;
            }

            const shouldShow = normalize(profileHeadSelect.dataset.originalValue) === 'yes'
                && normalize(profileHeadSelect.value) === 'no';

            newHeadContainer.classList.toggle('d-none', !shouldShow);

            const newHeadIdInput = newHeadContainer.querySelector('.profile-new-head-id-input');
            if (newHeadIdInput) {
                newHeadIdInput.required = shouldShow;
                if (!shouldShow) {
                    newHeadIdInput.value = '';
                }
            }

            const searchInput = newHeadContainer.querySelector('.profile-new-head-search-input');
            const results = newHeadContainer.querySelector('.profile-new-head-results');
            if (!shouldShow && searchInput && results) {
                searchInput.value = '';
                results.innerHTML = '';
                results.classList.add('d-none');
            }
        }

        function runProfileNewHeadSearch() {
            if (!newHeadContainer) {
                return;
            }

            const residentId = Number(newHeadContainer.dataset.residentId);
            const householdId = Number(newHeadContainer.dataset.householdId);
            const houseId = Number(newHeadContainer.dataset.houseId);
            const searchInput = newHeadContainer.querySelector('.profile-new-head-search-input');
            const results = newHeadContainer.querySelector('.profile-new-head-results');
            const query = normalize(searchInput ? searchInput.value : '');

            if (!results) {
                return;
            }

            const matches = headCandidateResidents.filter(function (person) {
                if (Number(person.id) === residentId) return false;
                if (normalize(person.headOfFamily) === 'yes') return false;

                const sameHousehold = Array.isArray(person.householdIds) && person.householdIds.some(function (id) {
                    return Number(id) === householdId;
                });
                const sameHouse = Array.isArray(person.houseIds) && person.houseIds.some(function (id) {
                    return Number(id) === houseId;
                });

                if (!sameHousehold && !sameHouse) return false;
                if (!query) return true;

                return buildSearchTerms(person).some(function (term) {
                    return term.includes(query);
                });
            });

            results.innerHTML = '';
            results.classList.remove('d-none');

            if (!matches.length) {
                results.innerHTML = '<div class="list-group-item resident-dropdown-message text-muted">No eligible resident found.</div>';
                return;
            }

            matches.forEach(function (person) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'list-group-item list-group-item-action';
                button.innerHTML =
                    '<div class="resident-option-name">' +
                        [person.firstName, person.middleName, person.lastName].filter(Boolean).join(' ') +
                    '</div>' +
                    '<div class="resident-option-meta">' +
                        [formatBirthday(person.birthday), formatAge(person.age), formatSex(person.sex), formatContact(person.contactNo)].join(' | ') +
                    '</div>';

                button.addEventListener('click', function () {
                    const newHeadIdInput = newHeadContainer.querySelector('.profile-new-head-id-input');
                    if (newHeadIdInput) {
                        newHeadIdInput.value = person.id;
                    }

                    if (searchInput) {
                        searchInput.value = [person.firstName, person.middleName, person.lastName].filter(Boolean).join(' ');
                    }

                    results.innerHTML = '';
                    results.classList.add('d-none');
                });

                results.appendChild(button);
            });
        }

        if (profileHeadSelect) {
            profileHeadSelect.addEventListener('change', updateNewHeadVisibility);
            updateNewHeadVisibility();
        }

        if (newHeadContainer) {
            const searchInput = newHeadContainer.querySelector('.profile-new-head-search-input');
            const searchButton = newHeadContainer.querySelector('.profile-new-head-search-btn');

            if (searchButton) {
                searchButton.addEventListener('click', runProfileNewHeadSearch);
            }

            if (searchInput) {
                searchInput.addEventListener('input', runProfileNewHeadSearch);
                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        runProfileNewHeadSearch();
                    }
                });
            }
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
