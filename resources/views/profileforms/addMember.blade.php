<style>
.resident-dropdown{
    position:absolute;
    z-index:1050;
    width:100%;
    background:white;
    border:1px solid #ddd;
    max-height:200px;
    overflow-y:auto;
    border-radius:4px;
}
.resident-option{
    padding:8px 10px;
    cursor:pointer;
    border-bottom:1px solid #eee;
}
.resident-option:hover{ background:#f0f0f0; }
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

                    <div class="mb-3 position-relative">
                        <label class="form-label">Search Resident</label>

                        <div class="input-group">
                            <input type="text"
                                   class="form-control resident-search-input"
                                   placeholder="Enter resident name then press Enter or click Search"
                                   autocomplete="off" required>

                            <button type="button" class="btn btn-outline-primary resident-search-btn">
                                Search
                            </button>
                        </div>

                        <input type="hidden" name="resident_id" class="resident-id-input">
                        <div class="resident-dropdown d-none"></div>

                        <div class="form-text">
                            Press Enter or click Search to show results.
                        </div>
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
document.addEventListener('DOMContentLoaded', function () {
    const residents = @json($residents);

    // Make sure IDs are numbers to match person.id type
    const existingMemberIds = new Set(
        (@json($members->pluck('resident_id')->toArray() ?? [])).map(Number)
    );

    const form = document.getElementById('addHouseholdMemberForm');
    const searchInput = document.querySelector('.resident-search-input');
    const searchBtn = document.querySelector('.resident-search-btn');
    const hiddenInput = document.querySelector('.resident-id-input');
    const dropdown = document.querySelector('.resident-dropdown');

    function closeDropdown() {
        dropdown.classList.add('d-none');
        dropdown.innerHTML = '';
    }

    function formatName(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1).toLowerCase() : '';
    }

    function runSearch() {
        const query = (searchInput.value || '').toLowerCase().trim();
        dropdown.innerHTML = '';
        hiddenInput.value = '';

        if (!query) {
            closeDropdown();
            return;
        }

        const matches = residents.filter(function (person) {
            const id = Number(person.id);

            // Skip residents already added
            if (existingMemberIds.has(id)) return false;

            const fullName = (
                person.lastName + ' ' +
                person.firstName + ' ' +
                (person.middleName ?? '')
            ).toLowerCase();

            return fullName.includes(query) || id.toString().includes(query);
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

            option.textContent = `${last}, ${first} ${middle ? middle : ''} (ID: ${person.id})`;

            option.addEventListener('click', function () {
                searchInput.value = option.textContent;
                hiddenInput.value = person.id;
                closeDropdown();
            });

            dropdown.appendChild(option);
        });

        dropdown.classList.remove('d-none');
    }

    // Do not reveal dropdown on typing
    searchInput.addEventListener('input', function () {
        hiddenInput.value = '';
        closeDropdown();
    });

    // Press Enter to search (prevent form submit)
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            runSearch();
        }
    });

    // Click button to search
    searchBtn.addEventListener('click', function () {
        runSearch();
        searchInput.focus();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!form.contains(e.target)) closeDropdown();
    });

    // Prevent submit unless a resident is selected
    form.addEventListener('submit', function (e) {
        if (!hiddenInput.value) {
            e.preventDefault();
            alert('Please select a resident from the dropdown.');
            searchInput.focus();
        }
    });

    // Optional: clear on modal open
    const modalEl = document.getElementById('addHouseholdMemberModal');
    if (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function () {
            searchInput.value = '';
            hiddenInput.value = '';
            closeDropdown();
        });
    }
});
</script>
@endpush
