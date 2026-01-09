@php
    $user = auth()->user();
@endphp

<form action="{{ route($user->role . '.update.profile', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" 
               value="{{ old('email', $user->email) }}" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-3">
        <label for="contactNumber" class="form-label">Contact Number</label>
        <input type="text" name="contactNumber" class="form-control" 
               value="{{ old('contactNumber', $user->contactNumber) }}" required>
        @error('contactNumber') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-3">
        <label for="birthday" class="form-label">Birthday</label>
        <input type="date" name="birthday" class="form-control" 
               value="{{ old('birthday', $user->birthday) }}" required>
        @error('birthday') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <hr>
    
    <h6>Change Password (Optional)</h6>
    
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control">
        @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" class="form-control">
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary">Update Profile</button>
