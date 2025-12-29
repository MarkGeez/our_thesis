<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('non-resident.dashboard') }}" class="logo-wrapper">
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
                    <a class="{{ Request::routeIs('non-resident.dashboard') ? 'active' : '' }}"
                       href="{{ route('non-resident.dashboard') }}">
                        <span class="icon home"></span>Dashboard
                    </a>
                </li>
            </ul>

            <span class="system-menu__title">system</span>

            <ul class="sidebar-body-menu">

                <li>
                    <a class="{{ Request::routeIs('non-resident.profile') ? 'active' : '' }}"
                       href="{{ route('non-resident.profile') }}">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>Profile
                    </a>
                </li>

                

                <li>
                    <a class="{{ Request::routeIs('non-resident.blotter') ? 'active' : '' }}"
                       href="{{ route('non-resident.blotter' )}}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>My Blotter
                    </a>
                </li>

                
                <li>
                    <a class="{{ Request::routeIs('non-resident.contactus') ? 'active' : '' }}"
                       href="{{ route('non-resident.contactus') }}">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>Contact Us
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('non-resident.aboutus') ? 'active' : '' }}"
                       href="{{ route('non-resident.aboutus') }}">
                        <span class="icon"><i class="fa-solid fa-circle-info"></i></span>About Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
