<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
        --success-color: #059669;
        --warning-color: #f59e0b;
        --danger-color: #dc2626;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--light-bg);
        color: var(--text-primary);
    }

    /* Main Container Styling */
    .main.users.chart-page {
        background-color: var(--light-bg);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .main-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 0;
        margin: 0 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        color: black;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 0;
    }

    .page-header h2 {
        color: rgb(0, 0, 0);
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-header-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Search Section */
    .search-section {
        background: #f8fafc;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .search-section .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-section .input-group-text {
        background-color: white;
        border-right: none;
        color: var(--text-secondary);
    }

    .search-section .form-control {
        border-left: none;
        padding: 0.625rem 1rem;
    }

    .search-section .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }

    /* Table Styling */
    .table-container {
        padding: 2rem;
    }

    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .results-count {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .results-count .count-number {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .table-filter-bar {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: var(--text-primary);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    .status-badge i {
        font-size: 0.9rem;
    }

    .status-approved {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-declined {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .overdue-pending-note {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.4rem;
        padding: 0.25rem 0.55rem;
        border-radius: 999px;
        border: 1px solid #fca5a5;
        color: #b91c1c;
        font-size: 0.72rem;
        font-weight: 700;
        background: #fff5f5;
        width: fit-content;
    }

    .pending-age-note {
        margin-top: 0.35rem;
        font-size: 0.72rem;
        line-height: 1.35;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.45rem;
        border-radius: 6px;
        border: 1px solid #fcd34d;
        font-weight: 600;
        color: #92400e;
        background: #fffbeb;
        width: fit-content;
    }

    /* Button Styling */
    .btn {
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-sm {
        padding: 0.4rem 0.85rem;
        font-size: 0.8rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    /* Image Previews */
    .image-preview {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .image-preview-profile {
        border-radius: 50%;
    }

    /* Status Radio Buttons */
    .status-radio-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .status-radio-option {
        position: relative;
    }

    .btn-check:checked + .status-radio-label {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .status-radio-label {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.25rem 0.75rem;
        border: 2px solid transparent;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .status-radio-label i {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }

    .status-radio-label span {
        font-weight: 600;
        font-size: 0.875rem;
    }

    .btn-check:checked + .btn-outline-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #047857 100%) !important;
        border-color: var(--success-color) !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-warning {
        background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%) !important;
        border-color: var(--warning-color) !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #b91c1c 100%) !important;
        border-color: var(--danger-color) !important;
        color: white !important;
    }

    /* Pagination Styling */
    .pagination-container {
        padding: 2rem;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-radius: 0 0 16px 16px;
        border-top: 2px solid var(--border-color);
    }

    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .pagination-info-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        border: 2px solid var(--border-color);
        font-weight: 600;
    }

    .pagination-info-text i {
        color: var(--primary-color);
    }

    .pagination-info-numbers {
        color: var(--primary-color);
        font-weight: 700;
    }

    /* Pagination Navigation */
    .pagination {
        margin: 0;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.625rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0;
        background: white;
        min-width: 44px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-link:hover:not(.disabled) {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        transform: scale(1.1);
        position: relative;
        z-index: 1;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* First and Last Page Buttons */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-weight: 700;
        padding: 0.625rem 1.25rem;
    }

    .pagination .page-item:first-child .page-link {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .pagination .page-item:last-child .page-link {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .pagination .page-item:first-child .page-link:hover:not(.disabled),
    .pagination .page-item:last-child .page-link:hover:not(.disabled) {
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    }

    /* Quick Jump Section */
    .pagination-quick-jump {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        border: 2px solid var(--border-color);
    }

    .pagination-quick-jump label {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .pagination-quick-jump input {
        width: 80px;
        padding: 0.5rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        text-align: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .pagination-quick-jump input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .pagination-quick-jump button {
        padding: 0.5rem 1rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .pagination-quick-jump button:hover {
        background: var(--secondary-color);
        transform: scale(1.05);
    }

    /* Per Page Selector */
    .pagination-per-page {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        border: 2px solid var(--border-color);
    }

    .pagination-per-page label {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .pagination-per-page select {
        padding: 0.5rem 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .pagination-per-page select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .pagination-container {
            padding: 1.5rem 1rem;
        }

        .pagination-wrapper {
            gap: 1rem;
        }

        .pagination {
            gap: 0.35rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            min-width: 38px;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0.5rem 0.875rem;
        }

        .pagination-info {
            font-size: 0.8rem;
        }

        .pagination-quick-jump,
        .pagination-per-page {
            width: 100%;
            justify-content: center;
        }

        .pagination-quick-jump input {
            width: 70px;
        }
    }

    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            min-width: 34px;
        }

        .pagination-info-text {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }


    /* Modal Improvements */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .modal-header.bg-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
    }

    .modal-header.bg-info {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1.25rem 1.5rem;
        background-color: #f8fafc;
        border-top: 2px solid var(--border-color);
    }

    .user-details-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .user-details-modal .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: #fff;
        border-bottom: none;
    }

    .user-details-modal .modal-header .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-details-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.85;
    }

    .user-details-modal .section-card {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
    }

    .user-details-modal .detail-label {
        display: block;
        font-size: 0.74rem;
        letter-spacing: 0.45px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
        font-weight: 700;
    }

    .user-details-modal .detail-value {
        font-weight: 600;
        color: #0f172a;
        line-height: 1.35;
    }

    .user-details-modal .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #fff;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem auto;
        overflow: hidden;
    }

    .user-details-modal .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-details-modal .proof-box {
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
    }

    .role-block {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.45rem;
    }

    .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        width: fit-content;
        padding: 0.34rem 0.7rem;
        border-radius: 999px;
        border: 1px solid transparent;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.25px;
        text-transform: uppercase;
        line-height: 1;
    }

    .role-pill.role-admin {
        color: #1e3a8a;
        background: #dbeafe;
        border-color: #93c5fd;
    }

    .role-pill.role-subadmin {
        color: #155e75;
        background: #cffafe;
        border-color: #67e8f9;
    }

    .role-pill.role-resident {
        color: #065f46;
        background: #d1fae5;
        border-color: #6ee7b7;
    }

    .role-pill.role-non-resident {
        color: #7c2d12;
        background: #ffedd5;
        border-color: #fdba74;
    }

    .eligibility-note {
        font-size: 0.72rem;
        line-height: 1.35;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.45rem;
        border-radius: 6px;
        border: 1px solid transparent;
        font-weight: 500;
        opacity: 0.9;
        width: fit-content;
    }

    .eligibility-note.eligible {
        color: #4b5563;
        background: #f8fafc;
        border-color: #e5e7eb;
    }

    .eligibility-note.pending {
        color: #6b7280;
        background: #f8fafc;
        border-color: #e5e7eb;
    }

    /* Alert Styling */
    .alert-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #3b82f6;
        color: #1e40af;
        border-radius: 12px;
        padding: 1.25rem;
        font-weight: 500;
    }

    .pending-review-banner {
        margin: 1rem 2rem 0;
        border-radius: 12px;
        border: 1px solid #fde68a;
        background: linear-gradient(135deg, #fff7ed 0%, #fffbeb 100%);
        padding: 0.9rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .pending-review-banner.is-overdue {
        border-color: #fecaca;
        background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 100%);
    }

    .pending-review-banner .banner-title {
        font-weight: 700;
        color: #92400e;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pending-review-banner.is-overdue .banner-title {
        color: #991b1b;
    }

    .pending-review-banner .banner-text {
        margin: 0;
        color: #7c2d12;
        font-size: 0.92rem;
    }

    .pending-review-banner .banner-counts {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .pending-review-pill {
        background: #fff;
        border: 1px solid #fed7aa;
        color: #9a3412;
        font-weight: 700;
        font-size: 0.78rem;
        padding: 0.35rem 0.6rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .pending-review-banner.is-overdue .pending-review-pill.overdue {
        border-color: #fca5a5;
        color: #b91c1c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            margin: 0 0.75rem;
            border-radius: 12px;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .table-container {
            padding: 1rem;
            overflow-x: auto;
        }

        .status-radio-group {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
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
                <!-- Enhanced Header -->
                <div class="page-header">
                    <h2>
                        <div class="page-header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        User Records Management
                    </h2>
                </div>
                @if (($hasPendingUsers ?? false) || ((int) ($pendingUsersCount ?? 0) > 0))
                    <div class="pending-review-banner {{ ($hasOverduePendingUsers ?? false) ? 'is-overdue' : '' }}">
                        <div>
                            <div class="banner-title">
                                <i class="fas fa-hourglass-half"></i>
                                Pending User Approvals Need Review
                            </div>
                            <p class="banner-text">
                                @if(($hasOverduePendingUsers ?? false))
                                    Some pending users have been waiting for more than 72 hours. Review and update their status.
                                @else
                                    There are pending users awaiting approval. Review their status when ready.
                                @endif
                            </p>
                        </div>
                        <div class="banner-counts">
                            <span class="pending-review-pill">Pending: {{ (int) ($pendingUsersCount ?? 0) }}</span>
                            <span class="pending-review-pill overdue">Over 72h: {{ (int) ($pendingOver72HoursCount ?? 0) }}</span>
                        </div>
                    </div>
                @endif
           

                <!-- Search Section -->
                <div class="search-section">
                    <form action="{{ route($user->role . '.users') }}" method="get">
                        <input type="hidden" name="status_filter" value="{{ request('status_filter', 'all') }}">
                        <input type="hidden" name="role_filter" value="{{ request('role_filter', 'all') }}">
                        <input type="hidden" name="sort" value="{{ request('sort', 'id_desc') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-8">
                                <label class="form-label">Search User</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Search by name or ID..." 
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route($user->role . '.users') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                @if($userList->count() > 0)
                    <!-- Table Container -->
                    <div class="table-container">
                        <div class="results-info">
                            <div class="results-count">
                                <i class="fas fa-user-check me-2 text-primary"></i>
                                Found <span class="count-number">{{ $userList->total() }}</span> user{{ $userList->total() !== 1 ? 's' : '' }}
                            </div>
                            <form method="GET" action="{{ route($user->role . '.users') }}" class="table-filter-bar">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <div class="filter-group">
                                    <span class="filter-label">Status</span>
                                    <select name="status_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('status_filter', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                        <option value="approved" {{ request('status_filter') === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="pending" {{ request('status_filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="declined" {{ request('status_filter') === 'declined' ? 'selected' : '' }}>Declined</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <span class="filter-label">Role</span>
                                    <select name="role_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('role_filter', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                        <option value="admin" {{ request('role_filter') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="subadmin" {{ request('role_filter') === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                        <option value="resident" {{ request('role_filter') === 'resident' ? 'selected' : '' }}>Resident</option>
                                        <option value="non-resident" {{ request('role_filter') === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <span class="filter-label">Sort</span>
                                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="id_desc" {{ request('sort', 'id_desc') === 'id_desc' ? 'selected' : '' }}>ID: Newest</option>
                                        <option value="id_asc" {{ request('sort') === 'id_asc' ? 'selected' : '' }}>ID: Oldest</option>
                                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                        <option value="role_asc" {{ request('sort') === 'role_asc' ? 'selected' : '' }}>Role: A-Z</option>
                                        <option value="role_desc" {{ request('sort') === 'role_desc' ? 'selected' : '' }}>Role: Z-A</option>
                                        <option value="status_asc" {{ request('sort') === 'status_asc' ? 'selected' : '' }}>Status: A-Z</option>
                                        <option value="status_desc" {{ request('sort') === 'status_desc' ? 'selected' : '' }}>Status: Z-A</option>
                                    </select>
                                </div>
                                <a href="{{ route($user->role . '.users', array_filter(['search' => request('search')])) }}" class="btn btn-link btn-sm text-secondary text-decoration-none">
                                    <i class="fa fa-undo me-1"></i>Reset
                                </a>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userList as $list)
                                        @php
                                            $eligibilityDate = $list->created_at ? $list->created_at->copy()->addMonths(6) : null;
                                            $eligibilityDaysRemaining = $eligibilityDate ? max(0, (int) ceil(now()->diffInRealDays($eligibilityDate, false))) : null;
                                            $isNonResidentEligible = $list->role === 'non-resident' && $eligibilityDate && $eligibilityDaysRemaining <= 0;
                                            $isOwnAccount = (int) $user->id === (int) $list->id;
                                            $roleStyleMap = [
                                                'admin' => ['class' => 'role-admin', 'icon' => 'fa-user-shield'],
                                                'subadmin' => ['class' => 'role-subadmin', 'icon' => 'fa-user-gear'],
                                                'resident' => ['class' => 'role-resident', 'icon' => 'fa-house-user'],
                                                'non-resident' => ['class' => 'role-non-resident', 'icon' => 'fa-user-clock'],
                                            ];
                                            $roleStyle = $roleStyleMap[$list->role] ?? ['class' => 'role-non-resident', 'icon' => 'fa-user'];
                                        @endphp
                                        <tr>
                                            <td><strong>#{{ $list->id }}</strong></td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-link text-decoration-none p-0 fw-semibold"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#userDetailsModal{{ $list->id }}"
                                                        title="View user details">
                                                    {{ ucwords(strtolower($list->firstName)) }}
                                                     {{ ucwords(strtolower($list->middleName)) }}
                                                    {{ ucwords(strtolower($list->lastName)) }}
                                                </button>
                                                @if($list->status === 'pending')
                                                    @php
                                                        $duplicateResident = \App\Models\Resident::where('firstName', $list->firstName)
                                                            ->where('middleName', $list->middleName)
                                                            ->where('lastName', $list->lastName)
                                                            ->where('birthday', $list->birthday)
                                                            ->exists();
                                                    @endphp
                                                    @if($duplicateResident)
                                                        <span class="badge bg-warning text-dark ms-2">Duplicate in residents</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $list->email }}</td>
                                            <td>
                                                <div class="role-block">
                                                    <span class="role-pill {{ $roleStyle['class'] }}">
                                                        <i class="fas {{ $roleStyle['icon'] }}"></i>
                                                        {{ ucfirst($list->role) }}
                                                    </span>
                                                    @if($list->role === 'non-resident' && $eligibilityDate)
                                                        @if($isNonResidentEligible)
                                                            <span class="eligibility-note eligible">
                                                                <i class="fas fa-circle-check"></i>
                                                                Eligible for Official Resident now ({{ $eligibilityDate->format('M d, Y') }})
                                                            </span>
                                                        @else
                                                            <span class="eligibility-note pending">
                                                                <i class="fas fa-hourglass-half"></i>
                                                                Eligible for Official Resident in {{ $eligibilityDaysRemaining }} days ({{ $eligibilityDate->format('M d, Y') }})
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusConfig = [
                                                        'approved' => ['class' => 'status-approved', 'icon' => 'fa-check-circle', 'text' => 'Approved'],
                                                        'pending' => ['class' => 'status-pending', 'icon' => 'fa-clock', 'text' => 'Pending'],
                                                        'rejected' => ['class' => 'status-declined', 'icon' => 'fa-times-circle', 'text' => 'Declined'],
                                                        'declined' => ['class' => 'status-declined', 'icon' => 'fa-times-circle', 'text' => 'Declined']
                                                    ];
                                                    $status = $statusConfig[$list->status] ?? $statusConfig['pending'];
                                                    $isPendingOver72 = $list->status === 'pending'
                                                        && $list->created_at
                                                        && $list->created_at->lte(now()->subHours(72));
                                                    $pendingAgeLabel = null;
                                                    if ($list->status === 'pending' && $list->created_at) {
                                                        $registeredAt = $list->created_at;
                                                        $daysPending = (int) $registeredAt->diffInDays(now());
                                                        $hoursPending = (int) $registeredAt->copy()->addDays($daysPending)->diffInHours(now());
                                                        if ($daysPending > 0) {
                                                            $pendingAgeLabel = 'Pending for ' . $daysPending . ' day' . ($daysPending !== 1 ? 's' : '') . ' ' . $hoursPending . ' hour' . ($hoursPending !== 1 ? 's' : '');
                                                        } else {
                                                            $totalHoursPending = max(0, (int) $registeredAt->diffInHours(now()));
                                                            $pendingAgeLabel = 'Pending for ' . $totalHoursPending . ' hour' . ($totalHoursPending !== 1 ? 's' : '');
                                                        }
                                                    }
                                                @endphp
                                                <span class="status-badge {{ $status['class'] }}">
                                                    <i class="fas {{ $status['icon'] }}"></i>
                                                    {{ $status['text'] }}
                                                </span>
                                                @if($pendingAgeLabel)
                                                    <span class="pending-age-note">
                                                        <i class="fas fa-hourglass-half"></i>
                                                        {{ $pendingAgeLabel }}
                                                    </span>
                                                @endif
                                                @if($isPendingOver72)
                                                    <div class="overdue-pending-note">
                                                        <i class="fas fa-exclamation-triangle"></i> Over 72h
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    @if($list->role === 'superadmin')
                                                        <span class="text-muted small fw-semibold"></span>
                                                    @else
                                                        @if($list->status === 'pending')
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-success btn-action" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#statusModal{{ $list->id }}">
                                                                <i class="fas fa-sync-alt"></i> Status
                                                            </button>
                                                        @endif
                                                        @if($isOwnAccount && $user->role === 'admin')
                                                            <span class="text-muted small fw-semibold">Current account</span>
                                                        @else
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-primary btn-action" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#roleModal{{ $list->id }}">
                                                                <i class="fas fa-user-cog"></i> Role
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- User Details Modal --}}
                                        <div class="modal fade user-details-modal" id="userDetailsModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-user me-2"></i>User Details
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <div class="section-card h-100 text-center">
                                                                    <div class="profile-avatar">
                                                                        @if($list->profile_image)
                                                                            <img src="{{ asset('storage/' . $list->profile_image) }}" alt="Profile image">
                                                                        @else
                                                                            <i class="fas fa-user" style="font-size: 54px; color: #94a3b8;"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div class="detail-value mb-1">
                                                                        {{ ucwords(strtolower(trim(($list->firstName ?? '') . ' ' . ($list->middleName ?? '') . ' ' . ($list->lastName ?? '')))) }}
                                                                    </div>
                                                                    <small class="text-muted">User #{{ $list->id }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="section-card h-100">
                                                                    <div class="row g-3">
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Email</span>
                                                                            <div class="detail-value">{{ $list->email ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Contact Number</span>
                                                                            <div class="detail-value">{{ $list->contactNumber ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Birthday</span>
                                                                            <div class="detail-value">{{ $list->birthday ? \Carbon\Carbon::parse($list->birthday)->format('M d, Y') : 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Role</span>
                                                                            <div class="detail-value text-capitalize">{{ $list->role ?? 'N/A' }}</div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Status</span>
                                                                            <div class="detail-value text-capitalize">{{ $list->status ?? 'pending' }}</div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="detail-label">Registration Date</span>
                                                                            <div class="detail-value">{{ $list->created_at ? $list->created_at->format('M d, Y h:i A') : 'N/A' }}</div>
                                                                        </div>
                                                                        @if($list->role === 'non-resident' && $eligibilityDate)
                                                                            <div class="col-12">
                                                                                <span class="detail-label">Resident Role Eligibility</span>
                                                                                <div class="detail-value">
                                                                                    @if($isNonResidentEligible)
                                                                                        Eligible for Official Resident now ({{ $eligibilityDate->format('M d, Y') }})
                                                                                    @else
                                                                                        Eligible for Official Resident in {{ $eligibilityDaysRemaining }} days ({{ $eligibilityDate->format('M d, Y') }})
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($list->resident)
                                                            <div class="section-card mt-3">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <span class="detail-label">Resident Details</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span class="detail-label">Age</span>
                                                                        <div class="detail-value">{{ $list->resident->age ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span class="detail-label">Sex</span>
                                                                        <div class="detail-value text-capitalize">{{ $list->resident->sex ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span class="detail-label">Parent</span>
                                                                        <div class="detail-value text-capitalize">{{ $list->resident->parent ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span class="detail-label">Enrolled</span>
                                                                        <div class="detail-value text-capitalize">{{ $list->resident->enrolled ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Educational Attainment</span>
                                                                        <div class="detail-value">{{ $list->resident->educationalAttainment ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Religion</span>
                                                                        <div class="detail-value">{{ $list->resident->religion ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Resident Contact</span>
                                                                        <div class="detail-value">{{ $list->resident->contactNo ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Resident Birthday</span>
                                                                        <div class="detail-value">{{ $list->resident->birthday ? \Carbon\Carbon::parse($list->resident->birthday)->format('M d, Y') : 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Head of Family</span>
                                                                        <div class="detail-value text-capitalize">{{ $list->resident->headOfFamily ?? 'N/A' }}</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="detail-label">Emergency Contact</span>
                                                                        <div class="detail-value">
                                                                            {{ $list->resident->emergencyContactName ?? 'N/A' }}
                                                                            <span class="text-muted">/</span>
                                                                            {{ $list->resident->emergencyContactNo ?? 'N/A' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="section-card mt-3">
                                                            <span class="detail-label mb-2">Proof of Identity</span>
                                                            @if($list->proofOfIdentity)
                                                                <div class="proof-box">
                                                                    <img src="{{ asset('storage/' . $list->proofOfIdentity) }}"
                                                                         alt="ID proof"
                                                                         class="img-fluid rounded"
                                                                         style="max-height: 360px; width: 100%; object-fit: contain;">
                                                                </div>
                                                            @else
                                                                <div class="proof-box text-muted">No ID proof uploaded.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($list->role !== 'superadmin')
                                            {{-- Status Update Modal --}}
                                            <div class="modal fade" id="statusModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-user-check me-2"></i>Update User Status
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route($user->role . '.update.status', $list->id) }}" method="POST" class="js-confirm-status-form" data-user-name="{{ trim(ucwords(strtolower(($list->firstName ?? '') . ' ' . ($list->lastName ?? '')))) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-muted small">USER</label>
                                                                    <div class="fw-bold fs-5">
                                                                        {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="form-label fw-semibold mb-3">Select New Status</label>
                                                                    <div class="status-radio-group">
                                                                        <div class="status-radio-option">
                                                                            <input type="radio" class="btn-check" name="status" 
                                                                                   id="approve{{ $list->id }}" value="approved" 
                                                                                   {{ $list->status == 'approved' ? 'checked' : '' }}>
                                                                            <label class="status-radio-label btn-outline-success" for="approve{{ $list->id }}">
                                                                                <i class="fas fa-check-circle"></i>
                                                                                <span>Approve</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="status-radio-option">
                                                                            <input type="radio" class="btn-check" name="status" 
                                                                                   id="pending{{ $list->id }}" value="pending" 
                                                                                   {{ $list->status == 'pending' ? 'checked' : '' }}>
                                                                            <label class="status-radio-label btn-outline-warning" for="pending{{ $list->id }}">
                                                                                <i class="fas fa-clock"></i>
                                                                                <span>Pending</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="status-radio-option">
                                                                            <input type="radio" class="btn-check" name="status" 
                                                                                   id="decline{{ $list->id }}" value="declined" 
                                                                                   {{ $list->status == 'declined' || $list->status == 'rejected' ? 'checked' : '' }}>
                                                                            <label class="status-radio-label btn-outline-danger" for="decline{{ $list->id }}">
                                                                                <i class="fas fa-times-circle"></i>
                                                                                <span>Decline</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save me-1"></i>Update Status
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Role Update Modal --}}
                                            <div class="modal fade" id="roleModal{{ $list->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-user-cog me-2"></i>Update User Role
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route($user->role . '.update.role', $list->id) }}" method="POST" class="js-confirm-role-form" data-user-name="{{ trim(ucwords(strtolower(($list->firstName ?? '') . ' ' . ($list->lastName ?? '')))) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-muted small">USER</label>
                                                                    <div class="fw-bold fs-5">
                                                                        {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="form-label fw-semibold">
                                                                        New Role 
                                                                        <span class="badge bg-secondary ms-2">Current: {{ ucfirst($list->role) }}</span>
                                                                    </label>
                                                                    @if($list->role === 'non-resident' && $eligibilityDate)
                                                                        @if($isNonResidentEligible)
                                                                            <div class="alert alert-success py-2 px-3 mb-3">
                                                                                <i class="fas fa-circle-check me-1"></i>
                                                                                This user is eligible for Official Resident now ({{ $eligibilityDate->format('M d, Y') }}).
                                                                            </div>
                                                                        @else
                                                                            <div class="alert alert-warning py-2 px-3 mb-3">
                                                                                <i class="fas fa-hourglass-half me-1"></i>
                                                                                Eligible for Official Resident in {{ $eligibilityDaysRemaining }} days ({{ $eligibilityDate->format('M d, Y') }}).
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                    @if(($adminLimitReached ?? false) && $list->role !== 'admin')
                                                                        <div class="alert alert-warning py-2 px-3 mb-3">
                                                                            <i class="fas fa-triangle-exclamation me-1"></i>
                                                                            Admin limit reached ({{ $currentAdminCount ?? 0 }}/{{ $maxAdmins ?? 2 }}). Demote an existing admin before assigning this user as Admin.
                                                                        </div>
                                                                    @endif
                                                                    <select name="role" class="form-select form-select-lg">
                                                                        <option
                                                                            value="admin"
                                                                            {{ $list->role === 'admin' ? 'selected' : '' }}
                                                                            {{ (($adminLimitReached ?? false) && $list->role !== 'admin') ? 'disabled' : '' }}
                                                                        >
                                                                            Admin
                                                                        </option>
                                                                        <option value="subadmin" {{ $list->role === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                                                        <option value="resident" {{ $list->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                                                        <option value="non-resident" {{ $list->role === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-info text-white">
                                                                    <i class="fas fa-save me-1"></i>Update Role
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Enhanced Pagination -->
                    @if($userList->count() > 0)
                    <div class="pagination-container">
                        <div class="pagination-wrapper">
                            <!-- Pagination Info -->
                            <div class="pagination-info">
                                <div class="pagination-info-text">
                                    <i class="fas fa-list-ol"></i>
                                    Showing 
                                    <span class="pagination-info-numbers">{{ $userList->firstItem() ?? 0 }}</span>
                                    to 
                                    <span class="pagination-info-numbers">{{ $userList->lastItem() ?? 0 }}</span>
                                    of 
                                    <span class="pagination-info-numbers">{{ $userList->total() }}</span>
                                    entries
                                </div>
                            </div>

                            <!-- Main Pagination -->
                            <nav aria-label="User list pagination">
                                <ul class="pagination">
                                {{-- First Page Link --}}
                                @if ($userList->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-angle-double-left"></i>
                                            <span class="d-none d-sm-inline ms-1">First</span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->url(1) }}" rel="first">
                                            <i class="fas fa-angle-double-left"></i>
                                            <span class="d-none d-sm-inline ms-1">First</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- Previous Page Link --}}
                                @if ($userList->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $currentPage = $userList->currentPage();
                                    $lastPage = $userList->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                @endphp

                                {{-- Show first page if not in range --}}
                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->url(1) }}">1</a>
                                    </li>
                                    @if ($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                {{-- Page Numbers --}}
                                @for ($i = $start; $i <= $end; $i++)
                                    @if ($i == $currentPage)
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $i }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $userList->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Show last page if not in range --}}
                                @if ($end < $lastPage)
                                    @if ($end < $lastPage - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->url($lastPage) }}">{{ $lastPage }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($userList->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->nextPageUrl() }}" rel="next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif

                                {{-- Last Page Link --}}
                                @if ($userList->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userList->url($userList->lastPage()) }}" rel="last">
                                            <span class="d-none d-sm-inline me-1">Last</span>
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <span class="d-none d-sm-inline me-1">Last</span>
                                            <i class="fas fa-angle-double-right"></i>
                                        </span>
                                    </li>
                                @endif
                                </ul>
                            </nav>

                            <!-- Additional Controls -->
                        </div>
                    </div>
                    @endif
                @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusLabelMap = {
            approved: 'Approved',
            pending: 'Pending',
            declined: 'Declined'
        };

        document.querySelectorAll('.js-confirm-status-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                const selected = form.querySelector('input[name="status"]:checked');
                const selectedStatus = selected ? selected.value : '';
                const statusLabel = statusLabelMap[selectedStatus] || selectedStatus || 'selected status';
                const userName = form.getAttribute('data-user-name') || 'this user';
                const message = `You are about to update the status of ${userName} to "${statusLabel}".\n\nDo you want to continue?`;

                if (!window.confirm(message)) {
                    event.preventDefault();
                }
            });
        });

        document.querySelectorAll('.js-confirm-role-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                const roleSelect = form.querySelector('select[name="role"]');
                const selectedRole = roleSelect ? roleSelect.value : '';
                const roleLabel = selectedRole ? selectedRole.replace('-', ' ').replace(/\b\w/g, function (char) { return char.toUpperCase(); }) : 'selected role';
                const userName = form.getAttribute('data-user-name') || 'this user';
                const message = `You are about to change the role of ${userName} to "${roleLabel}".\n\nDo you want to continue?`;

                if (!window.confirm(message)) {
                    event.preventDefault();
                }
            });
        });
    });
</script>
