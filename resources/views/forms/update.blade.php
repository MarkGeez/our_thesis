
<style>
    /* Section Headers - Clean & Spaced */
    .update-form .form-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: flex;
        align-items: center;
        margin-bottom: 1.2rem;
        color: #6c757d;
    }

    /* Lighter Input Styles */
    .update-form .form-control,
    .update-form .form-select {
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        padding: 0.6rem 0.85rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    /* Soft Focus State */
    .update-form .form-control:focus,
    .update-form .form-select:focus {
        border-color: #bbdefb !important;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.05) !important;
        background-color: #fff !important;
        outline: none;
    }

    /* Soften the labels */
    .update-form .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        color: #555;
        font-weight: 600;
    }

    /* Light Card */
    .update-form .light-card {
        background-color: #fcfcfc;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .update-form .history-list {
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        background: #fff;
    }

    .update-form input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 1;
        display: block;
        cursor: pointer;
    }

    .update-form .date-group .form-control {
        border-right: 0 !important;
        border-radius: 8px 0 0 8px !important;
    }

    .update-form .date-group .input-group-text {
        border: 1px solid #e0e0e0 !important;
        border-left: 0 !important;
        border-radius: 0 8px 8px 0 !important;
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .update-form .badge-status {
        border-radius: 999px;
        padding: 0.35rem 0.75rem;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .update-form .error-text { color: #e57373; font-size: 0.85rem; }

    .update-form .text-danger { color: #ff6b6b !important; }
</style>

<div class="update-form p-2">
    <div class="row g-3 mb-3">
        <div class="col-lg-7">
            <div class="light-card h-100">
                <h6 class="form-section-title text-primary mb-3"><i class="fa fa-file-alt me-2 opacity-50"></i>Blotter Information</h6>
                <div class="row gy-2">
                    <div class="col-md-6">
                        <label class="form-label">Complainant</label>
                        <div class="fw-semibold">{{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Respondent</label>
                        <div class="fw-semibold">{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Current Status</label>
                        <span class="badge bg-info text-dark badge-status text-capitalize">{{ $blotter->current_status }}</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Blotter #</label>
                        <div class="fw-semibold">#{{ $blotter->id }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="light-card h-100">
                <h6 class="form-section-title mb-3"><i class="fa fa-clock-rotate-left me-2 opacity-50"></i>Status History</h6>
                @if($history->count() > 0)
                    @foreach ($history as $hist)
                        {{ date('M-d Y', strToTime($hist->date)) }}
                        @if (!empty($hist->photo_path))
                        <img src="{{ Storage::url($hist->photo_path) }}" alt="" srcset="">
                        @endif
                        {{ $hist->status  }}
                        {{ $hist->remarks }}
                        <br>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No status updates yet.</p>
                @endif
            </div>
        </div>
    </div>
   
    <form method="POST" action="{{ route('admin.blotter.update.store', $blotter->id) }}" enctype="multipart/form-data">
        
        @csrf
        @method('PUT')

        <div class="light-card mb-4">
            <h6 class="form-section-title text-primary mb-3"><i class="fa fa-pen-to-square me-2 opacity-50"></i>Add New Status Update</h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="status_{{ $blotter->id }}" class="form-label">New Status <span class="text-danger">*</span></label>
                    @php
                        $selectedStatus = old('status', $blotter->current_status);
                    @endphp
                    <select name="status" id="status_{{ $blotter->id }}" class="form-select" required>
                        <option value="">-- Select Status --</option>
                        @foreach($availableStatuses as $status)
                            @php
                                $isUsed = isset($usedStatuses) && in_array($status, $usedStatuses, true);
                                $isSelected = $selectedStatus === $status;
                            @endphp
                            <option value=" {{ $status }}" {{ $isSelected ? 'selected' : '' }} {{ $isUsed && !$isSelected ? 'disabled' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}{{ $isUsed && !$isSelected ? ' (already used)' : '' }}
                            </option>
    
                        @endforeach
                         @error('status')
                            <div class="error-text mt-1">{{ $message }}</div>
                            @enderror
                    </select>
                    
                </div>

                <div class="col-md-6">
                    <label for="date_{{ $blotter->id }}" class="form-label">Update Date <span class="text-danger">*</span></label>
                    <div class="input-group date-group">
                        <input type="date" name="date" id="date_{{ $blotter->id }}" value="{{ old('date') }}" class="form-control" required>
                        <span class="input-group-text" id="date_trigger_{{ $blotter->id }}" style="cursor: pointer;"><i class="fa fa-calendar"></i></span>
                    </div>
                    @error('date')
                        <div class="error-text mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="remarks_{{ $blotter->id }}" class="form-label">Remarks / Notes <span class="text-danger">*</span></label>
                    <textarea name="remarks" id="remarks_{{ $blotter->id }}" class="form-control" value="{{ old('remarks') }}"rows="3" placeholder="Describe the update..." required>{{ old('remarks') }}</textarea>
                    @error('remarks')
                        <div class="error-text mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="photo_path_{{ $blotter->id }}" class="form-label">Attach Photo (Optional)</label>
                    <input type="file" name="photo_path" accept="image/jpg, image/jpeg, image/png" id="photo_path_{{ $blotter->id }}" class="form-control">
                    <small class="form-text text-muted">JPG, JPEG, or PNG (max 5MB)</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light text-decoration-none small fw-bold" data-bs-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 600; letter-spacing: 0.5px;">
                Record Update
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date_{{ $blotter->id }}');
        const trigger = document.getElementById('date_trigger_{{ $blotter->id }}');
        const rawDate = "{{ old('date') }}";

        if (dateInput && rawDate) {
            dateInput.value = rawDate;
        }

        const openPicker = () => {
            if (!dateInput) return;
            if (typeof dateInput.showPicker === 'function') {
                dateInput.showPicker();
            } else {
                dateInput.focus();
            }
        };

        if (trigger && dateInput) {
            trigger.addEventListener('mousedown', function (event) {
                event.preventDefault();
                dateInput.focus();
                openPicker();
            });
        }

        if (dateInput) {
            dateInput.addEventListener('click', openPicker);
        }
    });
</script>