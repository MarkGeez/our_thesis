
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body class="d-flex justify-content-center align-items-start vh-100" style="padding-top: 40px;">
    <div class="d-flex flex-column align-items-center">

    <div class="card shadow">
        <h3>Login</h3>
        <form action="{{ route('login.attempt') }}" method="post">
            @csrf
            @if(session('status'))
                <div class="bg-warning text-dark small mb-2 rounded p-2">{{ session('status') }}</div>
            @endif

            <div class="input-with-icon">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                <i class="fa-solid fa-envelope input-icon"></i>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                <i class="fa-solid fa-lock input-icon"></i>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class=" d-flex align-items-center justify-content-between w-100 text-white">
            <div class="d-flex align-items-center gap-2">
                <input type="checkbox" name="RememberMe" id="RememberMe">
                <label for="RememberMe" class="m-0">Remember Me</label>
            </div>

            <a href="#" class="text-white fw-bold">Forgot Password?</a>
        </div>


            <button type="submit" class="btn btn-primary fw-bold">Login</button>
        </form>

        <p id="textforlogin">Don't have an account? <a href="{{ route('register') }}" class="text-light fw-bold">Register</a></p>
    </div>

    <div class="image-container d-flex justify-content-center mt-4 gap-3">
    <img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Image 1" class="uniform-image" id="brgy249logo">
    <img src="https://poropointfreeport.gov.ph/wp-content/uploads/2024/12/Hi-Res-BAGONG-PILIPINAS-LOGO-1474x1536-1.png" alt="Image 2" class="uniform-image">
</div>

    </div>

</body>
</html>
