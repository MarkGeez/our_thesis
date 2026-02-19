<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        .main.users.chart-page {
            background-color: var(--light-bg);
            min-height: 100vh;
            padding: 2rem 0;
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
            color: #000;
            border-radius: 15px;
            padding: 30px;
            margin: 20px;
        }

        .welcome-card h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
            font-family: "Oswald", sans-serif;
        }

        .records-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 0 1rem;
        }

        .feedback-list {
            padding: 1rem;
        }

        .feedback-card {
            border: 1px solid var(--border-color);
            border-radius: 14px;
            background: #fff;
            padding: 1rem 1.1rem;
            margin-bottom: 0.85rem;
            transition: all 0.2s ease;
        }

        .feedback-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(30, 55, 90, 0.08);
            border-color: #d8e4ff;
        }

        .feedback-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.55rem;
            flex-wrap: wrap;
        }

        .feedback-author {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-primary);
            font-weight: 700;
        }

        .feedback-time {
            font-size: 0.83rem;
            color: var(--text-secondary);
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 0.3rem 0.65rem;
            white-space: nowrap;
        }

        .feedback-message {
            margin: 0;
            color: #334155;
            line-height: 1.55;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .pagination-container {
            padding: 18px 22px 22px 22px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
            border-top: 2px solid var(--border-color);
        }

        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
            margin: 0;
        }

        .pagination-info-text {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            background: #fff;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            border: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .pagination-info-text i {
            color: var(--primary-color);
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
                <div class="welcome-card">
                    <h3>Feedback from the Barangay</h3>
                </div>

                <div class="records-container">
                    @if ($feedbacks->count() > 0)
                        <div class="feedback-list">
                            @foreach ($feedbacks as $feedback)
                                <article class="feedback-card">
                                    <div class="feedback-head">
                                        <div class="feedback-author">
                                            <i class="fa-solid fa-user-pen"></i>
                                            <span>
                                                @if ($feedback->user)
                                                    {{ ucfirst($feedback->user->firstName) }} {{ ucfirst($feedback->user->lastName) }}
                                                @else
                                                    Unknown User
                                                @endif
                                            </span>
                                        </div>
                                        <span class="feedback-time">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            {{ date('M d, Y h:i A', strtotime($feedback->created_at)) }}
                                        </span>
                                    </div>
                                    <p class="feedback-message">{{ $feedback->message }}</p>
                                </article>
                            @endforeach
                        </div>

                        @if($feedbacks->hasPages())
                            <div class="pagination-container">
                                <div class="pagination-wrapper">
                                    <div class="pagination-info-text">
                                        <i class="fa-solid fa-list-check"></i>
                                        <span>
                                            Showing <strong>{{ $feedbacks->firstItem() }}</strong>
                                            to <strong>{{ $feedbacks->lastItem() }}</strong>
                                            of <strong>{{ $feedbacks->total() }}</strong> results
                                        </span>
                                    </div>
                                    {{ $feedbacks->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-5 text-center">
                            <p class="text-muted mb-0">No feedback submissions found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>

    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>


