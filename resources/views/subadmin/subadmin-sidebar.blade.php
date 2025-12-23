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
                    <a class="{{ Request::routeIs('subadmin.dashboard') ? 'active' : '' }}"
                       href="{{ route('subadmin.dashboard') }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">Personal</span>

            <ul class="sidebar-body-menu">

                <li>
                    <a class="{{ Request::routeIs('subadmin.profile') ? 'active' : '' }}"
                       href="{{ route('subadmin.profile') }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>

                @php
    $servicesActive = Request::routeIs(
        'subadmin.adminBlotter*',
        
        'subadmin.adminServices*',
        'subadmin.adminComplaint*',
        
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
                           <a class="{{ Request::routeIs('subadmin.adminBlotter*') ? 'active' : '' }}" href="{{ route('subadmin.adminBlotter') }}">
                                <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>My Blotter
                            </a>

                        </li>
                        <li>
                           <a class="{{ Request::routeIs('subadmin.adminCertificate*') ? 'active' : '' }}"
                       href="{{ route('subadmin.adminCertificate') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></i></span>My Documents
                    </a>

                    </a>
                        </li>
                        <li>
                           <a class="{{ Request::routeIs('subadmin.adminServices*') ? 'active' : '' }}"
                       href="{{ route('subadmin.adminServices') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></i></span>My Services
                    </a>

                    </a>
                        </li>
                        <li>
                           <a class="{{ Request::routeIs('subadmin.adminComplaint*') ? 'active' : '' }}"
                       href="{{ route('subadmin.adminComplaint') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></i></span>My Complaints 
                    </a>
                    </ul>
                </li>
                <span class="system-menu__title">manage system</span>
                <li>
                    <a class="{{ Request::routeIs('subadmin.announcements') ? 'active' : '' }}"
                       href="{{ route('subadmin.announcements') }}">
                        <span class="icon"><i class="fa-solid fa-bullhorn"></i></i></span>Announcements
                    </a>
                </li>
                
                

                <li>
                    <a class="{{ Request::routeIs('subadmin.blotterRequest') ? 'active' : '' }}"
                       href="{{ route('subadmin.blotterRequest' )}}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter Requests
                    </a>
                </li>

            

                <li>
                    <a class="{{ Request::routeIs('subadmin.serviceRequest') ? 'active' : '' }}"
                       href="{{ route('subadmin.serviceRequest') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Service Requests
                    </a>
                </li>
                 <li>
                    <a class="{{ Request::routeIs('subadmin.complaintRequest') ? 'active' : '' }}"
                       href="{{ route('subadmin.complaintRequest') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaints Records
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
