<style> .form-control, .form-select { background-color: #ffffff; border: 1.5px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 14px; } .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25); } .form-label { font-weight: 600; margin-bottom: 6px; } .input-group-text { background-color: #f1f3f5; cursor: pointer; } input[type="date"]::-webkit-calendar-picker-indicator { opacity: 1; cursor: pointer; } </style>
@php
$user = auth()->user();
@endphp

<form method="POST" action="{{ route(auth()->user()->role . '.update.profile', auth()->user()->id) }}" enctype="multipart/form-data"> @csrf @method('PUT')<div class="card-body">

    <h6 class="text-muted mb-3">Profile Image</h6>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <div class="d-flex align-items-center gap-3">
                    <div>
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #f1f3f5;">
                                <i class="fas fa-user" style="font-size: 40px; color: #adb5bd;"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-2">Accepted formats: JPG, PNG, GIF (Max 2MB)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <h6 class="text-muted mb-3">Proof of Identity</h6>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Uploaded Proof</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        @if($user->proofOfIdentity)
                            <img src="{{ asset('storage/' . $user->proofOfIdentity) }}" alt="Proof of identity" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <span class="text-muted">No proof uploaded</span>
                        @endif
                    </div>
                    <div class="flex-grow-1" style="min-width: 220px;">
                        <input type="file" name="proofOfIdentity" id="proofOfIdentity" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-2">Upload to replace the current proof (JPG/PNG, Max 4MB)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

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
    
        <div class="col-md-4">
            <label for="current_password" class="form-label">Current Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password">
                <span class="input-group-text" onclick="togglePassword('current_password')" style="cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                >
                <span class="input-group-text" onclick="togglePassword('password')" style="cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                >
                <span class="input-group-text" onclick="togglePassword('password_confirmation')" style="cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>
    </div>

</div>

<div class="card-footer text-end">
    <button type="submit" class="btn btn-primary px-4">
        Save Changes
    </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

</div>

</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const birthday = document.getElementById('birthday');
        const openDate = document.getElementById('openDate');
        const rawDate = "{{ old('birthday', $user->birthday) }}";

        if (birthday && rawDate) {
            const d = new Date(rawDate);
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            birthday.value = `${d.getFullYear()}-${month}-${day}`;
        }

        const openPicker = () => {
            if (!birthday) return;
            if (typeof birthday.showPicker === 'function') {
                birthday.showPicker();
            } else {
                birthday.focus();
            }
        };

        if (openDate && birthday) {
            openDate.addEventListener('mousedown', function (event) {
                event.preventDefault();
                birthday.focus();
                openPicker();
            });
        }

        if (birthday) {
            birthday.addEventListener('click', openPicker);
        }
    });

    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>