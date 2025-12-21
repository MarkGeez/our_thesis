<!DOCTYPE html>
<html lang="en">
<head>
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
            margin: 5px 20px;
            padding: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .announcement-card img {
            display: block;
            margin: 0 auto 15px;
            width: auto;
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
            padding-top: 10px;
        }

        .announcement-meta {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .announcement-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
        }

        .announcement-actions form {
            margin: 0;
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

            line-height: 1.5px;
            }

        @media (max-width: 768px) {
            .announcements-grid {
                grid-template-columns: 1fr;
            }

            .announcement-card img {
                height: 240px;
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
                <!-- Dashboard Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title">Welcome back, {{ ucfirst(auth()->user()->firstName) }}!</h3>
                                    <p class="card-text">Here's what's happening in your community.</p>
                                </div>

                            </div>

                           <div class="container-fluid">
                        <h2 style="color:#007BFF; margin-left: 10px;">Latest Announcements</h2>

                        <div class="announcements-grid">
                            @foreach($announcements as $announcement)
                            <div class="announcement-card">

                            @if($announcement->image)
                                <img src="{{ $announcement->image ? asset('storage/'.$announcement->image) : 'no image uploaded' }}"
                                     alt="{{ $announcement->title }}">
                            @endif

                            
                                <h3 class="fw-bold mb-2">{{ $announcement->title }}</h3>
                            <div class="announcement-text">
                                <p class="mt-1" style="line-height: 1.25em;">
                                    {{ $announcement->details }}
                                </p>

                                @if($announcement->eventTime || $announcement->eventEnd)
                                    <p class="mt-2 mb-2"><strong>Event Start:</strong>  {{ date('M d, Y g:i A', strtotime($announcement->eventTime)) }}</p>
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