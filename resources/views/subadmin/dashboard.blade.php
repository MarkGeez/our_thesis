<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Boldonse&family=Chicle&family=Exo:ital,wght@0,100..900;1,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Metal+Mania&family=Mochiy+Pop+P+One&family=Oi&family=Oswald:wght@200..700&family=Quicksand:wght@600&family=Reggae+One&family=Teko:wght@300..700&family=Yesteryear&display=swap" rel="stylesheet">
    <style>
        .oswald-regular {
            font-family: "Oswald", sans-serif;
            font-optical-sizing: auto;
            font-weight: 200;
            font-style: normal;
            }
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

        .announcement-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
            flex-wrap: wrap;
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
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .header-section {
            padding: 20px 30px;
            background: none;
            margin-bottom: 20px;
        }

        .header-section h2 {
            color: #000;
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
                flex-direction: column;
                gap: 15px;
                align-items: flex-start !important;
            }
            
            .header-section h2 {
                font-size: 1.4rem;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding: 0;
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
            
            .announcement-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .btn-sm {
                width: 100%;
                justify-content: center;
            }
            
            .modal-dialog {
                margin: 10px;
            }
            
            .modal-dialog.modal-dialog-centered {
                max-width: calc(100% - 20px);
            }
            
            .form-control {
                font-size: 16px;
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
        }

        #successAlert {
            max-width: 90vw !important;
            margin: 15px auto !important;
            font-size: 0.95rem;
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
            font-family: "Oswald", sans-serif;
        }

        .welcome-card p {
            font-size: 1.1rem;
            opacity: 0.95;
        }
    </style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])

    <div class="main-wrapper">
        @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="main-container">
                <div class="welcome-card">
                                <h3>Welcome, {{ ucfirst(auth()->user()->firstName) }}!</h3>
                                <p>Here's what's happening in your community.</p>
                </div>

                @if(session("success"))
                    <div id="successAlert" class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm">
                        <h6>{{ session("success") }}</h6>
                    </div>

                    <script>
                        setTimeout(function() {
                            const alertBox = document.getElementById("successAlert");
                            if (alertBox) {
                                alertBox.style.display = "none";
                            }
                        }, 10000);
                    </script>
                @endif

                <div class="announcements-grid">
                    @foreach($announcement as $announcements)
                        <div class="announcement-card">
                            @if($announcements->image)
                                <img src="{{ $announcements->image ? asset('storage/'.$announcements->image) : 'no image uploaded' }}"
                                     alt="{{ $announcements->title }}">
                            @endif
                              
                            <h3 class="fw-bold mb-2">{{ $announcements->title }}</h3>
                            <div class="announcement-text">
                                <p class="mt-1">{{ $announcements->details }}</p>

                                @if($announcements->eventTime || $announcements->eventEnd)
                                    <p class="mt-2 mb-2"><strong>Event Start:</strong> {{ date('M d, Y g:i A', strtotime($announcements->eventTime)) }}</p>
                                    <p><strong>Event End:</strong> {{ date('M d, Y g:i A', strtotime($announcements->eventEnd)) }}</p>
                                @endif
                            </div>
                            <div class="announcement-meta">
                                Posted by: {{ ucfirst($announcements->user->firstName) }},
                                {{ ucfirst($announcements->user->lastName) }}
                            </div>

                            <div class="announcement-actions">
                                <form action="{{ route('admin.announcement.archive', $announcements->id) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>

                        <div class="modal fade"
                             id="editAnnouncement{{ $announcements->id }}"
                             tabindex="-1"
                             aria-labelledby="editAnnouncementLabel{{ $announcements->id }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="editAnnouncementLabel{{ $announcements->id }}">
                                            Edit Announcement
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.update.announcement', $announcements->id) }}"
                                              method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <label for="title{{ $announcements->id }}">Title</label>
                                            <input class="form-control" type="text"
                                                   name="title"
                                                   id="title{{ $announcements->id }}"
                                                   value="{{ $announcements->title }}"
                                                   required>

                                            <label for="details{{ $announcements->id }}">Details</label>
                                            <textarea class="form-control"
                                                      name="details"
                                                      id="details{{ $announcements->id }}"
                                                      cols="40"
                                                      rows="10">{{ old('details', $announcements->details) }}</textarea>

                                            <label for="eventTime{{ $announcements->id }}">Event Start</label>
                                            <input class="form-control"
                                                   type="datetime-local"
                                                   name="eventTime"
                                                   id="eventTime{{ $announcements->id }}"
                                                   value="{{ old('eventTime', $announcements->eventTime ? date('Y-m-d\TH:i', strtotime($announcements->eventTime)) : '') }}">

                                            <label for="eventEnd{{ $announcements->id }}">Event End</label>
                                            <input class="form-control"
                                                   type="datetime-local"
                                                   name="eventEnd"
                                                   id="eventEnd{{ $announcements->id }}"
                                                   value="{{ old('eventEnd', $announcements->eventEnd ? date('Y-m-d\TH:i', strtotime($announcements->eventEnd)) : '') }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
