<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Blotter Management</title>
    
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>

<div class="layer"></div>
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">  
    @include('admin.admin-sidebar', ['admin' => auth()->user()])

    <div class="main-wrapper">
        @include('admin.admin-header', ['admin' => auth()->user()])
        
        <main class="main users chart-page" id="skip-target">
            @include('forms.blotter',['plaintiff'=> view('forms.unhidden')->render(), 'button'=>"Encode blotter"])
            <div class="container-fluid p-4">
                <h3 class="mb-4">Blotter Requests</h3>

                @if($blotters->isEmpty())
                    <div class="alert alert-info">No blotter requests found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Submitted By</th>
                                    <th>Defendant</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Proof</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blotters as $blotter)
                                    <tr>
                                        <td>{{ $blotter->id }}</td>
                                        <td>{{ $blotter->user->firstName ?? '' }} {{ $blotter->user->lastName ?? '' }}</td>
                                        <td>{{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</td>
                                        <td>{{ Str::limit($blotter->blotterDescription, 50) }}</td>
                                        
                                        <td>
                                            <span class="badge bg-{{ $blotter->status === 'PENDING' ? 'warning' : 'success' }}"> {{ ucfirst(strtolower($blotter->status)) }} </span>
                                        </td>
                                        <td>
                                            @if($blotter->proof)
                                                <a href="{{ asset('storage/'.$blotter->proof) }}" target="_blank">
                                                    <i class="fa fa-file"></i> View
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>{{ $blotter->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#viewBlotter{{ $blotter->id }}">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-secondary me-1" data-bs-toggle="modal" data-bs-target="#updateBlotter{{ $blotter->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#statusBlotter{{ $blotter->id }}">
                                                <i class="fa fa-flag"></i> Status
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- View Modal --}}
                                    <div class="modal fade" id="viewBlotter{{ $blotter->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Blotter Details #{{ $blotter->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Defendant Information:</h6>
                                                    <p><strong>Name:</strong> {{ $blotter->defendantName }} {{ $blotter->defendantMiddleName }} {{ $blotter->defendantLastName }}</p>
                                                    <p><strong>Age:</strong> {{ $blotter->defendantAge ?? 'N/A' }}</p>
                                                    <p><strong>Address:</strong> {{ $blotter->defendantAddress ?? 'N/A' }}</p>
                                                    <p><strong>Contact:</strong> {{ $blotter->defendantContactNumber ?? 'N/A' }}</p>
                                                    
                                                    @if($blotter->witnessName)
                                                        <hr>
                                                        <h6>Witness Information:</h6>
                                                        <p><strong>Name:</strong> {{ $blotter->witnessName }}</p>
                                                        <p><strong>Contact:</strong> {{ $blotter->witnessContactNumber ?? 'N/A' }}</p>
                                                    @endif

                                                    <hr>
                                                    <h6>Description:</h6>
                                                    <p>{{ $blotter->blotterDescription }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('forms.update')
                                    @include('forms.status')
                                    
 

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div> 


{{-- Auto-open modal on validation errors --}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalEl = null;
            
            @if(old('updateBlotterId'))
                var id = "{{ old('updateBlotterId') }}";
                modalEl = document.getElementById('updateBlotter' + id);
            @elseif(old('statusBlotterId'))
                var id = "{{ old('statusBlotterId') }}";
                modalEl = document.getElementById('statusBlotter' + id);
            @else
                modalEl = document.getElementById('blotterModal');
            @endif

            if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    </script>
@endif


<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
