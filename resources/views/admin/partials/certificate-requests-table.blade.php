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
                    <th>Role</th>
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
                    <td><span class="badge bg-secondary">{{ ucfirst($request->user->role ?? '—') }}</span></td>
                    <td><span class="badge bg-info">{{ ucfirst($request->certificate_type) }}</span></td>
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
                        @if($request->status === 'pending')
                            <form action="{{ route('admin.certificate.approve', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve this certificate request?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check me-1"></i>Approve</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" data-reject-id="{{ $request->id }}"><i class="fas fa-times me-1"></i>Reject</button>
                        @endif
                        @if(in_array($request->status, ['approved', 'picked_up']))
                            <button type="button" class="btn btn-sm btn-info text-white" data-preview-id="{{ $request->id }}"><i class="fas fa-eye me-1"></i>Preview</button>
                            <a href="{{ route('admin.certificate.generate', $request->id) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print me-1"></i>Print</a>
                        @endif
                        @if($request->status === 'declined' && $request->decline_reason)
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="{{ $request->decline_reason }}">Reason</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
