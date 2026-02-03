<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        
        .settings-container { max-width: 900px; margin: 0 auto; padding: 20px; }
        
        /* Modern Card Styling */
        .form-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid #eef0f2;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f3f5;
        }

        .section-header i {
            font-size: 1.2rem;
            margin-right: 12px;
            color: #4e73df;
        }

        .section-header h5 {
            margin: 0;
            font-weight: 700;
            color: #2d3748;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* Logo Preview Area */
        .logo-upload-card {
            background: #f8fafc;
            border: 2px dashed #cbd5e0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .logo-upload-card:hover { border-color: #4e73df; }

        .logo-preview {
            max-width: 120px;
            max-height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.08));
            margin-bottom: 15px;
        }

        /* Theme Presets */
        .theme-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .color-preset {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            border: 3px solid #fff;
            box-shadow: 0 0 0 1px #ddd;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .color-preset:hover { transform: translateY(-3px); }
        .color-preset.active { box-shadow: 0 0 0 2px #4e73df; transform: scale(1.1); }

        .btn-save-settings {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 14px rgba(78, 115, 223, 0.3);
        }

        .btn-save-settings:hover { opacity: 0.9; transform: translateY(-1px); }
        
        .form-label { font-weight: 600; color: #4a5568; font-size: 0.9rem; }
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold text-dark">System Settings</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </nav>
                    </div>

                    @if ($errors->any() || session('success'))
                        <div class="mb-4">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Whoops!</strong> Please check the form for errors.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                        </div>
                    @endif

                    <form action="{{ route('admin.updateSettings') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fa-solid fa-circle-nodes"></i>
                                        <h5>Identity & Branding</h5>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">System Logo</label>
                                        <div class="logo-upload-card">
                                            <img src="{{ asset($settings->logo_path ?? 'template/img/brgy 249 Logo png.png') }}" 
                                                 id="preview-img" class="logo-preview">
                                            <input type="file" name="logo" id="logo-input" class="form-control" accept="image/*">
                                            <small class="text-muted d-block mt-2">Recommended: PNG or SVG with transparent background.</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="barangay_name" class="form-label">Barangay Name</label>
                                        <input type="text" class="form-control" id="barangay_name" name="barangay_name"
                                               value="{{ old('barangay_name', $settings->barangay_name ?? 'Brgy 249') }}" required>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fa-solid fa-envelope-open-text"></i>
                                        <h5>Contact Information</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" value="{{ $settings->contact_number ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="contact_email" class="form-control" value="{{ $settings->contact_email ?? '' }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <textarea name="contact_address" class="form-control" rows="2">{{ $settings->contact_address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="form-section h-100">
                                    <div class="section-header">
                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                        <h5>Interface Theme</h5>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Sidebar Theme Color</label>
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <input type="color" class="form-control form-control-color" id="theme-picker" 
                                                   name="theme" value="{{ $settings->theme ?? '#0061f7' }}">
                                            <input type="text" class="form-control form-control-sm" id="hex-output" 
                                                   value="{{ $settings->theme ?? '#0061f7' }}" readonly>
                                        </div>

                                        <label class="form-label d-block mb-2">Color Presets</label>
                                        <div class="theme-grid" id="preset-container">
                                            <div class="color-preset" style="background: #0061f7;" data-color="#0061f7" title="Default Blue"></div>
                                            <div class="color-preset" style="background: #2d3436;" data-color="#2d3436" title="Midnight"></div>
                                            <div class="color-preset" style="background: #1cc88a;" data-color="#1cc88a" title="Success Green"></div>
                                            <div class="color-preset" style="background: #6f42c1;" data-color="#6f42c1" title="Royal Purple"></div>
                                            <div class="color-preset" style="background: #e74a3b;" data-color="#e74a3b" title="Modern Red"></div>
                                            <div class="color-preset" style="background: #f6c23e;" data-color="#f6c23e" title="Golden Sun"></div>
                                            <div class="color-preset" style="background: #36b9cc;" data-color="#36b9cc" title="Ocean Teal"></div>
                                            <div class="color-preset" style="background: #fd7e14;" data-color="#fd7e14" title="Vibrant Orange"></div>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded bg-light border">
                                        <p class="small text-muted mb-0">
                                            <i class="fa-solid fa-circle-info me-1"></i>
                                            Selecting a theme color updates the navigation sidebar for all user roles instantly upon saving.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-3 mt-4">
                            <button type="button" class="btn btn-link text-muted text-decoration-none" onclick="location.reload()">Discard Changes</button>
                            <button type="submit" class="btn btn-primary btn-save-settings">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save System Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo-input');
        const previewImg = document.getElementById('preview-img');
        const themePicker = document.getElementById('theme-picker');
        const hexOutput = document.getElementById('hex-output');
        const presets = document.querySelectorAll('.color-preset');

        // Live Logo Preview
        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { previewImg.src = e.target.result; }
                reader.readAsDataURL(file);
            }
        });

        // Theme Preset Selection
        presets.forEach(preset => {
            preset.addEventListener('click', function() {
                const selectedColor = this.getAttribute('data-color');
                themePicker.value = selectedColor;
                hexOutput.value = selectedColor.toUpperCase();
                
                // Update active class
                presets.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Sync Hex Text with Picker
        themePicker.addEventListener('input', function() {
            hexOutput.value = this.value.toUpperCase();
            presets.forEach(p => p.classList.remove('active'));
        });
    });
</script>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>