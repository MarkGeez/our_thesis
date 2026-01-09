<style> .form-control, .form-select { background-color: #ffffff; border: 1.5px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 14px; } .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25); } .form-label { font-weight: 600; margin-bottom: 6px; } .input-group-text { background-color: #f1f3f5; cursor: pointer; } </style>
@php
$user = auth()->user();
@endphp

<form action="{{ route($user->role . '.update.profile', $user->id) }}" method="POST"> @csrf @method('PUT')
<div class="card-body">

    <h6 class="text-muted mb-3">Account Information</h6>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input
                type="email"
                name="email"
                class="form-control form-control-lg"
                value="{{ old('email', $user->email) }}"
                required
            >
        </div>

        <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input
                type="text"
                name="contactNumber"
                class="form-control form-control-lg"
                value="{{ old('contactNumber', $user->contactNumber) }}"
                required
            >
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <label class="form-label">Birthday</label>
            <div class="input-group">
                <input
                    type="date"
                    name="birthday"
                    id="birthday"
                    class="form-control form-control-lg"
                    required
                >
                <span class="input-group-text" id="openDate">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>

    <hr>

    <h6 class="text-muted mb-3">Change Password</h6>
    <small class="text-muted d-block mb-3">
        Leave empty if you do not want to change your password
    </small>

    <div class="row mb-3">
        <!--
        <div class="col-md-4">
            <label for="current_password" class="form-label">Current Password</label>
        <div class="input-group">
            <input type="password" class="form-control" id="current_password" name="current_password" required>
            <span class="input-group-text" onclick="togglePassword('current_password')">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        </div>
        -->
        <div class="col-md-4">
            <label class="form-label">New Password</label>
            <input
                type="password"
                name="password"
                class="form-control form-control-lg"
            >
        </div>

        <div class="col-md-4">
            <label class="form-label">Confirm New Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control form-control-lg"
            >
        </div>
    </div>

</div>

<div class="card-footer text-end">
    <button type="submit" class="btn btn-primary px-4">
        Save Changes
    </button>
</div>

</form> <script> document.addEventListener('DOMContentLoaded', function () { const birthday = document.getElementById('birthday'); const openDate = document.getElementById('openDate'); const rawDate = "{{ old('birthday', $user->birthday) }}"; if (rawDate) { const d = new Date(rawDate); birthday.value = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); } openDate.addEventListener('click', function () { if (birthday.showPicker) { birthday.showPicker(); } else { birthday.focus(); } }); }); function togglePassword(id) { const input = document.getElementById(id); input.type = input.type === 'password' ? 'text' : 'password'; } </script>