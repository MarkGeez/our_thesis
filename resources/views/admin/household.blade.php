<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('logo')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            width: 50px; height: 50px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }

        .stat-label { font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; }

        /* Modal Styles */
        .modal-header { background: #dbdbdb; color: white; border-radius: 0; }
        .modal-header .btn-close { filter: brightness(0) invert(1); }
        .modal-title { font-family: 'Bebas Neue', sans-serif; color: #333333; }
        .modal-body { padding: 0; max-height: 70vh; overflow-y: auto; }

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

        .house-card.active { border-color: #0d6efd; background: #f8f9ff; }
        .house-header { display: flex; justify-content: space-between; align-items: center; }
        .house-number { font-size: 1.2rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 10px; }

        .house-icon {
            width: 40px; height: 40px;
            background: #0d6efd; color: white;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .household-badge {
            background: #0d6efd; color: white;
            padding: 6px 14px; border-radius: 20px;
            font-size: 0.9rem; font-weight: 600;
        }

        .expand-icon { transition: transform 0.3s ease; color: #0d6efd; font-size: 1.1rem; }
        .expand-icon.rotated { transform: rotate(180deg); }

        /* Household Card Styles */
        .heads-section { margin-top: 15px; padding-top: 15px; border-top: 2px solid #e9ecef; display: none; }
        .heads-section.show { display: block; animation: slideDown 0.3s ease; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            color: #1e293b;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .head-card {
            border-left: 5px solid #0d6efd !important;
            background: rgba(13, 110, 253, 0.03);
        }

        .member-container {
            padding-left: 30px;
            border-left: 2px dashed #dee2e6;
            margin-left: 20px;
            margin-bottom: 25px;
        }

        .glass-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .glass-title { font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; gap: 10px; }
        .glass-meta { display: flex; align-items: center; gap: 14px; color: #475569; font-size: 0.85rem; flex-wrap: wrap; margin-top: 10px; }

        .meta-item { display: flex; align-items: center; gap: 5px; }

        .glass-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(13, 110, 253, 0.3);
        }

        .glass-avatar-fallback {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            display: inline-flex; align-items: center; justify-content: center;
            border: 2px solid rgba(13, 110, 253, 0.25);
        }

        .section-title {
            font-size: 0.8rem; font-weight: 800;
            color: #1e293b; text-transform: uppercase;
            letter-spacing: 1px; margin: 10px 0 12px;
        }

        .loading-spinner { text-align: center; padding: 40px; color: #64748b; }
        .no-data-message { text-align: center; padding: 20px; color: #94a3b8; font-style: italic; font-size: 0.9rem; }
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
                                        <div class="icon-box"><i class="fas fa-road"></i></div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const housesModal = new bootstrap.Modal(document.getElementById('housesModal'));

    function toTitleCase(value) {
        return (value || '').toLowerCase().replace(/\b\w/g, l => l.toUpperCase()).trim();
    }

    function formatFullName(res) {
        const first = res.firstName || '';
        const middle = res.middleName ? ` ${res.middleName}` : '';
        const last = res.lastName ? ` ${res.lastName}` : '';
        return toTitleCase(`${first}${middle}${last}`);
    }

    function renderAvatar(resident, iconClass, isHead = false) {
        const url = resident.image_path ? (resident.image_path.startsWith('http') ? resident.image_path : `/storage/${resident.image_path}`) : null;
        const extraClass = isHead ? 'head-avatar' : '';
        if (url) {
            return `<img class="glass-avatar ${extraClass}" src="${url}" alt="Profile">`;
        }
        return `<span class="glass-avatar-fallback ${extraClass}"><i class="fas ${iconClass}"></i></span>`;
    }

    $('.view-houses-btn').click(function() {
        const streetId = $(this).data('street-id');
        const streetName = $(this).data('street-name');
        $('#streetNameDisplay').text(streetName + ' - Houses');
        $('#houseSearchInput').val('');
        $('#housesModalBody').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-3">Loading houses...</p></div>');
        housesModal.show();
        loadHouses(streetId);
    });

    function loadHouses(streetId) {
        $.ajax({
            url: `/admin/households/streets/${streetId}`,
            method: 'GET',
            success: function(response) {
                if (response.success && response.houses?.length > 0) {
                    displayHouses(response.houses);
                } else {
                    $('#housesModalBody').html('<div class="no-data-message"><i class="fas fa-home fa-3x mb-3"></i><p>No houses found</p></div>');
                }
            }
        });
    }

    function displayHouses(houses) {
        let html = '';
        houses.forEach(house => {
            const count = (house.heads_count ?? house.households_count ?? 0);
            html += `
                <div class="house-card" data-house-id="${house.id}" data-house-no="${house.house_no}">
                    <div class="house-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="house-icon"><i class="fas fa-home"></i></div>
                            <div class="house-number">House ${house.house_no}</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="household-badge">${count} Household${count !== 1 ? 's' : ''}</span>
                            <i class="fas fa-chevron-down expand-icon"></i>
                        </div>
                    </div>
                    <div class="heads-section" id="heads-${house.id}">
                        <div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i></div>
                    </div>
                </div>`;
        });
        $('#housesModalBody').html(html);

        $('.house-card').click(function() {
            const houseId = $(this).data('house-id');
            const section = $('#heads-' + houseId);
            $(this).toggleClass('active');
            $(this).find('.expand-icon').toggleClass('rotated');
            if (!section.hasClass('show')) {
                if (!section.data('loaded')) loadHouseholdHeads(houseId);
                else section.addClass('show');
            } else {
                section.removeClass('show');
            }
        });
    }

    function loadHouseholdHeads(houseId) {
        $.ajax({
            url: `/admin/households/houses/${houseId}`,
            method: 'GET',
            success: function(response) {
                if (response.success) displayHouseholdHeads(houseId, response.groups || []);
            }
        });
    }

    function displayHouseholdHeads(houseId, groups) {
        const section = $('#heads-' + houseId);
        let html = '<div class="px-3 pb-2">';

        if (groups.length > 0) {
            groups.forEach(group => {
                const headRes = group.head?.resident || {};
                
                html += `
                    <div class="section-title text-primary mt-3"><i class="fas fa-crown me-1"></i> Household Head</div>
                    <div class="glass-card head-card">
                        <div class="glass-header">
                            <div class="glass-title">
                                ${renderAvatar(headRes, 'fa-user-circle', true)}
                                <span>${formatFullName(headRes)}</span>
                            </div>
                        </div>
                        <div class="glass-meta">
                            <div class="meta-item"><i class="fas fa-phone"></i> ${headRes.contactNo || headRes.contactNumber || 'N/A'}</div>
                            <div class="meta-item"><i class="fas fa-venus-mars"></i> ${toTitleCase(headRes.sex || 'N/A')}</div>
                            <div class="meta-item"><i class="fas fa-cake-candles"></i> ${headRes.birthday || headRes.birthdate || 'N/A'}</div>
                            <div class="meta-item"><i class="fas fa-id-card"></i> Age: ${headRes.age || 0}</div>
                        </div>
                    </div>`;

                html += '<div class="member-container">';
                html += '<div class="section-title" style="font-size:0.75rem">Family Members</div>';
                
                if (!group.members?.length) {
                    html += '<div class="no-data-message py-1">No members tagged</div>';
                } else {
                    group.members.forEach(m => {
                        const mRes = m.resident || {};
                        html += `
                            <div class="glass-card mb-3 shadow-sm border-0">
                                <div class="glass-header">
                                    <div class="glass-title">
                                        ${renderAvatar(mRes, 'fa-user')}
                                        <span>${formatFullName(mRes)}</span>
                                    </div>
                                    <span class="badge bg-info text-white" style="font-size: 0.75rem; padding: 4px 8px;">${m.relationship || 'Member'}</span>
                                </div>
                                <div class="glass-meta">
                                    <div class="meta-item"><i class="fas fa-phone"></i> ${mRes.contactNo || mRes.contactNumber || 'N/A'}</div>
                                    <div class="meta-item"><i class="fas fa-venus-mars"></i> ${toTitleCase(mRes.sex || 'N/A')}</div>
                                    <div class="meta-item"><i class="fas fa-cake-candles"></i> ${mRes.birthday || mRes.birthdate || 'N/A'}</div>
                                    <div class="meta-item"><i class="fas fa-id-card"></i> Age: ${mRes.age || 0}</div>
                                </div>
                            </div>`;
                    });
                }
                html += '</div>';
            });
        } else {
            html += '<div class="no-data-message">No households found</div>';
        }
        section.html(html + '</div>').addClass('show').data('loaded', true);
        
    }

    function filterHouses(query) {
        const term = query.toLowerCase();
        $('.house-card').each(function() {
            $(this).toggle($(this).data('house-no').toString().toLowerCase().includes(term));
        });
    }

    $('#houseSearchInput').on('input', function() { filterHouses($(this).val()); });
});
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
