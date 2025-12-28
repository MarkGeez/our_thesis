<div class="modal fade" id="updateBlotter{{ $blotter->id }}" tabindex="-1" aria-labelledby="updateBlotterLabel{{ $blotter->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="updateBlotterLabel{{ $blotter->id }}">
                    <i class="fa fa-edit me-2"></i>Edit Blotter #{{ $blotter->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route(auth()->user()->role . '.update.blotter', $blotter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="updateBlotterId" value="{{ $blotter->id }}">

                <div class="modal-body p-4">
                    
                    <section>
                        <h6>Defendant Information</h6>
                        <div class="info-box">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="info-label">First Name *</label>
                                    <input type="text" 
                                           name="defendantName" 
                                           class="form-control @error('defendantName') is-invalid @enderror" 
                                           value="{{ old('defendantName', $blotter->defendantName) }}" 
                                           placeholder="Enter first name"
                                           required>
                                    @error('defendantName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Middle Name</label>
                                    <input type="text" 
                                           name="defendantMiddleName" 
                                           class="form-control @error('defendantMiddleName') is-invalid @enderror" 
                                           value="{{ old('defendantMiddleName', $blotter->defendantMiddleName) }}" 
                                           placeholder="Enter middle name (optional)">
                                    @error('defendantMiddleName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Last Name *</label>
                                    <input type="text" 
                                           name="defendantLastName" 
                                           class="form-control @error('defendantLastName') is-invalid @enderror" 
                                           value="{{ old('defendantLastName', $blotter->defendantLastName) }}" 
                                           placeholder="Enter last name"
                                           required>
                                    @error('defendantLastName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-8">
                                    <label class="info-label">Contact Number</label>
                                    <input type="text" 
                                           name="defendantContactNumber" 
                                           class="form-control @error('defendantContactNumber') is-invalid @enderror" 
                                           value="{{ old('defendantContactNumber', $blotter->defendantContactNumber) }}" 
                                           placeholder="09xxxxxxxxx">
                                    @error('defendantContactNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Age</label>
                                    <input type="number" 
                                           name="defendantAge" 
                                           class="form-control @error('defendantAge') is-invalid @enderror" 
                                           value="{{ old('defendantAge', $blotter->defendantAge) }}" 
                                           placeholder="25"
                                           min="1" 
                                           max="120">
                                    @error('defendantAge') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="info-label">Complete Address</label>
                                    <input type="text" 
                                           name="defendantAddress" 
                                           class="form-control @error('defendantAddress') is-invalid @enderror" 
                                           value="{{ old('defendantAddress', $blotter->defendantAddress) }}" 
                                           placeholder="Street, Barangay, City/Municipality, Province">
                                    @error('defendantAddress') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h6>Witness Information (Optional)</h6>
                        <div class="info-box">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label class="info-label">Witness Name</label>
                                    <input type="text" 
                                           name="witnessName" 
                                           class="form-control @error('witnessName') is-invalid @enderror" 
                                           value="{{ old('witnessName', $blotter->witnessName) }}" 
                                           placeholder="Full name of witness">
                                    @error('witnessName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="info-label">Witness Contact Number</label>
                                    <input type="text" 
                                           name="witnessContactNumber" 
                                           class="form-control @error('witnessContactNumber') is-invalid @enderror" 
                                           value="{{ old('witnessContactNumber', $blotter->witnessContactNumber) }}" 
                                           placeholder="09xxxxxxxxx">
                                    @error('witnessContactNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h6>Case Details & Evidence</h6>
                        <div class="info-box">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="info-label">Case Description *</label>
                                    <textarea name="blotterDescription" 
                                              class="form-control @error('blotterDescription') is-invalid @enderror" 
                                              rows="4" 
                                              placeholder="Provide detailed description of the incident..."
                                              required>{{ old('blotterDescription', $blotter->blotterDescription) }}</textarea>
                                    @error('blotterDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="info-label d-block">Evidence / Proof</label>
                                    @if($blotter->proof)
                                        <div class="d-flex align-items-center gap-3 mb-3 p-2 border rounded bg-white">
                                            <img src="{{ asset('storage/' . $blotter->proof) }}" alt="Proof" class="img-thumbnail" style="height: 60px; width: 60px; object-fit: cover;">
                                            <div>
                                                <small class="text-muted d-block">Current file:</small>
                                                <span class="small fw-bold text-truncate" style="max-width: 200px; display: inline-block;">{{ basename($blotter->proof) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="input-group">
                                        <input type="file" 
                                               name="proof" 
                                               class="form-control @error('proof') is-invalid @enderror"
                                               accept="image/*,.pdf">
                                    </div>
                                    <div class="form-text mt-1">Leave empty to keep current file. (Max 4MB, JPG/PNG/PDF)</div>
                                    @error('proof') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
