<div class="modal fade" id="statusBlotter{{ $blotter->id }}" tabindex="-1" aria-labelledby="statusBlotterLabel{{ $blotter->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="statusBlotterLabel{{ $blotter->id }}">
                    <i class="fa fa-flag me-2 text-primary"></i>Update Status {{ $blotter->formatted_blotter_number }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route(auth()->user()->role . '.status.blotter', $blotter->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusBlotterId" value="{{ $blotter->id }}">

                <div class="modal-body p-4">
                    
                    <section>
                        <h6>Current Record Information</h6>
                        <div class="info-box mb-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="info-label">Blotter ID</div>
                                    <div class="fw-bold text-dark">{{ $blotter->formatted_blotter_number }}</div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="info-label">Current Status</div>
                                    @php
                                        $statusLabels = [
                                            'filed' => 'Filed',
                                            'first_hearing' => 'First Hearing',
                                            'second_hearing' => 'Second Hearing',
                                            'third_hearing' => 'Third Hearing',
                                            'for_summons' => 'For Summons',
                                            'criminal_civil_case' => 'Criminal Case/Civil Case',
                                            'referred_to_pnp' => 'Referred to PNP',
                                            'certificate_to_file_action' => 'Certificate to File Action',
                                            'barangay_protection_order' => 'Barangay Protection Order',
                                            'resolved' => 'Resolved',
                                        ];
                                        $currentStatus = $blotter->current_status ?? $blotter->status;
                                        $displayStatus = $statusLabels[$currentStatus] ?? ucfirst(strtolower($currentStatus));
                                        $badgeClass = match($currentStatus) {
                                            'filed' => 'secondary',
                                            'first_hearing', 'second_hearing', 'third_hearing', 'for_summons' => 'primary',
                                            'barangay_protection_order' => 'warning text-dark',
                                            'criminal_civil_case', 'certificate_to_file_action' => 'danger',
                                            'referred_to_pnp' => 'dark',
                                            'resolved' => 'success',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="info-label">Defendant</div>
                                    <div class="text-dark">{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h6>Change Case Status</h6>
                        <div class="form-group mb-3">
                            <label class="info-label">Select New Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled>-- Choose Option --</option>
                                <option value="first_hearing" {{ old('status', $blotter->status) === 'first_hearing' ? 'selected' : '' }}>First Hearing</option>
                                <option value="second_hearing" {{ old('status', $blotter->status) === 'second_hearing' ? 'selected' : '' }}>Second Hearing</option>
                                <option value="third_hearing" {{ old('status', $blotter->status) === 'third_hearing' ? 'selected' : '' }}>Third Hearing</option>
                                <option value="for_summons" {{ old('status', $blotter->status) === 'for_summons' ? 'selected' : '' }}>For Summons</option>
                                <option value="criminal_civil_case" {{ old('status', $blotter->status) === 'criminal_civil_case' ? 'selected' : '' }}>Criminal Case/Civil Case</option>
                                <option value="referred_to_pnp" {{ old('status', $blotter->status) === 'referred_to_pnp' ? 'selected' : '' }}>Referred to PNP</option>
                                <option value="certificate_to_file_action" {{ old('status', $blotter->status) === 'certificate_to_file_action' ? 'selected' : '' }}>Certificate to File Action</option>
                                <option value="barangay_protection_order" {{ old('status', $blotter->status) === 'barangay_protection_order' ? 'selected' : '' }}>Barangay Protection Order</option>
                                <option value="resolved" {{ old('status', $blotter->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="info-label">Status Notes / Remarks (Optional)</label>
                            <textarea name="statusDescription" 
                                      class="form-control @error('statusDescription') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Briefly explain the reason for this status change...">{{ old('statusDescription', $blotter->statusDescription) }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Maximum 255 characters</small>
                            </div>
                            @error('statusDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </section>
                </div>

                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
