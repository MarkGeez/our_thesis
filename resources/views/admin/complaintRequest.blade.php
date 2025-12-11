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
            <main class="main users chart-page" id="skip-target"></main>

</main>

@if (session('success'))
    <p>{{ session('success')}}</p>
@endif

@foreach ($complaints as $complaint)
<table class="table table-bordered">

    <tr>
        <th>Complaint ID</th>
        <th>Complainant ID</th>
        <th>Complainant Name</th>
        <th>Address</th>
        <th>Details</th>
        <th>Respondent ID</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions:</th>
    </tr>

    <tr>
        <td>{{ $complaint->id }}</td>
        <td>{{ $complaint->complainant_id }}</td>
        <td>{{ $complaint->complainantName }}</td>
        <td>{{ $complaint->address }}</td>
        <td>{{ $complaint->details }}</td>
        <td>{{ $complaint->respondent_id }}</td>
        <td>{{ $complaint->status }}</td>
        <td>{{ $complaint->created_at }}</td>
        <td>{{ $complaint->updated_at }}</td>
        <td>
   <form action="{{ route('admin.update.complaint', $complaint->id) }}" method="post">
        @csrf
        @method('PUT')

        <input type="radio" name="status" value="resolved" id="resolved">Resolved
        <input type="radio" name="status" value="rejected" id="rejected">Rejected
        <input type="radio" name="status" value="on-going" id="on-going">On-going
        <button type="submit" class="btn btn-primary">Update Status</button>
   </form>
</td>
    </tr>

</table>
@endforeach

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>