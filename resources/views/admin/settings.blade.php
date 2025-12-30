<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .settings-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .logo-preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: contain;
            margin: 20px 0;
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .form-section {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])
        <main class="main users chart-page" id="skip-target">
            <div class="container mt-5">
                <div class="settings-container">
                    <h1 class="mb-4">System Settings</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.updateSettings') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Logo Settings -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fa-solid fa-image"></i> Logo Settings
                            </h5>

                            <div class="mb-3">
                                <label for="currentLogo" class="form-label">Current Logo</label>
                                <div>
                                    @if ($settings && $settings->logo_path)
                                        <img src="{{ asset($settings->logo_path) }}" alt="Current Logo" class="logo-preview">
                                    @else
                                        <img src="{{ asset('template/img/brgy 249 Logo png.png') }}" alt="Default Logo"
                                            class="logo-preview">
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload New Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                    id="logo" name="logo" accept="image/*">
                                <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 10MB</small>
                                @error('logo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Barangay Name Settings -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fa-solid fa-heading"></i> Barangay Name
                            </h5>

                            <div class="mb-3">
                                <label for="barangay_name" class="form-label">Barangay Name</label>
                                <input type="text" class="form-control @error('barangay_name') is-invalid @enderror"
                                    id="barangay_name" name="barangay_name"
                                    value="{{ old('barangay_name', $settings->barangay_name ?? 'brgy249') }}" required>
                                @error('barangay_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Sidebar Theme Color -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fa-solid fa-palette"></i> Sidebar Theme Color
                            </h5>

                            <div class="mb-3">
                                <label for="theme" class="form-label">Choose sidebar color</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="color" class="form-control form-control-color @error('theme') is-invalid @enderror"
                                           id="theme" name="theme" value="{{ old('theme', $settings->theme ?? '#0061f7') }}" title="Pick a color">
                                    <input type="text" class="form-control" style="max-width: 140px;"
                                           value="{{ old('theme', $settings->theme ?? '#0061f7') }}" readonly>
                                </div>
                                <small class="text-muted">This color will be applied to all sidebars (admin, subadmin, resident, non-resident).</small>
                                @error('theme')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Details -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fa-solid fa-address-book"></i> Contact Details
                            </h5>

                            <div class="mb-3">
                                <label for="contact_address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('contact_address') is-invalid @enderror"
                                       id="contact_address" name="contact_address"
                                       value="{{ old('contact_address', $settings->contact_address ?? 'Barangay 249 Zone 23, Tondo, Manila') }}">
                                @error('contact_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                       id="contact_number" name="contact_number"
                                       value="{{ old('contact_number', $settings->contact_number ?? '0999-123-4567') }}">
                                @error('contact_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                       id="contact_email" name="contact_email"
                                       value="{{ old('contact_email', $settings->contact_email ?? 'brgy249@email.com') }}">
                                @error('contact_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>