<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Barangay 249</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo:wght@300;400;600;700&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2d7dfd;
            --accent-gold:  #ffd700;
            --glass-white:  rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        /* ── BASE ─────────────────────────────────────────── */
        body {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
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
            background: radial-gradient(circle, rgba(45,125,253,0.1) 0%, transparent 70%);
            transform: translate(-50%, -50%);
        }

        /* ── GLASS CARD ───────────────────────────────────── */
        .auth-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            background: var(--glass-white);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7);
            animation: fadeInScale 0.8s cubic-bezier(0.23,1,0.32,1) forwards;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ── BRAND HEADER ─────────────────────────────────── */
        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.2rem;
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
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* ── SECTION LABEL ────────────────────────────────── */
        .section-label {
            font-family: 'Oswald', sans-serif;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        /* ── FORM CONTROLS ────────────────────────────────── */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: rgba(255,255,255,0.9);
        }

        .input-group {
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }

        .input-group.is-invalid-group {
            border-color: rgba(239,68,68,0.7);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
        }

        .input-group:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(45,125,253,0.25);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.5);
            padding-left: 15px;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px 15px;
            font-size: 0.95rem;
            box-shadow: none !important;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.3); }

        /* ── PASSWORD TOGGLE ──────────────────────────────── */
        .btn-toggle-pw {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.5);
            padding-right: 15px;
            padding-left: 10px;
            transition: color 0.3s;
            cursor: pointer;
            line-height: 1;
        }

        .btn-toggle-pw:hover { color: white; }

        /* ── ALERTS ───────────────────────────────────────── */
        .auth-alert {
            border-radius: 10px;
            padding: 0.7rem 0.9rem;
            margin-bottom: 1.1rem;
            font-size: 0.82rem;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-weight: 500;
        }

        .auth-alert i { margin-top: 1px; flex-shrink: 0; }

        .auth-alert-success {
            background: rgba(16,185,129,0.18);
            color: #ecfdf5;
            border: 1px solid rgba(16,185,129,0.5);
        }

        .auth-alert-error {
            background: rgba(239,68,68,0.18);
            color: #fef2f2;
            border: 1px solid rgba(239,68,68,0.45);
        }

        .auth-alert-info {
            background: rgba(14,165,233,0.18);
            color: #f0f9ff;
            border: 1px solid rgba(14,165,233,0.45);
        }

        /* Inline field error */
        .field-error {
            border-radius: 7px;
            padding: 0.35rem 0.6rem;
            margin-top: 0.4rem;
            font-size: 0.72rem;
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
            gap: 0.4rem;
            font-weight: 500;
            background: rgba(239,68,68,0.18);
            color: #fef2f2;
            border: 1px solid rgba(239,68,68,0.45);
        }

        .field-error i { margin-top: 1px; flex-shrink: 0; }

        /* ── FORGOT PASSWORD LINK ─────────────────────────── */
        .forgot-link {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 600;
        }

        .forgot-link:hover { color: var(--accent-gold); }

        /* ── SUBMIT BUTTON ────────────────────────────────── */
        .btn-auth {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1a2a88 100%);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 13px;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 1.05rem;
            border-radius: 12px;
            width: 100%;
            margin-top: 18px;
            color: #fff;
            transition: all 0.4s;
            cursor: pointer;
        }

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(45,125,253,0.4);
            border-color: var(--accent-gold);
            color: #fff;
        }

        /* ── FOOTER LINK ──────────────────────────────────── */
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
        }

        .auth-footer a {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ───────────────────────────────────── */
        @media (max-width: 520px) {
            .auth-card { padding: 2rem 1.4rem; border-radius: 24px; }
            .brand-header h1 { font-size: 2.6rem; }
        }
    </style>
</head>
<body>

<canvas id="particle-canvas"></canvas>
<div class="cursor-glow" id="cursorGlow"></div>

<div class="auth-card">

    <!-- ── BRAND HEADER ──────────────────────────────────── -->
    <header class="brand-header">
        <div class="d-flex justify-content-center gap-3 mb-3">
            <img src="{{ asset('images/Brgy-logo-1.png') }}" height="65"
                 style="border-radius:50%; background:rgba(255,255,255,0.15); padding:3px; object-fit:contain;">
            <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" height="65" style="object-fit:contain;">
        </div>
        <h3>e-Barangay Portal</h3>
        <h1>LOGIN</h1>
    </header>

    <!-- ── SESSION ALERTS ────────────────────────────────── -->
    @if(session('auth_success'))
        <div class="auth-alert auth-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <div>{{ session('auth_success') }}</div>
        </div>
    @endif

    @if(session('auth_error'))
        <div class="auth-alert auth-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>{{ session('auth_error') }}</div>
        </div>
    @endif

    @if(session('status') && !session('auth_success') && !session('auth_error'))
        <div class="auth-alert auth-alert-info">
            <i class="fa-solid fa-circle-info"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <form action="{{ route('login.attempt') }}" method="POST" novalidate>
        @csrf

        <div class="section-label">Account Access</div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group @error('email') is-invalid-group @enderror">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" id="email" name="email" class="form-control"
                       placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
            @error('email')
            <div class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
            </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <div class="input-group @error('password') is-invalid-group @enderror">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="••••••••" required>
                <button type="button" class="btn-toggle-pw" data-toggle-target="password"
                        aria-label="Show password" aria-pressed="false">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password')
            <div class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i><div>{{ $message }}</div>
            </div>
            @enderror
        </div>

        <!-- Forgot Password -->
        <div class="d-flex justify-content-end mb-1">
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
        </div>

        <button type="submit" class="btn-auth">
            SIGN IN <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
        </button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Register Here</a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── PASSWORD TOGGLE ───────────────────────────────────────────
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

    // ── PARTICLES ─────────────────────────────────────────────────
    (function () {
        const canvas = document.getElementById('particle-canvas');
        const ctx    = canvas.getContext('2d');
        let W, H, particles = [];
        const COLORS = ['rgba(45,125,253,', 'rgba(255,215,0,', 'rgba(255,255,255,'];
        function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
        window.addEventListener('resize', resize); resize();
        function rand(a, b) { return Math.random() * (b - a) + a; }
        function P() { this.reset(); }
        P.prototype.reset = function () {
            this.x = rand(0,W); this.y = rand(0,H); this.r = rand(0.5,2.5);
            this.vx = rand(-0.3,0.3); this.vy = rand(-0.5,-0.1);
            this.color = COLORS[Math.floor(Math.random()*COLORS.length)];
            this.alpha = rand(0.1,0.5); this.life = 0; this.maxLife = rand(200,600);
        };
        P.prototype.update = function () {
            this.x += this.vx; this.y += this.vy; this.life++;
            if (this.y < -5 || this.life > this.maxLife) this.reset();
        };
        P.prototype.draw = function () {
            const prog = this.life / this.maxLife;
            const a = this.alpha * (1 - Math.pow(prog - 0.5, 2) * 4);
            ctx.beginPath(); ctx.arc(this.x, this.y, this.r, 0, Math.PI*2);
            ctx.fillStyle = this.color + Math.max(0,a) + ')'; ctx.fill();
        };
        for (let i = 0; i < 80; i++) particles.push(new P());
        (function loop() {
            ctx.clearRect(0,0,W,H);
            particles.forEach(function(p){ p.update(); p.draw(); });
            requestAnimationFrame(loop);
        })();
    })();
</script>
</body>
</html>