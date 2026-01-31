
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
    .main-wrapper { background-color: #f8f9fa; min-height: 100vh; }
    .page-title { font-family: 'Orbitron', sans-serif; font-weight: 700; color: #1e293b; }
    
    .street-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: #ffffff;
        cursor: pointer;
    }
    
    .street-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-label { font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; }

    /* Modal Styles */
    .modal-header {
        background: #0d6efd;
        color: white;
        border-radius: 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-title {
        font-family: 'Orbitron', sans-serif;
        font-weight: 700;
    }

    .modal-body {
        padding: 0;
        max-height: 70vh;
        overflow-y: auto;
    }

    /* House Card Styles */
    .house-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        margin: 15px;
        transition: all 0.3s ease;
        background: white;
        cursor: pointer;
    }

    .house-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
        transform: translateX(5px);
    }

    .house-card.active {
        border-color: #0d6efd;
        background: #f8f9ff;
    }

    .house-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .house-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .house-icon {
        width: 40px;
        height: 40px;
        background: #0d6efd;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .household-badge {
        background: #0d6efd;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .expand-icon {
        transition: transform 0.3s ease;
        color: #0d6efd;
        font-size: 1.1rem;
    }

    .expand-icon.rotated {
        transform: rotate(180deg);
    }

    /* Household Heads Section */
    .heads-section {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #e9ecef;
        display: none;
    }

    .heads-section.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        color: #1e293b;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.12);
    }

    .glass-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .glass-title {
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .glass-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #475569;
        font-size: 0.9rem;
        flex-wrap: wrap;
    }

    .glass-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(13, 110, 253, 0.3);
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
    }

    .glass-avatar-fallback {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(13, 110, 253, 0.25);
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 10px 0 12px;
    }

    .loading-spinner {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }

    .no-data-message {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
        font-style: italic;
    }

    .view-houses-btn {
        cursor: pointer;
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
        <div class="container-fluid px-4">
            
             <div class="d-flex justify-content-between align-items-center">
  <h2 style="color:#000000; margin: 20px 45px;">Household Management</h2>
  

</div>

            <div class="row g-4">
                @foreach ($street as $streets)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card street-card h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box">
                                    <i class="fas fa-road"></i>
                                </div>
                               
                            </div>
                            
                            <h5 class="card-title fw-bold mb-1">{{ $streets->street_name }}</h5>
                            <div class="mb-4">
                                <span class="stat-label d-block">Total Houses</span>
                                <span class="stat-value">{{ $streets->houses_count }}</span>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-outline-primary btn-sm view-houses-btn" 
                                    data-street-id="{{ $streets->id }}"
                                    data-street-name="{{ $streets->street_name }}">
                                    View Houses <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </main>
</div>
</div> 

<!-- Houses Modal -->
<div class="modal fade" id="housesModal" tabindex="-1" aria-labelledby="housesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="housesModalLabel">
                    <i class="fas fa-home me-2"></i>
                    <span id="streetNameDisplay">Houses</span>
                </h5>
                <div class="ms-3 flex-grow-1">
                    <input type="text" class="form-control form-control-sm" id="houseSearchInput" placeholder="Search house number...">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="housesModalBody">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-3">Loading houses...</p>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const housesModal = new bootstrap.Modal(document.getElementById('housesModal'));

    function toTitleCase(value) {
        return (value || '')
            .toLowerCase()
            .replace(/\b\w/g, function(letter) { return letter.toUpperCase(); })
            .trim();
    }

    function getProfileUrl(path) {
        if (!path) return null;
        if (path.startsWith('http') || path.startsWith('/')) return path;
        return `/storage/${path}`;
    }

    function renderAvatar(resident, iconClass) {
        const url = getProfileUrl(resident.image_path);
        if (url) {
            return `<img class="glass-avatar" src="${url}" alt="Profile">`;
        }
        return `<span class="glass-avatar-fallback"><i class="fas ${iconClass}"></i></span>`;
    }

    // Handle "View Houses" button click
    $('.view-houses-btn').click(function() {
        const streetId = $(this).data('street-id');
        const streetName = $(this).data('street-name');
        
        // Update modal title
        $('#streetNameDisplay').text(streetName + ' - Houses');
        
        // Reset search and show modal with loading state
        $('#houseSearchInput').val('');
        $('#housesModalBody').html(`
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-3">Loading houses...</p>
            </div>
        `);
        housesModal.show();
        
        // Load houses
        loadHouses(streetId);
    });

    // Load houses for a street
    function loadHouses(streetId) {
        $.ajax({
            url: `/admin/households/streets/${streetId}`,
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success && response.houses && response.houses.length > 0) {
                    displayHouses(response.houses);
                } else {
                    $('#housesModalBody').html(`
                        <div class="no-data-message">
                            <i class="fas fa-home fa-3x mb-3"></i>
                            <p>No houses found for this street</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading houses:', error);
                $('#housesModalBody').html(`
                    <div class="no-data-message">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3 text-danger"></i>
                        <p>Failed to load houses. Please try again.</p>
                    </div>
                `);
            }
        });
    }

    // Display houses in modal
    function displayHouses(houses) {
        let html = '';
        
        houses.forEach(house => {
            const householdCount = house.households_count || 0;
            html += `
                <div class="house-card" data-house-id="${house.id}" data-house-no="${house.house_no}">
                    <div class="house-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="house-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="house-number">
                                House ${house.house_no}
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="household-badge">
                                ${householdCount} Household${householdCount !== 1 ? 's' : ''}
                            </span>
                            <i class="fas fa-chevron-down expand-icon"></i>
                        </div>
                    </div>
                    <div class="heads-section" id="heads-${house.id}">
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                            <p class="mt-2 mb-0">Loading household heads...</p>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#housesModalBody').html(html);

        // Apply current search filter if any
        filterHouses($('#houseSearchInput').val());
        
        // Add click handlers to house cards
        $('.house-card').click(function(e) {
            e.stopPropagation();
            const houseId = $(this).data('house-id');
            const headsSection = $('#heads-' + houseId);
            const expandIcon = $(this).find('.expand-icon');
            
            // Toggle active state
            $(this).toggleClass('active');
            expandIcon.toggleClass('rotated');
            
            // Toggle heads section
            if (headsSection.hasClass('show')) {
                headsSection.removeClass('show');
            } else {
                // Close other open sections
                $('.heads-section.show').removeClass('show');
                $('.house-card.active').not(this).removeClass('active');
                $('.expand-icon.rotated').not(expandIcon).removeClass('rotated');
                
                // Load heads if not already loaded
                if (!headsSection.data('loaded')) {
                    loadHouseholdHeads(houseId);
                } else {
                    headsSection.addClass('show');
                }
            }
        });
    }

    // Filter houses in modal by house number
    function filterHouses(query) {
        const term = (query || '').toString().trim().toLowerCase();
        if (!term) {
            $('.house-card').show();
            return;
        }
        $('.house-card').each(function() {
            const houseNo = ($(this).data('house-no') || '').toString().toLowerCase();
            $(this).toggle(houseNo.includes(term));
        });
    }

    // Search input handler
    $('#houseSearchInput').on('input', function() {
        filterHouses($(this).val());
    });

    // Load household heads for a house
    function loadHouseholdHeads(houseId) {
        const headsSection = $('#heads-' + houseId);
        
        $.ajax({
            url: `/admin/households/houses/${houseId}`,
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    displayHouseholdHeads(houseId, response.heads || [], response.members || []);
                } else {
                    headsSection.html(`
                        <div class="no-data-message">
                            <p class="mb-0">No household heads found</p>
                        </div>
                    `);
                    headsSection.addClass('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading household heads:', error);
                headsSection.html(`
                    <div class="no-data-message">
                        <p class="mb-0 text-danger">Failed to load household heads</p>
                    </div>
                `);
                headsSection.addClass('show');
            }
        });
    }

    // Display household heads
    function displayHouseholdHeads(houseId, heads, members) {
        const headsSection = $('#heads-' + houseId);

        const safeHeads = heads || [];
        const safeMembers = members || [];
        let html = '<div class="px-2">';

        html += '<div class="section-title">Household Head(s)</div>';
        if (safeHeads.length === 0) {
            html += `
                <div class="no-data-message">
                    <i class="fas fa-user-times mb-2"></i>
                    <p class="mb-0">No household head assigned</p>
                </div>
            `;
        } else {
            safeHeads.forEach(head => {
                const resident = head.resident || {};
                const firstName = toTitleCase(resident.firstName);
                const middleName = toTitleCase(resident.middleName);
                const lastName = toTitleCase(resident.lastName);
                const fullName = [firstName, middleName, lastName].filter(Boolean).join(' ') || 'N/A';
                const contact = resident.contactNo || 'N/A';
                const age = resident.age || 'N/A';
                const sex = toTitleCase(resident.sex);
                const birthday = resident.birthday || 'N/A';

                html += `
                    <div class="glass-card">
                        <div class="glass-header">
                            <div class="glass-title">
                                ${renderAvatar(resident, 'fa-user-circle')}
                                <span>${fullName}</span>
                            </div>
                            <div class="glass-meta">
                                <span><i class="fas fa-phone"></i> ${contact}</span>
                                <span><i class="fas fa-venus-mars"></i> ${sex}</span>
                                <span><i class="fas fa-id-card"></i> ${age}</span>
                                <span><i class="fas fa-cake-candles"></i> ${birthday}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        html += '<div class="section-title">Members Tagged</div>';
        if (safeMembers.length === 0) {
            html += `
                <div class="no-data-message">
                    <i class="fas fa-users mb-2"></i>
                    <p class="mb-0">No members tagged</p>
                </div>
            `;
        } else {
            safeMembers.forEach(member => {
                const resident = member.resident || {};
                const firstName = toTitleCase(resident.firstName);
                const middleName = toTitleCase(resident.middleName);
                const lastName = toTitleCase(resident.lastName);
                const fullName = [firstName, middleName, lastName].filter(Boolean).join(' ') || 'N/A';
                const contact = resident.contactNo || 'N/A';
                const age = resident.age || 'N/A';
                const sex = toTitleCase(resident.sex);
                const birthday = resident.birthday || 'N/A';

                html += `
                    <div class="glass-card">
                        <div class="glass-header">
                            <div class="glass-title">
                                ${renderAvatar(resident, 'fa-user')}
                                <span>${fullName}</span>
                            </div>
                            <div class="glass-meta">
                                <span><i class="fas fa-phone"></i> ${contact}</span>
                                <span><i class="fas fa-venus-mars"></i> ${sex}</span>
                                <span><i class="fas fa-id-card"></i> ${age}</span>
                                <span><i class="fas fa-cake-candles"></i> ${birthday}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        html += '</div>';
        headsSection.html(html);
        
        headsSection.addClass('show');
        headsSection.data('loaded', true);
    }
});
</script>


