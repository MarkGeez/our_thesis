<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Boldonse&family=Chicle&family=Exo:ital,wght@0,100..900;1,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Metal+Mania&family=Mochiy+Pop+P+One&family=Oi&family=Oswald:wght@200..700&family=Quicksand:wght@600&family=Reggae+One&family=Teko:wght@300..700&family=Yesteryear&display=swap" rel="stylesheet">
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

        .bebas-neue-regular {
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 6rem;
             color: white;
            text-align: center;
        }

        
        .exo-regular {
        font-family: "Exo", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        }

        .oswald-regular {
            font-family: "Oswald", sans-serif;
            font-optical-sizing: auto;
            font-weight: 200;
            font-style: normal;
            }

        h5, h4 {
            color: white;
            font-family: "Exo", sans-serif;
            text-align: center
        }

        .title-inline {
            display: flex;
            justify-content: center;
            align-items: baseline;
            
        }

        h3 {
            color: white;
            text-align: center;
            font-family: "Oswald", sans-serif;
            font-size: 4rem;
            margin: 0;  
        }

        h1 {
            color: white;
            text-align: center;
            font-family: "Bebas Neue", sans-serif;
            font-size: 6rem;
            margin: 0; 
        }


        .card {
            width: 100vw;
            max-width: 750px;
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

@media (max-width: 768px) {
            h3 {
                font-size: 2.5rem;
            }

            h1 {
                font-size: 3.5rem;
            }

            .title-inline {
                flex-wrap: wrap;  /* allows wrapping if needed */
                gap: 0.25rem;
            }
        }

        @media (max-width: 480px) {
            h3 {
                font-size: 1.75rem;
            }

            h1 {
                font-size: 2.5rem;
            }

            .title-inline {
                flex-wrap: wrap;
                gap: 0.15rem;
            }
        }

        
    </style>
</head>
<body class="d-flex justify-content-center align-items-start vh-100" style="padding-top: 40px;">
    <div class="d-flex flex-column align-items-center">

    <div class="card shadow">
        <h5>Welcome to</h5>
        <div class="title-inline">
            <h3>brgy</h3>
            <h1>249 Online</h1>
        </div>
        <h4>Your easy access to forms, services, and barangay updates for Barangay 249 Tondo, Manila residents.</h4>
   
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('login') }}" class="btn  btn-lg mx-2 rounded-pill text-light" style="background: #2237c3;
background: linear-gradient(0deg, rgba(34, 55, 195, 1) 0%, rgba(45, 125, 253, 1) 100%);">Get Started <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
<div class="image-container d-flex justify-content-center mt-4 gap-3">
    <img src={{ asset('images/Brgy-logo-1.png') }} alt="Image 1" class="uniform-image" id="brgy249logo">
    <img src="https://poropointfreeport.gov.ph/wp-content/uploads/2024/12/Hi-Res-BAGONG-PILIPINAS-LOGO-1474x1536-1.png" alt="Image 2" class="uniform-image">
</div>

    </div>
</body>
</html>
