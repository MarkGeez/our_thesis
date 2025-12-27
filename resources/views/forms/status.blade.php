<div class="modal fade" id="statusBlotter{{ $blotter->id }}" tabindex="-1" aria-labelledby="statusBlotterLabel{{ $blotter->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusBlotterLabel{{ $blotter->id }}">Update Blotter Status #{{ $blotter->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route(auth()->user()->role . '.status.blotter', $blotter->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="statusBlotterId" value="{{ $blotter->id }}">

                    <h4>Current Information</h4>

                    <div class="mb-3">
                        <label>Blotter ID</label>
                        <input type="text" class="form-control" value="#{{ $blotter->id }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Defendant Name</label>
                        <input type="text" class="form-control" value="{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Current Status</label>
                        <span class="badge bg-{{ $blotter->status === 'PENDING' ? 'warning' : ($blotter->status === 'RESOLVED' ? 'info' : ($blotter->status === 'SCHEDULED' ? 'primary' : 'success')) }}">
                            {{ ucfirst(strtolower($blotter->status)) }}
                        </span>
                    </div>

                    <hr>

                    <h4>Update Status</h4>

                    <div class="mb-3">
                        <label>New Status *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="PENDING" {{ old('status', $blotter->status) === 'PENDING' ? 'selected' : '' }}>Pending</option>
                            <option value="SCHEDULED" {{ old('status', $blotter->status) === 'SCHEDULED' ? 'selected' : '' }}>Scheduled</option>
                            <option value="RESOLVED" {{ old('status', $blotter->status) === 'RESOLVED' ? 'selected' : '' }}>Resolved</option>
                            <option value="CLOSED" {{ old('status', $blotter->status) === 'CLOSED' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Status Description (Optional)</label>
                        <textarea name="statusDescription"
                                  class="form-control border border-light @error('statusDescription') is-invalid @enderror"
                                  rows="4" placeholder="Add notes about the status update...">{{ old('statusDescription', $blotter->statusDescription) }}</textarea>
                        <small class="text-muted">Max 255 characters</small>
                        @error('statusDescription')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
