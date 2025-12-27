<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Blotter Management</title>
    
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .header-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        @include('admin.admin-sidebar', ['admin' => auth()->user()])

        <div class="main-wrapper">
            @include('admin.admin-header', ['admin' => auth()->user()])
            
            <main class="main users chart-page" id="skip-target">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Button moved to header section -->
                <div class="header-actions">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blotterModal">
                        <i class="fas fa-plus me-2"></i>Submit Blotter
                    </button>
                </div>

                <!-- Blotters Table -->
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Blotter Records</h3>
                        <div class="text-muted">Total: {{ $blotters->count() }}</div>
                    </div>
                    
                    @if($blotters->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Plaintiff</th>
                                        <th>Defendant</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blotters as $blotter)
                                        <tr>
                                            <td>#{{ $blotter->id }}</td>
                                            <td>
                                                <strong>{{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</strong><br>
                                                <small class="text-muted">{{ $blotter->plaintiffContactNumber }}</small>
                                            </td>
                                            <td>
                                                {{ $blotter->defendantName }} {{ $blotter->defendantLastName }}<br>
                                                <small class="text-muted">{{ $blotter->defendantAddress }}</small>
                                            </td>
                                            <td>
                                                {{ Str::limit($blotter->blotterDescription, 50) }}
                                                @if(strlen($blotter->blotterDescription) > 50)
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $blotter->id }}">Read more</a>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($blotter->status)
                                                    @case('pending')
                                                        <span class="status-badge status-pending">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="status-badge status-approved">
                                                            <i class="fas fa-check me-1"></i>Approved
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="status-badge status-rejected">
                                                            <i class="fas fa-times me-1"></i>Rejected
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="status-badge">{{ $blotter->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $blotter->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $blotter->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $blotter->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="descriptionModal{{ $blotter->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Case Description #{{ $blotter->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $blotter->blotterDescription }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination if needed -->
                        @if($blotters->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $blotters->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h4>No blotter records found</h4>
                            <p class="text-muted">Submit your first blotter using the button above.</p>
                        </div>
                    @endif
                </div>

                <!-- Submit Blotter Modal -->
                <div class="modal fade" id="blotterModal" tabindex="-1" aria-labelledby="blotterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="blotterModalLabel">Submit New Blotter</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <div class="modal-body">
                                <form action="{{ route('admin.submit.blotter') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="plaintiffName">
                                    <input type="text" name="plaintiffLastName">
                                    <input type="text" name="plaintiffMiddleName">
                                    <input type="text" name="plaintiffAddress">
                                    <input type="text" name="plaintiffContactNumber">
                                    <input type="text" name="plaintiffAge">
                                    
                                    <!-- Defendant Information -->
                                    <h4 class="mb-4">Defendant Information</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">First Name *</label>
                                            <input type="text" name="defendantName"
                                                   class="form-control @error('defendantName') is-invalid @enderror"
                                                   value="{{ old('defendantName') }}" required>
                                            @error('defendantName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Last Name *</label>
                                            <input type="text" name="defendantLastName"
                                                   class="form-control @error('defendantLastName') is-invalid @enderror"
                                                   value="{{ old('defendantLastName') }}" required>
                                            @error('defendantLastName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Middle Name</label>
                                            <input type="text" name="defendantMiddleName"
                                                   class="form-control @error('defendantMiddleName') is-invalid @enderror"
                                                   value="{{ old('defendantMiddleName') }}">
                                            @error('defendantMiddleName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Age</label>
                                            <input type="number" name="defendantAge"
                                                   class="form-control @error('defendantAge') is-invalid @enderror"
                                                   value="{{ old('defendantAge') }}">
                                            @error('defendantAge')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Address *</label>
                                        <input type="text" name="defendantAddress"
                                               class="form-control @error('defendantAddress') is-invalid @enderror"
                                               value="{{ old('defendantAddress') }}" required>
                                        @error('defendantAddress')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" name="defendantContactNumber"
                                               class="form-control @error('defendantContactNumber') is-invalid @enderror"
                                               value="{{ old('defendantContactNumber') }}">
                                        @error('defendantContactNumber')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <!-- Witness Information -->
                                    <h4 class="mb-4">Witness Information (Optional)</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Witness Name</label>
                                            <input type="text" name="witnessName"
                                                   class="form-control @error('witnessName') is-invalid @enderror"
                                                   value="{{ old('witnessName') }}">
                                            @error('witnessName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" name="witnessContactNumber"
                                                   class="form-control @error('witnessContactNumber') is-invalid @enderror"
                                                   value="{{ old('witnessContactNumber') }}">
                                            @error('witnessContactNumber')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <!-- Case Details -->
                                    <h4 class="mb-4">Case Details</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Description *</label>
                                        <textarea name="blotterDescription"
                                                  class="form-control @error('blotterDescription') is-invalid @enderror"
                                                  rows="4" required>{{ old('blotterDescription') }}</textarea>
                                        @error('blotterDescription')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Upload Proof (Optional)</label>
                                        <input type="file" name="proof"
                                               class="form-control @error('proof') is-invalid @enderror">
                                        <small class="text-muted">Max file size: 5MB. Allowed: PDF, JPG, PNG</small>
                                        @error('proof')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Blotter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Auto-open modal on validation errors -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('blotterModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('template/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
</body>
</html>