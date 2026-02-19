<style>
    .table-filter-bar {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        margin-top: 1.5rem;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table-filter-bar .form-control, 
    .table-filter-bar .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        height: 38px; /* Standardize height */
    }

    /* Remove focus ring and use a cleaner border */
    .table-filter-bar .form-control:focus,
    .table-filter-bar .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }
</style>

@php
    $filteredRequests = $filteredRequests ?? collect();
    $tab = $tab ?? 'all';
@endphp
@if($filteredRequests->isEmpty())
    <div class="alert alert-info">No certificate requests in this category.</div>
@else
    <form method="GET" action="{{ route('admin.certificateRequest') }}" class="table-filter-bar">
    <input type="hidden" name="tab" value="{{ $tab }}">

    <div class="flex-grow-1" style="min-width: 250px;">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="fa fa-search"></i>
            </span>
            <input type="text" name="search" 
                   class="form-control border-start-0 ps-0" 
                   placeholder="Search requester or certificate type..." 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-3">
                Search
            </button>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        @if($tab === 'all')
            <div class="filter-group">
                <span class="filter-label d-none d-md-inline">Status:</span>
                <select name="status_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all" {{ request('status_filter', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status_filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status_filter') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="picked_up" {{ request('status_filter') === 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="declined" {{ request('status_filter') === 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
        @endif

        <div class="filter-group">
            <span class="filter-label d-none d-md-inline">Sort:</span>
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="date_desc" {{ request('sort', 'date_desc') === 'date_desc' ? 'selected' : '' }}>Date: Newest</option>
                <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Date: Oldest</option>
                <option value="id_desc" {{ request('sort') === 'id_desc' ? 'selected' : '' }}>ID: Newest</option>
                <option value="id_asc" {{ request('sort') === 'id_asc' ? 'selected' : '' }}>ID: Oldest</option>
                <option value="type_asc" {{ request('sort') === 'type_asc' ? 'selected' : '' }}>Type: A-Z</option>
                <option value="type_desc" {{ request('sort') === 'type_desc' ? 'selected' : '' }}>Type: Z-A</option>
                <option value="status_asc" {{ request('sort') === 'status_asc' ? 'selected' : '' }}>Status: A-Z</option>
                <option value="status_desc" {{ request('sort') === 'status_desc' ? 'selected' : '' }}>Status: Z-A</option>
            </select>
        </div>

        <div class="vr mx-1 d-none d-md-block"></div> <a href="{{ route('admin.certificateRequest', ['tab' => $tab]) }}" 
           class="btn btn-link btn-sm text-secondary text-decoration-none px-2" 
           title="Reset Filters">
            <i class="fa fa-undo me-1"></i>Reset
        </a>
    </div>
</form>

    <div class="results-info">
        <div class="results-count ms-3">
            Records: <span class="count-number">{{ $filteredRequests instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $filteredRequests->total() : $filteredRequests->count() }}</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Cert ID</th>
                    <th>Requester</th>
                    <th>Certificate Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Updated By</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredRequests as $request)
                <tr>
                    <td><code>{{ $request->id }}</code></td>
                    <td>
                        <button type="button" class="btn btn-link text-decoration-none p-0" data-requester-user-id="{{ $request->user_id }}" data-requester-resident-id="{{ $request->resident_id ?? '' }}" title="View user information">
                            @if($request->resident)
                                {{ ucwords(strtolower($request->resident->firstName . ' ' . $request->resident->lastName)) }}
                            @else
                                {{ ucwords(strtolower($request->user->firstName . ' ' . $request->user->lastName)) }}
                            @endif
                        </button>
                    </td>
                    <td><span >{{ ucfirst($request->certificate_type) }}</span></td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div>
                                <p class="mb-0 small">{{ Str::limit($request->purpose, 40) }}</p>
                                <button type="button" class="btn btn-xs btn-outline-primary mt-1" data-view-request-id="{{ $request->id }}" title="View full request details">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>
                        @switch($request->status)
                            @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                            @case('approved') <span class="badge bg-success">Approved</span> @break
                            @case('picked_up') <span class="badge bg-secondary">Picked up</span> @break
                            @case('declined') <span class="badge bg-danger">Declined</span> @break
                            @default <span class="badge bg-secondary">{{ $request->status }}</span>
                        @endswitch
                    </td>
                    <td>
                        @if($request->approver)
                            <small>{{ ucwords(strtolower($request->approver->firstName . ' ' . $request->approver->lastName)) }}</small>
                            <br>
                            <small class="text-muted">{{ $request->approved_at?->format('M d, Y H:i') ?? '-' }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $request->created_at->format('M d, Y H:i') }}</td>
                    <td class="text-center">
                        <div class="d-flex flex-wrap justify-content-center gap-2 action-btns">
                            @if($request->status === 'pending')
                                <form action="{{ route('admin.certificate.approve', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve this certificate request?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check me-1"></i>Approve</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" data-reject-id="{{ $request->id }}"><i class="fas fa-times me-1"></i>Reject</button>
                            @endif
                            @if($request->status === 'approved')
                                <button type="button" class="btn btn-sm btn-info text-white" data-preview-id="{{ $request->id }}"><i class="fas fa-print me-1"></i>Generate Certificate</button>
                                {{--<a href="{{ route('admin.certificate.generate', $request->id) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print me-1"></i>Print</a>--}}
                            @endif
                            @if($request->status === 'declined' && $request->decline_reason)
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#declineReasonModal" data-reason="{{ $request->decline_reason }}">Reason</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($filteredRequests instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $filteredRequests->hasPages())
        <div class="pagination-container">
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <div class="pagination-info-text">
                        <i class="fa-solid fa-list-check"></i>
                        <span>
                            Showing <span class="pagination-info-numbers">{{ $filteredRequests->firstItem() }}</span>
                            to <span class="pagination-info-numbers">{{ $filteredRequests->lastItem() }}</span>
                            of <span class="pagination-info-numbers">{{ $filteredRequests->total() }}</span> results
                        </span>
                    </div>
                </div>
                {{ $filteredRequests->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
@endif
