<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-image: url('{{ asset("images/brgy249_background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-weight: bolder;
            padding: 20px;
        }

        .card {
            width: 100vw;
            max-width: 500px;
            padding: 1.5rem;
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
            margin-top: 50px;
        }

        .card h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #fff;
            text-align: center;
        }

        .card-description {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .input-with-icon {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-control {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            font-size: 1.2rem;
            padding: 0.75rem 0.5rem;
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

        .form-control:disabled {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .input-with-icon .form-control {
            padding-right: 3rem;
        }

        .input-with-icon .input-icon {
            position: absolute;
            right: 12px;
            top: 68%;
            transform: translateY(-50%);
            color: #fff;
            pointer-events: none;
            font-size: 1.2rem;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        .text-danger.small {
            font-size: 0.9rem;
        }

        #textforlogin {
            font-size: 1rem;
            font-weight: normal;
            text-align: center;
            margin-top: 1rem;
            color: #fff;
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

        .alert {
            font-size: 0.95rem;
            border-radius: 10px;
        }

        .back-to-login {
            text-align: center;
            margin-top: 1rem;
        }

        .back-to-login a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .password-requirements {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 0.5rem;
            padding: 0.5rem;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
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
    </style>
</head>
<body class="d-flex justify-content-center align-items-start vh-100" style="padding-top: 40px;">
    <div class="d-flex flex-column align-items-center">

    <div class="card shadow">
        <h3>Reset Password</h3>
        <p class="card-description">Create a new password for your account. Make sure it's strong and secure.</p>
        
        <form action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Please check the fields below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="input-with-icon">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                <i class="fa-solid fa-envelope input-icon"></i>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <div id="passwordError" class="auth-alert auth-alert-error" style="display: none;"></div>
                <div class="password-requirements">
                    Minimum 8 characters required
                </div>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <div id="passwordMismatchError" class="auth-alert auth-alert-error text-black" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation"></i><div>Passwords do not match</div>
                </div>
                @error('password_confirmation')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Reset Password</button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left"></i> Back to Login</a>
        </div>
    </div>

    <div class="image-container d-flex justify-content-center mt-4 gap-3">
        <img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Image 1" class="uniform-image" id="brgy249logo">
        <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" alt="Image 2" class="uniform-image">
    </div>

    </div>

    <script>
        (function () {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('passwordError');
            const passwordMismatchError = document.getElementById('passwordMismatchError');

            if (!passwordInput || !confirmPasswordInput || !passwordError || !passwordMismatchError) {
                return;
            }

            const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

            function validatePasswordMatch() {
                if (
                    passwordInput.value !== confirmPasswordInput.value &&
                    confirmPasswordInput.value.length > 0
                ) {
                    passwordMismatchError.style.display = 'block';
                } else {
                    passwordMismatchError.style.display = 'none';
                }
            }

            passwordInput.addEventListener('input', function () {
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

                validatePasswordMatch();
            });

            confirmPasswordInput.addEventListener('input', function () {
                validatePasswordMatch();
            });
        })();
    </script>

</body>
</html>
