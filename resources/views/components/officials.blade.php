<link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">

<style>
<<<<<<< HEAD
.sidebar{
    background: {{ \App\Models\Setting::get('theme', '#0061f7') }} !important;
    height: 100vh;
    overflow: hidden;
=======
    
  .resident-dropdown {
    position: absolute;
    width: 100%;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-top: 4px;
    z-index: 1000;
    max-height: 240px;
    overflow-y: auto;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  }

  .resident-option {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 0.9rem;
  }

  .resident-option:hover {
    background: #f1f5f9;
  }

  .official-card {
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
>>>>>>> 9ea40ac5cf61fb52008b8b0fb38abf0df1b62142
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
    background: {{ \App\Models\Setting::get('theme', '#0061f7') }} !important;
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

/* optional: smoother scrolling */
.sidebar-body{
    scroll-behavior: smooth;
}

/* optional: cleaner scrollbar */
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
    padding-left: 12px;
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

<<<<<<< HEAD
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
.sidebar-body-menu a.active {
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
=======
  .search-help {
    font-size: 0.8rem;
    color: #94a3b8;
  }
  .input-group-text{
    background-color:#f1f3f5;
    border:1.5px solid #ced4da;
    cursor:pointer;
}
input[type="date"]::-webkit-calendar-picker-indicator{
    opacity:1;
    cursor:pointer;
}

/* keeps the date field aligned and full width inside input-group */
.input-group > .form-control[type="date"]{
    flex:1 1 auto;
    width:1%;
    min-width:0;
    font-size: 0.9rem
>>>>>>> 9ea40ac5cf61fb52008b8b0fb38abf0df1b62142
}
</style>


<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="{{ route('admin.dashboard') }}" class="logo-wrapper">
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

<<<<<<< HEAD
            <button class="sidebar-toggle transparent-btn" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle"></span>
            </button>
=======
                <div class="official-card-body">
                    <div class="avatar-ring">
                        <img src="{{ $avatar }}" alt="Official Photo" class="official-avatar">
                    </div>
                    <div class="flex-grow-1">
                        @if($resident)
                            <p class="official-name mb-1">{{ ucwords(strtolower($resident->firstName.' '.$resident->lastName)) }}</p>
                        @elseif($showControls)
                            <p class="official-name mb-1">No resident assigned</p>
                        @endif

                        <p class="official-meta mb-0">
                            @if($official && $official->start && $official->end)
                                Term: {{ date('M d, Y', strtotime($official->start)) }} - {{ date('M d, Y', strtotime($official->end)) }}
                            @elseif($official)
                                Term dates not set yet.
                            @elseif($showControls)
                                Tag a resident to display in this slot.
                            @endif
                        </p>

                        @if($official && $official->details)
                            <p class="official-meta mb-0">Notes: {{ $official->details }}</p>
                        @endif
                    </div>
                </div>

                @if($showControls)
                    <div class="official-card-actions">
                        <p class="official-action-title mb-2">Assign / Update Resident</p>
                        <form method="POST" action="{{ route('admin.assign.official') }}" class="row g-2 official-assign-form">
                            @csrf
                            <input type="hidden" name="position" value="{{ $slot }}">

                            <div class="col-12 position-relative">
    <label class="form-label">Search Resident</label>
    <div class="input-group">
        <input type="text"
            class="form-control resident-search-input"
            placeholder="Type name then Enter or Search"
            autocomplete="off"
            value="{{ $resident ? ucwords(strtolower($resident->lastName)).', '.ucwords(strtolower($resident->firstName)) : '' }}">
        
        <button type="button" class="btn btn-outline-primary resident-search-btn">
            <i class="fa fa-search"></i>
        </button>
    </div>

    <input type="hidden"
        name="resident_id"
        class="resident-id-input"
        value="{{ $official->resident_id ?? '' }}">

    <div class="resident-dropdown d-none"></div>
    <small class="search-help">Click search to see matching residents.</small>
</div>

                            <div class="col-12">
                                <label class="form-label">Term / Notes</label>
                                <input type="text" name="details" class="form-control" placeholder="e.g. 2024-2027 term" value="{{ $official ? $official->details : '' }}">
                            </div>

                           <div class="col-12">
    <label class="form-label">Start Date</label>
    <div class="input-group mb-3 w-100">
        <input
            type="date"
            name="start"
            class="form-control form-control-lg official-start-date"
            value="{{ $official ? $official->start : now()->toDateString() }}"
            data-raw="{{ old('start', $official ? $official->start : now()->toDateString()) }}"
            required
        >
        <span class="input-group-text official-start-open">
            <i class="fa fa-calendar"></i>
        </span>
    </div>

    <label class="form-label">End Date</label>
    <div class="input-group w-100">
        <input
            type="date"
            name="end"
            class="form-control form-control-lg official-end-date"
            value="{{ $official ? $official->end : now()->copy()->addYears(3)->toDateString() }}"
            data-raw="{{ old('end', $official ? $official->end : now()->copy()->addYears(3)->toDateString()) }}"
            required
        >
        <span class="input-group-text official-end-open">
            <i class="fa fa-calendar"></i>
        </span>
    </div>
</div>



                            <div class="col-12 d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fa fa-save me-1"></i> Save Assignment
                                </button>
                            </div>
                        </form>

                        @if($official)
                            <form method="POST" action="{{ route('admin.untag.official', $official->id) }}" class="mt-2" onsubmit="return confirm('Remove the resident from this position?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fa fa-times me-1"></i> Clear Assignment
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
>>>>>>> 9ea40ac5cf61fb52008b8b0fb38abf0df1b62142
        </div>

<<<<<<< HEAD

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
                        'admin.blotter.*',
                        'admin.adminCertificate*',
                        'admin.adminServices*',
                        'admin.adminComplaint*'
                    );
                @endphp
                <li>
                    <a class="show-cat-btn {{ $servicesActive ? 'active' : '' }}" href="#">
                         E-Barangay Services
                         <span class="category__btn transparent-btn" title="Open list">
                             <span class="sr-only">Open list</span>
                             <span class="icon arrow-down" aria-hidden="true"></span>
                         </span>
                     </a>
                     <ul class="cat-sub-menu">
                        
                        <li>
                           <a class="{{ Request::routeIs('admin.adminCertificate*') ? 'active' : '' }}"
                               href="{{ route('admin.adminCertificate') }}">
                                <span class="icon"><i class="fa-solid fa-file-lines"></i></span>My Documents
                            </a>
                        </li>
                        <li>
                           <a class="{{ Request::routeIs('admin.adminComplaint*') ? 'active' : '' }}"
                               href="{{ route('admin.adminComplaint') }}">
                                <span class="icon"><i class="fa-solid fa-comments"></i></span>My Complaints 
                            </a>
                        </li>
                    </ul>
                </li>
                <span class="system-menu__title">manage system</span>
                <li>
                    <a class="{{ Request::routeIs('admin.announcements') ? 'active' : '' }}"
                       href="{{ route('admin.announcements') }}">
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
                    <a class="{{ Request::routeIs('admin.residents') ? 'active' : '' }}"
                       href="{{ route('admin.residents') }}">
                        <span class="icon"><i class="fa-solid fa-users"></i></i></span>Residents
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.household') ? 'active' : '' }}"
                       href="{{ route('admin.household') }}">
                        <span class="icon"><i class="fa-solid fa-house-user"></i></span>Household
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.users') ? 'active' : '' }}"
                       href="{{ route('admin.users') }}">
                        <span class="icon"><i class="fa-solid fa-users"></i></i></span>Users
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.barangayOfficials') ? 'active' : '' }}"
                       href="{{ route('admin.barangayOfficials') }}">
                        <span class="icon"><i class="fa-solid fa-users-cog"></i></i></span>Officials
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.blotter.*') ? 'active' : '' }}" href="{{ route('admin.blotter.index') }}">
                        <span class="icon"><i class="fa-solid fa-file-circle-exclamation"></i></span>Manage Blotters
                    </a>
                </li>
                <li>
                    <a class="{{ Request::routeIs('admin.certificateRequest') ? 'active' : '' }}"
                       href="{{ route('admin.certificateRequest') }}">
                        <span class="icon"><i class="fa-solid fa-file-lines"></i></span>Document Requests
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.complaintRequest') ? 'active' : '' }}"
                       href="{{ route('admin.complaintRequest') }}">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>Complaints Records
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.reports') ? 'active' : '' }}"
                       href="{{ route('admin.reports') }}">
                        <span class="icon"><i class="fa-solid fa-clipboard-list"></i></i></span>Reports
                    </a>
                </li>

                <li>
                    <a class="{{ Request::routeIs('admin.archives') ? 'active' : '' }}"
                       href="{{ route('admin.archives') }}">
                        <span class="icon"><i class="fa-solid fa-box-archive"></i></span>Archives
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

    // scroll active item into view within sidebar-body only
    const sidebarBody = document.querySelector('.sidebar-body');
    if (sidebarBody && active) {
        // Small delay to ensure DOM is fully rendered
        setTimeout(function() {
            const activeRect = active.getBoundingClientRect();
            const bodyRect = sidebarBody.getBoundingClientRect();
            
            // Calculate scroll position to center the active item in sidebar-body
            const offset = activeRect.top - bodyRect.top - (bodyRect.height / 2) + (activeRect.height / 2);
            
            sidebarBody.scrollTo({
                top: sidebarBody.scrollTop + offset,
                behavior: 'smooth'
            });
        }, 100);
    }
});
</script>
=======
@if($showControls)
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const residents = @json($residents);

    document.querySelectorAll('.official-assign-form').forEach(function (form) {
        const searchInput = form.querySelector('.resident-search-input');
        const searchBtn = form.querySelector('.resident-search-btn');
        const hiddenInput = form.querySelector('.resident-id-input');
        const dropdown = form.querySelector('.resident-dropdown');

        // DATE INPUTS (same behavior as users.blade)
        const startInput = form.querySelector('.official-start-date');
        const startOpen = form.querySelector('.official-start-open');
        const endInput = form.querySelector('.official-end-date');
        const endOpen = form.querySelector('.official-end-open');

        function normalizeToYmd(raw) {
            if (!raw) return '';
            const d = new Date(raw);
            if (isNaN(d)) return '';
            return d.getFullYear() + '-' +
                String(d.getMonth() + 1).padStart(2, '0') + '-' +
                String(d.getDate()).padStart(2, '0');
        }

        if (startInput) {
            const rawStart = startInput.getAttribute('data-raw') || startInput.value;
            const formattedStart = normalizeToYmd(rawStart);
            if (formattedStart) startInput.value = formattedStart;
        }

        if (endInput) {
            const rawEnd = endInput.getAttribute('data-raw') || endInput.value;
            const formattedEnd = normalizeToYmd(rawEnd);
            if (formattedEnd) endInput.value = formattedEnd;
        }

        function openPicker(inputEl) {
            if (!inputEl) return;
            if (inputEl.showPicker) inputEl.showPicker();
            else inputEl.focus();
        }

        if (startOpen && startInput) {
            startOpen.addEventListener('click', function () {
                openPicker(startInput);
            });
        }

        if (endOpen && endInput) {
            endOpen.addEventListener('click', function () {
                openPicker(endInput);
            });
        }

        // your existing resident search code continues here...
        function closeDropdown() {
            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
        }

        function formatName(name) {
            if (!name) return '';
            return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
        }

        function runSearch() {
            const query = searchInput.value.toLowerCase().trim();
            dropdown.innerHTML = '';
            hiddenInput.value = '';

            if (!query) {
                closeDropdown();
                return;
            }

            const matches = residents.filter(function (person) {
                const fullName = (
                    person.lastName + ' ' +
                    person.firstName + ' ' +
                    (person.middleName ?? '')
                ).toLowerCase();
                return fullName.includes(query) || person.id.toString().includes(query);
            }).slice(0, 8);

            if (matches.length === 0) {
                closeDropdown();
                return;
            }

            matches.forEach(function (person) {
                const option = document.createElement('div');
                option.classList.add('resident-option');

                const last = formatName(person.lastName);
                const first = formatName(person.firstName);
                const middle = formatName(person.middleName);

                option.textContent = last + ', ' + first + (middle ? ' ' + middle : '') + ' (ID: ' + person.id + ')';

                option.addEventListener('click', function () {
                    searchInput.value = option.textContent;
                    hiddenInput.value = person.id;
                    closeDropdown();
                });

                dropdown.appendChild(option);
            });

            dropdown.classList.remove('d-none');
        }

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                runSearch();
            }
        });

        searchBtn.addEventListener('click', function () {
            runSearch();
            searchInput.focus();
        });

        document.addEventListener('click', function (e) {
            if (!form.contains(e.target)) closeDropdown();
        });
    });
});
</script>
@endif
>>>>>>> 9ea40ac5cf61fb52008b8b0fb38abf0df1b62142
