<nav class="main-nav--bg">
    <style>
        .header-user-trigger {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 4px 10px 4px 4px;
            border-radius: 999px;
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        .header-user-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.1;
        }

        .header-user-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e293b;
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-user-hint {
            font-size: 0.68rem;
            color: #64748b;
        }

        .header-user-trigger {
            transition: all 0.2s ease;
        }

        .header-user-trigger:hover {
            border-color: #bfdbfe;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
            transform: translateY(-1px);
        }

        .nav-user-wrapper:focus-within .header-user-trigger {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .nav-user-wrapper .users-item-dropdown {
            min-width: 240px;
            margin-top: 8px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            opacity: 0;
            transform: translateY(-6px) scale(0.98);
            transform-origin: top right;
            transition: opacity 0.18s ease, transform 0.18s ease;
            pointer-events: none;
        }

        .nav-user-wrapper .users-item-dropdown.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .nav-user-wrapper .users-item-dropdown li a,
        .nav-user-wrapper .users-item-dropdown li button {
            border-radius: 10px;
            margin: 4px 8px;
            padding: 10px 12px;
            transition: background-color 0.18s ease, color 0.18s ease;
        }

        .nav-user-wrapper .users-item-dropdown li a:hover,
        .nav-user-wrapper .users-item-dropdown li button:hover {
            background: #f1f5f9;
        }

        .nav-user-wrapper .users-item-dropdown hr {
            margin: 6px 10px;
            border-color: #e2e8f0;
        }

        @media (max-width: 768px) {
            .header-user-meta {
                display: none;
            }

            .header-user-trigger {
                padding-right: 4px;
            }
        }
    </style>

    <div class="container main-nav">
        <div class="main-nav-start">
            <div style="display:inline-block; margin-right:12px;">
                <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}"
                    alt="logo" style="width:50px; height:auto; display:block;">
            </div>
        </div>
        <div class="main-nav-end">
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle--gray" aria-hidden="true"></span>
            </button>

            <div class="nav-user-wrapper">
                <button class="nav-user-btn dropdown-btn header-user-trigger" title="Open profile menu" type="button" aria-label="Open profile menu and logout options">
                    <span class="sr-only">Open profile menu</span>
                    <span class="nav-user-img">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default_profile.jpg') }}" alt="User profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                    </span>
                    <span class="header-user-meta">
                        <span class="header-user-name">{{ ucwords(trim(auth()->user()->firstName . ' ' . auth()->user()->lastName)) }}</span>
                        <span class="header-user-hint">Profile & Logout</span>
                    </span>
                    <i data-feather="chevron-down" aria-hidden="true" style="width:16px; height:16px; color:#64748b;"></i>
                </button>

                <ul class="users-item-dropdown nav-user-dropdown dropdown">
                    <li class="user-info text-center">
                        <h3 class="user-name mb-2">{{ ucwords(trim(auth()->user()->firstName . ' ' . auth()->user()->lastName)) }}</h3>
                        <p class="text-secondary user-role text-muted small">Admin</p>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('admin.profile') }}">
                            <i data-feather="user" aria-hidden="true"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="danger" style="background: none; border: none; padding: 0; width: 100%; text-align: left;">
                                <i style="color: #dc3545" data-feather="log-out" aria-hidden="true"></i>
                                <span class="text-danger">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@include('components.form-submit-stopper')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameFieldSelector = [
            'input[type="text"][name="firstName"]',
            'input[type="text"][name="middleName"]',
            'input[type="text"][name="lastName"]',
            'input[type="text"][name="emergencyContactName"]',
            'input[type="text"][name="firstname"]',
            'input[type="text"][name="middlename"]',
            'input[type="text"][name="lastname"]',
            'input[type="text"][name="emergencycontactname"]'
        ].join(',');

        const namePattern = /^[A-Za-z ]+$/;

        function sanitizeName(value) {
            return value
                .replace(/[^A-Za-z ]+/g, '')
                .replace(/\s{2,}/g, ' ')
                .replace(/^\s+/, '');
        }

        function isOptionalNameField(field) {
            const name = (field.getAttribute('name') || '').toLowerCase();
            return name === 'middlename' || name === 'emergencycontactname';
        }

        function validateNameField(field) {
            const trimmed = field.value.trim();
            const optionalField = isOptionalNameField(field);

            if (!trimmed && optionalField) {
                field.setCustomValidity('');
                return true;
            }

            if (!trimmed) {
                field.setCustomValidity('This field is required.');
                return false;
            }

            if (!namePattern.test(trimmed)) {
                field.setCustomValidity('Only letters and spaces are allowed.');
                return false;
            }

            field.setCustomValidity('');
            return true;
        }

        function setupNameValidation(field) {
            field.setAttribute('autocomplete', 'off');
            field.setAttribute('pattern', '[A-Za-z ]+');
            field.setAttribute('title', 'Only letters and spaces are allowed.');

            field.addEventListener('input', function () {
                const caret = field.selectionStart;
                const previousLength = field.value.length;
                field.value = sanitizeName(field.value);

                if (typeof caret === 'number') {
                    const delta = previousLength - field.value.length;
                    const nextCaret = Math.max(0, caret - delta);
                    field.setSelectionRange(nextCaret, nextCaret);
                }

                validateNameField(field);
            });

            field.addEventListener('blur', function () {
                field.value = field.value.replace(/\s{2,}/g, ' ').trim();
                validateNameField(field);
            });

            validateNameField(field);
        }

        document.querySelectorAll(nameFieldSelector).forEach(setupNameValidation);

        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                const fields = form.querySelectorAll(nameFieldSelector);
                let isValid = true;

                fields.forEach(function (field) {
                    field.value = field.value.replace(/\s{2,}/g, ' ').trim();
                    if (!validateNameField(field)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    const firstInvalidField = Array.from(fields).find(function (field) {
                        return !field.checkValidity();
                    });

                    if (firstInvalidField) {
                        firstInvalidField.reportValidity();
                        firstInvalidField.focus();
                    }
                }
            });
        });
    });
</script>
