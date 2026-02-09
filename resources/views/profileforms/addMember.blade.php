<div class="modal fade" id="addFamilyMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add Family Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" ></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route(auth()->user()->role . '.family.store') }}" id="addFamilyForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required placeholder="Enter first name">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter middle name">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required placeholder="Enter last name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                <select class="form-select" id="sex" name="sex" required>
                                    <option value="" selected disabled>Select sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter contact number">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="relationship" class="form-label">Relationship</label>
                                <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Enter relationship">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" form="addFamilyForm" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Add Family Member
                    </button>
                </div>
            </div>
        </div>
    </div>