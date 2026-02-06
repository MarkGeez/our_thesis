@php
    $user = auth()->user();
@endphp

<form action="{{ route($user->role . '.edit.family', $member->id) }}" method="post">
    @method('PUT')
    @csrf
    
    <div class="row mb-3">
        <!-- First Name -->
        <div class="col-md-4">
            <input type="text" 
                   name="firstName" 
                   placeholder="First Name *" 
                   class="form-control @error('firstName') is-invalid @enderror"
                   value="{{ old('firstName', $member->firstName) }}"
                   required>
            @error('firstName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Middle Name -->
        <div class="col-md-4">
            <input type="text" 
                   name="middleName" 
                   placeholder="Middle Name" 
                   class="form-control @error('middleName') is-invalid @enderror"
                   value="{{ old('middleName', $member->middleName) }}">
            @error('middleName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Last Name -->
        <div class="col-md-4">
            <input type="text" 
                   name="lastName" 
                   placeholder="Last Name *" 
                   class="form-control @error('lastName') is-invalid @enderror"
                   value="{{ old('lastName', $member->lastName) }}"
                   required>
            @error('lastName')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row mb-3">
        <!-- Birthdate -->
        <div class="col-md-4">
            <input type="date" 
                   name="birthdate" 
                   class="form-control @error('birthdate') is-invalid @enderror"
                   value="{{ old('birthdate', $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('Y-m-d') : '') }}"
                   required>
            @error('birthdate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Sex as Radio Buttons - Styled as inline buttons -->
        <div class="col-md-4">
            <div class="btn-group w-100" role="group">
                <input type="radio" 
                       class="btn-check" 
                       name="sex" 
                       id="male" 
                       value="male"
                       {{ old('sex', $member->sex) == 'male' ? 'checked' : '' }}
                       required>
                <label class="btn btn-outline-primary" for="male">Male</label>
                
                <input type="radio" 
                       class="btn-check" 
                       name="sex" 
                       id="female" 
                       value="female"
                       {{ old('sex', $member->sex) == 'female' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="female">Female</label>
            </div>
            @error('sex')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Relationship -->
        <div class="col-md-4">
            <input type="text" 
                   name="relationship" 
                   placeholder="Relationship *" 
                   class="form-control @error('relationship') is-invalid @enderror"
                   value="{{ old('relationship', $member->relationship) }}"
                   required>
            @error('relationship')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <!-- Contact Number -->
    <div class="mb-3">
        <input type="tel" 
               name="contactNumber" 
               placeholder="Contact Number (09XXXXXXXXX)" 
               class="form-control @error('contactNumber') is-invalid @enderror"
               value="{{ old('contactNumber', $member->contactNumber) }}">
        @error('contactNumber')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <label for="is_inactive">Is this member active?</label>
    <input type="hidden" name="is_inactive" value="0"> 
<input type="checkbox" name="is_inactive" value="1"
       {{ old('is_inactive', $member->is_inactive ?? 0) ? 'checked' : '' }}>


    
    <!-- Buttons -->
    <div class="d-flex justify-content-between">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>