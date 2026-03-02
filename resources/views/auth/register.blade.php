<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Register</title>

    <style>
        /* Your existing styles remain exactly the same */
        body {
            background-image: url('{{ asset("images/brgy249_background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-weight: bolder;
        }

        .card {
            width: 100vw;
            max-width: 500px;
            padding: 0.75rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.8),
                transparent
            );
        }

        .card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.8),
                transparent,
                rgba(255, 255, 255, 0.3)
            );
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .input-with-icon {
            position: relative;
        }

        .form-control {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            font-size: 0.8rem;
            padding: 0.35rem 0.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 1); 
            opacity: 1;
            font-weight: 500;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.58);
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.25rem !important;
            color: rgba(255, 255, 255, 0.9);
        }

        .input-with-icon .form-control {
            padding-right: 2.5rem; 
            font-size: 0.7rem;
            padding: 0.4rem 2.5rem 0.4rem 0.5rem; 
        }

        .input-with-icon .input-icon {
            position: absolute;
            right: 10px;
            top: 72.5%;
            transform: translateY(-50%);
            color: #fff !important;
            pointer-events: none;
        }

        .mb-3 {
            margin-bottom: 0.75rem !important; 
        }

        button {
            width: 100%;
            padding: 0.5rem !important; 
        }

        .divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 0.75rem 0; 
        }

        .text-light.small {
            font-size: 0.67rem; 
            margin: 0 2px 
        }
        #textforlogin {
            font-size: 0.9rem;
            font-weight: normal !important;
        }
        .imageBrgy {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 16px;
        }

        .imageBrgy img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 8px;
        }

        @media (max-width: 480px) {
            .imageBrgy img {
                width: 56px;
                height: 56px;
            }
        }

        .image-container img.uniform-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: none;
            box-shadow: none;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            .image-container img.uniform-image {
                width: 90px;
                height: 90px;
            }
        }

        #brgy249logo {
            border-radius: 100%;
        }

       /* --- IMPROVED TERMS & CONDITIONS STYLES --- */
        .terms-container {
            background: rgba(0, 0, 0, 0.15); /* Darker overlay for better text contrast */
            border-radius: 12px;
            padding: 12px;
            margin: 1.5rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .form-check {
            display: flex;
            align-items: flex-start; /* Aligns checkbox with the first line of text */
            padding-left: 0;
            margin-bottom: 0;
        }

        .terms-checkbox {
            min-width: 18px;
            height: 18px;
            margin-top: 3px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #0d6efd;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .terms-text {
            font-size: 0.78rem;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            cursor: pointer;
        }

        .terms-text a {
            color: #6fb1ff; /* Brighter blue for visibility on dark/blur background */
            text-decoration: none;
            border-bottom: 1px solid rgba(111, 177, 255, 0.4);
            transition: all 0.2s;
        }

        .terms-text a:hover {
            color: #fff;
            border-bottom-color: #fff;
        }

        .terms-error-box {
            font-size: 0.7rem;
            color: #ff9999;
            margin-top: 8px;
            display: block;
            font-weight: bold;
        }
        .proof-instruction {
    background: rgba(255, 255, 255, 0.1);
    border-left: 3px solid #6fb1ff;
    padding: 8px 12px;
    margin-top: 5px;
    margin-bottom: 10px;
    border-radius: 4px;
}

.proof-instruction p {
    font-size: 0.72rem;
    line-height: 1.4;
    color: rgba(255, 255, 255, 0.85);
    margin: 0;
    font-weight: normal;
}

.proof-instruction i {
    margin-right: 5px;
    color: #6fb1ff;
}
    </style>
</head>

<body class="d-flex justify-content-center align-items-start vh-100" style="padding-top: 40px;">
    <div class="d-flex flex-column align-items-center">
        <div class="card shadow">
            <h3 class="text-center mb-3 text-light">Register</h3>

            <form action="{{ route('register.attempt') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <!-- Your existing form fields (unchanged) -->
                <div class="input-with-icon mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" name="firstName" id="firstName" class="form-control"
                    placeholder="Enter your first name" value="{{ old('firstName') }}" required>
                    <i class="fa-solid fa-user input-icon"></i>
                    @error('firstName')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message}}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" name="middleName" id="middleName" class="form-control"
                    placeholder="Enter your middle name" value="{{ old('middleName') }}" required> 
                    <i class="fa-solid fa-user input-icon"></i>
                    @error('middleName')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" name="lastName" id="lastName" class="form-control"
                    placeholder="Enter your last name" value="{{ old('lastName') }}" required>
                    <i class="fa-solid fa-user input-icon"></i>
                    @error('lastName')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                    placeholder="Enter your email" value="{{ old('email') }}" required>
                    <i class="fa-solid fa-envelope input-icon"></i>
                    @error('email')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                    placeholder="Enter your password" required>
                    <i class="fa-solid fa-lock input-icon"></i>
                    @error('password')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3" id="confirmPasswordContainer" style="display: none;">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="Confirm your password">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <div id="passwordMismatchError" class="bg-danger p-1 my-1 rounded text-light small mt-1" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i> Passwords do not match
                    </div>
                    @error('password_confirmation')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-with-icon mb-3">
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input type="text" name="contactNumber" id="contactNumber" class="form-control"
                    placeholder="Enter your contact number" value="{{ old('contactNumber') }}" required>
                    <i class="fa-solid fa-phone input-icon"></i>
                    @error('contactNumber')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" name="birthday" id="birthday" class="form-control"
                    value="{{ old('birthday') }}" max="{{ now()->subDay()->format('Y-m-d') }}" required>
                    @error('birthday')
                    <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Proof of Identity</label>
                    
                    <div class="proof-instruction">
                        <p>
                            <i class="fas fa-info-circle"></i> 
                            Submit a clear photo of your valid ID or any image proof to verify your residency in Barangay 249.
                        </p>
                    </div>

                    <input type="file" accept=".jpg, .jpeg, .png" name="proofOfIdentity"
                        id="proofOfIdentity" class="form-control">
                        
                    @error('proofOfIdentity')
                        <div class="bg-danger p-1 my-1 rounded text-light small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="terms-container">
                    <div class="form-check">
                        <input class="terms-checkbox" type="checkbox" name="terms_accepted" id="terms_accepted" value="1" required>
                        <label class="terms-text" for="terms_accepted">
                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a> of the e-Barangay System.
                        </label>
                    </div>
                    @error('terms_accepted')
                        <span class="terms-error-box"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary fw-bold" id="submitBtn" disabled>Submit</button>
            </form>

            <p class="text-light mt-3" id="textforlogin" style="text-align: center">Already have an account? <a href="{{ route('login') }}" class="text-light fw-bold">Login</a></p>
        </div>

        <div class="image-container d-flex justify-content-center mt-4 gap-3">
            <img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Image 1" class="uniform-image" id="brgy249logo">
            <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" alt="Image 2" class="uniform-image">
        </div>
    </div>

    <!-- TERMS & CONDITIONS MODAL -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: rgba(255,255,255,0.98); border-radius: 15px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Terms & Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-0" style="font-size: 0.85rem; line-height: 1.6; max-height: 400px; overflow-y: auto;">
                    <p><strong>1. Eligibility:</strong> You must be a legitimate resident of the barangay.</p>
                    <p><strong>2. Account Responsibility:</strong> You are responsible for maintaining the confidentiality of your account.</p>
                    <p><strong>3. Accurate Information:</strong> You agree to provide accurate, current, and complete information.</p>
                    <p><strong>4. System Use:</strong> The system is for legitimate barangay services only.</p>
                    <p><strong>5. Data Privacy:</strong> Personal data is protected per RA 10173 (Data Privacy Act).</p>
                    <p><strong>6. Prohibited Activities:</strong> No spam, harassment, false reports, or illegal activities. </p>
                    <p><strong>7. Document Requests:</strong> Submitted documents become barangay property for record-keeping and verification purposes.</p>
                    <p><strong>8. System Changes:</strong> Barangay reserves the right to modify, suspend, or terminate the system without notice.</p>
                    <p><strong>9. Limitation of Liability:</strong> Barangay not liable for system downtime, data loss, or indirect damages.</p>
                    <p><strong>10. Governing Law:</strong> Subject to Philippine laws and barangay jurisdiction.</p>
                    <p>By registering, you acknowledge you've read and agree to these terms.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="privacyModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: rgba(255,255,255,0.98); border-radius: 15px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Privacy Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="font-size: 0.85rem;">
                    <p>We collect only necessary data for official barangay functions. Your data is stored securely and never shared with third parties without consent.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Got it</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide confirm password field and validate password match
        const passwordInput = document.getElementById('password');
        const confirmPasswordContainer = document.getElementById('confirmPasswordContainer');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMismatchError = document.getElementById('passwordMismatchError');

        passwordInput.addEventListener('input', function() {
            // Show confirm password container if password has content
            if (this.value.length > 0) {
                confirmPasswordContainer.style.display = 'block';
            } else {
                confirmPasswordContainer.style.display = 'none';
                passwordMismatchError.style.display = 'none';
                confirmPasswordInput.value = '';
            }
            validatePasswordMatch();
        });

        confirmPasswordInput.addEventListener('input', function() {
            validatePasswordMatch();
        });

        function validatePasswordMatch() {
            if (passwordInput.value !== confirmPasswordInput.value && confirmPasswordInput.value.length > 0) {
                passwordMismatchError.style.display = 'block';
            } else {
                passwordMismatchError.style.display = 'none';
            }
        }

        // Enable/disable submit button based on checkbox
        document.getElementById('terms_accepted').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });
    </script>
</body>
</html>
