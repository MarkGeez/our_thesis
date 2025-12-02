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

            <span class="system-menu__title">system</span>

            <ul class="sidebar-body-menu">

                <li>
                    <a class="{{ Request::routeIs('admin.profile') ? 'active' : '' }}"
                       href="{{ route('admin.profile') }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.create-announcement') ? 'active' : '' }}"
                       href="{{ route('admin.create-announcement') }}">
                        <span class="icon"><i class="fa-solid fa-bullhorn"></i></i></span>Announcements
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.blotter') ? 'active' : '' }}"
                       href="{{ route('admin.blotter' )}}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Blotter Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.certificate') ? 'active' : '' }}"
                       href="{{ route('admin.certificate') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></span>Document Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.service') ? 'active' : '' }}"
                       href="{{ route('admin.service') }}">
                        <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Service Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.complaint') ? 'active' : '' }}"
                       href="{{ route('admin.complaint') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaints
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.feedback') ? 'active' : '' }}"
                       href="{{ route('admin.feedback') }}">
                        <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>Feedback
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.feedback') ? 'active' : '' }}"
                       href="{{ route('admin.feedback') }}">
                        <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>Settings
                    </a>
                </li>

                
            </ul>
        </div>
    </div>
</aside>
