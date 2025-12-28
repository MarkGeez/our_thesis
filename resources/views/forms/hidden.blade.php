<section>
    <h6>Plaintiff Information</h6>
    <div class="info-box">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="info-label">First Name</label>
                <div class="form-control bg-light">{{ auth()->user()->firstName ?? auth()->user()->name }}</div>
                <input type="hidden" name="plaintiffName" value="{{ auth()->user()->firstName ?? auth()->user()->name }}">
            </div>
            <div class="col-md-4">
                <label class="info-label">Middle Name</label>
                <div class="form-control bg-light">{{ auth()->user()->middleName ?? '' }}</div>
                <input type="hidden" name="plaintiffMiddleName" value="{{ auth()->user()->middleName ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="info-label">Last Name</label>
                <div class="form-control bg-light">{{ auth()->user()->lastName ?? '' }}</div>
                <input type="hidden" name="plaintiffLastName" value="{{ auth()->user()->lastName ?? '' }}">
            </div>

            <div class="col-md-8">
                <label class="info-label">Complete Address</label>
                <div class="form-control bg-light">{{ auth()->user()->address ?? '' }}</div>
                <input type="hidden" name="plaintiffAddress" value="{{ auth()->user()->address ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="info-label">Contact Number</label>
                <div class="form-control bg-light">{{ auth()->user()->contactNumber ?? '' }}</div>
                <input type="hidden" name="plaintiffContactNumber" value="{{ auth()->user()->contactNumber ?? '' }}">
            </div>

            <div class="col-md-4">
                <label class="info-label">Age</label>
                <div class="form-control bg-light">{{ auth()->user()->age ?? '' }}</div>
                <input type="hidden" name="plaintiffAge" value="{{ auth()->user()->age ?? '' }}">
            </div>
        </div>
    </div>
</section>
