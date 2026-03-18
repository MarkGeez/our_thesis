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

        /* =============================================
           PAGE LOADER
        ============================================= */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #page-loader.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .loader-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 5rem;
            color: white;
            letter-spacing: 8px;
            animation: loaderPulse 1.2s ease-in-out infinite;
        }
        .loader-bar-track {
            width: 200px;
            height: 2px;
            background: rgba(255,255,255,0.15);
            border-radius: 99px;
            margin-top: 20px;
            overflow: hidden;
        }
        .loader-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            border-radius: 99px;
            animation: loaderFill 1.4s ease forwards;
        }
        @keyframes loaderFill {
            0%   { width: 0%; }
            60%  { width: 80%; }
            100% { width: 100%; }
        }
        @keyframes loaderPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.97); }
        }

        /* =============================================
           FLOATING PARTICLE CANVAS
        ============================================= */
        #particle-canvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        /* =============================================
           BASE BODY
        ============================================= */
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

        /* =============================================
           NAV — SLIDE DOWN ON LOAD
        ============================================= */
        .glass-nav {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;

            /* Animation */
            transform: translateY(-100%);
            opacity: 0;
            animation: navSlideDown 0.7s cubic-bezier(0.23, 1, 0.32, 1) 1.4s forwards;
        }
        @keyframes navSlideDown {
            to { transform: translateY(0); opacity: 1; }
        }

        .nav-link {
            color: white !important;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            opacity: 0.8;
            transition: opacity 0.3s, color 0.3s;
            position: relative;
        }
        /* Nav underline sweep */
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--accent-gold);
            border-radius: 2px;
            transition: width 0.3s, left 0.3s;
        }
        .nav-link:hover::after { width: 100%; left: 0; }
        .nav-link:hover { opacity: 1 !important; }

        /* =============================================
           HERO SECTION — STAGGERED ENTRANCE
        ============================================= */
        .hero-section {
            padding: 50px 15px 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .glass-card {
            max-width: 850px;
            padding: 3rem 2rem;
            border-radius: 40px;
            background: var(--glass-white);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            text-align: center;

            /* Animation */
            opacity: 0;
            transform: translateY(40px) scale(0.97);
            animation: heroCardIn 0.9s cubic-bezier(0.23, 1, 0.32, 1) 1.8s forwards;
        }
        @keyframes heroCardIn {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Individual hero children stagger */
        .hero-eyebrow  { opacity: 0; animation: fadeUp 0.7s ease 2.1s forwards; }
        .hero-title    { opacity: 0; animation: fadeUp 0.7s ease 2.3s forwards; }
        .hero-subtitle { opacity: 0; animation: fadeUp 0.7s ease 2.5s forwards; }
        .hero-cta      { opacity: 0; animation: fadeUp 0.7s ease 2.7s forwards; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
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
            /* Subtle floating bob */
            animation: heroCardIn 0.9s cubic-bezier(0.23, 1, 0.32, 1) 1.8s forwards,
                       floatBob 6s ease-in-out 3s infinite;
        }
        @keyframes floatBob {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
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
            /* Glitch on hover */
            transition: filter 0.2s;
        }
        h1:hover {
            animation: glitch 0.4s linear;
        }
        @keyframes glitch {
            0%   { text-shadow: 2px 0 #2d7dfd, -2px 0 #ffd700; }
            20%  { text-shadow: -3px 0 #ffd700, 3px 0 #2d7dfd; transform: skewX(-2deg); }
            40%  { text-shadow: 3px 2px #ff0080, -2px -1px #00ffff; transform: skewX(1deg); }
            60%  { text-shadow: -2px 0 #2d7dfd, 2px 0 #ffd700; transform: skewX(0); }
            80%  { text-shadow: 2px -1px #ffd700, -1px 1px #2d7dfd; }
            100% { text-shadow: none; }
        }

        h3 { font-family: "Oswald", sans-serif; font-size: 3.5rem; margin: 0; font-weight: 300; text-transform: uppercase; color: var(--accent-gold); }
        
        /* =============================================
           SECTION REVEAL — SCROLL TRIGGERED
        ============================================= */
        .section-container {
            width: 100%;
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        /* Elements that animate in on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                        transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                        transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                        transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                        transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        /* Stagger delay helpers */
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }

        .section-title {
            font-family: 'Oswald', sans-serif;
            font-size: 3rem;
            text-align: center;
            margin-bottom: 50px;
            text-transform: uppercase;
            position: relative;
        }
        /* Animated underline on section titles */
        .section-title::after {
            content: '';
            display: block;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            border-radius: 2px;
            margin: 12px auto 0;
            transition: width 1.2s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .section-title.visible::after { width: 120px; }

        /* =============================================
           BUTTONS
        ============================================= */
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1a2a88 100%);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 15px 40px;
            font-weight: 700;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 1;
        }
        .btn-custom::before {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: all 0.6s;
            z-index: -1;
        }
        .btn-custom:hover {
            transform: translateY(-5px) scale(1.05); 
            box-shadow: 0 15px 30px rgba(45, 125, 253, 0.5), 0 0 40px rgba(45, 125, 253, 0.3); 
            color: #fff;
            border-color: var(--accent-gold);
        }
        .btn-custom:hover::before { left: 100%; }
        .btn-custom:hover i { animation: rocketLaunch 0.5s infinite alternate; }
        @keyframes rocketLaunch {
            from { transform: translate(0, 0) rotate(0deg); }
            to   { transform: translate(3px, -5px) rotate(-10deg); }
        }
        @media (max-width: 768px) {
            .btn-custom { padding: 12px 30px; font-size: 0.9rem; }
        }

        /* =============================================
           OFFICIAL CARDS
        ============================================= */
        .official-card {
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1),
                        background 0.3s,
                        box-shadow 0.4s;
        }
        .official-card:hover {
            transform: translateY(-12px) scale(1.02);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 30px rgba(45,125,253,0.15);
        }

        /* =============================================
           ANNOUNCEMENT CARD IMAGE ZOOM
        ============================================= */
        .announcement-img-wrap {
            overflow: hidden;
        }
        .announcement-img-wrap img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .official-card:hover .announcement-img-wrap img {
            transform: scale(1.07);
        }

        /* =============================================
           CONTACT / MAP
        ============================================= */
        .map-frame {
            filter: grayscale(100%) invert(90%) contrast(90%);
            border-radius: 20px;
            transition: filter 0.5s;
        }
        .map-frame:hover { filter: grayscale(0%) invert(0%) contrast(100%); }

        /* =============================================
           FOOTER
        ============================================= */
        footer { position: relative; z-index: 1; }

        /* =============================================
           CURSOR GLOW (desktop only)
        ============================================= */
        .cursor-glow {
            position: fixed;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, rgba(45, 125, 253, 0.08) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            transition: left 0.12s ease, top 0.12s ease;
        }

        /* =============================================
           SECTION DIVIDER
        ============================================= */
        .section-divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            border-radius: 99px;
            margin: 0 auto 50px;
        }

        .announcement-details {
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
</head>
<body>

    <!-- ============================================================
         PAGE LOADER
    ============================================================ -->
    <div id="page-loader">
        <div class="loader-logo">BRGY 249</div>
        <div class="loader-bar-track">
            <div class="loader-bar-fill"></div>
        </div>
    </div>

    <!-- Cursor glow (desktop) -->
    <div class="cursor-glow" id="cursorGlow"></div>

    <!-- Particle canvas -->
    <canvas id="particle-canvas"></canvas>

    <!-- ============================================================
         NAVBAR
    ============================================================ -->
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
                    
                    <li class="nav-item"><a class="nav-link px-3" href="#announcements">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#officials">Officials</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#contact">Contact Us</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 fw-bold">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ============================================================
         HERO
    ============================================================ -->
    <section class="hero-section">
        <div class="glass-card shadow" id="mainbody">
            <h5 class="hero-eyebrow text-uppercase fw-bold text-primary mb-2"
                style="letter-spacing: 5px; font-size: 1.1rem; color: white !important;">Welcome to</h5>

            <div class="hero-title d-md-flex justify-content-center align-items-baseline gap-3 mb-3">
                <h3>barangay</h3>
                <h1>249</h1>
            </div>

            <h4 class="hero-subtitle fw-light mb-5 px-md-5"
                style="opacity: 0.8; font-size: 1.75rem;">
                Streamlined public services, real-time announcements, and community support at your devices.
            </h4>

            <a href="{{ route('login') }}" class="btn btn-lg btn-custom rounded-pill text-light shadow hero-cta">
                GET STARTED <i class="fa-solid fa-rocket ms-2"></i>
            </a>
        </div>
    </section>

     <!-- ============================================================
         ANNOUNCEMENTS
    ============================================================ -->
    <div class="section-container" id="announcements">
        <h2 class="section-title reveal">Latest Updates</h2>
        <div class="section-divider reveal delay-1"></div>

        <div class="row g-4 justify-content-center">
            @forelse ($announcements as $index => $announcement)
            <div class="col-12 col-md-6 reveal delay-{{ ($index % 4) + 1 }}">
                <div class="official-card d-flex flex-column h-100 overflow-hidden">
                    @if($announcement->image)
                        <div class="announcement-img-wrap">
                            <img src="{{ asset('storage/' . $announcement->image) }}" alt="News">
                        </div>
                    @endif
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary rounded-pill px-3 text-uppercase">Announcement</span>
                            <small class="opacity-50">{{ $announcement->created_at->format('M d, Y') }}</small>
                        </div>
                        <h3 class="h4 mb-3" style="font-family: 'Oswald'; color: white;">{{ strtoupper($announcement->title) }}</h3>
                        <div class="announcement-details opacity-75 small">{{ $announcement->details }}</div>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-center opacity-50">No recent updates.</p>
            @endforelse
        </div>
    </div>


    <!-- ============================================================
         OFFICIALS
    ============================================================ -->
    <div class="section-container" id="officials">
        <h2 class="section-title reveal">Barangay Leadership</h2>
        <div class="section-divider reveal delay-1"></div>

        @include('components.officials', [
            'positions' => $positions,
            'officialsByPosition' => $officialsByPosition,
            'showControls' => false,
        ])
    </div>

   
    <!-- ============================================================
         CONTACT
    ============================================================ -->
    <div class="section-container mb-5" id="contact">
        <h2 class="section-title reveal">Contact Us</h2>
        <div class="section-divider reveal delay-1"></div>

        <div class="glass-card mx-auto reveal-scale" style="max-width: 1100px; padding: 3rem;">
            <div class="row g-5 align-items-center text-start">
                <div class="col-lg-5 reveal-left">
                    <h4 class="text-primary fw-bold mb-4 text-uppercase" style="font-family: 'Oswald';">Location & Contact</h4>
                    <div class="d-flex gap-3 mb-4">
                        <i class="fa-solid fa-map-location-dot text-info fs-4"></i>
                        <p class="mb-0">{{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila') }}</p>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <i class="fa-solid fa-phone-volume text-success fs-4"></i>
                                <p class="mb-0">{{ \App\Models\Setting::get('contact_number', '09170000000') }}</p>
                    </div>
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-envelope-open-text text-warning fs-4"></i>
                        <p class="mb-0">{{ \App\Models\Setting::get('contact_email', 'brgy249@email.com') }}</p>
                    </div>
                </div>
                <div class="col-lg-7 reveal-right">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.6974750090753!2d120.9780723024629!3d14.6163018517375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5fa20b91ee9%3A0x4fc85db2949a910d!2sBarangay%20249%20Tondo!5e0!3m2!1sen!2sph!4v1759393446597!5m2!1sen!2sph"
                        width="100%"
                        height="300"
                        class="map-frame"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 text-center border-top border-white border-opacity-10 mt-5 reveal">
        <p class="small opacity-50 mb-0">© 2026 BARANGAY 249, TONDO, MANILA. ALL RIGHTS RESERVED.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ===============================================================
    // 1. PAGE LOADER — dismiss after page ready
    // ===============================================================
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('page-loader').classList.add('loaded');
        }, 1500);
    });

    // ===============================================================
    // 2. FLOATING PARTICLES
    // ===============================================================
    (function() {
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];

        const COLORS = ['rgba(45,125,253,', 'rgba(255,215,0,', 'rgba(255,255,255,'];

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function rand(min, max) { return Math.random() * (max - min) + min; }

        function Particle() {
            this.reset();
        }
        Particle.prototype.reset = function() {
            this.x = rand(0, W);
            this.y = rand(0, H);
            this.r = rand(0.5, 2.5);
            this.vx = rand(-0.3, 0.3);
            this.vy = rand(-0.5, -0.1);
            this.color = COLORS[Math.floor(Math.random() * COLORS.length)];
            this.alpha = rand(0.1, 0.5);
            this.life = 0;
            this.maxLife = rand(200, 600);
        };
        Particle.prototype.update = function() {
            this.x += this.vx;
            this.y += this.vy;
            this.life++;
            if (this.y < -5 || this.life > this.maxLife) this.reset();
        };
        Particle.prototype.draw = function() {
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
            particles.forEach(p => { p.update(); p.draw(); });
            requestAnimationFrame(loop);
        }
        loop();
    })();

    // ===============================================================
    // 3. CURSOR GLOW (desktop only)
    // ===============================================================
    const glow = document.getElementById('cursorGlow');
    if (window.matchMedia('(pointer: fine)').matches) {
        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top  = e.clientY + 'px';
        });
    } else {
        glow.style.display = 'none';
    }

    // ===============================================================
    // 4. INTERSECTION OBSERVER — SCROLL REVEALS
    // ===============================================================
    const revealSelectors = '.reveal, .reveal-left, .reveal-right, .reveal-scale, .section-title';
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Don't unobserve so title underline persists
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll(revealSelectors).forEach(el => {
        observer.observe(el);
    });

    // ===============================================================
    // 5. NAV — background opacity intensifies on scroll
    // ===============================================================
    const nav = document.querySelector('.glass-nav');
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        const alpha = Math.min(0.85, 0.5 + y / 400);
        nav.style.background = `rgba(0,0,0,${alpha})`;
    });

    // ===============================================================
    // 6. ACTIVE NAV LINK on scroll
    // ===============================================================
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(s => {
            if (window.scrollY >= s.offsetTop - 120) current = s.id;
        });
        navLinks.forEach(link => {
            link.style.opacity = link.getAttribute('href') === '#' + current ? '1' : '0.8';
            link.style.color = link.getAttribute('href') === '#' + current
                ? 'var(--accent-gold)' : '';
        });
    });
    </script>
</body>
</html>
