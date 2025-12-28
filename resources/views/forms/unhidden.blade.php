<section>
    <h6>Plaintiff Information</h6>
    <div class="info-box">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="info-label">First Name *</label>
                <input type="text" 
                       name="plaintiffName"
                       placeholder="Enter first name here..." 
                       class="form-control @error('plaintiffName') is-invalid @enderror" 
                       value="{{ old('plaintiffName') }}" 
                       required>
                @error('plaintiffName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="info-label">Middle Name</label>
                <input type="text" 
                       name="plaintiffMiddleName" 
                       placeholder="Enter middle name here..."
                       class="form-control @error('plaintiffMiddleName') is-invalid @enderror" 
                       value="{{ old('plaintiffMiddleName') }}">
                @error('plaintiffMiddleName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="info-label">Last Name *</label>
                <input type="text" 
                       name="plaintiffLastName" 
                       placeholder="Enter last name here..."
                       class="form-control @error('plaintiffLastName') is-invalid @enderror" 
                       value="{{ old('plaintiffLastName') }}" 
                       required>
                @error('plaintiffLastName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label class="info-label">Complete Address</label>
                <input type="text" 
                       name="plaintiffAddress" 
                       placeholder="Enter complete address here..."
                       class="form-control @error('plaintiffAddress') is-invalid @enderror" 
                       value="{{ old('plaintiffAddress') }}">
                @error('plaintiffAddress')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="info-label">Contact Number</label>
                <input type="text" 
                       name="plaintiffContactNumber" 
                       placeholder="09xxxxxxxxx"
                       class="form-control @error('plaintiffContactNumber') is-invalid @enderror" 
                       value="{{ old('plaintiffContactNumber') }}">
                @error('plaintiffContactNumber')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="info-label">Age</label>
                <input type="number" 
                       name="plaintiffAge" 
                       class="form-control @error('plaintiffAge') is-invalid @enderror" 
                       value="{{ old('plaintiffAge') }}" 
                       placeholder="Enter age here..."
                       min="1" 
                       max="120">
                @error('plaintiffAge')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</section>
