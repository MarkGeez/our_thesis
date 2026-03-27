<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Barangay 249</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo:wght@300;400;600;700&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2d7dfd;
            --accent-gold: #ffd700;
            --glass-white: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        /* =============================================
           BASE & BACKGROUND
        ============================================= */
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                              url('{{ asset("images/brgy249_background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Exo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
            overflow-x: hidden;
        }

        #particle-canvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .cursor-glow {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, rgba(45, 125, 253, 0.1) 0%, transparent 70%);
            transform: translate(-50%, -50%);
        }

        /* =============================================
           LARGE GLASS CONTAINER
        ============================================= */
        .register-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            background: var(--glass-white);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 4rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            animation: fadeInScale 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* =============================================
           BRAND HEADER
        ============================================= */
        .brand-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .brand-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 4rem;
            letter-spacing: 4px;
            margin-bottom: 0;
            background: linear-gradient(to bottom, #fff, #bdc3c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-header h3 {
            font-family: 'Oswald', sans-serif;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        /* =============================================
           SECTION LABELS
        ============================================= */
        .section-label {
            font-family: 'Oswald', sans-serif;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* =============================================
           FORM CONTROLS
        ============================================= */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }

        .input-group.is-invalid-group {
            border-color: rgba(239, 68, 68, 0.7);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }

        .input-group:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(45, 125, 253, 0.25);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            padding-left: 15px;
        }

        .form-control,
        .form-select {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px 15px;
            font-size: 0.95rem;
            box-shadow: none !important;
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) opacity(0.5);
            cursor: pointer;
        }

        input[type="file"].form-control {
            padding: 10px 15px;
            cursor: pointer;
        }

        /* =============================================
           PASSWORD TOGGLE
        ============================================= */
        .btn-toggle-pw {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            padding-right: 15px;
            padding-left: 10px;
            transition: color 0.3s;
            cursor: pointer;
            line-height: 1;
        }

        .btn-toggle-pw:hover { color: white; }

        /* =============================================
           VALIDATION ERROR ALERTS
        ============================================= */
        .auth-alert {
            border-radius: 8px;
            padding: 0.4rem 0.65rem;
            margin-top: 0.45rem;
            font-size: 0.72rem;
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
            gap: 0.4rem;
            font-weight: 500;
        }

        .auth-alert i { margin-top: 1px; flex-shrink: 0; }

        .auth-alert-error {
            background: rgba(239, 68, 68, 0.18);
            color: #fef2f2;
            border: 1px solid rgba(239, 68, 68, 0.45);
        }

        /* =============================================
           CONFIRM PASSWORD (smooth reveal)
        ============================================= */
        #confirmPasswordWrapper {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.38s ease, opacity 0.3s ease;
        }

        #confirmPasswordWrapper.visible {
            max-height: 200px;
            opacity: 1;
        }

        /* =============================================
           PROOF OF IDENTITY NOTICE
        ============================================= */
        .proof-notice {
            background: rgba(45, 125, 253, 0.1);
            border-left: 4px solid var(--primary-blue);
            border-radius: 0 8px 8px 0;
            padding: 0.65rem 1rem;
            margin-bottom: 0.75rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
        }

        .proof-notice i { color: #6fb1ff; margin-right: 6px; }

        /* =============================================
           TERMS CONTAINER
        ============================================= */
        .terms-container {
            background: rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.1rem;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            padding-left: 0;
            margin-bottom: 0;
        }

        .terms-checkbox {
            min-width: 16px;
            height: 16px;
            margin-top: 3px;
            margin-right: 10px;
            flex-shrink: 0;
            cursor: pointer;
            accent-color: var(--primary-blue);
        }

        .terms-text {
            font-size: 0.82rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.75);
            cursor: pointer;
        }

        .terms-text a {
            color: #6fb1ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .terms-text a:hover { color: #fff; }

        /* =============================================
           SUBMIT BUTTON
        ============================================= */
        .btn-register {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1a2a88 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 15px;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 1.2rem;
            border-radius: 12px;
            width: 100%;
            margin-top: 20px;
            color: #fff;
            transition: all 0.4s;
            cursor: pointer;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(45, 125, 253, 0.4);
            border-color: var(--accent-gold);
        }

        .btn-register:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* =============================================
           LOGIN LINK
        ============================================= */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .login-link a {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover { text-decoration: underline; }

        /* =============================================
           RESPONSIVE
        ============================================= */
        @media (max-width: 992px) {
            .register-container { padding: 2.5rem 2rem; }
            .brand-header h1 { font-size: 3rem; }
        }

        @media (max-width: 576px) {
            .register-container { padding: 2rem 1.2rem; border-radius: 24px; }
            .brand-header h1 { font-size: 2.4rem; }
        }
    </style>
</head>
<body>

<canvas id="particle-canvas"></canvas>
<div class="cursor-glow" id="cursorGlow"></div>

<div class="register-container">

    <!-- ── BRAND HEADER ──────────────────────────────────────── -->
    <header class="brand-header">
        <div class="d-flex justify-content-center gap-3 mb-3">
            <img src="{{ asset('images/Brgy-logo-1.png') }}" height="70"
                 style="border-radius:50%; background:rgba(255,255,255,0.15); padding:3px; object-fit:contain;">
            <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" height="70" style="object-fit:contain;">
        </div>
        <h3>e-Barangay Portal</h3>
        <h1>REGISTRATION</h1>
    </header>

    <form action="{{ route('register.attempt') }}" method="POST" enctype="multipart/form-data" novalidate
          id="registerForm">
        @csrf

        <!-- ── PERSONAL INFORMATION ──────────────────────────── -->
        <div class="section-label">Personal Information</div>

        <div class="row g-4 mb-4">
            <!-- First Name -->
            <div class="col-md-4">
                <label for="firstName" class="form-label">First Name</label>
                <div class="input-group @error('firstName') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="firstName" id="firstName" class="form-control"
                           placeholder="Juan" value="{{ old('firstName') }}"
                           pattern="^[A-Za-z\s]+$" title="Letters only (A-Z or a-z)." required>
                </div>
                <div id="firstNameError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>First name must contain letters only (A-Z or a-z).</div>
                </div>
                @error('firstName')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <!-- Middle Name -->
            <div class="col-md-4">
                <label for="middleName" class="form-label">Middle Name</label>
                <div class="input-group @error('middleName') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="middleName" id="middleName" class="form-control"
                           placeholder="Santos" value="{{ old('middleName') }}"
                           pattern="^[A-Za-z\s]+$" title="Letters only (A-Z or a-z)." required>
                </div>
                <div id="middleNameError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>Middle name must contain letters only (A-Z or a-z).</div>
                </div>
                @error('middleName')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="col-md-4">
                <label for="lastName" class="form-label">Last Name</label>
                <div class="input-group @error('lastName') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="lastName" id="lastName" class="form-control"
                           placeholder="Dela Cruz" value="{{ old('lastName') }}"
                           pattern="^[A-Za-z\s]+$" title="Letters only (A-Z or a-z)." required>
                </div>
                <div id="lastNameError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>Last name must contain letters only (A-Z or a-z).</div>
                </div>
                @error('lastName')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group @error('email') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="juan@example.com" value="{{ old('email') }}" required>
                </div>
                @error('email')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <!-- Contact Number -->
            <div class="col-md-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <div class="input-group @error('contactNumber') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                    <input type="tel" name="contactNumber" id="contactNumber" class="form-control"
                           placeholder="09170000000" value="{{ old('contactNumber') }}"
                           inputmode="numeric" pattern="^09\d{9}$" maxlength="11" required>
                </div>
                {{-- Live contact error injected by JS --}}
                <div id="contactError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div></div>
                </div>
                @error('contactNumber')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <!-- Birthday -->
            <div class="col-md-3">
                <label for="birthday" class="form-label">Birthday</label>
                <div class="input-group @error('birthday') is-invalid-group @enderror">
                    <input type="date" name="birthday" id="birthday" class="form-control px-3"
                           value="{{ old('birthday') }}" max="{{ now()->subDay()->format('Y-m-d') }}" required>
                </div>
                @error('birthday')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>

        <!-- ── ACCOUNT SECURITY ──────────────────────────────── -->
        <div class="section-label">Account Security</div>

        <div class="row g-4 mb-5">
            <!-- Password -->
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <div class="input-group @error('password') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="••••••••" required>
                    <button type="button" class="btn-toggle-pw" data-toggle-target="password"
                            aria-label="Show password" aria-pressed="false">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                {{-- Live password strength error injected by JS --}}
                <div id="passwordError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div></div>
                </div>
                @error('password')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <!-- Confirm Password — revealed when password has input -->
            <div class="col-md-6" id="confirmPasswordWrapper">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group @error('password_confirmation') is-invalid-group @enderror">
                    <span class="input-group-text"><i class="fa-solid fa-shield-check"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control" placeholder="••••••••">
                    <button type="button" class="btn-toggle-pw" data-toggle-target="password_confirmation"
                            aria-label="Show confirm password" aria-pressed="false">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMismatchError" class="auth-alert auth-alert-error" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>Passwords do not match</div>
                </div>
                @error('password_confirmation')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>

        <!-- ── RESIDENCY VERIFICATION ────────────────────────── -->
        <div class="section-label">Residency Verification</div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="proof-notice">
                    <i class="fa-solid fa-circle-info"></i>
                    Submit a clear photo of your valid Government ID or any image proof to verify your residency in Barangay 249.
                    Accepted formats: JPG, JPEG, PNG. Maximum file size: 4 MB.
                </div>
                <div class="input-group @error('proofOfIdentity') is-invalid-group @enderror">
                    <input type="file" name="proofOfIdentity" id="proofOfIdentity"
                           class="form-control" accept=".jpg,.jpeg,.png">
                </div>
                <div id="proofSizeError" class="auth-alert auth-alert-error mt-2" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>Proof of identity must be 4 MB or smaller.</div>
                </div>
                @error('proofOfIdentity')
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>

        <!-- ── TERMS & CONDITIONS ────────────────────────────── -->
        <div class="terms-container mb-2">
            <div class="form-check">
                <input class="terms-checkbox" type="checkbox" name="terms_accepted"
                       id="terms_accepted" value="1" required>
                <label class="terms-text" for="terms_accepted">
                    I agree to the
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms &amp; Conditions</a>
                    and
                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                    of the e-Barangay System.
                </label>
            </div>
            @error('terms_accepted')
            <div class="auth-alert auth-alert-error mt-2">
                <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
            </div>
            @enderror
        </div>

        <!-- ── SUBMIT ─────────────────────────────────────────── -->
        <button type="submit" class="btn-register" id="submitBtn" disabled>
            CREATE ACCOUNT <i class="fa-solid fa-arrow-right ms-2"></i>
        </button>
    </form>

    <div class="login-link">
        Already have an account? <a href="{{ route('login') }}">Login Here</a>
    </div>
</div>


<!-- ============================================================
     TERMS & CONDITIONS MODAL
============================================================ -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background:rgba(255,255,255,0.98); border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="font-family:'Oswald',sans-serif;">
                    <i class="fa-solid fa-file-contract text-primary me-2"></i>Terms &amp; Conditions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:0.85rem; line-height:1.7; color:#333;">
                <p><strong>1. Eligibility:</strong> You must be a legitimate resident of the barangay.</p>
                <p><strong>2. Account Responsibility:</strong> You are responsible for maintaining the confidentiality of your account.</p>
                <p><strong>3. Accurate Information:</strong> You agree to provide accurate, current, and complete information.</p>
                <p><strong>4. System Use:</strong> The system is for legitimate barangay services only.</p>
                <p><strong>5. Data Privacy:</strong> Personal data is protected per RA 10173 (Data Privacy Act).</p>
                <p><strong>6. Prohibited Activities:</strong> No spam, harassment, false reports, or illegal activities.</p>
                <p><strong>7. Document Requests:</strong> Submitted documents become barangay property for record-keeping and verification purposes.</p>
                <p><strong>8. System Changes:</strong> Barangay reserves the right to modify, suspend, or terminate the system without notice.</p>
                <p><strong>9. Limitation of Liability:</strong> Barangay not liable for system downtime, data loss, or indirect damages.</p>
                <p><strong>10. Governing Law:</strong> Subject to Philippine laws and barangay jurisdiction.</p>
                <p class="mb-0 text-muted" style="font-size:0.78rem;">By registering, you acknowledge you have read and agree to these terms.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary px-4 fw-bold" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     PRIVACY POLICY MODAL
============================================================ -->
<div class="modal fade" id="privacyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:rgba(255,255,255,0.98); border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="font-family:'Oswald',sans-serif;">
                    <i class="fa-solid fa-shield-halved text-success me-2"></i>Privacy Policy
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:0.85rem; line-height:1.7; color:#333;">
                <p>We collect only necessary data for official barangay functions. Your data is stored securely and never shared with third parties without consent.</p>
                <p class="mb-0">All information is handled in compliance with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-success px-4 fw-bold" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── PASSWORD VISIBILITY TOGGLES ──────────────────────────────
    document.querySelectorAll('.btn-toggle-pw').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.getAttribute('data-toggle-target'));
            const icon  = btn.querySelector('i');
            if (!input || !icon) return;
            const showing  = input.type === 'text';
            input.type     = showing ? 'password' : 'text';
            icon.className = showing ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
            btn.setAttribute('aria-pressed', String(!showing));
            btn.setAttribute('aria-label',  showing ? 'Show password' : 'Hide password');
        });
    });

    // ── ELEMENT REFS ──────────────────────────────────────────────
    const passwordInput         = document.getElementById('password');
    const confirmWrapper        = document.getElementById('confirmPasswordWrapper');
    const confirmPasswordInput  = document.getElementById('password_confirmation');
    const passwordMismatchError = document.getElementById('passwordMismatchError');
    const passwordError         = document.getElementById('passwordError');
    const firstNameInput        = document.getElementById('firstName');
    const middleNameInput       = document.getElementById('middleName');
    const lastNameInput         = document.getElementById('lastName');
    const firstNameError        = document.getElementById('firstNameError');
    const middleNameError       = document.getElementById('middleNameError');
    const lastNameError         = document.getElementById('lastNameError');
    const contactInput          = document.getElementById('contactNumber');
    const contactError          = document.getElementById('contactError');
    const proofInput            = document.getElementById('proofOfIdentity');
    const proofSizeError        = document.getElementById('proofSizeError');
    const submitBtn             = document.getElementById('submitBtn');
    const termsCheckbox         = document.getElementById('terms_accepted');
    const maxProofSizeBytes     = 4 * 1024 * 1024;

    // Password must be at least 8 chars, 1 uppercase, 1 number
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
    const nameRegex = /^[A-Za-z\s]+$/;

    // ── PASSWORD — LIVE STRENGTH + CONFIRM REVEAL ─────────────────
    passwordInput.addEventListener('input', function () {
        const val = this.value;

        // Show/hide confirm field
        if (val.length > 0) {
            confirmWrapper.classList.add('visible');
        } else {
            confirmWrapper.classList.remove('visible');
            confirmPasswordInput.value = '';
            passwordMismatchError.style.display = 'none';
        }

        // Live strength feedback (co-programmer's validation)
        if (val.length === 0) {
            passwordError.style.display = 'none';
            passwordError.querySelector('div').textContent = '';
        } else if (!passwordRegex.test(val)) {
            passwordError.style.display = 'flex';
            passwordError.querySelector('div').textContent =
                'Minimum of 8 characters, at least 1 uppercase letter and 1 number.';
        } else {
            passwordError.style.display = 'none';
            passwordError.querySelector('div').textContent = '';
        }

        validatePasswordMatch();
    });

    // ── CONFIRM PASSWORD — MISMATCH CHECK ────────────────────────
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    function validatePasswordMatch() {
        const mismatch = confirmPasswordInput.value.length > 0 &&
                         passwordInput.value !== confirmPasswordInput.value;
        passwordMismatchError.style.display = mismatch ? 'flex' : 'none';
    }

    // ── CONTACT NUMBER — LIVE VALIDATION (co-programmer's) ───────
    contactInput.addEventListener('input', function () {
        // Strip non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');

        // Enforce max 11 digits
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }

        if (this.value.length === 0) {
            contactError.style.display = 'none';
            contactError.querySelector('div').textContent = '';
        } else if (this.value.length !== 11) {
            contactError.style.display = 'flex';
            contactError.querySelector('div').textContent =
                'Contact number must be exactly 11 digits.';
        } else {
            contactError.style.display = 'none';
            contactError.querySelector('div').textContent = '';
        }
    });

    // ── NAME FIELDS — LETTERS ONLY (A-Z / a-z) ───────────────────
    function validateNameField(input, errorBox, label, allowEmpty) {
        if (!input || !errorBox) return true;

        input.value = input.value.replace(/[^A-Za-z\s]/g, '');
        const value = input.value.trim();

        if (allowEmpty && value.length === 0) {
            errorBox.style.display = 'none';
            return true;
        }

        const valid = nameRegex.test(value);
        errorBox.style.display = valid ? 'none' : 'flex';
        if (!valid) {
            errorBox.querySelector('div').textContent = label + ' must contain letters only (A-Z or a-z).';
        }

        return valid;
    }

    firstNameInput.addEventListener('input', function () {
        validateNameField(firstNameInput, firstNameError, 'First name', false);
    });

    middleNameInput.addEventListener('input', function () {
        validateNameField(middleNameInput, middleNameError, 'Middle name', false);
    });

    lastNameInput.addEventListener('input', function () {
        validateNameField(lastNameInput, lastNameError, 'Last name', false);
    });

    // ── TERMS CHECKBOX — ENABLES SUBMIT ──────────────────────────
    termsCheckbox.addEventListener('change', function () {
        submitBtn.disabled = !this.checked;
    });

    // ── PROOF OF IDENTITY — FILE SIZE CHECK (4MB) ────────────────
    proofInput.addEventListener('change', function () {
        const selectedFile = this.files && this.files.length ? this.files[0] : null;

        if (selectedFile && selectedFile.size > maxProofSizeBytes) {
            this.value = '';
            proofSizeError.style.display = 'flex';
            proofSizeError.querySelector('div').textContent = 'Proof of identity must be 4 MB or smaller.';
            return;
        }

        proofSizeError.style.display = 'none';
        proofSizeError.querySelector('div').textContent = '';
    });

    // ── FORM SUBMIT — BLOCK IF LIVE ERRORS EXIST ─────────────────
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        const pwVal      = passwordInput.value;
        const contactVal = contactInput.value;
        const contactRx  = /^\d{11}$/;
        const selectedFile = proofInput.files && proofInput.files.length ? proofInput.files[0] : null;
        const proofTooLarge = !!selectedFile && selectedFile.size > maxProofSizeBytes;
        const firstNameValid = validateNameField(firstNameInput, firstNameError, 'First name', false);
        const middleNameValid = validateNameField(middleNameInput, middleNameError, 'Middle name', false);
        const lastNameValid = validateNameField(lastNameInput, lastNameError, 'Last name', false);

        if (!passwordRegex.test(pwVal) || !contactRx.test(contactVal) || proofTooLarge || !firstNameValid || !middleNameValid || !lastNameValid) {
            e.preventDefault();

            if (!passwordRegex.test(pwVal)) {
                passwordError.style.display = 'flex';
                passwordError.querySelector('div').textContent =
                    'Minimum of 8 characters, at least 1 uppercase letter and 1 number.';
            }
            if (!contactRx.test(contactVal)) {
                contactError.style.display = 'flex';
                contactError.querySelector('div').textContent =
                    'Contact number must be exactly 11 digits.';
            }

            if (proofTooLarge) {
                proofSizeError.style.display = 'flex';
                proofSizeError.querySelector('div').textContent = 'Proof of identity must be 4 MB or smaller.';
            }
        }

        if (!e.defaultPrevented) {
            const form = this;
            const activeSubmit = e.submitter || form.querySelector('button[type="submit"], input[type="submit"]');

            if (activeSubmit) {
                activeSubmit.disabled = true;
                activeSubmit.setAttribute('aria-disabled', 'true');
                activeSubmit.style.pointerEvents = 'none';
                activeSubmit.style.opacity = '0.7';
            }
        }
    });

    window.addEventListener('pageshow', function () {
        const form = document.getElementById('registerForm');
        if (!form) return;

        form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (btn) {
            btn.disabled = false;
            btn.removeAttribute('aria-disabled');
            btn.style.pointerEvents = '';
            btn.style.opacity = '';
        });
    });

    // ── CURSOR GLOW (desktop only) ────────────────────────────────
    const glow = document.getElementById('cursorGlow');
    if (window.matchMedia('(pointer: fine)').matches) {
        document.addEventListener('mousemove', function (e) {
            glow.style.left = e.clientX + 'px';
            glow.style.top  = e.clientY + 'px';
        });
    } else {
        glow.style.display = 'none';
    }

    // ── FLOATING PARTICLES ────────────────────────────────────────
    (function () {
        const canvas = document.getElementById('particle-canvas');
        const ctx    = canvas.getContext('2d');
        let W, H, particles = [];
        const COLORS = ['rgba(45,125,253,', 'rgba(255,215,0,', 'rgba(255,255,255,'];

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function rand(min, max) { return Math.random() * (max - min) + min; }

        function Particle() { this.reset(); }
        Particle.prototype.reset = function () {
            this.x       = rand(0, W);
            this.y       = rand(0, H);
            this.r       = rand(0.5, 2.5);
            this.vx      = rand(-0.3, 0.3);
            this.vy      = rand(-0.5, -0.1);
            this.color   = COLORS[Math.floor(Math.random() * COLORS.length)];
            this.alpha   = rand(0.1, 0.5);
            this.life    = 0;
            this.maxLife = rand(200, 600);
        };
        Particle.prototype.update = function () {
            this.x += this.vx;
            this.y += this.vy;
            this.life++;
            if (this.y < -5 || this.life > this.maxLife) this.reset();
        };
        Particle.prototype.draw = function () {
            const progress = this.life / this.maxLife;
            const a = this.alpha * (1 - Math.pow(progress - 0.5, 2) * 4);
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
            ctx.fillStyle = this.color + Math.max(0, a) + ')';
            ctx.fill();
        };

        for (let i = 0; i < 80; i++) particles.push(new Particle());

        function loop() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(function (p) { p.update(); p.draw(); });
            requestAnimationFrame(loop);
        }
        loop();
    })();
</script>
</body>
</html>