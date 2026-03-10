@php $themeColor = \App\Models\Setting::get('theme', '#0061f7'); @endphp
<style>
.sidebar {
    background: {{ $themeColor }} !important;
    height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.sidebar-start {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

/* Keep header fixed at top */
.sidebar-head {
    position: sticky;
    top: 0;
    z-index: 10;
    background: {{ $themeColor }} !important;
    flex-shrink: 0;
}

/* make only the body scrollable */
.sidebar-body{
    flex: 1;
    overflow-y: hidden;
    padding-right: 6px;
    min-height: 0; /* Important for flex scrolling */
}

/* enable scroll on hover */
.sidebar:hover .sidebar-body{
    overflow-y: auto;
}

/* smoother scrolling */
.sidebar-body{
    scroll-behavior: smooth;
}

/* cleaner scrollbar */
.sidebar-body::-webkit-scrollbar{
    width: 6px;
}
.sidebar-body::-webkit-scrollbar-track{
    background: transparent;
}
.sidebar-body::-webkit-scrollbar-thumb{
    background: rgba(255,255,255,0.35);
    border-radius: 6px;
}
.sidebar-body::-webkit-scrollbar-thumb:hover{
    background: rgba(255,255,255,0.55);
}

/* ============================================
   ENHANCED ACTIVE STATE STYLING
   ============================================ */

/* Base menu item styling */
.sidebar-body-menu a,
.cat-sub-menu a {
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 4px 0;
    border-radius: 12px;
    overflow: hidden;
    padding-left: 12px;
}

/* Active state for main menu items */
.sidebar-body-menu a.active,
.cat-sub-menu a.active {
    background: rgba(255, 255, 255, 0.25) !important;
    font-weight: 600;
    color: #ffffff !important;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.2),
        inset 0 0 0 1px rgba(255, 255, 255, 0.4);
    transform: translateX(4px);
}

/* Left accent border - more prominent */
.sidebar-body-menu a.active::before,
.cat-sub-menu a.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background: linear-gradient(180deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
    border-radius: 0 4px 4px 0;
    box-shadow: 
        2px 0 10px rgba(255, 255, 255, 0.6),
        0 0 20px rgba(255, 255, 255, 0.3);
    animation: pulse 2s ease-in-out infinite;
}

/* Glowing effect on the right edge */
.sidebar-body-menu a.active::after,
.cat-sub-menu a.active::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 60%;
    background: linear-gradient(180deg, 
        transparent 0%, 
        rgba(255, 255, 255, 0.6) 50%, 
        transparent 100%);
    border-radius: 4px 0 0 4px;
    opacity: 0.8;
}

/* Icon enhancement for active items */
.sidebar-body-menu a.active .icon,
.cat-sub-menu a.active .icon {
    color: #fff !important;
    transform: scale(1.15);
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.sidebar-body-menu a.active .icon i,
.cat-sub-menu a.active .icon i {
    animation: iconPulse 2s ease-in-out infinite;
}

/* Show category button active state */
.show-cat-btn.active {
    background: rgba(255, 255, 255, 0.25) !important;
    font-weight: 600;
    color: #ffffff !important;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.2),
        inset 0 0 0 1px rgba(255, 255, 255, 0.4);
    transform: translateX(4px);
}

.show-cat-btn.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background: linear-gradient(180deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
    border-radius: 0 4px 4px 0;
    box-shadow: 
        2px 0 10px rgba(255, 255, 255, 0.6),
        0 0 20px rgba(255, 255, 255, 0.3);
}

.show-cat-btn.active .icon {
    color: #fff !important;
    transform: scale(1.15);
}

/* Hover state - subtle enhancement */
.sidebar-body-menu a:hover:not(.active),
.cat-sub-menu a:hover:not(.active) {
    background: rgba(255, 255, 255, 0.12) !important;
    transform: translateX(2px);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
}

/* Submenu active indication */
.cat-sub-menu {
    position: relative;
    padding-left: 8px;
}

.cat-sub-menu::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 2px;
}

.cat-sub-menu a {
    padding-left: 45px !important;
}

/* Animations */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
        box-shadow: 
            2px 0 10px rgba(255, 255, 255, 0.6),
            0 0 20px rgba(255, 255, 255, 0.3);
    }
    50% {
        opacity: 0.85;
        box-shadow: 
            2px 0 15px rgba(255, 255, 255, 0.8),
            0 0 25px rgba(255, 255, 255, 0.5);
    }
}

@keyframes iconPulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.08);
    }
}

/* Focus state for accessibility */
.sidebar-body-menu a:focus,
.cat-sub-menu a:focus {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

/* Active with gradient background variant */
.sidebar-body-menu a.active,
.show-cat-btn.active {
    background: linear-gradient(
        90deg, 
        rgba(255, 255, 255, 0.3) 0%, 
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.15) 100%
    ) !important;
}
.sidebar-body-menu a:hover:not(.active),
.cat-sub-menu a:hover:not(.active),
.show-cat-btn:hover:not(.active){
    padding-left: 16px; /* adjust: 14px to 20px */
}

/* Keep submenu indentation but still add a little space on hover */
.cat-sub-menu a:hover:not(.active){
    padding-left: 52px !important; /* was 45px, adds +7px */
}

/* Optional: ensure icon has breathing room from the left edge */
.sidebar-body-menu a .icon,
.cat-sub-menu a .icon{
    margin-left: 6px;
}

/* If your template makes links inline, this helps padding apply cleanly */
.sidebar-body-menu a,
.cat-sub-menu a,
.show-cat-btn{
    display: flex;
    align-items: center;
    gap: 10px; /* space between icon and text */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Keep icon flex-shrink so it never gets squished */
.sidebar-body-menu a .icon,
.cat-sub-menu a .icon,
.show-cat-btn .icon {
    flex-shrink: 0;
}

/* Shrink font slightly for long labels only, keeps them readable */
.sidebar-body-menu a,
.cat-sub-menu a {
    font-size: 0.875rem;
}

/* ============================================
   LIGHT SIDEBAR CONTRAST ADJUSTMENTS
   ============================================ */

/* Light sidebar scrollbar styling */
.sidebar.sidebar--light .sidebar-body::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.25);
}

.sidebar.sidebar--light .sidebar-body::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.4);
}

/* Dark text for light backgrounds */
.sidebar.sidebar--light .sidebar-body-menu a,
.sidebar.sidebar--light .cat-sub-menu a,
.sidebar.sidebar--light .show-cat-btn {
    color: #333333 !important;
}

/* Light background active state with dark text */
.sidebar.sidebar--light .sidebar-body-menu a.active,
.sidebar.sidebar--light .cat-sub-menu a.active {
    background: rgba(0, 0, 0, 0.12) !important;
    color: #1a1a1a !important;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.15),
        inset 0 0 0 1px rgba(0, 0, 0, 0.2);
}

/* Dark accent border for light sidebar active state */
.sidebar.sidebar--light .sidebar-body-menu a.active::before,
.sidebar.sidebar--light .cat-sub-menu a.active::before {
    background: linear-gradient(180deg, #333333 0%, rgba(51, 51, 51, 0.8) 100%);
    box-shadow: 
        2px 0 10px rgba(0, 0, 0, 0.25),
        0 0 20px rgba(0, 0, 0, 0.15);
}

/* Dark gradient for light sidebar active state */
.sidebar.sidebar--light .sidebar-body-menu a.active::after,
.sidebar.sidebar--light .cat-sub-menu a.active::after {
    background: linear-gradient(180deg, 
        transparent 0%, 
        rgba(0, 0, 0, 0.3) 50%, 
        transparent 100%);
}

/* Dark text for active icons in light sidebar */
.sidebar.sidebar--light .sidebar-body-menu a.active .icon,
.sidebar.sidebar--light .cat-sub-menu a.active .icon {
    color: #333333 !important;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
}

/* Light sidebar show category button active state */
.sidebar.sidebar--light .show-cat-btn.active {
    background: rgba(0, 0, 0, 0.12) !important;
    color: #1a1a1a !important;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.15),
        inset 0 0 0 1px rgba(0, 0, 0, 0.2);
}

.sidebar.sidebar--light .show-cat-btn.active::before {
    background: linear-gradient(180deg, #333333 0%, rgba(51, 51, 51, 0.8) 100%);
    box-shadow: 
        2px 0 10px rgba(0, 0, 0, 0.25),
        0 0 20px rgba(0, 0, 0, 0.15);
}

.sidebar.sidebar--light .show-cat-btn.active .icon {
    color: #333333 !important;
}

/* Hover state for light sidebar */
.sidebar.sidebar--light .sidebar-body-menu a:hover:not(.active),
.sidebar.sidebar--light .cat-sub-menu a:hover:not(.active) {
    background: rgba(0, 0, 0, 0.08) !important;
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.15);
}

/* Submenu vertical line for light sidebar */
.sidebar.sidebar--light .cat-sub-menu::before {
    background: rgba(0, 0, 0, 0.15);
}

/* Focus state for light sidebar */
.sidebar.sidebar--light .sidebar-body-menu a:focus,
.sidebar.sidebar--light .cat-sub-menu a:focus {
    outline: 2px solid rgba(0, 0, 0, 0.3);
    outline-offset: 2px;
}

/* Logo text color for light sidebar */
.sidebar.sidebar--light .logo-text .logo-title {
    color: #333333 !important;
}

/* System menu title for light sidebar */
.sidebar.sidebar--light .system-menu__title {
    color: rgba(0, 0, 0, 0.5) !important;
}

/* Light mode active state gradient */
.sidebar.sidebar--light .sidebar-body-menu a.active,
.sidebar.sidebar--light .show-cat-btn.active {
    background: linear-gradient(
        90deg, 
        rgba(0, 0, 0, 0.15) 0%, 
        rgba(0, 0, 0, 0.1) 50%,
        rgba(0, 0, 0, 0.08) 100%
    ) !important;
}
</style>

<aside class="sidebar" data-theme="{{ $themeColor }}">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('subadmin.dashboard') }}" class="logo-wrapper">
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
                    <a class="{{ Request::routeIs('subadmin.dashboard') ? 'active' : '' }}" href="{{ route('subadmin.dashboard') }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">Personal</span>

<ul class="sidebar-body-menu">
    <li>
        <a class="{{ Request::routeIs('subadmin.profile') ? 'active' : '' }}" href="{{ route('subadmin.profile') }}">
            <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
        </a>
    </li>

    @php
        // Only active for "My" services, NOT for "Complaints Records"
        $servicesActive = Request::routeIs(
            'subadmin.subadminCertificate*',
            'subadmin.complaint'
        );
    @endphp

    <li>
    <a class="show-cat-btn {{ $servicesActive ? 'active' : '' }}" href="javascript:void(0)">
         E-Barangay Services
        <span class="category__btn transparent-btn" title="Open list">
            <span class="sr-only">Open list</span>
            <span class="icon arrow-down" aria-hidden="true"></span>
        </span>
    </a>
    <ul class="cat-sub-menu {{ $servicesActive ? 'visible' : '' }}">
        <li>
            <a class="{{ Request::routeIs('subadmin.subadminCertificate*') ? 'active' : '' }}" href="{{ route('subadmin.subadminCertificate') }}">
                <span class="icon"><i class="fa-solid fa-file-lines"></i></span>My Certificates
            </a>
        </li>
        <li>
            <a class="{{ Request::routeIs('subadmin.complaint') ? 'active' : '' }}" href="{{ route('subadmin.complaint') }}">
                <span class="icon"><i class="fa-solid fa-comments"></i></span>My Complaints
            </a>
        </li>
    </ul>
</li>
</ul>

<span class="system-menu__title">Manage System</span>

<ul class="sidebar-body-menu">
    <li>
        <a class="{{ Request::routeIs('subadmin.announcements') ? 'active' : '' }}" href="{{ route('subadmin.announcements') }}">
            <span class="icon"><i class="fa-solid fa-bullhorn"></i></span>Announcements
        </a>
    </li>
    <li>
        <a class="{{ Request::routeIs('subadmin.complaintRequest') ? 'active' : '' }}" href="{{ route('subadmin.complaintRequest') }}">
                                    <span class="icon"><i class="fa-solid fa-comments"></i></span> Complaints Records
        </a>
    </li>
    <li>
        <a class="{{ Request::routeIs('subadmin.aboutus') ? 'active' : '' }}" href="{{ route('subadmin.aboutus') }}">
            <span class="icon"><i class="fa-solid fa-circle-info"></i></span>About Us
        </a>
    </li>
    <li>
        <a class="{{ Request::routeIs('subadmin.contactus') ? 'active' : '' }}" href="{{ route('subadmin.contactus') }}">
            <span class="icon"><i class="fa-solid fa-address-book"></i></span>Contact Us
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

    // Auto-open active submenu on load
    const activeItem = document.querySelector('.sidebar .active');
    if (activeItem) {
        const submenu = activeItem.closest('.cat-sub-menu');
        if (submenu) {
            submenu.classList.add('visible');
            const toggle = submenu.previousElementSibling;
            if (toggle && toggle.classList.contains('show-cat-btn')) {
                toggle.classList.add('active');
            }
        }

        // Scroll active item into view
        const sidebarBody = document.querySelector('.sidebar-body');
        if (sidebarBody) {
            setTimeout(function() {
                const activeRect = activeItem.getBoundingClientRect();
                const bodyRect = sidebarBody.getBoundingClientRect();
                const offset = activeRect.top - bodyRect.top - (bodyRect.height / 2) + (activeRect.height / 2);
                
                sidebarBody.scrollTo({
                    top: sidebarBody.scrollTop + offset,
                    behavior: 'smooth'
                });
            }, 100);
        }
    }
});
</script>

