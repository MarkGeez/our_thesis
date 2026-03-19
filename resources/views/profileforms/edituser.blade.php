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

    .auth-alert {
        border-radius: 8px;
        padding: 0.45rem 0.65rem;
        margin-top: 0.35rem;
        font-size: 0.72rem;
        line-height: 1.4;
        display: flex;
        align-items: flex-start;
        gap: 0.45rem;
        border: 1px solid transparent;
        font-weight: 500;
    }

    .auth-alert i {
        margin-top: 1px;
        flex-shrink: 0;
    }

    .auth-alert-error {
        background: rgba(239, 68, 68, 0.22);
        color: #fef2f2;
        border-color: rgba(239, 68, 68, 0.55);
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
                <input type="text" name="contactNumber" class="form-control form-control-lg" value="{{ old('contactNumber', $user->contactNumber) }}" required>
                <div id="contactError" class="auth-alert auth-alert-error text-black" style="display: none;"></div>
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
            <button type="button" class="btn btn-outline-primary btn-sm text-black" id="togglePasswordSection">
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
                    <div id="passwordError" class="auth-alert auth-alert-error text-black" style="display: none;"></div>
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
                    <div id="passwordMismatchError" class="auth-alert auth-alert-error" style="display: none;">
                        <i class="fa-solid fa-circle-exclamation"></i><div>Passwords do not match</div>
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
        const passwordError = document.getElementById('passwordError');
        const passwordMismatchError = document.getElementById('passwordMismatchError');
        const contactInput = document.querySelector('input[name="contactNumber"]');
        const contactError = document.getElementById('contactError');
        const rawDate = "{{ old('birthday', $user->birthday) }}";
        const hasPasswordErrors = @json($errors->has('password') || $errors->has('password_confirmation'));
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (passwordError) {
            passwordError.style.display = 'none';
        }

        if (passwordMismatchError) {
            passwordMismatchError.style.display = 'none';
        }

        if (contactError) {
            contactError.style.display = 'none';
        }

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

        function validatePasswordPolicy() {
            if (!passwordInput || !passwordError) {
                return;
            }

            if (passwordInput.value.length === 0) {
                passwordError.style.display = 'none';
                passwordError.textContent = '';
            } else if (!passwordRegex.test(passwordInput.value)) {
                passwordError.style.display = 'block';
                passwordError.textContent = 'Min 8 chars, 1 uppercase, 1 number.';
            } else {
                passwordError.style.display = 'none';
                passwordError.textContent = '';
            }
        }

        function validatePasswordMatch() {
            if (!passwordInput || !passwordConfirmationInput || !passwordMismatchError) {
                return;
            }

            if (
                passwordInput.value !== passwordConfirmationInput.value &&
                passwordConfirmationInput.value.length > 0
            ) {
                passwordMismatchError.style.display = 'block';
            } else {
                passwordMismatchError.style.display = 'none';
            }
        }

        function validateContactNumber() {
            if (!contactInput || !contactError) {
                return;
            }

            contactInput.value = contactInput.value.replace(/[^0-9]/g, '');
            if (contactInput.value.length > 11) {
                contactInput.value = contactInput.value.slice(0, 11);
            }

            if (contactInput.value.length === 0) {
                contactError.style.display = 'none';
                contactError.textContent = '';
                contactInput.setCustomValidity('');
            } else if (contactInput.value.length !== 11) {
                contactError.style.display = 'block';
                contactError.textContent = 'Must be exactly 11 digits.';
                contactInput.setCustomValidity('Must be exactly 11 digits.');
            } else {
                contactError.style.display = 'none';
                contactError.textContent = '';
                contactInput.setCustomValidity('');
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

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                validatePasswordPolicy();
                validatePasswordMatch();
            });
        }

        if (passwordConfirmationInput) {
            passwordConfirmationInput.addEventListener('input', function () {
                validatePasswordMatch();
            });
        }

        if (contactInput) {
            contactInput.addEventListener('input', function () {
                validateContactNumber();
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
                    if (passwordError) {
                        passwordError.style.display = 'none';
                        passwordError.textContent = '';
                    }
                    if (passwordMismatchError) {
                        passwordMismatchError.style.display = 'none';
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
