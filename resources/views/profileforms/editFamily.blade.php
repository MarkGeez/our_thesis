<button type="button" 
        class="btn btn-sm btn-warning d-flex align-items-center" 
        data-bs-toggle="modal" 
        data-bs-target="#editFamilyMemberModal{{ $member->id }}"
        style="padding: 0.25rem 0.75rem;">
    <i class="fas fa-edit me-1"></i> Edit
</button>

<!-- Edit Family Member Modal -->
<div class="modal fade" id="editFamilyMemberModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route(auth()->user()->role . '.edit.family', $member->id) }}" id="editFamilyForm{{ $member->id }}">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="firstName_{{ $member->id }}" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="firstName_{{ $member->id }}" name="firstName" value="{{ old('firstName', $member->firstName) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="middleName_{{ $member->id }}" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middleName_{{ $member->id }}" name="middleName" value="{{ old('middleName', $member->middleName) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="lastName_{{ $member->id }}" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastName_{{ $member->id }}" name="lastName" value="{{ old('lastName', $member->lastName) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birthdate_{{ $member->id }}" class="form-label">Birthday <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="birthdate_{{ $member->id }}" name="birthdate" value="{{ old('birthdate', $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('Y-m-d') : '') }}" max="{{ now()->subDay()->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sex_{{ $member->id }}" class="form-label">Sex <span class="text-danger">*</span></label>
                            <select class="form-select" id="sex_{{ $member->id }}" name="sex" required>
                                <option value="" disabled>Select sex</option>
                                <option value="male" {{ old('sex', $member->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex', $member->sex) == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="relationship_{{ $member->id }}" class="form-label">Relationship <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="relationship_{{ $member->id }}" name="relationship" value="{{ old('relationship', $member->relationship) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contactNumber_{{ $member->id }}" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" id="contactNumber_{{ $member->id }}" name="contactNumber" placeholder="09XXXXXXXXX" value="{{ old('contactNumber', $member->contactNumber) }}">
                        </div>
                    </div>

                    <div class="row mt-2">
    <div class="col-12">
        <div class="p-3 border rounded bg-light">
            <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
                <div>
                    <label class="form-check-label fw-bold mb-0" for="is_inactive_{{ $member->id }}" style="cursor: pointer;">
                        <i class="fas fa-user-slash me-2 text-muted"></i>Account Status
                    </label>
                    <div class="text-muted small">Mark this member as inactive to hide them from active lists.</div>
                </div>
                <div class="form-check form-switch">
                    <input type="hidden" name="is_inactive" value="0">
                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_inactive_{{ $member->id }}" 
                           name="is_inactive" value="1" style="width: 2.5em; height: 1.25em; cursor: pointer;"
                           {{ old('is_inactive', $member->is_inactive ?? 0) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" form="editFamilyForm{{ $member->id }}" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i>Update Member
                </button>
            </div>
        </div>
    </div>
</div>
