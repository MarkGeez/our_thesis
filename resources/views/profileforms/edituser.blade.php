<style> 
    .form-control, .form-select { 
        background-color: #ffffff; 
        border: 1.5px solid #ced4da; 
        border-radius: 6px; 
        padding: 10px 12px; 
        font-size: 14px; 
    } 
    .form-control:focus { 
        border-color: #0d6efd; 
        box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25); 
    } 
    .form-label { 
        font-weight: 600; 
        margin-bottom: 6px; 
    } 
    /* This ensures the calendar icon stays glued to the input */
    .input-group-text { 
        background-color: #f1f3f5; 
        border: 1.5px solid #ced4da; /* Matched with form-control */
        cursor: pointer; 
    } 
    input[type="date"]::-webkit-calendar-picker-indicator { 
        opacity: 1; 
        cursor: pointer; 
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }
    .password-section.d-none {
        display: none !important;
    }
</style>

@php
$user = auth()->user();
@endphp

<form method="POST" action="{{ route(auth()->user()->role . '.update.profile', auth()->user()->id) }}" enctype="multipart/form-data"> 
    @csrf 
    @method('PUT')
    
    <div class="card-body">
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

        <h6 class="text-muted mb-3">Account Information</h6>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="tel" name="contactNumber" class="form-control form-control-lg" value="{{ old('contactNumber', $user->contactNumber) }}" inputmode="numeric" pattern="^09\d{9}$" maxlength="11" placeholder="09170000000" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Birthday</label>
                <div class="input-group">
                    <input
                        type="date"
                        name="birthday"
                        id="user_birthday"
                        class="form-control form-control-lg"
                        value="{{ old('birthday', $user->birthday) }}"
                        max="{{ now()->subDay()->format('Y-m-d') }}"
                    >
                    <span class="input-group-text" id="user_openDate">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
                <div id="birthday_error" class="invalid-feedback"></div>
            </div>
        </div>

        <hr>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="text-muted mb-0">Password</h6>
            <button type="button" class="btn btn-outline-primary btn-sm" id="togglePasswordSection">
                Change Password
            </button>
        </div>

        <div id="passwordSection" class="password-section d-none">
            <div class="row mb-3">
                <div class="col-md-6">
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

                <div class="col-md-6">
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
    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const birthdayInput = document.getElementById('user_birthday');
        const openDateBtn = document.getElementById('user_openDate');
        const errorDisplay = document.getElementById('birthday_error');
        const passwordSection = document.getElementById('passwordSection');
        const togglePasswordSectionBtn = document.getElementById('togglePasswordSection');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const rawDate = "{{ old('birthday', $user->birthday) }}";
        const hasPasswordErrors = @json($errors->has('password') || $errors->has('password_confirmation'));

        if (rawDate && birthdayInput) {
            const d = new Date(rawDate);
            if (!isNaN(d)) {
                const formattedDate = d.getFullYear() + '-' + 
                                     String(d.getMonth() + 1).padStart(2, '0') + '-' + 
                                     String(d.getDate()).padStart(2, '0');
                birthdayInput.value = formattedDate;
            }
        }

        // Validate date on change
        if (birthdayInput) {
            birthdayInput.addEventListener('change', function () {
                validateBirthday();
            });
        }

        function validateBirthday() {
            const selectedDate = new Date(birthdayInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (birthdayInput.value && selectedDate > today) {
                errorDisplay.textContent = 'Birthday cannot be set to a future date.';
                birthdayInput.classList.add('is-invalid');
                birthdayInput.value = '';
            } else {
                errorDisplay.textContent = '';
                birthdayInput.classList.remove('is-invalid');
            }
        }

        if (openDateBtn && birthdayInput) {
            openDateBtn.addEventListener('click', function () {
                if (birthdayInput.showPicker) {
                    birthdayInput.showPicker();
                } else {
                    birthdayInput.focus();
                }
            });
        }

        if (togglePasswordSectionBtn && passwordSection) {
            if (hasPasswordErrors) {
                passwordSection.classList.remove('d-none');
                togglePasswordSectionBtn.textContent = 'Cancel Password Change';
            }

            togglePasswordSectionBtn.addEventListener('click', function () {
                const isHidden = passwordSection.classList.contains('d-none');
                passwordSection.classList.toggle('d-none');
                togglePasswordSectionBtn.textContent = isHidden ? 'Cancel Password Change' : 'Change Password';

                if (!isHidden) {
                    if (passwordInput) {
                        passwordInput.value = '';
                        passwordInput.type = 'password';
                    }
                    if (passwordConfirmationInput) {
                        passwordConfirmationInput.value = '';
                        passwordConfirmationInput.type = 'password';
                    }
                }
            });
        }
    });

    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
