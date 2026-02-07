<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    

    </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])



<div class="main-wrapper">
           
    @include('admin.admin-header', ['admin' => auth()->user()])
            <main class="main users chart-page" id="skip-target">
                <div class="container mt-4">
                    <h2 class="mb-4"><i class="fas fa-file-lines"></i> My Certificate Requests</h2>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-check-circle me-3"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card shadow-sm mb-4">
                        <div class="card-header"><strong>Request a Certificate</strong></div>
                        <div class="card-body">
                            <form action="{{ route('admin.certificate.request.store') }}" method="POST">
                                @csrf
                                <select id="certificate_type" name="certificate_type" class="form-select">
    <option value="">-- Select Certificate --</option>
    <option value="bonafide">Bonafide Certificate</option>
    <option value="indigency">Certification of Indigency</option>
    <option value="solo_parent">Affidavit of Solo Parent</option>
    <option value="senior">Senior Citizen Certificate</option>
</select>

                                    <div class="col-md-6">
                                        <label class="form-label">Purpose <span class="text-danger">*</span></label>
                                        <div id="bonafide_purpose" class="d-none">
    <label>Purpose</label>
    <select name="purpose" class="form-select bonafide-purpose">
        <option value="">Select purpose</option>
        <option>Bonafide Resident</option>
        <option>Medical Treatment</option>
        <option>Hospitalization Application</option>
        <option>For Postal ID</option>
        <option>School Reference</option>
        <option>Referral</option>
        <option>Transaction in Bank</option>
        <option>Overseas Travel Papers</option>
        <option>Processing for Calamity / Disaster Aid</option>
        <option>S.S.S. Reference</option>
        <option value="others">Others</option>
    </select>

    <input type="text" name="purpose_other" class="form-control mt-2 d-none"
           placeholder="Please specify purpose">
</div>

<div id="indigency_purpose" class="d-none">
    <label>Purpose</label>
    <select name="purpose" class="form-select indigency-purpose">
        <option value="">Select purpose</option>
        <option>Medical Assistance</option>
        <option>Educational Assistance</option>
        <option>Burial Assistance</option>
        <option>Financial Assistance</option>
        <option value="others">Others</option>
    </select>

    <input type="text" name="purpose_other" class="form-control mt-2 d-none"
           placeholder="Please specify purpose">
</div>

<div id="solo_parent_form" class="d-none">

    <label>Married / Unmarried to</label>
    <input type="text" name="form_data[partner_name]" class="form-control">

    <label class="mt-2">Number of Children</label>
    <input type="number" id="children_count" class="form-control" min="1">

    <div id="children_container"></div>

    <label class="mt-3">Separated from</label>
    <input type="text" name="form_data[separated_from]" class="form-control">

    <label class="mt-2">Since</label>
    <input type="date" name="form_data[since]" class="form-control">

</div>

<div id="senior_form" class="d-none">
    <label>Former Address</label>
    <input type="text" name="form_data[former_address]" class="form-control">

    <label class="mt-2">Transferred To</label>
    <input type="text" name="form_data[new_address]" class="form-control">
</div>




                                    </div>
                                    @php $res = $admin->resident ?? null; @endphp
                                    @if(!$res)
                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Your full address" maxlength="255">
                                    </div>
                                    @endif
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Submit Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <h5 class="mb-3">My Requests</h5>
                    @if($requests->isEmpty())
                        <div class="alert alert-info">You have not submitted any certificate requests yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover bg-white">
                                <thead class="table-primary">
                                    <tr><th>Certificate Type</th><th>Purpose</th><th>Status</th><th>Date</th><th>Remarks</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $req)
                                    <tr>
                                        <td><span class="badge bg-info">{{ ucfirst($req->certificate_type) }}</span></td>
                                        <td>{{ Str::limit($req->purpose, 50) }}</td>
                                        <td>
                                            @switch($req->status)
                                                @case('pending') <span class="badge bg-warning text-dark">Pending</span> @break
                                                @case('approved') <span class="badge bg-success">Approved</span> @break
                                                @case('picked_up') <span class="badge bg-secondary">Picked up</span> @break
                                                @case('declined') <span class="badge bg-danger">Declined</span> @break
                                                @default <span class="badge bg-secondary">{{ $req->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($req->status === 'approved' || $req->status === 'picked_up')
                                                <span class="text-success fw-bold"><i class="fas fa-map-marker-alt me-1"></i>You can now go to the admin's house for pickup.</span>
                                            @elseif($req->status === 'declined' && $req->decline_reason)
                                                <span class="text-muted">{{ $req->decline_reason }}</span>
                                            @else — @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </main>

</main>

</div>
</div> 


<script>
function handleOthers(selectClass) {
    document.querySelectorAll(selectClass).forEach(select => {
        select.addEventListener('change', function () {
            const otherInput = this.parentElement.querySelector('input[name="purpose_other"]');

            if (this.value === 'others') {
                otherInput.classList.remove('d-none');
            } else {
                otherInput.classList.add('d-none');
                otherInput.value = '';
            }
        });
    });
}

// apply to both purpose dropdowns
handleOthers('.bonafide-purpose');
handleOthers('.indigency-purpose');

    document.getElementById('children_count').addEventListener('input', function () {
    const container = document.getElementById('children_container');
    container.innerHTML = '';

    for (let i = 1; i <= this.value; i++) {
        container.innerHTML += `
            <div class="border p-2 mt-2">
                <label>Child ${i} Name</label>
                <input type="text" name="form_data[children][${i}][name]" class="form-control">

                <label>Date of Birth</label>
                <input type="date" name="form_data[children][${i}][dob]" class="form-control">
            </div>
        `;
    }
});

document.getElementById('certificate_type').addEventListener('change', function () {
    document.querySelectorAll(
        '#bonafide_purpose, #indigency_purpose, #solo_parent_form, #senior_form'
    ).forEach(div => div.classList.add('d-none'));

    if (this.value === 'bonafide') {
        document.getElementById('bonafide_purpose').classList.remove('d-none');
    }

    if (this.value === 'indigency') {
        document.getElementById('indigency_purpose').classList.remove('d-none');
    }

    if (this.value === 'solo_parent') {
        document.getElementById('solo_parent_form').classList.remove('d-none');
    }

    if (this.value === 'senior') {
        document.getElementById('senior_form').classList.remove('d-none');
    }
});


</script>
<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>

