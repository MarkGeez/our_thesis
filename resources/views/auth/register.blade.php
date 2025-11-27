<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Register</title>

        <style>
        body {
            background-image: url("https://scontent-mnl3-3.xx.fbcdn.net/v/t1.15752-9/551808660_24645116478444319_6807754490734972390_n.jpg?stp=dst-jpg_s2048x2048_tt6&_nc_cat=109&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeGwpXVRSoHHWA1K9xSHxI3n9a2MLZSER6b1rYwtlIRHpsr-xrkC-PhTkop0ZXG1TAch0TGwM6kb75xgyzjpr1zR&_nc_ohc=GwjrXKPGXo8Q7kNvwGDgRR1&_nc_oc=AdksV24RzmtdNzvMEzKlgwaev6ZLHO1nCpscUNMN4s4tc7MP2Ja_Vc48vHsAwl7rp1g&_nc_zt=23&_nc_ht=scontent-mnl3-3.xx&oh=03_Q7cD3wEnGn7I8EC23yUMP38iV-NFHQW1a4UmjJqlna2P2WMchw&oe=694A81E1");
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

        .form-label {
            font-size: 0.9rem; 
            margin-bottom: 0.25rem !important;
        }

        .text-danger.small {
            font-size: 0.75rem;  
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


    /* smaller screens */
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
    </style>
</head>

<body class="d-flex justify-content-center align-items-start vh-100" style="padding-top: 40px;">
    <div class="d-flex flex-column align-items-center">
        
    <div class="card shadow">
        <h3 class="text-center mb-3 text-light">Register</h3>

        <form action="{{ route('register.attempt') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-with-icon mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control"
                placeholder="Enter your first name" value="{{ old('firstName') }}" required>
                <i class="fa-solid fa-user input-icon"></i>
                @error('firstName')
                <div class="text-danger small mt-1">{{ $message}}</div>
                @enderror
            </div>


            
            <div class="input-with-icon mb-3">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" name="middleName" id="middleName" class="form-control"
                placeholder="Enter your middle name" value="{{ old('middleName') }}" required> 
                <i class="fa-solid fa-user input-icon"></i>
                @error('middleName')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control"
                placeholder="Enter your last name" value="{{ old('lastName') }}" required>
                <i class="fa-solid fa-user input-icon"></i>
                @error('lastName')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" class="form-control"
                placeholder="Enter your email" value="{{ old('email') }}" required>
                <i class="fa-solid fa-envelope input-icon"></i>
                @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter your password" required>
                <i class="fa-solid fa-lock input-icon"></i>
                @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-with-icon mb-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <input type="text" name="contactNumber" id="contactNumber" class="form-control"
                placeholder="Enter your contact number" value="{{ old('contactNumber') }}" required>
                <i class="fa-solid fa-phone input-icon"></i>
                @error('contactNumber')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" name="birthday" id="birthday" class="form-control"
                value="{{ old('birthday') }}" required>
                @error('birthday')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Proof of Identity</label>
                <input type="file" accept=".jpg, .jpeg, .png" name="proofOfIdentity"
                id="proofOfIdentity" class="form-control" required>
                @error('proofOfIdentity')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="divider"></div>

                        <div class="mb-3">
                <label class="form-label">Are you a resident of Barangay 249?</label>
                <div>
                    <label for="yes" class="form-label me-3">
                        <input type="radio" name="role" id="yes" value="yes"
                        @checked(old('role', 'yes') == 'yes')> Yes
                    </label>
                    <label for="no" class="form-label">
                        <input type="radio" name="role" id="no" value="no"
                        @checked(old('role') == 'no')> No
                    </label>
                </div>
                @error('role')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Submit</button>

        </form>


                <p class="text-light mt-3" id="textforlogin" style="text-align: center">Already have an account? <a href="{{ route('login') }}" class="text-light fw-bold">Login</a></p>
       
</div>


<div class="image-container d-flex justify-content-center mt-4 gap-3">
    <img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Image 1" class="uniform-image" id="brgy249logo">
    <img src="https://poropointfreeport.gov.ph/wp-content/uploads/2024/12/Hi-Res-BAGONG-PILIPINAS-LOGO-1474x1536-1.png" alt="Image 2" class="uniform-image">
</div>

</body>
</html>
