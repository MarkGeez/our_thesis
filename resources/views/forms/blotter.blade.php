<?php
    $role = auth()->user()->role;
?>


    <!-- Button to open modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blotterModal">
        {!! $button ?? ''!!}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blotterModalLabel">Submit Blotter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <!-- SINGLE FORM - No nesting -->
                    <form action="{{ route('admin.submit.blotter') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {!! $plaintiff ?? '' !!}
                        
                        
                        {{-- ================= DEFENDANT ================= --}}
                        <h4>Defendant Information</h4>

                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="defendantAddress"
                                   class="form-control border border-light @error('defendantAddress') is-invalid @enderror"
                                   value="{{ old('defendantAddress') }}">
                            @error('defendantAddress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Contact Number</label>
                            <input type="text" name="defendantContactNumber"
                                   class="form-control border border-light @error('defendantContactNumber') is-invalid @enderror"
                                   value="{{ old('defendantContactNumber') }}">
                            @error('defendantContactNumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>First Name *</label>
                                <input type="text" name="defendantName"
                                       class="form-control border border-light @error('defendantName') is-invalid @enderror"
                                       value="{{ old('defendantName') }}" required>
                                @error('defendantName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <label>Middle Name</label>
                                <input type="text" name="defendantMiddleName"
                                       class="form-control border border-light @error('defendantMiddleName') is-invalid @enderror"
                                       value="{{ old('defendantMiddleName') }}">
                                @error('defendantMiddleName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <label>Last Name *</label>
                                <input type="text" name="defendantLastName"
                                       class="form-control border border-light @error('defendantLastName') is-invalid @enderror"
                                       value="{{ old('defendantLastName') }}" required>
                                @error('defendantLastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-2">
                            <label>Age</label>
                            <input type="number" name="defendantAge"
                                   class="form-control border border-light @error('defendantAge') is-invalid @enderror"
                                   value="{{ old('defendantAge') }}">
                            @error('defendantAge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        {{-- ================= WITNESS ================= --}}
                        <h4>Witness (Optional)</h4>

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="witnessName"
                                   class="form-control border border-light @error('witnessName') is-invalid @enderror"
                                   value="{{ old('witnessName') }}">
                            @error('witnessName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Contact Number</label>
                            <input type="text" name="witnessContactNumber"
                                   class="form-control border border-light @error('witnessContactNumber') is-invalid @enderror"
                                   value="{{ old('witnessContactNumber') }}">
                            @error('witnessContactNumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        {{-- ================= CASE DETAILS ================= --}}
                        <h4>Case Details</h4>

                        <div class="mb-3">
                            <label>Upload Proof</label>
                            <input type="file" name="proof"
                                   class="form-control border border-light @error('proof') is-invalid @enderror">
                            @error('proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Description *</label>
                            <textarea name="blotterDescription"
                                      class="form-control border border-light @error('blotterDescription') is-invalid @enderror"
                                      rows="5" required>{{ old('blotterDescription') }}</textarea>
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

    
