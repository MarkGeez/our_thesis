<style>
.resident-dropdown {
    position: relative;
    width: 100%;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-top: 4px;
    z-index: 2000;
    /* Prevent the dropdown from covering fields below in the modal */
    max-height: 160px;
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

.resident-option-name {
    display: block;
    font-weight: 600;
    color: #0f172a;
}

.resident-option-meta {
    display: block;
    margin-top: 2px;
    font-size: 0.8rem;
    color: #64748b;
}

.search-help {
    font-size: 0.8rem;
    color: #94a3b8;
}

.resident-dropdown-message {
    padding: 10px 12px;
    font-size: 0.9rem;
    color: #64748b;
}
</style>

<div class="modal fade" id="addHouseholdMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add Household Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addHouseholdMemberForm" method="POST" action="{{ route($user->role. '.family.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Search Resident</label>

                        <div class="position-relative">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control resident-search-input"
                                       placeholder="Type name then Enter or Search"
                                       autocomplete="off" required>

                                <button type="button" class="btn btn-outline-primary resident-search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                            <input type="hidden" name="resident_id" class="resident-id-input">
                            <div class="resident-dropdown d-none"></div>
                        </div>

                        <small class="search-help d-block mt-1" style="font-size: 0.8rem; color: #94a3b8;">Click search to see matching residents.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Relationship</label>
                        <select name="relationship" class="form-select" required>
                            <option value="">-- Select Relationship --</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Child">Child</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Grandparent">Grandparent</option>
                            <option value="Grandchild">Grandchild</option>
                            <option value="In-law">In-law</option>
                            <option value="Nephew">Nephew</option>
                            <option value="Niece">Niece</option>
                            <option value="Cousin">Cousin</option>
                            <option value="Partner">Partner</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addHouseholdMemberForm" class="btn btn-success">Add Household Member</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function initializeAddMemberModal() {
    const residents = @json($residents);
    const currentResidentId = Number(@json(optional($resident)->id));
    const existingMemberIds = new Set(
        (@json($members->pluck('resident_id')->toArray() ?? [])).map(Number)
    );

    const modalEl = document.getElementById('addHouseholdMemberModal');
    if (!modalEl || modalEl.dataset.searchInitialized === 'true') {
        return;
    }

    modalEl.dataset.searchInitialized = 'true';

    const form = document.getElementById('addHouseholdMemberForm');
    const searchInput = modalEl.querySelector('.resident-search-input');
    const searchBtn = modalEl.querySelector('.resident-search-btn');
    const hiddenInput = modalEl.querySelector('.resident-id-input');
    const dropdown = modalEl.querySelector('.resident-dropdown');

    if (!form || !searchInput || !searchBtn || !hiddenInput || !dropdown) {
        return;
    }

    const currentResident = residents.find(p => Number(p.id) === currentResidentId) || null;
    const headLastNameNorm = normalize(currentResident?.lastName);

    function residentHouseKey(person) {
        if (!person) return null;
        if (person.streetId === null || person.streetId === undefined) return null;
        const houseNoNorm = normalize(person.houseNo);
        if (!houseNoNorm) return null;
        return `${person.streetId}-${houseNoNorm}`;
    }

    const headHouseKey = residentHouseKey(currentResident);

    function closeDropdown() {
        dropdown.classList.add('d-none');
        dropdown.innerHTML = '';
    }

    function showDropdownMessage(message) {
        dropdown.innerHTML = '<div class="resident-dropdown-message">' + message + '</div>';
        dropdown.classList.remove('d-none');
    }

    function formatName(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1).toLowerCase() : '';
    }

    function normalize(value) {
        return (value || '').toString().toLowerCase().replace(/\s+/g, ' ').trim();
    }

    function buildSearchTerms(person) {
        const first = normalize(person.firstName);
        const middle = normalize(person.middleName);
        const last = normalize(person.lastName);

        return [
            [first, middle, last].filter(Boolean).join(' '),
            [first, last].filter(Boolean).join(' '),
            [last, first, middle].filter(Boolean).join(' '),
            [last, first].filter(Boolean).join(' '),
            [first, last].filter(Boolean).join(', '),
            [last, first].filter(Boolean).join(', '),
        ];
    }

    function isHeadTagged(person) {
        return normalize(person && person.headOfFamily) === 'yes';
    }

    function formatBirthday(value) {
        if (!value) return 'Birthday: N/A';

        const parsed = new Date(value);
        if (Number.isNaN(parsed.getTime())) {
            return 'Birthday: ' + value;
        }

        return 'Birthday: ' + parsed.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: '2-digit'
        });
    }

    function formatSex(value) {
        if (!value) return 'Sex: N/A';
        return 'Sex: ' + formatName(value);
    }

    function formatContact(value) {
        return 'Contact: ' + (value || 'N/A');
    }

    function renderDropdownOptions(people, options = {}) {
        dropdown.innerHTML = '';
        const headerTitle = options?.headerTitle ? options.headerTitle : null;
        if (headerTitle) {
            const header = document.createElement('div');
            header.classList.add('resident-dropdown-message');
            header.style.fontWeight = '700';
            header.textContent = headerTitle;
            dropdown.appendChild(header);
        }

        people.forEach(function (item) {
            const person = item?.person ? item.person : item;
            const note = item?.note ? item.note : null;

            const option = document.createElement('div');
            option.classList.add('resident-option');

            const last = formatName(person.lastName);
            const first = formatName(person.firstName);
            const middle = formatName(person.middleName);
            const fullName = `${last}, ${first}${middle ? ' ' + middle : ''}`;
            const birthday = formatBirthday(person.birthday);
            const sex = formatSex(person.sex);
            const contact = formatContact(person.contactNo);

            option.innerHTML = `
                <span class="resident-option-name">${fullName}</span>
                <span class="resident-option-meta">${birthday} | ${sex} | ${contact}${note ? '<br><span style="color:#0d6efd;font-weight:600;">' + note + '</span>' : ''}</span>
            `;

            option.addEventListener('click', function () {
                searchInput.value = fullName;
                hiddenInput.value = person.id;
                closeDropdown();
            });

            dropdown.appendChild(option);
        });

        dropdown.classList.remove('d-none');
    }

    function getSuggestedResidents() {
        if (!currentResident) return [];

        // If head has no address information, fall back to same-last-name suggestions.
        // (Otherwise, suggestions are based on same street + house number.)
        if (!headHouseKey) {
            const lastNameFallback = residents
                .filter(function (person) {
                    const id = Number(person.id);
                    if (existingMemberIds.has(id)) return false;
                    if (id === currentResidentId) return false;
                    if (isHeadTagged(person)) return false;
                    return headLastNameNorm && normalize(person.lastName) === headLastNameNorm;
                })
                .slice(0, 8);
            return lastNameFallback;
        }

        const suggested = residents
            .filter(function (person) {
                const id = Number(person.id);
                if (existingMemberIds.has(id)) return false;
                if (id === currentResidentId) return false;
                if (isHeadTagged(person)) return false;

                const addressMatch = headHouseKey && residentHouseKey(person) === headHouseKey;
                // Only suggest residents from the same street + house number.
                return addressMatch;
            })
            .map(function (person) {
                const addressMatch = headHouseKey && residentHouseKey(person) === headHouseKey;
                const lastMatch = headLastNameNorm && normalize(person.lastName) === headLastNameNorm;
                const note = lastMatch
                    ? 'Suggested: same last name and same street/house as head'
                    : 'Suggested: same street/house as head';
                return {
                    person,
                    // Same last name + same street+house should float to the top.
                    score: (addressMatch ? 2 : 0) + (lastMatch ? 2 : 0),
                    note
                };
            })
            .sort((a, b) => b.score - a.score)
            .map(x => ({ person: x.person, note: x.note }))
            .slice(0, 8);

        return suggested;
    }

    function runSearch() {
        const query = normalize(searchInput.value);
        dropdown.innerHTML = '';
        hiddenInput.value = '';

        if (!query) {
            showDropdownMessage('Enter a resident name or ID first.');
            return;
        }

        const matches = residents.filter(function (person) {
            const id = Number(person.id);

            if (existingMemberIds.has(id)) return false;
            if (id === currentResidentId) return false;
            if (isHeadTagged(person)) return false;

            const searchableNames = buildSearchTerms(person);

            return searchableNames.some(function (value) {
                return value.includes(query);
            }) || id.toString().includes(query);
        }).slice(0, 8);

        if (matches.length === 0) {
            showDropdownMessage('No matching residents found.');
            return;
        }

        renderDropdownOptions(matches, { headerTitle: null });
    }

    searchInput.addEventListener('input', function () {
        hiddenInput.value = '';
        closeDropdown();
    });

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

    document.addEventListener('click', function (e) {
        if (!modalEl.contains(e.target)) {
            closeDropdown();
        }
    });

    form.addEventListener('submit', function (e) {
        if (!hiddenInput.value) {
            e.preventDefault();
            alert('Please select a resident from the dropdown.');
            searchInput.focus();
        }
    });

    modalEl.addEventListener('shown.bs.modal', function () {
        searchInput.value = '';
        hiddenInput.value = '';
        const suggested = getSuggestedResidents();
        if (!suggested.length) {
            showDropdownMessage('No suggested residents found. Use search to tag a resident.');
        } else {
            renderDropdownOptions(suggested, { headerTitle: 'Suggested Members' });
        }
        searchInput.focus();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAddMemberModal);
} else {
    initializeAddMemberModal();
}
</script>
@endpush
