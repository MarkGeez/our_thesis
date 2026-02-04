<div class="card-body">
            @if($resident)
                <div class="row mb-2">
                    <div class="col-5 text-muted">Resident Name</div>
                    <div class="col-7">
                        {{ ucwords($resident->firstName) }}
                        {{ ucwords($resident->middleName) }}
                        {{ ucwords($resident->lastName) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Contact No.</div>
                    <div class="col-7">{{ $resident->contactNo }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Address</div>
                    <div class="col-7">
                        @if($resident && $resident->households->first() && $resident->households->first()->house)
                            @php
                                $house = $resident->households->first()->house;
                                $street = optional($house)->street;
                            @endphp
                            {{ $house->house_no ?? 'N/A' }} {{ optional($street)->street_name ?? '' }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Birthday</div>
                    <div class="col-7">{{ \Carbon\Carbon::parse($resident->birthday)->format('F d, Y') }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Age / Sex</div>
                    <div class="col-7">{{ $resident->age }} / <span class="text-capitalize">{{ $resident->sex }}</span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Parent Status</div>
                    <div class="col-7 text-capitalize">{{ $resident->parent }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Enrolled</div>
                    <div class="col-7 text-capitalize">{{ $resident->enrolled }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Head of Family</div>
                    <div class="col-7 text-capitalize">{{ $resident->headOfFamily }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Education</div>
                    <div class="col-7">{{ $resident->educationalAttainment ?? 'N/A' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Religion</div>
                    <div class="col-7">{{ $resident->religion ?? 'Not specified' }}</div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Emergency Contact</div>
                    <div class="col-7">{{ $resident->emergencyContactName }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 text-muted">Emergency No.</div>
                    <div class="col-7">{{ $resident->emergencyContactNo }}</div>
                </div>

            @else
                <div class="alert alert-warning mb-0">
                    No resident information retrieved.
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            @if($resident)
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editResidentModal">
                    Edit Resident Info
                </button>

                {{--  
                <button class="btn btn-sm btn-outline-success" onclick="window.location.href='{{ route('admin.family.add') }}'">
                    <i class="fas fa-user-plus me-1"></i>Add Family Member
                </button>
                --}}
            @endif
        </div>
    </div>
</div>

    @if($members && $members->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Family Members ({{ $members->count() }})</h6>
                    <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#addFamilyMemberModal">
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
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-soft-success d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #e8f5e9;">
                                                <i class="fas fa-user text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ ucwords($member->firstName) }} {{ ucwords($member->lastName) }}</div>
                                                <small class="text-muted text-capitalize">{{ $member->sex ?? 'N/A' }}</small>
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
                                            {{ $member->contactNumber ?? $member->contactNo ?? 'None' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="fas fa-calendar-alt me-1 text-muted"></i>
                                            @if($member->birthdate || $member->birthday)
                                                {{ \Carbon\Carbon::parse($member->birthdate ?? $member->birthday)->format('M d, Y') }}
                                            @else
                                                <span class="text-muted italic">Not set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary" title="Edit Member">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route($user->role . '.untag.member', $member->id) }}" method="POST">
                @csrf 
                
                @method('DELETE') 

                <button type="submit" class="btn btn-danger">untag</button>
            </form>
                                        </div>
                                    </td>
                                    <td>
                                        @include('profileforms.editFamily')
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
    @else
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                <i class="fas fa-info-circle fs-4 me-3"></i>
                <div>
                    <strong>No family members listed.</strong> 
                    You can add members using the button in the Resident Information section.
                </div>
            </div>
        </div>
    </div>
    @endif