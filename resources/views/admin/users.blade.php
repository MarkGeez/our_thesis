<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
<style>
    .btn-group > .btn-check:checked + .btn {
    z-index: 2;
    color: #fff; /* Ensures text stays white when active */
}

/* Optional: Add a slight shadow to the selected state */
.btn-check:checked + .btn-outline-success { background-color: #198754 !important; }
.btn-check:checked + .btn-outline-warning { background-color: #ffc107 !important; color: #000 !important; }
.btn-check:checked + .btn-outline-danger { background-color: #dc3545 !important; }
</style>
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>

<div class="page-flex">
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])

        <main class="main users chart-page" id="skip-target">
            <div class="main-container">

                <div class="d-flex align-items-center justify-content-between mb-4 px-4">
                    <h2 class="mb-0 text-dark">User Records</h2>
                </div>

                <form action="{{ route($user->role . '.users') }}" method="get" class="px-4 mb-4">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Search User</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Enter name or ID here..." 
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>
                        <div class="col-12 col-md-auto d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Search</button>
                            @if(request('search'))
                                <a href="{{ route($user->role . '.users') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-1"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                @if($userList->count() > 0)
                    <div class="px-4 mb-2 text-muted">
                        Found {{ $userList->total() }} users
                    </div>

                    <div class="table-responsive px-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Profile Image</th>
                                    <th>Proof of Identity</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userList as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>
                                            {{ ucwords(strtolower($list->firstName)) }}
                                            {{ ucwords(strtolower($list->lastName)) }}
                                        </td>
                                        <td>{{ $list->email }}</td>
                                        <td><span class="">{{ ucfirst($list->role) }}</span></td>
                                        <td>
                                            @if($list->profile_image)
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('storage/' . $list->profile_image) }}" alt="Profile image of {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#profileImgModal{{ $list->id }}">
                                                        <i class="fa-solid fa-image"></i> View
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($list->proofOfIdentity)
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('storage/' . $list->proofOfIdentity) }}" alt="Proof of identity for {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}" class="rounded" style="width:60px;height:60px;object-fit:cover;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#proofModal{{ $list->id }}">
                                                        <i class="fa-solid fa-image"></i> View
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted">No upload</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusConfig = [
                                                    'approved' => ['class' => 'bg-success', 'icon' => 'fa-check-circle', 'text' => 'Approved'],
                                                    'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-clock', 'text' => 'Pending'],
                                                    'rejected' => ['class' => 'bg-danger', 'icon' => 'fa-times-circle', 'text' => 'Rejected'],
                                                    'declined' => ['class' => 'bg-danger', 'icon' => 'fa-times-circle', 'text' => 'Declined']
                                                ];
                                                $status = $statusConfig[$list->status] ?? $statusConfig['pending'];
                                            @endphp
                                            <div class="d-flex align-items-center gap-2">
                                                
                                                <span class="badge {{ $status['class'] }}  px-3 py-2">
                                                    {{ $status['text'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <!-- Status Update Button -->
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#statusModal{{ $list->id }}"
                                                        title="Update Status">
                                                    <i class="fas fa-sync-alt"></i> Update Status
                                                </button>
                                                
                                                <!-- Role Update Button -->
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#roleModal{{ $list->id }}"
                                                        title="Update Role">
                                                    <i class="fas fa-user-cog"></i> Update Role
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Profile Image Modal --}}
                                    @if($list->profile_image)
                                    <div class="modal fade" id="profileImgModal{{ $list->id }}" tabindex="-1" aria-labelledby="profileImgModalLabel{{ $list->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="profileImgModalLabel{{ $list->id }}">Profile Image</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $list->profile_image) }}" alt="Profile image of {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}" class="img-fluid" style="max-height:70vh;object-fit:contain;">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Status Update Modal --}}
                                    @if($list->proofOfIdentity)
                                    <div class="modal fade" id="proofModal{{ $list->id }}" tabindex="-1" aria-labelledby="proofModalLabel{{ $list->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="proofModalLabel{{ $list->id }}">Proof of Identity</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $list->proofOfIdentity) }}" alt="Proof of identity for {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}" class="img-fluid" style="max-height:70vh;object-fit:contain;">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="modal fade" id="statusModal{{ $list->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $list->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="statusModalLabel{{ $list->id }}">
                                                        <i class="fas fa-user-check me-2"></i>Update Status
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route($user->role . '.update.status', $list->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">User: {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}</label>
                                                            </div>
                                                            <div class="col-12">
    <label class="form-label fw-semibold">New Status</label>
    <div class="btn-group w-100" role="group" aria-label="Status selection">
        <input type="radio" class="btn-check" name="status" id="approve{{ $list->id }}" 
            value="approved" {{ $list->status == 'approved' ? 'checked' : '' }}>
        <label class="btn btn-outline-success d-flex flex-column align-items-center py-3" for="approve{{ $list->id }}">
            <i class="fas fa-check-circle mb-1 fs-5"></i>
            <span>Approve</span>
        </label>

        <input type="radio" class="btn-check" name="status" id="pending{{ $list->id }}" 
            value="pending" {{ $list->status == 'pending' ? 'checked' : '' }}>
        <label class="btn btn-outline-warning d-flex flex-column align-items-center py-3" for="pending{{ $list->id }}">
            <i class="fas fa-clock mb-1 fs-5"></i>
            <span>Pending</span>
        </label>

        <input type="radio" class="btn-check" name="status" id="decline{{ $list->id }}" 
            value="declined" {{ $list->status == 'declined' || $list->status == 'rejected' ? 'checked' : '' }}>
        <label class="btn btn-outline-danger d-flex flex-column align-items-center py-3" for="decline{{ $list->id }}">
            <i class="fas fa-times-circle mb-1 fs-5"></i>
            <span>Decline</span>
        </label>
    </div>
</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save me-1"></i>Update Status
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Role Update Modal --}}
                                    <div class="modal fade" id="roleModal{{ $list->id }}" tabindex="-1" aria-labelledby="roleModalLabel{{ $list->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title" id="roleModalLabel{{ $list->id }}">
                                                        <i class="fas fa-user-cog me-2"></i>Update Role
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route($user->role . '.update.role', $list->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">User: {{ ucwords(strtolower($list->firstName)) }} {{ ucwords(strtolower($list->lastName)) }}</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">New Role <span class="text-muted fs-6">(Current: {{ ucfirst($list->role) }})</span></label>
                                                                <select name="role" class="form-select">
                                                                    <option value="admin" {{ $list->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                    <option value="subadmin" {{ $list->role === 'subadmin' ? 'selected' : '' }}>Sub-admin</option>
                                                                    <option value="resident" {{ $list->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                                                    <option value="non-resident" {{ $list->role === 'non-resident' ? 'selected' : '' }}>Non-resident</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-info text-white">
                                                            <i class="fas fa-save me-1"></i>Update Role
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 mt-3">
                        {{ $userList->links() }}
                    </div>
                @else
                    <div class="alert alert-info mx-4 mt-3">
                        No users found.
                    </div>
                @endif

            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
