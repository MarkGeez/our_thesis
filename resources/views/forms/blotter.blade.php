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
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input name="plaintiffName" class="form-control" placeholder="John" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input name="plaintiffMiddleName" class="form-control" placeholder="Santos">
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input name="plaintiffLastName" class="form-control" placeholder="Doe" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Age</label>
                <input type="number" name="plaintiffAge" class="form-control" placeholder="--">
            </div>
            <div class="col-md-5">
                <label class="form-label">Contact Number</label>
                <input name="plaintiffContactNumber" class="form-control" placeholder="0917-000-0000">
            </div>
            <div class="col-md-5">
                <label class="form-label">Address</label>
                <input name="plaintiffAddress" class="form-control" placeholder="Street / Brgy Address">
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
                <label class="form-label">First Name</label>
                <input name="defendantName" class="form-control" placeholder="Respondent's name">
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input name="defendantMiddleName" class="form-control" placeholder="...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name</label>
                <input name="defendantLastName" class="form-control" placeholder="...">
            </div>
            <div class="col-md-8">
                <label class="form-label">Last Known Residence</label>
                <input name="defendantAddress" class="form-control" placeholder="Neighborhood or specific location">
            </div>
            <div class="col-md-4">
                <label class="form-label">Contact Number <span class="text-muted">(Optional)</span></label>
                <input name="defendantContactNumber" class="form-control" placeholder="09xx-xxx-xxxx">
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

                <input name="witnessContactNumber" class="form-control" placeholder="Phone Number">
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
                        </select>
                    @else
                        <input type="hidden" name="blotter_type" value="{{ old('blotter_type', $defaultBlotterType) }}">
                    @endif
                </div>
                <label class="form-label">Attach Evidence/Proof (Optional)</label>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scheduleInput = document.getElementById('blotter_schedule');
        const scheduleTrigger = document.querySelector('.blotter-form .schedule-trigger');
        const rawSchedule = "{{ old('schedule') }}";

        if (scheduleInput && rawSchedule) {
            scheduleInput.value = rawSchedule;
        }

        // Only open picker when clicking the calendar icon, not the input itself
        if (scheduleTrigger && scheduleInput) {
            scheduleTrigger.addEventListener('click', function (event) {
                event.preventDefault();
                if (typeof scheduleInput.showPicker === 'function') {
                    scheduleInput.showPicker();
                } else {
                    scheduleInput.focus();
                }
            });
        }
    });
</script>
