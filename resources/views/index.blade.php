<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 249 Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo:wght@300;400;700&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2d7dfd;
            --accent-gold: #ffd700;
            --glass-white: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        html { scroll-behavior: smooth; }

        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("images/brgy249_background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Exo', sans-serif;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0.5rem 0;
        }

        .nav-link {
            color: white !important;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            opacity: 0.8;
            transition: 0.3s;
        }

        /* --- REDUCED GAP HERE --- */
        .hero-section {
            padding: 50px 15px 60px; /* Reduced from 120px to 50px */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .glass-card {
            max-width: 850px;
            padding: 3rem 2rem; /* Slightly tighter internal padding */
            border-radius: 40px;
            background: var(--glass-white);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            text-align: center;
        }
        #mainbody {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
        }

        h1 { 
            font-family: "Bebas Neue", sans-serif; 
            font-size: 7rem; 
            margin: 0; 
            line-height: 0.9; 
            letter-spacing: 4px;
            background: linear-gradient(to bottom, #fff, #bdc3c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.5));
        }

        h3 { font-family: "Oswald", sans-serif; font-size: 3.5rem; margin: 0; font-weight: 300; text-transform: uppercase; color: var(--accent-gold); }
        
        .section-container {
            width: 100%;
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .section-title {
            font-family: 'Oswald', sans-serif;
            font-size: 3rem;
            text-align: center;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1a2a88 100%);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 15px 40px;
            font-weight: 700;
            transition: 0.3s;
        }

        .official-card {
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: 0.3s;
        }
        .btn-custom {
    background: linear-gradient(135deg, var(--primary-blue) 0%, #1a2a88 100%);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 15px 40px;
    font-weight: 700;
    position: relative;
    overflow: hidden; /* Important for the sweep effect */
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    z-index: 1;
}

/* The Shine/Sweep Effect */
.btn-custom::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
    );
    transition: all 0.6s;
    z-index: -1;
}

.btn-custom:hover {
    transform: translateY(-5px) scale(1.05); 
    box-shadow: 0 15px 30px rgba(45, 125, 253, 0.4); 
    color: #fff;
    border-color: var(--accent-gold);
}

.btn-custom:hover::before {
    left: 100%; 
}


.btn-custom:hover i {
    animation: rocketLaunch 0.5s infinite alternate;
}

@keyframes rocketLaunch {
    from { transform: translate(0, 0); }
    to { transform: translate(3px, -3px); }
}
@media (max-width: 768px) {
    .btn-custom {
        padding: 12px 30px;
        font-size: 0.9rem;
    }
}

        .official-card:hover { transform: translateY(-10px); background: rgba(255, 255, 255, 0.1); }
        .map-frame { filter: grayscale(100%) invert(90%) contrast(90%); border-radius: 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg glass-nav sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Logo" height="60" style="border-radius: 50%; background: white; padding: 2px;">
                <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" alt="Bagong Pilipinas" height="60">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="fa-solid fa-bars text-white"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link px-3" href="#officials">Officials</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#announcements">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#contact">Contact Us</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 fw-bold">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section" >
        <div class="glass-card shadow" id="mainbody">
            <h5 class="text-uppercase fw-bold tracking-widest text-primary mb-2" style="letter-spacing: 5px; font-size: 1.5 rem; color: white;">Welcome to</h5>
            <div class="d-md-flex justify-content-center align-items-baseline gap-3 mb-3">
                <h3>barangay</h3>
                <h1>249</h1>
            </div>
            <h4 class="fw-light mb-5 px-md-5" style="opacity: 0.8; font-size: 1.75rem;">Streamlined public services, real-time announcements, and community support at your devices.</h4>
            <a href="{{ route('login') }}" class="btn btn-lg btn-custom rounded-pill text-light shadow">
                GET STARTED <i class="fa-solid fa-rocket ms-2"></i>
            </a>
        </div>
    </section>

    <div class="section-container" id="officials">
        <h2 class="section-title">Barangay Leadership</h2>
     
        @include('components.officials', [
            'positions' => $positions,
            'officialsByPosition' => $officialsByPosition,
            'showControls' => false,
        ])
        </div>
    </div>

    <div class="section-container" id="announcements">
        <h2 class="section-title">Latest Updates</h2>
        <div class="row g-4 justify-content-center">
            @forelse ($announcements as $announcement)
            <div class="col-12 col-md-6">
                <div class="official-card d-flex flex-column h-100 overflow-hidden">
                    @if($announcement->image)
                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="News" style="width: 100%; height: 250px; object-fit: cover;">
                    @endif
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary rounded-pill px-3 text-uppercase">Announcement</span>
                            <small class="opacity-50">{{ $announcement->created_at->format('M d, Y') }}</small>
                        </div>
                        <h3 class="h4 mb-3" style="font-family: 'Oswald'; color: white;">{{ strtoupper($announcement->title) }}</h3>
                        <p class="opacity-75 small">{{ Str::limit($announcement->details, 150) }}</p>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-center opacity-50">No recent updates.</p>
            @endforelse
        </div>
    </div>

    <div class="section-container mb-5" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="glass-card mx-auto" style="max-width: 1100px; padding: 3rem;">
            <div class="row g-5 align-items-center text-start">
                <div class="col-lg-5">
                    <h4 class="text-primary fw-bold mb-4 text-uppercase" style="font-family: 'Oswald';">Location & Contact</h4>
                    <div class="d-flex gap-3 mb-4">
                        <i class="fa-solid fa-map-location-dot text-info fs-4"></i>
                        <p class="mb-0">{{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila') }}</p>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <i class="fa-solid fa-phone-volume text-success fs-4"></i>
                        <p class="mb-0">{{ \App\Models\Setting::get('contact_number', '0999-123-4567') }}</p>
                    </div>
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-envelope-open-text text-warning fs-4"></i>
                        <p class="mb-0">{{ \App\Models\Setting::get('contact_email', 'brgy249@email.com') }}</p>
                    </div>
                </div>
                <div class="col-lg-7">



                    <iframe



                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.6974750090753!2d120.9780723024629!3d14.6163018517375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5fa20b91ee9%3A0x4fc85db2949a910d!2sBarangay%20249%20Tondo!5e0!3m2!1sen!2sph!4v1759393446597!5m2!1sen!2sph"



                        width="100%"



                        height="300"



                        style="border:0;"



                        allowfullscreen=""



                        loading="lazy"



                        referrerpolicy="no-referrer-when-downgrade">



                    </iframe>



                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 text-center border-top border-white border-opacity-10 mt-5">
        <p class="small opacity-50 mb-0">© 2026 BARANGAY 249, TONDO, MANILA. ALL RIGHTS RESERVED.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>