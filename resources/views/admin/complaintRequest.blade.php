<head>
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
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])



<div class="main-wrapper">
           
    @include('admin.admin-header', ['admin' => auth()->user()])
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
                        <th>Remarks: </th>
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
                        <td>{{ ucfirst($complaint->complainantName) }}</td>
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
                        <td>{{ $complaint->created_at }}</td>
                        <td>{{ $complaint->updated_at }}</td>

                        <td>
                            <form action="{{ route('admin.update.complaint', $complaint->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="d-flex flex-column gap-1">

    <div class="d-flex align-items-center gap-1 container bg-success shadow-sm p-2 rounded-3">
        <input type="radio" name="status" value="resolved">
        <label class="text-light fw-bold">Resolved</label>
    </div>

    <div class="d-flex align-items-center gap-1 container bg-danger shadow-sm p-2 rounded-3">
        <input type="radio" name="status" value="rejected">
        <label class="text-light fw-bold">Rejected</label>
    </div>

    <div class="d-flex align-items-center gap-1 container bg-warning shadow-sm p-2 rounded-3">
        <input type="radio" name="status" value="on-going">
        <label class="text-dark fw-bold">On-going</label>
    </div>

    
    <div class="mt-2">
        <label class="fw-bold">Remarks (optional)</label>
        <textarea
            name="remarks"
            class="form-control"
            rows="2"
        >{{ old('remarks',  $complaint->remarks) }}</textarea>
    </div>

    <hr>

    <button type="submit" class="btn btn-sm btn-primary">
        Update Status
    </button>
    @error('status')
       <p>You need to select an acctiion </p>
    @enderror

</div>

                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @else
            <p class="ms-5 mt-3">No complaints found.</p>
        @endif

    </div>
</main>
    
</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>