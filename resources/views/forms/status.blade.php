<div class="modal fade" id="statusBlotter{{ $blotter->id }}" tabindex="-1" aria-labelledby="statusBlotterLabel{{ $blotter->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="statusBlotterLabel{{ $blotter->id }}">
                    <i class="fa fa-flag me-2 text-primary"></i>Update Status #{{ $blotter->id }}
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
                                    <div class="fw-bold text-dark">#{{ $blotter->id }}</div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="info-label">Current Status</div>
                                    <span class="badge bg-{{ $blotter->status === 'PENDING' ? 'warning text-dark' : ($blotter->status === 'RESOLVED' ? 'info' : ($blotter->status === 'SCHEDULED' ? 'primary' : 'success')) }}">
                                        {{ ucfirst(strtolower($blotter->status)) }}
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
                                <option value="PENDING" {{ old('status', $blotter->status) === 'PENDING' ? 'selected' : '' }}>Pending (Awaiting Action)</option>
                                <option value="SCHEDULED" {{ old('status', $blotter->status) === 'SCHEDULED' ? 'selected' : '' }}>Scheduled (For Hearing)</option>
                                <option value="COLD CASE" {{ old('status', $blotter->status) === 'COLD CASE' ? 'selected' : '' }}>Cold Case (Inactive)</option>
                                <option value="RESOLVED" {{ old('status', $blotter->status) === 'RESOLVED' ? 'selected' : '' }}>Resolved (Settled)</option>
                                <option value="CLOSED" {{ old('status', $blotter->status) === 'CLOSED' ? 'selected' : '' }}>Closed (Terminated)</option>
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