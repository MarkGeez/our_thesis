<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .announcement-card {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
            margin: 10px 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .announcement-card img {
            display: block;
            margin: 0 auto 15px;
            width: 100%;
            max-width: 400px;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }

        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            justify-items: stretch;
            align-items: start;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .announcement-meta {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .announcement-text {
            background-color: #f0efef;
            border-radius: 8px;
            padding: 15px;
            box-shadow:
                inset 0 3px 6px rgba(255, 255, 255, 0.6),
                inset 0 -3px 6px rgba(0, 0, 0, 0.25),
                inset 0 8px 20px rgba(0, 0, 0, 0.2),
                inset 0 -8px 20px rgba(0, 0, 0, 0.15);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 0 12px 6px rgba(255, 255, 255, 0.6);
            color: black;
            border-radius: 15px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .welcome-card h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .welcome-card p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .header-section {
            padding: 20px 30px;
            background: none;
            margin-bottom: 20px;
        }

        .header-section h2 {
            color: #007BFF;
            margin: 0;
            font-size: 1.8rem;
        }

        @media (max-width: 1024px) {
            .announcements-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                padding: 15px;
            }
            
            .header-section {
                padding: 15px 20px;
            }
            
            .header-section h2 {
                font-size: 1.5rem;
            }
            
            .welcome-card {
                margin: 15px;
                padding: 25px;
            }
        }

        @media (max-width: 768px) {
            .announcements-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 15px;
            }
            
            .announcement-card {
                margin: 5px 10px;
                padding: 18px;
            }
            
            .announcement-card img {
                height: 220px;
            }
            
            .header-section {
                padding: 15px 20px;
            }
            
            .header-section h2 {
                font-size: 1.4rem;
                margin-left: 0 !important;
            }
            
            .welcome-card {
                margin: 15px 10px;
                padding: 20px;
            }
            
            .welcome-card h3 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 0 5px;
            }
            
            .header-section {
                padding: 12px 15px;
                margin: 0 10px 20px 10px;
            }
            
            .header-section h2 {
                font-size: 1.3rem;
                line-height: 1.3;
            }
            
            .announcements-grid {
                padding: 10px 5px;
                gap: 12px;
            }
            
            .announcement-card {
                margin: 0 5px;
                padding: 15px;
            }
            
            .announcement-card img {
                height: 180px;
            }
            
            .announcement-card h3 {
                font-size: 1.2rem;
            }
            
            .announcement-text {
                padding: 12px;
                line-height: 1.5;
            }
            
            .welcome-card {
                margin: 10px 5px;
                padding: 18px;
            }
            
            .welcome-card h3 {
                font-size: 1.4rem;
            }
            
            .welcome-card p {
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .announcement-card img {
                height: 160px;
            }
            
            .announcement-card {
                padding: 12px;
            }
            
            .header-section h2 {
                font-size: 1.2rem;
            }
            
            .welcome-card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
        @include('resident.resident-sidebar', ['resident' => $resident])

        <div class="main-wrapper">
            @include('resident.resident-header', ['resident' => $resident])
            
            <main class="main users chart-page" id="skip-target">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="welcome-card">
                                <h3>Welcome, {{ ucfirst(auth()->user()->firstName) }}!</h3>
                                <p>Here's what's happening in your community.</p>
                            </div>

                            

                            <div class="announcements-grid">
                                @foreach($announcements as $announcement)
                                <div class="announcement-card">
                                    @if($announcement->image)
                                        <img src="{{ $announcement->image ? asset('storage/'.$announcement->image) : 'no image uploaded' }}"
                                             alt="{{ $announcement->title }}">
                                    @endif
                                      
                                    <h3 class="fw-bold mb-2">{{ $announcement->title }}</h3>
                                    <div class="announcement-text">
                                        <p class="mt-1">{{ $announcement->details }}</p>

                                        @if($announcement->eventTime || $announcement->eventEnd)
                                            <p class="mt-2 mb-2"><strong>Event Start:</strong> {{ date('M d, Y g:i A', strtotime($announcement->eventTime)) }}</p>
                                            <p><strong>Event End:</strong> {{ date('M d, Y g:i A', strtotime($announcement->eventEnd)) }}</p>
                                        @endif
                                    </div>
                                    <div class="announcement-meta">
                                        Posted by: {{ ucfirst($announcement->user->firstName) }},
                                        {{ ucfirst($announcement->user->lastName) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('template/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
