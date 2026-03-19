@php
    use Illuminate\Support\Str;

    // Default values to keep the component resilient when embedded elsewhere
    $positions = $positions ?? collect($officials ?? [])->pluck('position')->unique()->values()->all();
    $officialsByPosition = $officialsByPosition ?? collect($officials ?? [])->keyBy('position');
    $residents = $residents ?? collect();
    $routePrefix = $routePrefix ?? ((auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin'], true)) ? auth()->user()->role : 'admin');
    $showControls = $showControls ?? (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin'], true));
    $currentUser = auth()->user();
    $currentUserResidentId = optional($currentUser?->resident)->id;
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

  .official-card.is-clickable {
    cursor: pointer;
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

  .official-card-public .official-card-body {
    min-height: 110px;
  }

  .official-public-hint {
    margin-top: 10px;
    font-size: 0.78rem;
    color: rgba(255, 255, 255, 0.8);
  }

  .official-modal-avatar-wrap {
    width: 108px;
    height: 108px;
    margin: 0 auto 16px;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, #0d6efd, #7cc0ff);
  }

  .official-modal-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    background: #e2e8f0;
  }

  .official-modal-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.9rem;
    letter-spacing: 0.6px;
    color: #0f172a;
  }

  .official-modal-position {
    color: #475569;
    font-weight: 600;
  }

  .official-modal-meta-label {
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
  }

  .official-modal-meta-value {
    color: #0f172a;
    margin-bottom: 0;
  }

  .official-privacy-note {
    font-size: 0.82rem;
    color: #64748b;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 12px;
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
  .term-help {
    font-size: 0.85rem;
    color: #64748b;
  }
  .input-group-text{
    background-color:#f1f3f5;
    border:1.5px solid #ced4da;
    cursor:pointer;
}
input[type="date"]::-webkit-calendar-picker-indicator{
    opacity:1;
    cursor:pointer;
}

/* keeps the date field aligned and full width inside input-group */
.input-group > .form-control[type="date"]{
    flex:1 1 auto;
    width:1%;
    min-width:0;
    font-size: 0.9rem
}
</style>

@if($showControls)
    @php
        $termStart = old('term_start', now()->toDateString());
        $termEnd = old('term_end', now()->copy()->addYears(3)->toDateString());
    @endphp
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Officials Term Range (Applies To All Assignments)</h6>
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label mb-1" for="globalTermStart">Start Date</label>
                    <div class="input-group w-100">
                        <input
                            type="date"
                            id="globalTermStart"
                            class="form-control official-term-date-input"
                            value="{{ $termStart }}"
                            data-raw="{{ $termStart }}"
                            required
                        >
                        <span class="input-group-text official-term-date-open">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label mb-1" for="globalTermEnd">End Date</label>
                    <div class="input-group w-100">
                        <input
                            type="date"
                            id="globalTermEnd"
                            class="form-control official-term-date-input"
                            value="{{ $termEnd }}"
                            data-raw="{{ $termEnd }}"
                            required
                        >
                        <span class="input-group-text official-term-date-open">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <p class="term-help mb-0">
                        Set the term once, then assign/update officials below. Every save will use this same term range.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row g-4">
    @foreach ($positions as $slot)
        @php
            $official = $officialsByPosition[$slot] ?? null;
            $resident = $official?->resident;
            $isAdminOwnOfficialSlot =
                $showControls
                && $currentUser
                && $currentUser->role === 'admin'
                && $official
                && $currentUserResidentId
                && (int) $official->resident_id === (int) $currentUserResidentId;
            $avatar = $resident && $resident->image_path
                ? asset('storage/' . $resident->image_path)
                : asset('images/default_profile.jpg');
            $publicOfficialName = $resident
                ? trim(collect([$resident->firstName, $resident->middleName, $resident->lastName])->filter()->implode(' '))
                : '';
            $publicOfficialTerm = null;
            if ($official && $official->start && $official->end) {
                $publicOfficialTerm = date('M d, Y', strtotime($official->start)) . ' - ' . date('M d, Y', strtotime($official->end));
            } elseif ($official) {
                $publicOfficialTerm = 'Term dates not set yet.';
            }
        @endphp

        <div class="col-12 col-md-6 col-xl-4">
            <div
                class="official-card {{ $showControls ? '' : 'official-card-public' }} {{ !$showControls && $official && $resident ? 'is-clickable' : '' }}"
                @if(!$showControls && $official && $resident)
                    role="button"
                    tabindex="0"
                    data-bs-toggle="modal"
                    data-bs-target="#officialDetailsModal"
                    data-official-name="{{ e($publicOfficialName) }}"
                    data-official-position="{{ e($slot) }}"
                    data-official-image="{{ e($avatar) }}"
                    data-official-term="{{ e($publicOfficialTerm ?? 'Not available') }}"
                    data-official-notes="{{ e($official->details ?: 'No public notes provided.') }}"
                @endif
            >
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
                            <p class="official-meta mb-0">Notes: {{ $official->details }}</p>
                        @endif

                        @if(!$showControls && $official && $resident)
                            <p class="official-public-hint mb-0" style= "color: gray;">Click to view public profile</p>
                        @endif
                    </div>
                </div>

                @if($showControls)
                    <div class="official-card-actions">
                        <p class="official-action-title mb-2">Assign / Update Resident</p>
                        <form method="POST" action="{{ route($routePrefix . '.assign.official') }}" class="row g-2 official-assign-form">
                            @csrf
                            <input type="hidden" name="position" value="{{ $slot }}">
                            <input type="hidden" name="start" class="official-start-hidden" value="{{ $termStart ?? now()->toDateString() }}">
                            <input type="hidden" name="end" class="official-end-hidden" value="{{ $termEnd ?? now()->copy()->addYears(3)->toDateString() }}">
                            <input type="hidden" name="term_start" value="{{ $termStart ?? now()->toDateString() }}">
                            <input type="hidden" name="term_end" value="{{ $termEnd ?? now()->copy()->addYears(3)->toDateString() }}">

                            <div class="col-12 position-relative">
    <label class="form-label">Search Resident</label>
    <div class="input-group">
        <input type="text"
            class="form-control resident-search-input"
            placeholder="Type name then Enter or Search"
            autocomplete="off"
            value="{{ $resident ? ucwords(strtolower($resident->lastName)).', '.ucwords(strtolower($resident->firstName)) : '' }}"
            {{ $isAdminOwnOfficialSlot ? 'readonly' : '' }}>
        
        <button type="button" class="btn btn-outline-primary resident-search-btn" {{ $isAdminOwnOfficialSlot ? 'disabled' : '' }}>
            <i class="fa fa-search"></i>
        </button>
    </div>

    <input type="hidden"
        name="resident_id"
        class="resident-id-input"
        value="{{ $official->resident_id ?? '' }}">

    <div class="resident-dropdown d-none"></div>
    <small class="search-help">Click search to see matching residents.</small>
    @if($isAdminOwnOfficialSlot)
        <small class="text-muted d-block mt-1">You cannot modify your own official position in this module.</small>
    @endif
</div>

                            <div class="col-12">
                                <label class="form-label">Term / Notes</label>
                                <input type="text" name="details" class="form-control" placeholder="e.g. 2024-2027 term" value="{{ $official ? $official->details : '' }}">
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fa fa-save me-1"></i> Save Assignment
                                </button>
                            </div>
                        </form>

                        @if($official && !$isAdminOwnOfficialSlot)
                            <form method="POST" action="{{ route($routePrefix . '.untag.official', $official->id) }}" class="mt-2" onsubmit="return confirm('Remove the resident from this position?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fa fa-times me-1"></i> Clear Assignment
                                </button>
                            </form>
                        @elseif($official && $isAdminOwnOfficialSlot)
                            <button type="button" class="btn btn-outline-danger w-100 mt-2" disabled>
                                <i class="fa fa-times me-1"></i> Clear Assignment
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@if(!$showControls)
    <div class="modal fade" id="officialDetailsModal" tabindex="-1" aria-labelledby="officialDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="officialDetailsModalLabel">Official Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="text-center mb-4">
                        <div class="official-modal-avatar-wrap">
                            <img src="{{ asset('images/default_profile.jpg') }}" alt="Official Photo" class="official-modal-avatar" id="officialModalImage">
                        </div>
                        <div class="official-modal-name" id="officialModalName">Official Name</div>
                        <div class="official-modal-position" id="officialModalPosition">Position</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="official-modal-meta-label">Term of Service</div>
                            <p class="official-modal-meta-value" id="officialModalTerm">Not available</p>
                        </div>
                        <div class="col-12">
                            <div class="official-modal-meta-label">Public Notes</div>
                            <p class="official-modal-meta-value" id="officialModalNotes">No public notes provided.</p>
                        </div>
                    </div>

                    <div class="official-privacy-note">
                        This profile only shows public-facing official details and excludes sensitive resident information such as contact details, birth date, age, address, household data, and account records.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const officialDetailsModal = document.getElementById('officialDetailsModal');

    if (!officialDetailsModal) {
        return;
    }

    const modalName = document.getElementById('officialModalName');
    const modalPosition = document.getElementById('officialModalPosition');
    const modalImage = document.getElementById('officialModalImage');
    const modalTerm = document.getElementById('officialModalTerm');
    const modalNotes = document.getElementById('officialModalNotes');
    const defaultImage = @json(asset('images/default_profile.jpg'));

    function populateOfficialModal(card) {
        modalName.textContent = card.getAttribute('data-official-name') || 'Official Name';
        modalPosition.textContent = card.getAttribute('data-official-position') || 'Position';
        modalImage.src = card.getAttribute('data-official-image') || defaultImage;
        modalTerm.textContent = card.getAttribute('data-official-term') || 'Not available';
        modalNotes.textContent = card.getAttribute('data-official-notes') || 'No public notes provided.';
        modalImage.alt = (modalName.textContent || 'Official') + ' Photo';
    }

    document.querySelectorAll('.official-card.is-clickable').forEach(function (card) {
        card.addEventListener('click', function () {
            populateOfficialModal(card);
        });

        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                populateOfficialModal(card);
                bootstrap.Modal.getOrCreateInstance(officialDetailsModal).show();
            }
        });
    });
});
    </script>
@endif

@if($showControls)
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const residents = @json($residents);
    const globalTermStart = document.getElementById('globalTermStart');
    const globalTermEnd = document.getElementById('globalTermEnd');

    function normalizeToYmd(raw) {
        if (!raw) return '';
        const d = new Date(raw);
        if (isNaN(d)) return '';
        return d.getFullYear() + '-' +
            String(d.getMonth() + 1).padStart(2, '0') + '-' +
            String(d.getDate()).padStart(2, '0');
    }

    function openPicker(inputEl) {
        if (!inputEl) return;
        if (inputEl.showPicker) inputEl.showPicker();
        else inputEl.focus();
    }

    document.querySelectorAll('.official-term-date-input').forEach(function (input) {
        const raw = input.getAttribute('data-raw') || input.value;
        const formatted = normalizeToYmd(raw);
        if (formatted) input.value = formatted;
    });

    document.querySelectorAll('.official-term-date-open').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const wrapper = trigger.closest('.input-group');
            const input = wrapper ? wrapper.querySelector('.official-term-date-input') : null;
            openPicker(input);
        });
    });

    function syncSharedTermToForms() {
        const startValue = globalTermStart ? globalTermStart.value : '';
        const endValue = globalTermEnd ? globalTermEnd.value : '';

        document.querySelectorAll('.official-start-hidden').forEach(function (input) {
            input.value = startValue;
        });

        document.querySelectorAll('.official-end-hidden').forEach(function (input) {
            input.value = endValue;
        });

        document.querySelectorAll('input[name="term_start"]').forEach(function (input) {
            input.value = startValue;
        });

        document.querySelectorAll('input[name="term_end"]').forEach(function (input) {
            input.value = endValue;
        });
    }

    if (globalTermStart && globalTermEnd) {
        syncSharedTermToForms();
        globalTermStart.addEventListener('change', syncSharedTermToForms);
        globalTermEnd.addEventListener('change', syncSharedTermToForms);
    }

    document.querySelectorAll('.official-assign-form').forEach(function (form) {
        const searchInput = form.querySelector('.resident-search-input');
        const searchBtn = form.querySelector('.resident-search-btn');
        const hiddenInput = form.querySelector('.resident-id-input');
        const dropdown = form.querySelector('.resident-dropdown');

        // your existing resident search code continues here...
        function closeDropdown() {
            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
        }

        function formatName(name) {
            if (!name) return '';
            return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
        }

        function runSearch() {
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
            }).slice(0, 8);

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
        }

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                runSearch();
            }
        });

        searchBtn.addEventListener('click', function () {
            runSearch();
            searchInput.focus();
        });

        form.addEventListener('submit', function (e) {
            if (!globalTermStart || !globalTermEnd) return;

            const startValue = globalTermStart.value;
            const endValue = globalTermEnd.value;

            if (!startValue || !endValue) {
                e.preventDefault();
                alert('Please set the shared Start Date and End Date first.');
                return;
            }

            if (new Date(endValue) < new Date(startValue)) {
                e.preventDefault();
                alert('End Date must be on or after Start Date.');
                return;
            }
        });

        document.addEventListener('click', function (e) {
            if (!form.contains(e.target)) closeDropdown();
        });
    });
});
</script>
@endif
