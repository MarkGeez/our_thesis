<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('admin.dashboard') }}" class="logo-wrapper">
                <span class="sr-only">Home</span>
                <span class="icon logo">
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
                    <a class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">Personal</span>

            <ul class="sidebar-body-menu">

                <li>
                    <a class="{{ Request::routeIs('admin.profile') ? 'active' : '' }}"
                       href="{{ route('admin.profile') }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>

                @php
    $servicesActive = Request::routeIs(
        'admin.adminBlotter*',
        'admin.adminCertificate*',
        'admin.adminServices*',
        'admin.adminComplaint*',
        
    );
@endphp
                <li>
                    <!-- make this the toggle the script looks for and avoid malformed blade syntax -->
                    <a class="show-cat-btn" href="#">
                         E-Barangay Services
                         <span class="category__btn transparent-btn" title="Open list">
                             <span class="sr-only">Open list</span>
                             <span class="icon arrow-down" aria-hidden="true"></span>
                         </span>
                     </a>
                     <ul class="cat-sub-menu">
                        <li>
                           <a class="{{ Request::routeIs('admin.adminBlotter*') ? 'active' : '' }}" href="{{ route('admin.adminBlotter') }}">
                                <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter
                            </a>

                        </li>
                        <li>
                           <a class="{{ Request::routeIs('admin.adminCertificate*') ? 'active' : '' }}"
                       href="{{ route('admin.adminCertificate') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></i></span>Documents
                    </a>

                    </a>
                        </li>
                        <li>
                           <a class="{{ Request::routeIs('admin.adminServices*') ? 'active' : '' }}"
                       href="{{ route('admin.adminServices') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></i></span>Services
                    </a>

                    </a>
                        </li>
                        <li>
                           <a class="{{ Request::routeIs('admin.adminComplaint*') ? 'active' : '' }}"
                       href="{{ route('admin.adminComplaint') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></i></span>Complaints
                    </a>
                    </ul>
                </li>
                <span class="system-menu__title">manage system</span>
                <li>
                    <a class="{{ Request::routeIs('admin.create-announcement') ? 'active' : '' }}"
                       href="{{ route('admin.create-announcement') }}">
                        <span class="icon"><i class="fa-solid fa-bullhorn"></i></i></span>Announcements
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.census') ? 'active' : '' }}"
                       href="{{ route('admin.census') }}">
                        <span class="icon"><i class="fa-solid fa-address-book"></i></i></span>Census
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.users') ? 'active' : '' }}"
                       href="{{ route('admin.users') }}">
                        <span class="icon"><i class="fa-solid fa-users"></i></i></span>Users
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.barangay-officials') ? 'active' : '' }}"
                       href="{{ route('admin.barangayOfficials') }}">
                        <span class="icon"><i class="fa-solid fa-users-cog"></i></i></span>Officials
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.blotterRequest') ? 'active' : '' }}"
                       href="{{ route('admin.blotterRequest' )}}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.certificateRequest') ? 'active' : '' }}"
                       href="{{ route('admin.certificateRequest') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></span>Document Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.serviceRequest') ? 'active' : '' }}"
                       href="{{ route('admin.serviceRequest') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Service Requests
                    </a>
                </li>
                 <li>
                    <a class="{{ Request::routeIs('admin.complaintRequest') ? 'active' : '' }}"
                       href="{{ route('admin.complaintRequest') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaints
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.reports') ? 'active' : '' }}"
                       href="{{ route('admin.reports') }}">
                        <span class="icon"><i class="fa-solid fa-clipboard-list"></i></i></span>Reports
                    </a>
                </li>

               

                <li>
                    <a class="{{ Request::routeIs('admin.feedbackRequest') ? 'active' : '' }}"
                       href="{{ route('admin.feedbackRequest') }}">
                        <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>Feedback
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.activityLogs') ? 'active' : '' }}"
                       href="{{ route('admin.activityLogs') }}">
                        <span class="icon"><i class="fa-solid fa-history"></i></span>Activity Logs
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.settings') ? 'active' : '' }}"
                       href="{{ route('admin.settings') }}">
                        <span class="icon"><i class="fa-solid fa-gear"></i></span>Settings
                    </a>
                </li>

                
            </ul>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const active = document.querySelector('.sidebar .active');
    if (!active) return;

    // ensure parent submenu is open
    const submenu = active.closest('.cat-sub-menu');
    if (submenu) {
        submenu.style.display = 'block';
        const toggle = submenu.previousElementSibling;
        if (toggle) toggle.classList.add('active');
    }

    // scroll active item into view (center)
    try {
        active.scrollIntoView({ behavior: 'auto', block: 'center' });
    } catch (e) { /* ignore */ }
});
</script>
