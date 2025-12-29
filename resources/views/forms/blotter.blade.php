<?php
    $role = auth()->user()->role;
?>

<!-- Button to open modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blotterModal">
    {!! $button ?? '' !!}
</button>

<!-- Modal -->
<div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="blotterModalLabel">
                    <i class="fa fa-file-alt me-2"></i>Submit New Blotter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route($role . '.submit.blotter') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body p-4">
                    {!! $plaintiff ?? '' !!}
                    
                    <section>
                        <h6>Defendant Information</h6>
                        <div class="info-box">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="info-label">First Name *</label>
                                    <input type="text" name="defendantName" placeholder="Enter first name here..." class="form-control @error('defendantName') is-invalid @enderror" value="{{ old('defendantName') }}" required>
                                    @error('defendantName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Middle Name</label>
                                    <input type="text" name="defendantMiddleName" placeholder="Enter middle name here..." class="form-control @error('defendantMiddleName') is-invalid @enderror" value="{{ old('defendantMiddleName') }}">
                                    @error('defendantMiddleName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Last Name *</label>
                                    <input type="text" name="defendantLastName" placeholder="Enter last name here..." class="form-control @error('defendantLastName') is-invalid @enderror" value="{{ old('defendantLastName') }}" required>
                                    @error('defendantLastName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label class="info-label">Complete Address</label>
                                    <input type="text" name="defendantAddress" placeholder="Enter complete address here..." class="form-control @error('defendantAddress') is-invalid @enderror" value="{{ old('defendantAddress') }}">
                                    @error('defendantAddress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Contact Number</label>
                                    <input type="text" name="defendantContactNumber" placeholder="09xxxxxxxxx" class="form-control @error('defendantContactNumber') is-invalid @enderror" value="{{ old('defendantContactNumber') }}">
                                    @error('defendantContactNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="info-label">Age</label>
                                    <input type="number" name="defendantAge" placeholder="Enter age here..." class="form-control @error('defendantAge') is-invalid @enderror" value="{{ old('defendantAge') }}" min="1" max="120">
                                    @error('defendantAge')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="text" name="witnessName" placeholder="Enter witness name here..." class="form-control @error('witnessName') is-invalid @enderror" value="{{ old('witnessName') }}">
                                    @error('witnessName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="info-label">Witness Contact Number</label>
                                    <input type="text" name="witnessContactNumber" placeholder="09xxxxxxxxx" class="form-control @error('witnessContactNumber') is-invalid @enderror" value="{{ old('witnessContactNumber') }}">
                                    @error('witnessContactNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <textarea name="blotterDescription" placeholder="Enter case description here..." class="form-control @error('blotterDescription') is-invalid @enderror" rows="4" required>{{ old('blotterDescription') }}</textarea>
                                    @error('blotterDescription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="info-label d-block">Evidence / Proof</label>
                                    <div class="input-group">
                                        <input type="file" name="proof" placeholder="Upload photo or document here..." class="form-control @error('proof') is-invalid @enderror" accept="image/*,.pdf">
                                    </div>
                                    <div class="form-text mt-1">Upload photo or document (Max 4MB, JPG/PNG/PDF)</div>
                                    @error('proof')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Submit Blotter</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- to yung dating code

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blotterModal">
    {!! $button ?? '' !!}
</button>

<div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="blotterModalLabel">
                    <i class="fa fa-file-alt me-2"></i>Submit New Blotter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.submit.blotter') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body p-4">
                    {!! $plaintiff ?? '' !!}
                    
                    <section>
                        <h6>Defendant Information</h6>
                        <div class="info-box">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="info-label">First Name *</label>
                                    <input type="text" name="defendantName" placeholder="Enter first name here..." class="form-control @error('defendantName') is-invalid @enderror" value="{{ old('defendantName') }}" required>
                                    @error('defendantName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Middle Name</label>
                                    <input type="text" name="defendantMiddleName" placeholder="Enter middle name here..." class="form-control @error('defendantMiddleName') is-invalid @enderror" value="{{ old('defendantMiddleName') }}">
                                    @error('defendantMiddleName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Last Name *</label>
                                    <input type="text" name="defendantLastName" placeholder="Enter last name here..." class="form-control @error('defendantLastName') is-invalid @enderror" value="{{ old('defendantLastName') }}" required>
                                    @error('defendantLastName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label class="info-label">Complete Address</label>
                                    <input type="text" name="defendantAddress" placeholder="Enter complete address here..." class="form-control @error('defendantAddress') is-invalid @enderror" value="{{ old('defendantAddress') }}">
                                    @error('defendantAddress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="info-label">Contact Number</label>
                                    <input type="text" name="defendantContactNumber" placeholder="09xxxxxxxxx" class="form-control @error('defendantContactNumber') is-invalid @enderror" value="{{ old('defendantContactNumber') }}">
                                    @error('defendantContactNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="info-label">Age</label>
                                    <input type="number" name="defendantAge" placeholder="Enter age here..." class="form-control @error('defendantAge') is-invalid @enderror" value="{{ old('defendantAge') }}" min="1" max="120">
                                    @error('defendantAge')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="text" name="witnessName" placeholder="Enter witness name here..." class="form-control @error('witnessName') is-invalid @enderror" value="{{ old('witnessName') }}">
                                    @error('witnessName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="info-label">Witness Contact Number</label>
                                    <input type="text" name="witnessContactNumber" placeholder="09xxxxxxxxx" class="form-control @error('witnessContactNumber') is-invalid @enderror" value="{{ old('witnessContactNumber') }}">
                                    @error('witnessContactNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <textarea name="blotterDescription" placeholder="Enter case description here..." class="form-control @error('blotterDescription') is-invalid @enderror" rows="4" required>{{ old('blotterDescription') }}</textarea>
                                    @error('blotterDescription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="info-label d-block">Evidence / Proof</label>
                                    <div class="input-group">
                                        <input type="file" name="proof" placeholder="Upload photo or document here..." class="form-control @error('proof') is-invalid @enderror" accept="image/*,.pdf">
                                    </div>
                                    <div class="form-text mt-1">Upload photo or document (Max 4MB, JPG/PNG/PDF)</div>
                                    @error('proof')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Submit Blotter</button>
                </div>
            </form>
        </div>
    </div>
</div>
--}}