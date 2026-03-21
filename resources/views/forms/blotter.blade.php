<style>
    /* Section Headers - Clean & Spaced */
    .form-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: flex;
        align-items: center;
        margin-bottom: 1.2rem;
        color: #6c757d; /* Muted grey */
    }

    /* LIGHTER INPUT STYLES */
    .blotter-form .form-control,
    .blotter-form .form-select {
        border: 1px solid #e0e0e0 !important; /* Thinner, lighter border */
        border-radius: 8px !important;
        padding: 0.6rem 0.85rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.02); /* Very subtle depth */
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    /* Soft Focus State */
    .blotter-form .form-control:focus {
        border-color: #bbdefb !important; /* Very light blue */
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.05) !important;
        background-color: #fff !important;
        outline: none;
    }

    /* Soften the labels */
    .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        color: #555;
        font-weight: 600;
    }

    /* Divider */
    .light-divider {
        border-top: 1px solid #f0f0f0;
        margin: 2rem 0;
    }

    /* Light Card for Witnesses/Files */
    .light-card {
        background-color: #fcfcfc;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .text-danger { color: #ff6b6b !important; } /* Softer red */

    /* Date picker indicator remains visible/interactive */
    .blotter-form input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 1;
        display: block;
        cursor: pointer;
    }

    .blotter-form .date-group .form-control {
        border-right: 0 !important;
        border-radius: 8px 0 0 8px !important;
    }

    .blotter-form .date-group .input-group-text {
        border: 1px solid #e0e0e0 !important;
        border-left: 0 !important;
        border-radius: 0 8px 8px 0 !important;
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .resident-search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        max-height: 240px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        z-index: 30;
    }

    .resident-search-item {
        padding: 0.65rem 0.8rem;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
    }

    .resident-search-item:last-child {
        border-bottom: 0;
    }

    .resident-search-item:hover {
        background: #f8fafc;
    }

    .resident-search-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.88rem;
    }

    .resident-search-meta {
        color: #64748b;
        font-size: 0.78rem;
    }

    .resident-preview {
        margin-top: 0.65rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 10px;
        padding: 0.55rem 0.75rem;
        font-size: 0.82rem;
        color: #334155;
    }
</style>

@php
    $defaultBlotterType = $defaultBlotterType ?? old('blotter_type', 'regular');
    $showBlotterTypeSelector = $showBlotterTypeSelector ?? true;
@endphp

<form method="POST" action="{{ route('admin.blotter.store') }}" enctype="multipart/form-data" class="blotter-form p-2">
    @csrf

    <div class="mb-4">
        <h6 class="form-section-title text-primary">
            <i class="fa-solid fa-user-circle me-2 opacity-50"></i> Complainant Information (Nagrereklamo)
        </h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Complainant Type <span class="text-danger">*</span></label>
                <select name="plaintiff_party_type" class="form-select js-party-type" data-party="plaintiff">
                    <option value="resident" {{ old('plaintiff_party_type') === 'resident' ? 'selected' : '' }}>Resident</option>
                    <option value="non_resident" {{ old('plaintiff_party_type', 'non_resident') === 'non_resident' ? 'selected' : '' }}>Non-Resident</option>
                </select>
            </div>

            <div class="col-12 js-resident-block d-none" data-party-block="plaintiff">
                <label class="form-label">Search Complainant Resident</label>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text"
                               class="form-control js-resident-search-input"
                               data-party="plaintiff"
                               autocomplete="off"
                               placeholder="Type resident name or ID..."
                               value="{{ old('plaintiff_party_type') === 'resident' ? trim(collect([old('plaintiffName'), old('plaintiffMiddleName'), old('plaintiffLastName')])->filter()->implode(' ')) : '' }}">
                        <button type="button" class="btn btn-outline-primary js-resident-search-btn" data-party="plaintiff">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <input type="hidden" name="plaintiff_resident_id" class="js-resident-id-input" data-party="plaintiff" value="{{ old('plaintiff_resident_id') }}">
                    <div class="resident-search-dropdown d-none js-resident-dropdown" data-party="plaintiff"></div>
                    <div class="resident-preview js-resident-preview d-none" data-party="plaintiff"></div>
                </div>
                <small class="text-muted">Search a resident to auto-fill complainant details.</small>
            </div>

            <div class="col-12 js-manual-fields" data-party-manual="plaintiff">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input name="plaintiffName" class="form-control" placeholder="John" value="{{ old('plaintiffName') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input name="plaintiffMiddleName" class="form-control" placeholder="Santos" value="{{ old('plaintiffMiddleName') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input name="plaintiffLastName" class="form-control" placeholder="Doe" value="{{ old('plaintiffLastName') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Age</label>
                        <input type="number" name="plaintiffAge" class="form-control" placeholder="--" value="{{ old('plaintiffAge') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" name="plaintiffContactNumber" class="form-control" placeholder="09170000000" inputmode="numeric" pattern="^09\d{9}$" maxlength="11" value="{{ old('plaintiffContactNumber') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Address</label>
                        <input name="plaintiffAddress" class="form-control" placeholder="Street / Brgy Address" value="{{ old('plaintiffAddress') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="light-divider"></div>

    <div class="mb-4">
        <h6 class="form-section-title" style="color: #e57373;">
            <i class="fa-solid fa-user-tag me-2 opacity-50"></i> Respondent Details (Nirereklamo)
        </h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Respondent Type <span class="text-danger">*</span></label>
                <select name="defendant_party_type" class="form-select js-party-type" data-party="defendant">
                    <option value="resident" {{ old('defendant_party_type') === 'resident' ? 'selected' : '' }}>Resident</option>
                    <option value="non_resident" {{ old('defendant_party_type', 'non_resident') === 'non_resident' ? 'selected' : '' }}>Non-Resident</option>
                </select>
            </div>

            <div class="col-12 js-resident-block d-none" data-party-block="defendant">
                <label class="form-label">Search Respondent Resident</label>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text"
                               class="form-control js-resident-search-input"
                               data-party="defendant"
                               autocomplete="off"
                               placeholder="Type resident name or ID..."
                               value="{{ old('defendant_party_type') === 'resident' ? trim(collect([old('defendantName'), old('defendantMiddleName'), old('defendantLastName')])->filter()->implode(' ')) : '' }}">
                        <button type="button" class="btn btn-outline-primary js-resident-search-btn" data-party="defendant">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <input type="hidden" name="defendant_resident_id" class="js-resident-id-input" data-party="defendant" value="{{ old('defendant_resident_id') }}">
                    <div class="resident-search-dropdown d-none js-resident-dropdown" data-party="defendant"></div>
                    <div class="resident-preview js-resident-preview d-none" data-party="defendant"></div>
                </div>
                <small class="text-muted">Search a resident to auto-fill respondent details.</small>
            </div>

            <div class="col-12 js-manual-fields" data-party-manual="defendant">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input name="defendantName" class="form-control" placeholder="Respondent's name" value="{{ old('defendantName') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input name="defendantMiddleName" class="form-control" placeholder="..." value="{{ old('defendantMiddleName') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input name="defendantLastName" class="form-control" placeholder="..." value="{{ old('defendantLastName') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Last Known Residence</label>
                        <input name="defendantAddress" class="form-control" placeholder="Neighborhood or specific location" value="{{ old('defendantAddress') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number <span class="text-muted">(Optional)</span></label>
                        <input type="tel" name="defendantContactNumber" class="form-control" placeholder="09170000000" inputmode="numeric" pattern="^09\d{9}$" maxlength="11" value="{{ old('defendantContactNumber') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="light-card">
                <h6 class="form-section-title mb-3" style="font-size: 0.75rem;">Witness</h6>
                <div class="mb-3">
                    <label class="form-label">Witness Name</label>
                    <input name="witnessName" class="form-control" placeholder="Full Name">
                </div>
                                    <label class="form-label">Witness Contact Number</label>

                <input type="tel" name="witnessContactNumber" class="form-control" placeholder="09170000000" inputmode="numeric" pattern="^09\d{9}$" maxlength="11">
            </div>
        </div>

        <div class="col-md-6">
            <div class="light-card">
                <h6 class="form-section-title mb-3" style="font-size: 0.75rem;">Procedure</h6>{{--  
                <div class="mb-3">
                    <label class="form-label">Scheduled Hearing Date</label>
                    <div class="input-group date-group">
                        <input type="date" name="schedule" id="blotter_schedule" class="form-control">
                        <span class="input-group-text schedule-trigger"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>--}}
                <div class="mb-3">
                    @if($showBlotterTypeSelector)
                        <label class="form-label">Blotter Category</label>
                        <select name="blotter_type" class="form-select">
                            <option value="regular" {{ old('blotter_type', $defaultBlotterType) === 'regular' ? 'selected' : '' }}>Regular Blotter</option>
                            <option value="vawc" {{ old('blotter_type', $defaultBlotterType) === 'vawc' ? 'selected' : '' }}>VAWC Blotter</option>
                            <option value="katarungang_pambarangay" {{ old('blotter_type', $defaultBlotterType) === 'katarungang_pambarangay' ? 'selected' : '' }}>Katarungang Pambarangay</option>
                        </select>
                    @else
                        <input type="hidden" name="blotter_type" value="{{ old('blotter_type', $defaultBlotterType) }}">
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Incident Date & Time <span class="text-muted">(Optional)</span></label>
                      <input type="text"
                           name="incident_date_time"
                          class="form-control datetime-picker"
                          value="{{ old('incident_date_time') }}"
                          placeholder="Click to enter incident date and time...">
                    <small class="form-text text-muted">Leave blank if the exact incident date and time is unknown.</small>
                </div>
                <label class="form-label">Attach Blotter Image</label>
                <input type="file" name="proof" accept="image/jpg, image/jpeg, image/png" class="form-control">
                <small class="form-text text-muted">JPG, JPEG, or PNG (max 5MB)</small>
            </div>
        </div>

        <div class="col-12">
            <label class="form-label">Incident Narrative <span class="text-danger">*</span></label>
            <textarea name="blotterDescription" class="form-control" rows="4" 
                placeholder="Briefly describe the incident..." required></textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-5 pt-3">
        <button type="button" class="btn btn-link text-muted text-decoration-none small fw-bold" data-bs-dismiss="modal">Discard</button>
        <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 600; letter-spacing: 0.5px;">
            Record Blotter
        </button>
    </div>
</form>

@once
<script>
    (function () {
        if (window.__blotterPartySelectorInitialized === true) {
            return;
        }
        window.__blotterPartySelectorInitialized = true;

        const residentSearchUrl = @json(route('admin.blotter.residents.search'));

        function debounce(fn, delay) {
            let timeoutId;
            return function (...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        function showDropdownMessage(dropdown, message) {
            dropdown.innerHTML = '<div class="resident-search-item"><div class="resident-search-meta">' + message + '</div></div>';
            dropdown.classList.remove('d-none');
        }

        function closeDropdown(dropdown) {
            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
        }

        function normalizeResidentContact(value) {
            const normalized = String(value || '').replace(/\s+/g, '');
            return /^09\d{9}$/.test(normalized) ? normalized : '';
        }

        function getFieldRefs(form, party) {
            if (party === 'plaintiff') {
                return {
                    first: form.querySelector('[name="plaintiffName"]'),
                    middle: form.querySelector('[name="plaintiffMiddleName"]'),
                    last: form.querySelector('[name="plaintiffLastName"]'),
                    age: form.querySelector('[name="plaintiffAge"]'),
                    contact: form.querySelector('[name="plaintiffContactNumber"]'),
                    address: form.querySelector('[name="plaintiffAddress"]'),
                };
            }

            return {
                first: form.querySelector('[name="defendantName"]'),
                middle: form.querySelector('[name="defendantMiddleName"]'),
                last: form.querySelector('[name="defendantLastName"]'),
                age: form.querySelector('[name="defendantAge"]'),
                contact: form.querySelector('[name="defendantContactNumber"]'),
                address: form.querySelector('[name="defendantAddress"]'),
            };
        }

        function initPartySelector(form, party) {
            const typeSelect = form.querySelector('.js-party-type[data-party="' + party + '"]');
            const residentBlock = form.querySelector('.js-resident-block[data-party-block="' + party + '"]');
            const manualBlock = form.querySelector('.js-manual-fields[data-party-manual="' + party + '"]');
            const searchInput = form.querySelector('.js-resident-search-input[data-party="' + party + '"]');
            const searchBtn = form.querySelector('.js-resident-search-btn[data-party="' + party + '"]');
            const residentIdInput = form.querySelector('.js-resident-id-input[data-party="' + party + '"]');
            const dropdown = form.querySelector('.js-resident-dropdown[data-party="' + party + '"]');
            const preview = form.querySelector('.js-resident-preview[data-party="' + party + '"]');
            const fields = getFieldRefs(form, party);

            if (!typeSelect || !residentBlock || !manualBlock || !searchInput || !searchBtn || !residentIdInput || !dropdown || !preview) {
                return;
            }

            function fillFromResident(resident) {
                const contactNumber = normalizeResidentContact(resident.contact_no);

                if (fields.first) fields.first.value = resident.first_name || '';
                if (fields.middle) fields.middle.value = resident.middle_name || '';
                if (fields.last) fields.last.value = resident.last_name || '';
                if (fields.age) fields.age.value = resident.age || '';
                if (fields.contact) fields.contact.value = contactNumber;
                if (fields.address) fields.address.value = resident.address || '';

                residentIdInput.value = resident.id || '';
                searchInput.value = (resident.full_name || '').trim();
                preview.innerHTML =
                    '<strong>Selected Resident:</strong> ' + (resident.full_name || 'N/A') +
                    ' <span class="text-muted">(ID: ' + (resident.id || 'N/A') + ')</span><br>' +
                    'Age: ' + (resident.age || 'N/A') +
                    ' | Contact: ' + (contactNumber || 'N/A') +
                    ' | Address: ' + (resident.address || 'N/A');
                preview.classList.remove('d-none');
                closeDropdown(dropdown);
            }

            function toggleBlocks() {
                const isResident = typeSelect.value === 'resident';
                residentBlock.classList.toggle('d-none', !isResident);
                manualBlock.classList.toggle('d-none', isResident);

                if (!isResident) {
                    closeDropdown(dropdown);
                    preview.classList.add('d-none');
                }
            }

            function renderResults(items) {
                if (!Array.isArray(items) || items.length === 0) {
                    showDropdownMessage(dropdown, 'No matching residents found.');
                    return;
                }

                dropdown.innerHTML = '';

                items.forEach(function (resident) {
                    const option = document.createElement('div');
                    option.className = 'resident-search-item';
                    option.innerHTML =
                        '<div class="resident-search-name">' + (resident.full_name || 'N/A') +
                        ' <span class="text-muted">(ID: ' + (resident.id || 'N/A') + ')</span></div>' +
                        '<div class="resident-search-meta">Age: ' + (resident.age || 'N/A') +
                        ' | Contact: ' + (resident.contact_no || 'N/A') +
                        ' | Address: ' + (resident.address || 'N/A') + '</div>';

                    option.addEventListener('click', function () {
                        fillFromResident(resident);
                    });

                    dropdown.appendChild(option);
                });

                dropdown.classList.remove('d-none');
            }

            const runSearch = debounce(function () {
                const query = (searchInput.value || '').trim();

                if (query.length < 2) {
                    showDropdownMessage(dropdown, 'Type at least 2 characters to search residents.');
                    return;
                }

                fetch(residentSearchUrl + '?q=' + encodeURIComponent(query), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Failed resident search request.');
                        }
                        return response.json();
                    })
                    .then(function (payload) {
                        renderResults(payload?.data || []);
                    })
                    .catch(function () {
                        showDropdownMessage(dropdown, 'Unable to search residents right now. Please try again.');
                    });
            }, 280);

            typeSelect.addEventListener('change', function () {
                if (typeSelect.value !== 'resident') {
                    residentIdInput.value = '';
                    searchInput.value = '';
                }
                toggleBlocks();
            });

            searchInput.addEventListener('input', function () {
                residentIdInput.value = '';
                preview.classList.add('d-none');
                runSearch();
            });

            searchInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    runSearch();
                }
            });

            searchBtn.addEventListener('click', function () {
                runSearch();
            });

            document.addEventListener('click', function (event) {
                if (!residentBlock.contains(event.target)) {
                    closeDropdown(dropdown);
                }
            });

            toggleBlocks();
        }

        function initializeBlotterPartySelectors() {
            document.querySelectorAll('.blotter-form').forEach(function (form) {
                if (form.dataset.partySelectorInitialized === '1') {
                    return;
                }

                form.dataset.partySelectorInitialized = '1';
                initPartySelector(form, 'plaintiff');
                initPartySelector(form, 'defendant');
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeBlotterPartySelectors);
        } else {
            initializeBlotterPartySelectors();
        }
    })();
</script>
@endonce


