<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">

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

        .feedback-shell {
            max-width: 1050px;
            margin: 0 auto;
            padding: 0 0.75rem;
        }

        .feedback-hero {
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
            margin: 0 0.3rem 1rem 0.3rem;
        }

        .feedback-hero h2 {
            font-size: 2rem;
            margin: 0;
            font-weight: 700;
            font-family: "Oswald", sans-serif;
        }

        .panel {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 0 0.3rem 1rem 0.3rem;
            border: 1px solid #eef2f7;
        }

        .panel-head {
            padding: 1rem 1.1rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .panel-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .panel-body {
            padding: 1rem 1.1rem;
        }

        .feedback-note {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.9rem;
        }

        .feedback-input {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 0.9rem;
        }

        .feedback-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.58rem 1rem;
        }

        .feedback-item {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.9rem 1rem;
            background: #fff;
            margin-bottom: 0.8rem;
        }

        .feedback-item.current {
            border-color: #bfdbfe;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .feedback-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.45rem;
            flex-wrap: wrap;
        }

        .feedback-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.32rem 0.7rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            font-size: 0.77rem;
            font-weight: 700;
        }

        .feedback-date {
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .feedback-text {
            margin: 0;
            color: #334155;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .pagination-container {
            padding: 14px 16px 18px 16px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
            border-top: 1px solid var(--border-color);
        }

        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .pagination-info-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #fff;
            padding: 0.5rem 0.85rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.88rem;
        }

        .pagination-info-text i {
            color: var(--primary-color);
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
            <div class="feedback-shell">
                <div class="feedback-hero">
                    <h2>Feedback</h2>
                </div>

                <section class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title"><i class="fa-solid fa-paper-plane"></i> Submit Feedback</h3>
                    </div>
                    <div class="panel-body">
                        <p class="feedback-note">
                            Share your concerns, suggestions, or experience. Your input helps improve barangay services.
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        <form method="post" action="{{ route('resident.submit.feedback') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">From</label>
                                <input type="text" class="form-control feedback-input" value="{{ ucfirst($resident->firstName) }} {{ ucfirst($resident->lastName) }} (You)" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="feedbackMessage" class="form-label fw-semibold">Your message</label>
                                <textarea
                                    class="form-control feedback-input"
                                    id="feedbackMessage"
                                    name="message"
                                    rows="5"
                                    placeholder="Type your feedback here"
                                >{{ old('message') }}</textarea>

                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <i class="fa-solid fa-paper-plane me-1"></i>Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title"><i class="fa-solid fa-clock-rotate-left"></i> Your Feedback History</h3>
                    </div>
                    <div class="panel-body">
                        @if($latestFeedback)
                            <div class="feedback-item current">
                                <div class="feedback-meta">
                                    <span class="feedback-badge"><i class="fa-solid fa-star"></i>Current Feedback</span>
                                    <span class="feedback-date">{{ $latestFeedback->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <p class="feedback-text">{{ $latestFeedback->message }}</p>
                            </div>
                        @endif

                        @if($previousFeedbacks->count() > 0)
                            @foreach($previousFeedbacks as $item)
                                <div class="feedback-item">
                                    <div class="feedback-meta">
                                        <span class="feedback-badge"><i class="fa-regular fa-message"></i>Previous Feedback</span>
                                        <span class="feedback-date">{{ $item->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p class="feedback-text">{{ $item->message }}</p>
                                </div>
                            @endforeach

                            @if($previousFeedbacks->hasPages())
                                <div class="pagination-container">
                                    <div class="pagination-wrapper">
                                        <div class="pagination-info-text">
                                            <i class="fa-solid fa-list-check"></i>
                                            <span>
                                                Showing <strong>{{ $previousFeedbacks->firstItem() }}</strong>
                                                to <strong>{{ $previousFeedbacks->lastItem() }}</strong>
                                                of <strong>{{ $previousFeedbacks->total() }}</strong> previous feedbacks
                                            </span>
                                        </div>
                                        {{ $previousFeedbacks->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            @endif
                        @elseif(!$latestFeedback)
                            <div class="text-center py-4 text-muted">No feedback submitted yet.</div>
                        @endif
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
