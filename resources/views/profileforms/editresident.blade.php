<form action="{{ route(auth()->user()->role . '.update.ownInfo', $resident->id) }}" method="post">
    @csrf
    @method('PUT')
    
    <div class="row">
       

    <div class="row mt-3">
        <div class="col-md-3">
            <label for="houseNo">House No.</label>
            <input type="text" name="houseNo" class="form-control" value="{{ old('houseNo', $resident->houseNo) }}" required>
            @error('houseNo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-9">
            <label for="street">Street</label>
            <input type="text" name="street" class="form-control" value="{{ old('street', $resident->street) }}" required>
            @error('street') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label for="contactNo">Contact No.</label>
            <input type="text" name="contactNo" class="form-control" value="{{ old('contactNo', $resident->contactNo) }}" required>
            @error('contactNo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $resident->birthday) }}" required>
            @error('birthday') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label for="emergencyContactName">Emergency Contact Name</label>
            <input type="text" name="emergencyContactName" class="form-control" value="{{ old('emergencyContactName', $resident->emergencyContactName) }}" required>
            @error('emergencyContactName') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6">
            <label for="emergencyContactNo">Emergency Contact No.</label>
            <input type="text" name="emergencyContactNo" class="form-control" value="{{ old('emergencyContactNo', $resident->emergencyContactNo) }}" required>
            @error('emergencyContactNo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <label for="age">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $resident->age) }}" min="0" max="255" required>
            @error('age') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-3">
            <label for="sex">Sex</label>
            <select name="sex" class="form-control" required>
                <option value="">Select</option>
                <option value="male" {{ old('sex', $resident->sex) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('sex', $resident->sex) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('sex') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-3">
            <label for="parent">Parent Status</label>
            <select name="parent" class="form-control" required>
                <option value="">Select</option>
                <option value="yes" {{ old('parent', $resident->parent) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('parent', $resident->parent) == 'no' ? 'selected' : '' }}>No</option>
                <option value="single" {{ old('parent', $resident->parent) == 'single' ? 'selected' : '' }}>Single</option>
            </select>
            @error('parent') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-3">
            <label for="enrolled">Currently Enrolled</label>
            <select name="enrolled" class="form-control" required>
                <option value="">Select</option>
                <option value="yes" {{ old('enrolled', $resident->enrolled) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('enrolled', $resident->enrolled) == 'no' ? 'selected' : '' }}>No</option>
            </select>
            @error('enrolled') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label for="educationalAttainment">Educational Attainment</label>
            <input type="text" name="educationalAttainment" class="form-control" value="{{ old('educationalAttainment', $resident->educationalAttainment) }}">
            @error('educationalAttainment') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6">
            <label for="headOfFamily">Head of Family</label>
            <select name="headOfFamily" class="form-control" required>
                <option value="">Select</option>
                <option value="yes" {{ old('headOfFamily', $resident->headOfFamily) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('headOfFamily', $resident->headOfFamily) == 'no' ? 'selected' : '' }}>No</option>
            </select>
            @error('headOfFamily') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label for="religion">Religion</label>
            <input type="text" name="religion" class="form-control" value="{{ old('religion', $resident->religion) }}">
            @error('religion') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Update Information</button>
        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
    </div>
</form>