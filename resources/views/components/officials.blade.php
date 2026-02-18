@php
    use Illuminate\Support\Str;

    // Default values to keep the component resilient when embedded elsewhere
    $positions = $positions ?? collect($officials ?? [])->pluck('position')->unique()->values()->all();
    $officialsByPosition = $officialsByPosition ?? collect($officials ?? [])->keyBy('position');
    $residents = $residents ?? collect();
    $showControls = $showControls ?? (auth()->check() && auth()->user()->role === 'admin');
@endphp

<style>
  .resident-dropdown {
    position: absolute;
    width: 100%;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-top: 4px;
    z-index: 1000;
    max-height: 240px;
    overflow-y: auto;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  }

  .resident-option {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 0.9rem;
  }

  .resident-option:hover {
    background: #f1f5f9;
  }

  .official-card {
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .official-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
  }

  .official-card-header {
    padding: 16px 18px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .official-slot {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #0f172a;
    font-size: 0.95rem;
  }

  .official-card-body {
    padding: 16px 18px;
    display: flex;
    gap: 12px;
    align-items: center;
  }

  .avatar-ring {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 3px solid #0d6efd;
    display: grid;
    place-items: center;
    background: #e9f2ff;
  }

  .official-avatar {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    object-fit: cover;
    background: #e2e8f0;
  }

  .official-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.3rem;
    letter-spacing: 0.5px;
    margin: 0;
    color: #0f172a;
  }

  .official-meta {
    margin: 0;
    color: #64748b;
    font-size: 0.85rem;
  }

  .official-card-actions {
    padding: 0 18px 18px 18px;
    margin-top: auto;
  }

  .official-card-public .official-slot,
  .official-card-public .official-name,
  .official-card-public .official-meta {
    color: #ffffff;
  }

  .official-card-public .official-card-header {
    border-bottom-color: rgba(255, 255, 255, 0.2);
  }

  .official-action-title {
    font-weight: 700;
    font-size: 0.85rem;
    color: #334155;
  }

  .form-label {
    font-weight: 600;
    color: #334155;
  }

  .btn-outline-danger {
    border-width: 2px;
  }

  .search-help {
    font-size: 0.8rem;
    color: #94a3b8;
  }
</style>

<div class="row g-4">
    @foreach ($positions as $slot)
        @php
            $official = $officialsByPosition[$slot] ?? null;
            $resident = $official?->resident;
            $avatar = $resident && $resident->image_path
                ? asset('storage/' . $resident->image_path)
                : asset('images/default_profile.jpg');
        @endphp

        <div class="col-12 col-md-6 col-xl-4">
            <div class="official-card {{ $showControls ? '' : 'official-card-public' }}">
                <div class="official-card-header">
                    <span class="official-slot">{{ $slot }}</span>
                    @if($showControls)
                        @if($official)
                            <span class="badge text-bg-success">Tagged</span>
                        @else
                            <span class="badge text-bg-secondary">Unassigned</span>
                        @endif
                    @endif
                </div>

                <div class="official-card-body">
                    <div class="avatar-ring">
                        <img src="{{ $avatar }}" alt="Official Photo" class="official-avatar">
                    </div>
                    <div class="flex-grow-1">
                        @if($resident)
                            <p class="official-name mb-1">{{ ucwords(strtolower($resident->firstName.' '.$resident->lastName)) }}</p>
                        @elseif($showControls)
                            <p class="official-name mb-1">No resident assigned</p>
                        @endif

                        <p class="official-meta mb-0">
                            @if($official && $official->start && $official->end)
                                Term: {{ date('M d, Y', strtotime($official->start)) }} - {{ date('M d, Y', strtotime($official->end)) }}
                            @elseif($official)
                                Term dates not set yet.
                            @elseif($showControls)
                                Tag a resident to display in this slot.
                            @endif
                        </p>

                        @if($official && $official->details)
                            <p class="official-meta mb-0 mt-1">{{ $official->details }}</p>
                        @endif
                    </div>
                </div>

                @if($showControls)
                    <div class="official-card-actions">
                        <p class="official-action-title mb-2">Assign / Update Resident</p>
                        <form method="POST" action="{{ route('admin.assign.official') }}" class="row g-2 official-assign-form">
                            @csrf
                            <input type="hidden" name="position" value="{{ $slot }}">

                            <div class="col-12 position-relative">
                                <label class="form-label">Search Resident</label>
                                <input type="text"
                                    class="form-control resident-search-input"
                                    placeholder="Type name or ID"
                                    autocomplete="off"
                                    value="{{ $resident ? ucwords(strtolower($resident->lastName)).', '.ucwords(strtolower($resident->firstName)) : '' }}">

                                <input type="hidden"
                                    name="resident_id"
                                    class="resident-id-input"
                                    value="{{ $official->resident_id ?? '' }}">

                                <div class="resident-dropdown d-none"></div>
                                <small class="search-help">Select a resident from the list.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Term / Notes</label>
                                <input type="text" name="details" class="form-control" placeholder="e.g. 2024-2027 term" value="{{ $official ? $official->details : '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start" class="form-control" value="{{ $official ? $official->start : now()->toDateString() }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end" class="form-control" value="{{ $official ? $official->end : now()->copy()->addYears(3)->toDateString() }}">
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fa fa-save me-1"></i> Save Assignment
                                </button>
                            </div>
                        </form>

                        @if($official)
                            <form method="POST" action="{{ route('admin.untag.official', $official->id) }}" class="mt-2" onsubmit="return confirm('Remove the resident from this position?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fa fa-times me-1"></i> Clear Assignment
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@if($showControls)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const residents = @json($residents);

            document.querySelectorAll('.official-assign-form').forEach(function (form) {
                const searchInput = form.querySelector('.resident-search-input');
                const hiddenInput = form.querySelector('.resident-id-input');
                const dropdown = form.querySelector('.resident-dropdown');

                function closeDropdown() {
                    dropdown.classList.add('d-none');
                }

                function formatName(name) {
                    if (!name) return '';
                    return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                }

                searchInput.addEventListener('input', function () {
                    const query = searchInput.value.toLowerCase().trim();
                    dropdown.innerHTML = '';
                    hiddenInput.value = '';

                    if (!query) {
                        closeDropdown();
                        return;
                    }

                    const matches = residents.filter(function (person) {
                        const fullName = (
                            person.lastName + ' ' +
                            person.firstName + ' ' +
                            (person.middleName ?? '')
                        ).toLowerCase();
                        return fullName.includes(query) || person.id.toString().includes(query);
                    }).slice(0, 5);

                    if (matches.length === 0) {
                        closeDropdown();
                        return;
                    }

                    matches.forEach(function (person) {
                        const option = document.createElement('div');
                        option.classList.add('resident-option');

                        const last = formatName(person.lastName);
                        const first = formatName(person.firstName);
                        const middle = formatName(person.middleName);

                        option.textContent = last + ', ' + first + (middle ? ' ' + middle : '') + ' (ID: ' + person.id + ')';

                        option.addEventListener('click', function () {
                            searchInput.value = option.textContent;
                            hiddenInput.value = person.id;
                            closeDropdown();
                        });
                        dropdown.appendChild(option);
                    });

                    dropdown.classList.remove('d-none');
                });

                form.addEventListener('submit', function (e) {
                    if (!hiddenInput.value) {
                        e.preventDefault();
                        alert('Please select a resident from the dropdown.');
                        searchInput.focus();
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!form.contains(e.target)) {
                        closeDropdown();
                    }
                });
            });
        });
    </script>
@endif