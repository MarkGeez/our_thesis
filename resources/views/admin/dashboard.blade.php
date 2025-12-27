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

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="main-container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2 style="color:#000000; margin-left: 20px;">Latest Announcements</h2>
                </div>

                @if(session("success"))
                    <div id="successAlert" class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm"
                         style="max-width: 325px; box-shadow: 0 4px 12px rgb(5, 94, 12);">
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
                                <p class="mt-1" style="line-height: 1.25em;">
                                    {{ $announcements->details }}
                                </p>

                                @if($announcements->eventTime || $announcements->eventEnd)
                                    <p class="mt-2 mb-2"><strong>Event Start:</strong>  {{ date('M d, Y g:i A', strtotime($announcements->eventTime)) }}</p>
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

                        <!-- Edit Modal -->
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