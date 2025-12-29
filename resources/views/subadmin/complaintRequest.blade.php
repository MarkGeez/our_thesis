<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    

    </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('subadmin.subadmin-sidebar', ['subadmin' => auth()->user()])



<div class="main-wrapper">
           
    @include('subadmin.subadmin-header', ['subadmin' => auth()->user()])
        <main class="main users chart-page" id="skip-target">
    <div class="main-container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 style="color:#000000; margin: 20px 45px;">Complaints Records</h2>
        </div>

        @if (session('success'))
            <div class="container m-3 bg-white text-success fw-bold p-3 rounded-3 shadow-sm"
                 style="max-width: 325px; box-shadow: 0 4px 12px rgb(5, 94, 12);">
                <h6>{{ session('success') }}</h6>
            </div>
        @endif

        @if($complaints->count() > 0)

        <div class="table-responsive" style="margin: 0 3em;">
            <table class="table table-bordered table-striped-row table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Complaint ID</th>
                        <th>Complainant ID</th>
                        <th>Complainant Name</th>
                        <th>Address</th>
                        <th>Details</th>
                        <th>Respondent ID</th>
                        <th>Status</th>
                        <th> Admin Remarks: </th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->complainant_id }}</td>
<td>{{ ucwords(str_replace(',', '', $complaint->complainantName)) }}</td>
                        <td>{{ $complaint->address }}</td>
                        <td>{{ $complaint->details }}</td>
                        <td>{{ $complaint->respondent_id }}</td>
                        <td>
                        @php
                            $statusClass = [
                                'on-going' => 'bg-warning text-dark',
                                'resolved' => 'bg-success',
                                'rejected' => 'bg-danger',
                            ][$complaint->status] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </td>
                    <td>{{ $complaint->remarks}}</td>
                        <td>{{ date('M-d-Y g:i A', strtotime($complaint->created_at)) }}</td>
                        <td>{{ date('M-d-Y g:i A', strtotime($complaint->updated_at)) }}</td>

                       <td class="text-center"> <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#complaintActionModal{{ $complaint->id }}" > Manage </button> </td>
                    </tr>

                    <div class="modal fade" id="complaintActionModal{{ $complaint->id }}" tabindex="-1"> <div class="modal-dialog modal-dialog-centered"> <div class="modal-content">
                             <div class="modal-header">
            <h5 class="modal-title">
                Update Complaint #{{ $complaint->id }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('subadmin.update.complaint', $complaint->id) }}" method="POST"> 
            @csrf @method('PUT')

            <div class="modal-body">

    <div class="mb-3">
        <label class="fw-bold mb-2 d-block">Update Status</label>

        <div class="border rounded p-3">

            <div class="form-check mb-2">
                <input
                    class="form-check-input"
                    type="radio"
                    name="status"
                    id="statusResolved{{ $complaint->id }}"
                    value="resolved"
                    {{ $complaint->status == 'resolved' ? 'checked' : '' }}
                >
                <label class="form-check-label fw-semibold text-success" for="statusResolved{{ $complaint->id }}">
                    Resolved
                </label>
            </div>

            <div class="form-check mb-2">
                <input
                    class="form-check-input"
                    type="radio"
                    name="status"
                    id="statusRejected{{ $complaint->id }}"
                    value="rejected"
                    {{ $complaint->status == 'rejected' ? 'checked' : '' }}
                >
                <label class="form-check-label fw-semibold text-danger" for="statusRejected{{ $complaint->id }}">
                    Rejected
                </label>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="status"
                    id="statusOngoing{{ $complaint->id }}"
                    value="on-going"
                    {{ $complaint->status == 'on-going' ? 'checked' : '' }}
                >
                <label class="form-check-label fw-semibold text-warning" for="statusOngoing{{ $complaint->id }}">
                    On-going
                </label>
            </div>

        </div>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Remarks</label>
        <textarea
            name="remarks"
            class="form-control mt-1"
            rows="3"
            placeholder="Add remarks if needed"
        >{{ old('remarks', $complaint->remarks) }}</textarea>
    </div>

</div>

<div class="modal-footer d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        Cancel
    </button>
    <button type="submit" class="btn btn-primary">
        Save Changes
    </button>
</div>


        </form>

    </div>
</div>

                    @endforeach
                </tbody>

            </table>
        </div>

        @else
            <div class="bg-light m-3 p-3 shadowed"><p class="ms-5 mt-3">No complaints found.</p></div>
        @endif

    </div>
</main>
    
</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>