<div class="modal fade" id="updateBlotter{{ $blotter->id }}" tabindex="-1" aria-labelledby="updateBlotterLabel{{ $blotter->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlotterLabel{{ $blotter->id }}">Edit Blotter #{{ $blotter->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route(auth()->user()->role . '.update.blotter', $blotter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="updateBlotterId" value="{{ $blotter->id }}">

                    <h4>Defendant Information</h4>

                    <div class="mb-3">
                        <label>Defendant First Name *</label>
                        <input type="text" name="defendantName"
                               class="form-control border border-light @error('defendantName') is-invalid @enderror"
                               value="{{ old('defendantName', $blotter->defendantName) }}" required>
                        @error('defendantName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Defendant Middle Name</label>
                        <input type="text" name="defendantMiddleName"
                               class="form-control border border-light @error('defendantMiddleName') is-invalid @enderror"
                               value="{{ old('defendantMiddleName', $blotter->defendantMiddleName) }}">
                        @error('defendantMiddleName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Defendant Last Name *</label>
                        <input type="text" name="defendantLastName"
                               class="form-control border border-light @error('defendantLastName') is-invalid @enderror"
                               value="{{ old('defendantLastName', $blotter->defendantLastName) }}" required>
                        @error('defendantLastName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Defendant Address</label>
                        <input type="text" name="defendantAddress"
                               class="form-control border border-light @error('defendantAddress') is-invalid @enderror"
                               value="{{ old('defendantAddress', $blotter->defendantAddress) }}">
                        @error('defendantAddress')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Defendant Contact Number</label>
                            <input type="text" name="defendantContactNumber"
                                   class="form-control border border-light @error('defendantContactNumber') is-invalid @enderror"
                                   value="{{ old('defendantContactNumber', $blotter->defendantContactNumber) }}">
                            @error('defendantContactNumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label>Defendant Age</label>
                            <input type="number" name="defendantAge"
                                   class="form-control border border-light @error('defendantAge') is-invalid @enderror"
                                   value="{{ old('defendantAge', $blotter->defendantAge) }}" min="1" max="120">
                            @error('defendantAge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h4>Witness Information (Optional)</h4>

                    <div class="mb-3">
                        <label>Witness Name</label>
                        <input type="text" name="witnessName"
                               class="form-control border border-light @error('witnessName') is-invalid @enderror"
                               value="{{ old('witnessName', $blotter->witnessName) }}">
                        @error('witnessName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Witness Contact Number</label>
                        <input type="text" name="witnessContactNumber"
                               class="form-control border border-light @error('witnessContactNumber') is-invalid @enderror"
                               value="{{ old('witnessContactNumber', $blotter->witnessContactNumber) }}">
                        @error('witnessContactNumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h4>Case Details</h4>

                    <div class="mb-3">
                        <label>Current Proof/Evidence</label>
                        @if($blotter->proof)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $blotter->proof) }}" alt="Proof" class="img-thumbnail" style="max-height: 150px;">
                                <p class="text-muted small mt-1">{{ basename($blotter->proof) }}</p>
                            </div>
                        @else
                            <p class="text-muted">No proof uploaded</p>
                        @endif
                        
                        <label>Update Proof (Optional)</label>
                        <input type="file" name="proof"
                               class="form-control border border-light @error('proof') is-invalid @enderror">
                        <small class="text-muted">Leave empty to keep current file. Max 4MB, JPG/PNG/JPEG only.</small>
                        @error('proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Case Description *</label>
                        <textarea name="blotterDescription"
                                  class="form-control border border-light @error('blotterDescription') is-invalid @enderror"
                                  rows="5" required>{{ old('blotterDescription', $blotter->blotterDescription) }}</textarea>
                        @error('blotterDescription')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Blotter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>