<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('subadmin.dashboard') }}" class="logo-wrapper">
                <span class="sr-only">Home</span>
                <span class="logo" aria-hidden="true">
                    <img src="{{ asset('template/img/brgy 249 Logo png.png') }}" alt="Brgy 249 Logo">
                </span>
                <div class="logo-text">
                    <span class="logo-title" style="font-family: 'Orbitron', sans-serif;">brgy249</span>
                    <span class="logo-subtitle">Dashboard</span>
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
                    $servicesActive = Request::routeIs(
                        'subadmin.subadminBlotter*',
                        'subadmin.subadminCertificate*',
                        'subadmin.subadminServices*',
                        'subadmin.complaint*'
                    );
                @endphp

                <li>
                    <a class="show-cat-btn {{ $servicesActive ? 'active' : '' }}" href="##">
                        <span class="icon"></span>E-Barangay Services
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ Request::routeIs('subadmin.subadminBlotter') ? 'active' : '' }}" href="{{ route('subadmin.subadminBlotter') }}">
                                <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>My Blotter
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('subadmin.subadminCertificate*') ? 'active' : '' }}" href="{{ route('subadmin.subadminCertificate') }}">
                                <span class="icon"><i class="fa-solid fa-file-lines"></i></span>My Documents
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('subadmin.subadminServices*') ? 'active' : '' }}" href="{{ route('subadmin.subadminServices') }}">
                                <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>My Services
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
                    <a class="{{ Request::routeIs('subadmin.blotterRequest') ? 'active' : '' }}" href="{{ route('subadmin.blotterRequest') }}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter Requests
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('subadmin.serviceRequest') ? 'active' : '' }}" href="{{ route('subadmin.serviceRequest') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Service Requests
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('subadmin.complaintRequest') ? 'active' : '' }}" href="{{ route('subadmin.complaintRequest') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaints Records
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const activeItem = document.querySelector('.sidebar .active');
    if (!activeItem) return;

    // ensure parent submenu is open if a child is active
    const submenu = activeItem.closest('.cat-sub-menu');
    if (submenu) {
        submenu.style.display = 'block';
        const toggle = submenu.previousElementSibling;
        if (toggle) toggle.classList.add('active');
    }

    // scroll active item into view
    try {
        activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } catch (e) { /* fallback for older browsers */ }
});
</script>