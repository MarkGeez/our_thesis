<div class="card border-0 shadow-sm mb-4">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #218838 100%);">
        <h6 class="mb-0 fw-bold"><i class="fas fa-user-shield me-2"></i>Complainant Information (Nagsusumbong)</h6>
    </div>
    <div class="card-body bg-light">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold"><i class="fas fa-user me-1"></i>First Name</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->firstName ?? auth()->user()->name }}</div>
                <input type="hidden" name="plaintiffName" value="{{ auth()->user()->firstName ?? auth()->user()->name }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold"><i class="fas fa-user me-1"></i>Middle Name</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->middleName ?? 'N/A' }}</div>
                <input type="hidden" name="plaintiffMiddleName" value="{{ auth()->user()->middleName ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold"><i class="fas fa-user me-1"></i>Last Name</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->lastName ?? 'N/A' }}</div>
                <input type="hidden" name="plaintiffLastName" value="{{ auth()->user()->lastName ?? '' }}">
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold"><i class="fas fa-birthday-cake me-1"></i>Age</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->age ?? 'N/A' }}</div>
                <input type="hidden" name="plaintiffAge" value="{{ auth()->user()->age ?? '' }}">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold"><i class="fas fa-phone me-1"></i>Contact Number</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->contactNumber ?? 'N/A' }}</div>
                <input type="hidden" name="plaintiffContactNumber" value="{{ auth()->user()->contactNumber ?? '' }}">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold"><i class="fas fa-map-marker-alt me-1"></i>Complete Address</label>
                <div class="form-control bg-white" style="background-color: #f8f9fa; cursor: not-allowed;">{{ auth()->user()->address ?? 'N/A' }}</div>
                <input type="hidden" name="plaintiffAddress" value="{{ auth()->user()->address ?? '' }}">
            </div>
        </div>
        <div class="mt-3 p-2 bg-success bg-opacity-10 border border-success border-opacity-25 rounded">
            <small class="text-success">
                <i class="fas fa-check-circle me-1"></i>
                <strong>Auto-filled from your account.</strong> This information is locked and cannot be modified.
            </small>
        </div>
    </div>
</div>
