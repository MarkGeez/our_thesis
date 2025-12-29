
@if($blotters->count() > 0)
    <div class="table-responsive table-wrapper">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <!--<th>Submitted By</th>-->
                    <th>Defendant</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Notes/Remarks</th>
                    <th>Proof</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blotters as $blotter)
                    <tr>
                        <td>{{ $blotter->id }}</td>
                        <!--<td>{{ $blotter->user->firstName ?? '' }} {{ $blotter->user->lastName ?? '' }}</td>-->
                        <td>{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
                        <td>{{ Str::limit($blotter->blotterDescription, 50) }}</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'CLOSED'    => 'danger',
                                    'SCHEDULED' => 'primary',
                                    'RESOLVED'  => 'success',
                                    'PENDING'   => 'warning text-dark',
                                ];
                                $statusClass = $statusClasses[strtoupper($blotter->status)] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst(strtolower($blotter->status)) }}
                            </span>
                        </td>
                        <td>
                            @php
                               
                                $notes = $blotter->statusDescription ?? null;
                            @endphp
                            @if($notes)
                                <span title="{{ $notes }}">{{ Str::limit($notes, 60) }}</span>
                            @else
                                N/A
                            @endif
                        </td>
                        
                        <td>
                            @if($blotter->proof)
                                <a href="{{ asset('storage/'.$blotter->proof) }}" target="_blank">
                                    <i class="fa fa-file"></i> View
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $blotter->created_at->format('M d, Y') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewBlotter{{ $blotter->id }}">
                                <i class="fa fa-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    {{-- View Modal --}}
                    <div class="modal fade" id="viewBlotter{{ $blotter->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Blotter Details #{{ $blotter->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <section>
                                        <h6>Defendant Information</h6>
                                        <div class="info-box">
                                            <div class="row gy-3">
                                                <div class="col-sm-6">
                                                    <div class="info-label">Full Name</div>
                                                    <div class="info-value">{{ $blotter->defendantName }} {{ $blotter->defendantMiddleName }} {{ $blotter->defendantLastName }}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="info-label">Age</div>
                                                    <div class="info-value">{{ $blotter->defendantAge ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="info-label">Address</div>
                                                    <div class="info-value">{{ $blotter->defendantAddress ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="info-label">Contact Number</div>
                                                    <div class="info-value">{{ $blotter->defendantContactNumber ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    @if($blotter->witnessName)
                                        <section>
                                            <h6>Witness Information</h6>
                                            <div class="info-box">
                                                <div class="row gy-3">
                                                    <div class="col-sm-6">
                                                        <div class="info-label">Witness Name</div>
                                                        <div class="info-value">{{ $blotter->witnessName }}</div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-label">Contact Number</div>
                                                        <div class="info-value">{{ $blotter->witnessContactNumber ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @endif

                                    <section>
                                        <h6>Incident Description</h6>
                                        <div class="info-box">
                                            <div class="info-label mb-1">Details</div>
                                            <div class="info-value" style="white-space: pre-line; line-height: 1.6;">
                                                {{ $blotter->blotterDescription }}
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info">
        <i class="fa fa-info-circle me-2"></i>No blotters found.
    </div>
@endif