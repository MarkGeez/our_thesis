<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">

    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">

        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">

            <div class="container">
                <h2 class="mb-3">Feedback From Residents</h2>
                <hr>

                @if ($feedbacks->count() > 0)

                    @foreach ($feedbacks as $feedback)

                        <div class="mb-4 p-3 border rounded bg-white">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="fs-4 mb-2">
                                <strong>
                                    
                                    From:
                                    @if ($feedback->user)
                                        {{ ucfirst($feedback->user->firstName) }} {{ ucfirst($feedback->user->lastName) }}
                                    @else
                                        Unknown User
                                    @endif
                                </strong>
                                    </p>

                                <small class="text-muted">
                                    {{ date('M d, Y h:i A', strtotime($feedback->created_at)) }}
                                </small>
                            </div>

                            <p class="mb-0">
                                {{ $feedback->message }}
                            </p>

                        </div>

                    @endforeach

                    <div class="mt-3">
                        {{ $feedbacks->links() }}
                    </div>

                @else
                    <div class="alert alert-info">
                        No feedback submissions found.
                    </div>
                @endif
            </div>

        </main>

    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
