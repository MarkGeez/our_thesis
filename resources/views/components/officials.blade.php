<style>
    .official-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #e2e8f0;
    }

    .btn-remove {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 6px;
        padding: 6px 15px;
        transition: all 0.2s;
    }

    .btn-remove:hover {
        background-color: #ef4444;
        color: white;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }
    .official-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
    }

    .official-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .image-containers {
        background: #f8f9fa;
        padding: 30px 0;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .official-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background: #dee2e6;
    }

    .official-info {
        padding: 20px;
        text-align: center;
    }

    .official-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
        color: #000000;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

    .official-position {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 15px;
        display: block;
    }

    .term-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        display: inline-block;
    }

    .term-label {
        font-weight: bold;
        display: block;
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #94a3b8;
    }
</style>

<div class="row g-4 justify-content-center">
    @foreach ($officials as $official)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="official-card">
                <div class="image-containers">
                    <img src="{{ $official->resident->image_path ? asset('storage/' . $official->resident->image_path) : 'https://ui-avatars.com/api/?name='.urlencode($official->resident->firstName).'&background=0D6EFD&color=fff&size=128' }}" 
                         alt="Official Photo" class="official-avatar">
                </div>
                
                <div class="official-info">
                    <span class="official-position">{{ $official->position }}</span>
                    <h3 class="official-name">
    @if(Str::lower($official->position) === 'chairman' || Str::lower($official->position) === 'barangay chairman')
        Hon. 
    @endif
    {{ $official->resident->firstName }} {{ $official->resident->lastName }}
</h3>
                    
                    <div class="term-badge mt-2">
                        <span class="term-label">Service Term</span>
                        <small class="fw-bold">
                            {{ date('M Y', strtotime($official->start)) }} - {{ date('M Y', strtotime($official->end)) }}
                        </small>
                    </div>

                    @auth
                        @if(auth()->user()->role === "admin")
                            <div class="official-actions">
                                <form method="POST" action="{{ route('admin.untag.official', $official->id) }}" 
                                      onsubmit="return confirm('Are you sure you want to remove this resident from the officials list? This will not delete the resident record.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-remove w-100" type="submit">
                                        <i class="fas fa-user-minus me-1"></i> Remove Official
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>