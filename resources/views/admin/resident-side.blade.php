@php $themeColor = \App\Models\Setting::get('theme', '#0061f7'); @endphp

<style>
/* ============================================
   SIDEBAR FOUNDATION
   ============================================ */
.sidebar {
    background: {{ $themeColor }} !important;
    height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
}

/* ============================================
   TEXTURE OVERLAY — works on any color
   Fine diagonal pinstripe + dot grid layered
   ============================================ */
.sidebar::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        repeating-linear-gradient(
            -55deg,
            transparent,
            transparent 14px,
            rgba(255, 255, 255, 0.045) 14px,
            rgba(255, 255, 255, 0.045) 15px
        ),
        radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
    background-size: auto, 18px 18px;
    pointer-events: none;
    z-index: 0;
}

.sidebar.sidebar--light::before {
    background-image:
        repeating-linear-gradient(
            -55deg,
            transparent,
            transparent 14px,
            rgba(0, 0, 0, 0.06) 14px,
            rgba(0, 0, 0, 0.06) 15px
        ),
        radial-gradient(circle, rgba(0,0,0,0.06) 1px, transparent 1px);
    background-size: auto, 18px 18px;
}

.sidebar-start {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

/* ============================================
   SIDEBAR HEAD
   ============================================ */
.sidebar-head {
    position: sticky;
    top: 0;
    z-index: 10;
    background: {{ $themeColor }} !important;
    flex-shrink: 0;
}

/* ============================================
   SIDEBAR BODY / SCROLL
   ============================================ */
.sidebar-body {
    flex: 1;
    overflow-y: hidden;
    padding-right: 6px;
    min-height: 0;
    scroll-behavior: smooth;
}
.sidebar:hover .sidebar-body { overflow-y: auto; }

.sidebar-body::-webkit-scrollbar { width: 6px; }
.sidebar-body::-webkit-scrollbar-track { background: transparent; }
.sidebar-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.35); border-radius: 6px; }
.sidebar-body::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.55); }
.sidebar.sidebar--light .sidebar-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); }
.sidebar.sidebar--light .sidebar-body::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.35); }

/* ============================================
   MENU ITEM BASE
   ============================================ */
.sidebar-body-menu a,
.cat-sub-menu a {
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 4px 0;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.sidebar-body-menu a .icon,
.cat-sub-menu a .icon { flex-shrink: 0; margin-left: 6px; }

/* ============================================
   ACTIVE — DARK SIDEBAR (default)
   ============================================ */
.sidebar-body-menu a.active,
.cat-sub-menu a.active {
    background: linear-gradient(90deg, rgba(255,255,255,0.30) 0%, rgba(255,255,255,0.20) 50%, rgba(255,255,255,0.15) 100%) !important;
    font-weight: 600;
    color: #ffffff !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2), inset 0 0 0 1px rgba(255,255,255,0.4);
    transform: translateX(4px);
    padding-left: 12px;
}
.sidebar-body-menu a.active::before,
.cat-sub-menu a.active::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0; width: 5px;
    background: linear-gradient(180deg, #fff 0%, rgba(255,255,255,0.8) 100%);
    border-radius: 0 4px 4px 0;
    box-shadow: 2px 0 10px rgba(255,255,255,0.6), 0 0 20px rgba(255,255,255,0.3);
    animation: sbPulse 2s ease-in-out infinite;
}
.sidebar-body-menu a.active::after,
.cat-sub-menu a.active::after {
    content: '';
    position: absolute;
    right: 0; top: 50%;
    transform: translateY(-50%);
    width: 3px; height: 60%;
    background: linear-gradient(180deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
    border-radius: 4px 0 0 4px;
    opacity: 0.8;
}
.sidebar-body-menu a.active .icon,
.cat-sub-menu a.active .icon {
    color: #fff !important;
    transform: scale(1.15);
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}
.sidebar-body-menu a.active .icon i,
.cat-sub-menu a.active .icon i { animation: sbIconPulse 2s ease-in-out infinite; }

/* ============================================
   HOVER — DARK SIDEBAR
   ============================================ */
.sidebar-body-menu a:hover:not(.active),
.cat-sub-menu a:hover:not(.active) {
    background: rgba(255,255,255,0.12) !important;
    transform: translateX(2px);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2);
    padding-left: 16px;
}
.cat-sub-menu a:hover:not(.active) { padding-left: 52px !important; }

/* Section titles & logo */
.system-menu__title { color: rgba(255,255,255,0.55) !important; }
.sidebar .logo-title { color: #fff !important; }
.sidebar .logo-subtitle { color: rgba(255,255,255,0.7) !important; }

/* ============================================
   LIGHT SIDEBAR MODE
   ============================================ */
.sidebar.sidebar--light .sidebar-body-menu a,
.sidebar.sidebar--light .cat-sub-menu a {
    color: rgba(0,0,0,0.78) !important;
}
.sidebar.sidebar--light .sidebar-body-menu a.active,
.sidebar.sidebar--light .cat-sub-menu a.active {
    background: linear-gradient(90deg, rgba(0,0,0,0.14) 0%, rgba(0,0,0,0.09) 50%, rgba(0,0,0,0.06) 100%) !important;
    color: #1a202c !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12), inset 0 0 0 1px rgba(0,0,0,0.18) !important;
}
.sidebar.sidebar--light .sidebar-body-menu a.active::before,
.sidebar.sidebar--light .cat-sub-menu a.active::before {
    background: linear-gradient(180deg, #1a202c 0%, rgba(0,0,0,0.75) 100%);
    box-shadow: 2px 0 10px rgba(0,0,0,0.25), 0 0 16px rgba(0,0,0,0.1);
}
.sidebar.sidebar--light .sidebar-body-menu a.active::after,
.sidebar.sidebar--light .cat-sub-menu a.active::after {
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
}
.sidebar.sidebar--light .sidebar-body-menu a.active .icon,
.sidebar.sidebar--light .cat-sub-menu a.active .icon {
    color: #1a202c !important;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15));
}
.sidebar.sidebar--light .sidebar-body-menu a:hover:not(.active),
.sidebar.sidebar--light .cat-sub-menu a:hover:not(.active) {
    background: rgba(0,0,0,0.08) !important;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
}
.sidebar.sidebar--light .system-menu__title { color: rgba(0,0,0,0.45) !important; }
.sidebar.sidebar--light .logo-title { color: #1a202c !important; }
.sidebar.sidebar--light .logo-subtitle { color: rgba(0,0,0,0.55) !important; }
.sidebar.sidebar--light .sidebar-body-menu a:focus,
.sidebar.sidebar--light .cat-sub-menu a:focus { outline-color: rgba(0,0,0,0.4); }

/* ============================================
   ANIMATIONS
   ============================================ */
@keyframes sbPulse {
    0%, 100% { opacity: 1; box-shadow: 2px 0 10px rgba(255,255,255,0.6), 0 0 20px rgba(255,255,255,0.3); }
    50% { opacity: 0.85; box-shadow: 2px 0 15px rgba(255,255,255,0.8), 0 0 25px rgba(255,255,255,0.5); }
}
@keyframes sbIconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

.sidebar-body-menu a:focus,
.cat-sub-menu a:focus {
    outline: 2px solid rgba(255,255,255,0.5);
    outline-offset: 2px;
}
</style>

<aside class="sidebar" data-theme="{{ $themeColor }}">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('resident.dashboard') }}" class="logo-wrapper">
                <span class="sr-only">Home</span>
                <span class="" aria-hidden="true" style="width: 55px; height: 55px; margin-right: 10px;">
                    @php
                        $logoPath = \App\Models\Setting::get('logo', 'template/img/brgy 249 Logo png.png');
                    @endphp
                    <img src="{{ asset($logoPath) }}" alt="System Logo" style="border-radius: 50%;">
                </span>
                <div class="logo-text">
                    <span class="logo-title" style="font-family: 'Orbitron', sans-serif;">
                        {{ \App\Models\Setting::get('name') }}
                    </span>
                    <span class="logo-subtitle"></span>
                </div>
            </a>
            <button class="sidebar-toggle transparent-btn" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle"></span>
            </button>
        </div>

        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li>
                    <a class="{{ Request::routeIs('resident.dashboard') ? 'active' : '' }}"
                       href="{{ route('resident.dashboard') }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">system</span>

            <ul class="sidebar-body-menu">
                <li>
                    <a class="{{ Request::routeIs('resident.profile') ? 'active' : '' }}"
                       href="{{ route('resident.profile') }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('resident.certificate') ? 'active' : '' }}"
                       href="{{ route('resident.certificate') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></span>My Documents
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('resident.complaint') ? 'active' : '' }}"
                       href="{{ route('resident.complaint') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>My Complaints
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('resident.feedback') ? 'active' : '' }}"
                       href="{{ route('resident.feedback') }}">
                        <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>Feedback
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('resident.contactus') ? 'active' : '' }}"
                       href="{{ route('resident.contactus') }}">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>Contact Us
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('resident.aboutus') ? 'active' : '' }}"
                       href="{{ route('resident.aboutus') }}">
                        <span class="icon"><i class="fa-solid fa-circle-info"></i></span>About Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    (function applySidebarContrast() {
        const sidebar = document.querySelector('.sidebar');
        if (!sidebar) return;
        const hex = (sidebar.dataset.theme || '#0061f7').replace('#', '');
        if (hex.length !== 6) return;
        function toLinear(c) { return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4); }
        const r = toLinear(parseInt(hex.substr(0, 2), 16) / 255);
        const g = toLinear(parseInt(hex.substr(2, 2), 16) / 255);
        const b = toLinear(parseInt(hex.substr(4, 2), 16) / 255);
        const luminance = 0.2126 * r + 0.7152 * g + 0.0722 * b;
        if (luminance > 0.35) sidebar.classList.add('sidebar--light');
    })();
});
</script>