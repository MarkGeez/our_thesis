@php
    $filteredRequests = $filteredRequests ?? collect();
@endphp
@if($filteredRequests->isEmpty())
    <div class="alert alert-info">No certificate requests in this category.</div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Requester</th>
                    <th class="text-center">History</th>
                    <th>Certificate Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredRequests as $request)
                <tr>
                    <td>
                        @if($request->resident)
                            {{ ucwords(strtolower($request->resident->firstName . ' ' . $request->resident->lastName)) }}
                        @else
                            {{ ucwords(strtolower($request->user->firstName . ' ' . $request->user->lastName)) }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $stats = $requestStats[$request->user_id] ?? null;
                        @endphp
                        @if($stats)
                            <button type="button" class="btn btn-sm btn-outline-primary" data-history-user-id="{{ $request->user_id }}" title="View full history">
                                <i class="fas fa-history me-1"></i>
                                <span class="badge bg-primary">{{ $stats->total }}</span>
                                <span class="badge bg-success">{{ $stats->approved }}</span>
                                <span class="badge bg-danger">{{ $stats->declined }}</span>
                            </button>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td><span >{{ ucfirst($request->certificate_type) }}</span></td>
                    <td>{{ Str::limit($request->purpose, 40) }}</td>
                    <td>
                        @switch($request->status)
                            @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                            @case('approved') <span class="badge bg-success">Approved</span> @break
                            @case('picked_up') <span class="badge bg-secondary">Picked up</span> @break
                            @case('declined') <span class="badge bg-danger">Declined</span> @break
                            @default <span class="badge bg-secondary">{{ $request->status }}</span>
                        @endswitch
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
@endif
