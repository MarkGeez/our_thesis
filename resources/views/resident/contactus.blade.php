
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
        <style>
    :root {
      --contact-theme: {{ \App\Models\Setting::get('theme', '#0061f7') }};
      --contact-bg-soft: #f5f8ff;
      --contact-border: #e5e9f2;
      --contact-text: #2b3547;
      --contact-muted: #66758f;
    }

    .contact-shell {
      max-width: 1050px;
      margin: 0 auto 24px;
    }

    .contact-hero {
      background:
        linear-gradient(120deg, rgba(255, 255, 255, 0.95) 0%, rgba(245, 249, 255, 0.95) 100%),
        radial-gradient(circle at top right, rgba(0, 97, 247, 0.18), transparent 60%);
      border: 1px solid var(--contact-border);
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 18px;
      box-shadow: 0 10px 25px rgba(30, 55, 90, 0.08);
    }

    .contact-chip {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 97, 247, 0.1);
      color: var(--contact-theme);
      border: 1px solid rgba(0, 97, 247, 0.2);
      border-radius: 999px;
      padding: 6px 12px;
      font-size: 0.82rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 10px;
    }

    .contact-title {
      color: var(--contact-text);
      margin-bottom: 8px;
      font-weight: 700;
      font-size: clamp(1.4rem, 1.2rem + 1vw, 2rem);
    }

    .contact-subtitle {
      margin: 0;
      color: var(--contact-muted);
      max-width: 720px;
    }

    .contact-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 14px;
      margin-bottom: 16px;
    }

    .contact-card {
      border: 1px solid var(--contact-border);
      border-radius: 14px;
      background: #fff;
      padding: 16px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      min-height: 112px;
      box-shadow: 0 8px 18px rgba(36, 55, 85, 0.06);
    }

    .contact-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(0, 97, 247, 0.12);
      color: var(--contact-theme);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .contact-label {
      color: var(--contact-muted);
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 4px;
      font-weight: 700;
    }

    .contact-value {
      color: var(--contact-text);
      font-size: 0.95rem;
      font-weight: 600;
      line-height: 1.45;
      margin: 0;
      word-break: break-word;
    }

    .map-card {
      border: 1px solid var(--contact-border);
      border-radius: 16px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 10px 24px rgba(30, 55, 90, 0.08);
    }

    .map-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 14px 16px;
      border-bottom: 1px solid var(--contact-border);
      background: linear-gradient(180deg, #fdfefe 0%, var(--contact-bg-soft) 100%);
    }

    .map-title {
      margin: 0;
      color: var(--contact-text);
      font-weight: 700;
      font-size: 1rem;
    }

    .map-note {
      margin: 0;
      color: var(--contact-muted);
      font-size: 0.82rem;
      text-align: right;
    }

    .map-embed {
      width: 100%;
      height: 360px;
      border: 0;
      display: block;
    }

    @media (max-width: 992px) {
      .contact-grid {
        grid-template-columns: 1fr;
      }

      .map-header {
        align-items: flex-start;
        flex-direction: column;
      }

      .map-note {
        text-align: left;
      }
    }
  </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
    @include('resident.resident-sidebar', ['resident' => auth()->user()])
   

    <div class="main-wrapper">
        @include('resident.resident-header', ['resident' => auth()->user()])
            <main class="main users chart-page" id="skip-target">
                <!--Dito lalagay main content-->

                <div class="container">
          <div class="contact-shell">
            <div class="contact-hero">
              <span class="contact-chip">
                <i class="fa-solid fa-address-book"></i>
                Contact Us
              </span>
              <h1 class="contact-title">Get in Touch With {{ \App\Models\Setting::get('name', '249') }}</h1>
              <p class="contact-subtitle">
                Reach us through any of the details below. We are ready to assist with inquiries, concerns, and service-related concerns.
              </p>
            </div>

            <div class="contact-grid">
              <article class="contact-card">
                <span class="contact-icon">
                  <i class="fa-solid fa-location-dot"></i>
                </span>
                <div>
                  <p class="contact-label">Address</p>
                  <p class="contact-value">{{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila, 1008 Metro Manila') }}</p>
                </div>
              </article>

              <article class="contact-card">
                <span class="contact-icon">
                  <i class="fa-solid fa-phone"></i>
                </span>
                <div>
                  <p class="contact-label">Contact Number</p>
                  <p class="contact-value">{{ \App\Models\Setting::get('contact_number', '0999-123-4567') }}</p>
                </div>
              </article>

              <article class="contact-card">
                <span class="contact-icon">
                  <i class="fa-solid fa-envelope"></i>
                </span>
                <div>
                  <p class="contact-label">Email Address</p>
                  <p class="contact-value">{{ \App\Models\Setting::get('contact_email', 'brgy249@email.com') }}</p>
                </div>
              </article>
            </div>

            <section class="map-card">
              <div class="map-header">
                <h2 class="map-title">Barangay Office Location</h2>
                <p class="map-note">Use the map for directions and travel planning.</p>
              </div>
              <iframe class="map-embed" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.6974750090753!2d120.9780723024629!3d14.6163018517375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5fa20b91ee9%3A0x4fc85db2949a910d!2sBarangay%20249%20Tondo!5e0!3m2!1sen!2sph!4v1759393446597!5m2!1sen!2sph" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </section>
          </div>
        </div>

       

      </div>
            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>



