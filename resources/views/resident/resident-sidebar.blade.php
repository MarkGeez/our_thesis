<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('resident.dashboard', ['id' => $resident->id]) }}" class="logo-wrapper">
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
                    <a class="{{ Request::routeIs('resident.dashboard') ? 'active' : '' }}"
                       href="{{ route('resident.dashboard', ['id' => $resident->id]) }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">system</span>

            <ul class="sidebar-body-menu">

                <li>
                    <a class="{{ Request::routeIs('resident.profile') ? 'active' : '' }}"
                       href="{{ route('resident.profile', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.announcement') ? 'active' : '' }}"
                       href="{{ route('resident.announcement', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-bullhorn"></i></span>Announcement
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.blotter') ? 'active' : '' }}"
                       href="{{ route('resident.blotter', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.certificate') ? 'active' : '' }}"
                       href="{{ route('resident.certificate', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></span>Certificate
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.service') ? 'active' : '' }}"
                       href="{{ route('resident.service', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Service
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.complaint') ? 'active' : '' }}"
                       href="{{ route('resident.complaint', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaint
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.feedback') ? 'active' : '' }}"
                       href="{{ route('resident.feedback', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>Feedback
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.contactus') ? 'active' : '' }}"
                       href="{{ route('resident.contactus', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>Contact Us
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('resident.aboutus') ? 'active' : '' }}"
                       href="{{ route('resident.aboutus', ['id' => $resident->id]) }}">
                        <span class="icon"><i class="fa-solid fa-circle-info"></i></span>About Us
                    </a>
                </li>

            </ul>
        </div>
    </div>
</aside>
