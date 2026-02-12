<style>
    .resident-dropdown {
    position: absolute;
    z-index: 1000;
    width: 100%;
    background: white;
    border: 1px solid #ddd;
    max-height: 200px;
    overflow-y: auto;
    border-radius: 4px;
}

.resident-option {
    padding: 8px 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.resident-option:hover {
    background: #f0f0f0;
}

</style>

<form method="POST" action="{{ route($user->role. '.family.store') }}">
    @csrf
    <div class="mb-3 position-relative">
    <label class="form-label">Search Resident</label>

    <input type="text"
           class="form-control resident-search-input"
           placeholder="Enter resident name"
           autocomplete="off">

    <input type="hidden" name="resident_id" class="resident-id-input">

    <div class="resident-dropdown d-none"></div>
    </div>

    <input type="text" name="relationship" placeholder="kabit" >

    <button type="submit" class="btn btn-primary">Add Household Member</button>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Load all residents from backend
    const residents = @json($residents);

    const form = document.querySelector('form'); 
    const searchInput = document.querySelector('.resident-search-input');
    const hiddenInput = document.querySelector('.resident-id-input');
    const dropdown = document.querySelector('.resident-dropdown');

    function closeDropdown() {
        dropdown.classList.add('d-none');
    }

    function formatName(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1).toLowerCase() : '';
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
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!form.contains(e.target)) {
            closeDropdown();
        }
    });

    // Prevent submit unless a resident is selected
    form.addEventListener('submit', function (e) {
        if (!hiddenInput.value) {
            e.preventDefault();
            alert('Please select a resident from the dropdown.');
            searchInput.focus();
        }
    });

});
</script>
@endpush
