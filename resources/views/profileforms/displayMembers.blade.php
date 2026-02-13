{{--@if($members && $members->count() > 0)  --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Family Members ({{ $members->count() }})</h6>
                    <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#addHouseholdMemberModal">
                        <i class="fas fa-plus"></i> Add Family Member
                    </button>
                </div>
                <div class="card-body p-0"> <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Member Name</th>
                                    <th>Relationship</th>
                                    <th>Contact Info</th>
                                    <th>Birthday</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                @php $r = $member->resident; @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-soft-success d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #e8f5e9;">
                                                <i class="fas fa-user text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $r ? ucwords(trim($r->firstName . ' ' . ($r->middleName ?? '') . ' ' . $r->lastName)) : 'Unknown' }}</div>
                                                <small class="text-muted text-capitalize">{{ $r->sex ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-outline-secondary border text-secondary px-3 py-2">
                                            {{ $member->relationship ?? 'Member' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="fas fa-phone-alt me-1 text-muted"></i>
                                            {{ $r->contactNo ?? 'None' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="fas fa-calendar-alt me-1 text-muted"></i>
                                            @if($r && $r->birthday)
                                                {{ \Carbon\Carbon::parse($r->birthday)->format('M d, Y') }}
                                            @else
                                                <span class="text-muted italic">Not set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex gap-2 justify-content-end align-items-center">
                                            <form action="{{ route(auth()->user()->role . '.untag.member', $member->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger d-flex align-items-center" 
                                                        onclick="return confirm('Are you sure you want to remove this family member?')" 
                                                        style="padding: 0.25rem 0.75rem;">
                                                    <i class="fa-solid fa-user-minus me-1"></i> Untag Member
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>