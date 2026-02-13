
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

    /* Blotter-themed timeline for status history */
    .update-form .timeline {
        position: relative;
        padding-left: 18px;
    }

    .update-form .timeline::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #0d6efd, #79a7ff);
        opacity: 0.35;
    }

    .update-form .timeline-item {
        position: relative;
        padding: 0.75rem 0 0.75rem 14px;
        border-bottom: 1px dashed #e5e7eb;
    }

    .update-form .timeline-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .update-form .timeline-dot {
        position: absolute;
        left: -2px;
        top: 1.1rem;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
    }

    .update-form .timeline-body {
        background: #f9fbff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.03);
    }

    .update-form .timeline-header {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.35rem;
    }

    .update-form .timeline-meta {
        font-size: 0.8rem;
        color: #6b7280;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .update-form .timeline-remarks {
        font-size: 0.9rem;
        color: #111827;
        margin-bottom: 0.4rem;
        white-space: pre-wrap; /* preserve user-entered spacing/line breaks */
    }

    .update-form .timeline-photo {
        display: flex;
        gap: 0.6rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .update-form .timeline-photo img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .update-form .timeline-badge {
        padding: 0.2rem 0.75rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    .update-form .timeline-badge.pending { background: #fff7e6; color: #b45309; border: 1px solid #fde68a; }
    .update-form .timeline-badge.ongoing { background: #e0f2fe; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .update-form .timeline-badge.closed { background: #ecfdf3; color: #15803d; border: 1px solid #bbf7d0; }
    .update-form .timeline-badge.scheduled { background: #eff6ff; color: #1e3a8a; border: 1px solid #dbeafe; }
    .update-form .timeline-badge.cold { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .update-form .timeline-badge.resolved { background: #eefcf6; color: #0f766e; border: 1px solid #c5f3e5; }

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
        <div class="col-lg-5">
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
                        <span class="badge bg-info text-dark badge-status text-capitalize">{{ $statusLabels[$blotter->current_status] ?? ucfirst(str_replace('_', ' ', $blotter->current_status)) }}</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Blotter #</label>
                        <div class="fw-semibold">#{{ $blotter->id }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="light-card h-100">
                <h6 class="form-section-title mb-3"><i class="fa fa-clock-rotate-left me-2 opacity-50"></i>Status History</h6>
                @if($history->count() > 0)
                    <div class="history-list timeline">
                        @foreach ($history as $hist)
                            @php
                                $normalized = strtolower($hist->status ?? '');
                                $badgeClass = match(true) {
                                    str_contains($normalized, 'pending')   => 'pending',
                                    str_contains($normalized, 'ongoing')   => 'ongoing',
                                    str_contains($normalized, 'closed')    => 'closed',
                                    str_contains($normalized, 'scheduled') => 'scheduled',
                                    str_contains($normalized, 'resolved')  => 'resolved',
                                    str_contains($normalized, 'cold')      => 'cold',
                                    default                                => 'pending',
                                };
                            @endphp
                            <div class="timeline-item">
                                <span class="timeline-dot" style="background:#0d6efd;"></span>
                                <div class="timeline-body">
                                    <div class="timeline-header">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            @php
                                                $displayLabel = $statusLabels[$hist->status] ?? ucwords(str_replace('_', ' ', $hist->status));
                                            @endphp
                                            <span class="timeline-badge {{ $badgeClass }}">{{ $displayLabel }}</span>
                                        </div>
                                        <span class="badge bg-light text-dark border">Case #{{ $blotter->id }}</span>
                                    </div>
                                    <div class="timeline-remarks">{{ $hist->remarks }}</div>
                                    @php
                                        $updaterName = null;
                                        if ($hist->updater) {
                                            $updaterName = trim(($hist->updater->firstName ?? '') . ' ' . ($hist->updater->lastName ?? ''));
                                            if ($updaterName === '') {
                                                $updaterName = $hist->updater->email ?? null;
                                            }
                                        }
                                    @endphp
                                    <div class="timeline-meta">
                                        <span><i class="fa fa-user-shield me-1 text-primary"></i>{{ ucwords($updaterName ?? 'Unknown') }}</span>
                                    </div>
                                    @if (!empty($hist->photo_path) && $hist->photo_path !== null && trim($hist->photo_path) !== '')
                                        <div class="timeline-photo mt-2">
                                            <img src="{{ Storage::url($hist->photo_path) }}" 
                                                 alt="Status proof for blotter {{ $blotter->id }}"
                                                 style="cursor: pointer;"
                                                 onclick="showImageModal('{{ Storage::url($hist->photo_path) }}', '#{{ $blotter->id }}')"
                                                 title="Click to view full size">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="showImageModal('{{ Storage::url($hist->photo_path) }}', '#{{ $blotter->id }}')">
                                                <i class="fa fa-search-plus me-1"></i>View evidence
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                $displayLabel = $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status));
                            @endphp
                            <option value="{{ $status }}" {{ $isSelected ? 'selected' : '' }} {{ $isUsed && !$isSelected ? 'disabled' : '' }}>
                                {{ $displayLabel }}{{ $isUsed && !$isSelected ? ' (already used)' : '' }}
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
                        <input type="date" name="date" id="date_{{ $blotter->id }}" value="{{ old('date', now()->toDateString()) }}" class="form-control" required>
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

        // Only open picker when clicking the calendar icon, not the input itself
        if (trigger && dateInput) {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                if (typeof dateInput.showPicker === 'function') {
                    dateInput.showPicker();
                } else {
                    dateInput.focus();
                }
            });
        }
    });
</script>