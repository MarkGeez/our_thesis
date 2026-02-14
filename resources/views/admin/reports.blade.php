<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
        .reports-container {
            padding: 30px 20px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .report-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0a3a8a;
            padding-bottom: 15px;
        }

        .report-header h2 {
            color: #0a3a8a;
            margin: 0;
            font-weight: 600;
        }

        .filter-section {
            background: #f0f4f8;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #0a3a8a;
            box-shadow: 0 0 0 3px rgba(10, 58, 138, 0.1);
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-generate {
            background: #0a3a8a;
            color: white;
        }

        .btn-generate:hover {
            background: #062354;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(10, 58, 138, 0.3);
        }

        .btn-print {
            background: #4a7ebb;
            color: white;
        }

        .btn-print:hover {
            background: #3a5fa8;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 126, 187, 0.3);
        }

        .btn-pdf {
            background: #dc3545;
            color: white;
        }

        .btn-pdf:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .results-section {
            margin-top: 25px;
        }

        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #e7f3ff;
            border-left: 4px solid #0a3a8a;
            border-radius: 4px;
        }

        .results-info h6 {
            margin: 0;
            color: #0a3a8a;
            font-weight: 500;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
        }

        .results-table thead {
            background: #0a3a8a;
            color: white;
        }

        .results-table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #062354;
        }

        .results-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .results-table tbody tr:hover {
            background: #f8f9fa;
        }

        .results-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d4edda;
            color: #155724;
        }

        .badge-declined {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-completed {
            background: #d4edda;
            color: #155724;
        }

        .badge-ongoing {
            background: #d1ecf1;
            color: #0c5460;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-size: 16px;
        }

        .no-data i {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 15px;
            display: block;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading.show {
            display: block;
        }

        .spinner-border {
            color: #0a3a8a;
        }

        @media (max-width: 768px) {
            .filter-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .results-table {
                font-size: 12px;
            }

            .results-table th,
            .results-table td {
                padding: 8px 10px;
            }

            .filter-row {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])

<div class="main-wrapper">
    @include('admin.admin-header', ['admin' => auth()->user()])
    
    <main class="main reports-container" id="skip-target">
        <div class="report-card">
            <div class="report-header">
                <h2><i class="fas fa-file-alt"></i> Generate Reports</h2>
            </div>

            <!-- Report Type Selection -->
            <div class="filter-section">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="reportType">Report Type <span style="color: red;">*</span></label>
                        <select id="reportType" class="form-select">
                            <option value="">Select Report Type</option>
                            <option value="blotter">Blotter Reports</option>
                            <option value="certificate">Certificate Reports</option>
                            <option value="active_log">Active Logs Reports</option>
                            <option value="population">Population Reports</option>
                            <option value="household">Household Reports</option>
                        </select>
                    </div>
                </div>

                <!-- Date Range (Common for all reports) -->
                <div id="dateRangeFilters" class="filter-row" style="display: none;">
                    <div class="filter-group">
                        <label for="dateFrom">From Date</label>
                        <input type="date" id="dateFrom" class="form-control">
                    </div>
                    <div class="filter-group">
                        <label for="dateTo">To Date</label>
                        <input type="date" id="dateTo" class="form-control">
                    </div>
                </div>

                <!-- Blotter Filters -->
                <div id="blotterFilters" style="display: none;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="blotterStatus">Status</label>
                            <select id="blotterStatus" class="form-select">
                                <option value="">All Statuses</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="complainant">Complainant Name</label>
                            <input type="text" id="complainant" list="complainantOptions" class="form-control" placeholder="Enter complainant name">
                            <datalist id="complainantOptions"></datalist>
                        </div>
                        <div class="filter-group">
                            <label for="respondent">Respondent Name</label>
                            <input type="text" id="respondent" list="respondentOptions" class="form-control" placeholder="Enter respondent name">
                            <datalist id="respondentOptions"></datalist>
                        </div>
                    </div>
                </div>

                <!-- Certificate Filters -->
                <div id="certificateFilters" style="display: none;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="certificateType">Certificate Type</label>
                            <select id="certificateType" class="form-select">
                                <option value="">All Types</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="certificateStatus">Status</label>
                            <select id="certificateStatus" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Active Log Filters -->
                <div id="activeLogFilters" style="display: none;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="actionType">Action Type</label>
                            <select id="actionType" class="form-select">
                                <option value="">All Actions</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="actionUser">User</label>
                            <select id="actionUser" class="form-select">
                                <option value="">All Users</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Population Filters -->
                <div id="populationFilters" style="display: none;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="gender">Gender</label>
                            <select id="gender" class="form-select">
                                <option value="">All Genders</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="ageFrom">Ages From (Years)</label>
                            <input type="number" min="0" id="ageFrom" class="form-control" placeholder="e.g. 18">
                        </div>
                        <div class="filter-group">
                            <label for="ageTo">Ages To (Years)</label>
                            <input type="number" min="0" id="ageTo" class="form-control" placeholder="e.g. 60">
                        </div>
                    </div>
                </div>

                <!-- Household Filters -->
                <div id="householdFilters" style="display: none;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="houseNumber">House Number</label>
                            <input type="text" id="houseNumber" class="form-control" placeholder="Enter house number">
                        </div>
                        <div class="filter-group">
                            <label for="streetName">Street</label>
                            <input type="text" id="streetName" list="streetOptions" class="form-control" placeholder="Enter street name">
                            <datalist id="streetOptions"></datalist>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="button-group" style="margin-top: 20px;">
                    <button type="button" class="btn-action btn-generate" id="generateBtn">
                        <i class="fas fa-play-circle"></i> Generate Report
                    </button>
                    <button type="button" class="btn-action btn-print" id="printBtn" style="display: none;">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn-action btn-pdf" id="exportPdfBtn" style="display: none;">
                        <i class="fas fa-file-pdf"></i> Export to PDF
                    </button>
                </div>
            </div>

            <!-- Loading Indicator -->
            <div class="loading" id="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Generating report...</p>
            </div>

            <!-- Results Section -->
            <div class="results-section" id="resultsSection" style="display: none;">
                <div class="results-info">
                    <h6><i class="fas fa-check-circle"></i> Results: <span id="resultCount">0</span> records found</h6>
                </div>

                <table class="results-table" id="resultsTable">
                    <thead id="tableHead"></thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>

            <!-- No Results Message -->
            <div class="no-data" id="noData" style="display: none;">
                <i class="fas fa-inbox"></i>
                <p>No data found for the selected filters</p>
            </div>
        </div>
    </main>
</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>

<script>
    // Report Type Selection
    document.getElementById('reportType').addEventListener('change', function() {
        const reportType = this.value;
        
        // Hide all filter sections
        document.getElementById('dateRangeFilters').style.display = 'none';
        document.getElementById('blotterFilters').style.display = 'none';
        document.getElementById('certificateFilters').style.display = 'none';
        document.getElementById('activeLogFilters').style.display = 'none';
        document.getElementById('populationFilters').style.display = 'none';
        document.getElementById('householdFilters').style.display = 'none';

        if (reportType) {
            document.getElementById('dateRangeFilters').style.display = reportType === 'household' ? 'none' : 'grid';
            
            // Show specific filters based on report type
            switch(reportType) {
                case 'blotter':
                    document.getElementById('blotterFilters').style.display = 'block';
                    loadFilterOptions('blotter');
                    break;
                case 'certificate':
                    document.getElementById('certificateFilters').style.display = 'block';
                    loadFilterOptions('certificate');
                    break;
                case 'active_log':
                    document.getElementById('activeLogFilters').style.display = 'block';
                    loadFilterOptions('active_log');
                    break;
                case 'population':
                    document.getElementById('populationFilters').style.display = 'block';
                    loadFilterOptions('population');
                    break;
                case 'household':
                    document.getElementById('householdFilters').style.display = 'block';
                    loadFilterOptions('household');
                    break;
            }
        }
    });

    // Load filter options dynamically
    function loadFilterOptions(reportType) {
        fetch(`/admin/reports/filter-options/${reportType}`)
            .then(response => response.json())
            .then(data => {
                populateFilterOptions(reportType, data);
            })
            .catch(error => console.error('Error loading filter options:', error));
    }

    function populateFilterOptions(reportType, data) {
        switch(reportType) {
            case 'blotter':
                populateSelect('blotterStatus', data.statuses || []);
                populateDatalist('complainantOptions', data.complainants || []);
                populateDatalist('respondentOptions', data.respondents || []);
                break;
            case 'certificate':
                populateSelect('certificateType', data.types || []);
                break;
            case 'active_log':
                populateSelect('actionType', data.actions || []);
                populateUserSelect('actionUser', data.users || []);
                break;
            case 'household':
                populateDatalist('streetOptions', data.streets || []);
                break;
        }
    }

    function populateSelect(elementId, options) {
        const select = document.getElementById(elementId);
        const currentValue = select.value;
        
        // Keep the first empty option
        while (select.options.length > 1) {
            select.remove(1);
        }

        options.forEach(option => {
            const optionValue = typeof option === 'object' ? option.value : option;
            if (optionValue === null || optionValue === undefined || optionValue === '') {
                return;
            }
            const optionLabel = typeof option === 'object'
                ? option.label
                : String(option).charAt(0).toUpperCase() + String(option).slice(1);
            const opt = document.createElement('option');
            opt.value = optionValue;
            opt.textContent = optionLabel;
            select.appendChild(opt);
        });

        select.value = currentValue;
    }

    function populateDatalist(elementId, options) {
        const datalist = document.getElementById(elementId);
        datalist.innerHTML = '';

        options.forEach(option => {
            const value = typeof option === 'object' ? (option.value || '') : option;
            if (!value) {
                return;
            }
            const opt = document.createElement('option');
            opt.value = value;
            datalist.appendChild(opt);
        });
    }

    function populateUserSelect(elementId, users) {
        const select = document.getElementById(elementId);
        
        while (select.options.length > 1) {
            select.remove(1);
        }

        users.forEach(user => {
            const opt = document.createElement('option');
            opt.value = user.id;
            opt.textContent = user.firstName + ' ' + user.lastName;
            select.appendChild(opt);
        });
    }

    // Generate Report Button
    document.getElementById('generateBtn').addEventListener('click', function() {
        const reportType = document.getElementById('reportType').value;
        
        if (!reportType) {
            alert('Please select a report type');
            return;
        }

        generateReport(reportType);
    });

    function generateReport(reportType) {
        const loading = document.getElementById('loading');
        const resultsSection = document.getElementById('resultsSection');
        const noData = document.getElementById('noData');
        
        loading.classList.add('show');
        resultsSection.style.display = 'none';
        noData.style.display = 'none';

        const formData = new FormData();
        formData.append('date_from', document.getElementById('dateFrom').value);
        formData.append('date_to', document.getElementById('dateTo').value);

        // Add report-specific filters
        switch(reportType) {
            case 'blotter':
                formData.append('status', document.getElementById('blotterStatus').value);
                formData.append('complainant', document.getElementById('complainant').value);
                formData.append('respondent', document.getElementById('respondent').value);
                break;
            case 'certificate':
                formData.append('certificate_type', document.getElementById('certificateType').value);
                formData.append('status', document.getElementById('certificateStatus').value);
                break;
            case 'active_log':
                formData.append('action', document.getElementById('actionType').value);
                formData.append('user_id', document.getElementById('actionUser').value);
                break;
            case 'population':
                formData.append('gender', document.getElementById('gender').value);
                formData.append('age_from', document.getElementById('ageFrom').value);
                formData.append('age_to', document.getElementById('ageTo').value);
                break;
            case 'household':
                formData.append('house_number', document.getElementById('houseNumber').value);
                formData.append('street', document.getElementById('streetName').value);
                break;
        }

        const endpointMap = {
            'blotter': '{{ route("admin.reports.blotter") }}',
            'certificate': '{{ route("admin.reports.certificate") }}',
            'active_log': '{{ route("admin.reports.active-log") }}',
            'population': '{{ route("admin.reports.population") }}',
            'household': '{{ route("admin.reports.household") }}'
        };

        fetch(endpointMap[reportType], {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            loading.classList.remove('show');
            
            if (data.data && data.data.length > 0) {
                displayResults(data);
                document.getElementById('printBtn').style.display = 'inline-block';
                document.getElementById('exportPdfBtn').style.display = 'inline-block';
                document.getElementById('exportPdfBtn').onclick = function() {
                    exportToPdf(reportType);
                };
            } else {
                noData.style.display = 'block';
                document.getElementById('printBtn').style.display = 'none';
                document.getElementById('exportPdfBtn').style.display = 'none';
            }
        })
        .catch(error => {
            loading.classList.remove('show');
            console.error('Error:', error);
            alert('Error generating report. Please try again.');
        });
    }

    function displayResults(data) {
        const tableHead = document.getElementById('tableHead');
        const tableBody = document.getElementById('tableBody');
        const resultCount = document.getElementById('resultCount');
        const resultsSection = document.getElementById('resultsSection');

        tableHead.innerHTML = '';
        tableBody.innerHTML = '';

        if (!data.data || data.data.length === 0) return;

        // Get headers based on report type
        const headers = getTableHeaders(data.type);
        
        // Create table headers
        const headerRow = document.createElement('tr');
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        tableHead.appendChild(headerRow);

        // Create table rows
        data.data.forEach((record, index) => {
            const row = document.createElement('tr');
            const cells = getTableCells(record, data.type);
            cells.forEach(cell => {
                const td = document.createElement('td');
                td.innerHTML = cell;
                row.appendChild(td);
            });
            tableBody.appendChild(row);
        });

        resultCount.textContent = data.count;
        resultsSection.style.display = 'block';
    }

    function getTableHeaders(reportType) {
        const headersMap = {
            'blotter': ['Date', 'Complainant', 'Respondent', 'Description', 'Status', 'Action'],
            'certificate': ['Date', 'Requestor', 'Type', 'Status'],
            'active_log': ['Date', 'User', 'Action', 'Module', 'Description'],
            'population': ['Name', 'Age', 'Gender', 'Birthday', 'Contact'],
            'household': ['House #', 'Street', 'Head of Household', 'Members', 'Property Type']
        };
        return headersMap[reportType] || [];
    }

    function getTableCells(record, reportType) {
        switch(reportType) {
            case 'blotter':
                return [
                    new Date(record.created_at).toLocaleDateString(),
                    record.plaintiffName || '-',
                    record.defendantName || '-',
                    (record.blotterDescription || '').substring(0, 50) + '...',
                    `<span class="status-badge badge-${record.current_status.toLowerCase()}">${record.current_status}</span>`,
                    `<a href="#" class="text-primary">View</a>`
                ];
            case 'certificate':
                return [
                    new Date(record.created_at).toLocaleDateString(),
                    ((record.user?.firstName || '') + ' ' + (record.user?.lastName || '')).trim() || '-',
                    record.certificate_type || '-',
                    `<span class="status-badge badge-${record.status}">${record.status}</span>`
                ];
            case 'active_log':
                return [
                    new Date(record.created_at).toLocaleDateString(),
                    ((record.user?.firstName || '') + ' ' + (record.user?.lastName || '')).trim() || 'System',
                    record.action || '-',
                    record.module || record.model || '-',
                    record.description || '-'
                ];
            case 'population':
                return [
                    (record.firstName || '') + ' ' + (record.lastName || ''),
                    record.age || '-',
                    record.sex || '-',
                    record.birthday ? new Date(record.birthday).toLocaleDateString() : '-',
                    record.contactNo || '-'
                ];
            case 'household':
                const houseName = record.house?.house_no || '-';
                const streetName = record.house?.street?.street_name || '-';
                const headResident = (record.residents || []).find(resident => !!resident.pivot?.is_household_head);
                const headName = headResident ? ((headResident.firstName || '') + ' ' + (headResident.lastName || '')).trim() : '-';
                const memberCount = record.residents ? record.residents.length : 0;
                const propertyType = record.house?.property_type || '-';
                return [houseName, streetName, headName, memberCount, propertyType];
            default:
                return [];
        }
    }

    function exportToPdf(reportType) {
        const endpointMap = {
            'blotter': '{{ route("admin.reports.blotter") }}',
            'certificate': '{{ route("admin.reports.certificate") }}',
            'active_log': '{{ route("admin.reports.active-log") }}',
            'population': '{{ route("admin.reports.population") }}',
            'household': '{{ route("admin.reports.household") }}'
        };

        const payload = {
            export: 'pdf',
            date_from: document.getElementById('dateFrom').value,
            date_to: document.getElementById('dateTo').value,
        };

        switch(reportType) {
            case 'blotter':
                payload.status = document.getElementById('blotterStatus').value;
                payload.complainant = document.getElementById('complainant').value;
                payload.respondent = document.getElementById('respondent').value;
                break;
            case 'certificate':
                payload.certificate_type = document.getElementById('certificateType').value;
                payload.status = document.getElementById('certificateStatus').value;
                break;
            case 'active_log':
                payload.action = document.getElementById('actionType').value;
                payload.user_id = document.getElementById('actionUser').value;
                break;
            case 'population':
                payload.gender = document.getElementById('gender').value;
                payload.age_from = document.getElementById('ageFrom').value;
                payload.age_to = document.getElementById('ageTo').value;
                break;
            case 'household':
                payload.house_number = document.getElementById('houseNumber').value;
                payload.street = document.getElementById('streetName').value;
                break;
        }

        submitPost(endpointMap[reportType], payload);
    }

    function submitPost(url, payload) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name=\"csrf-token\"]')?.content || '';
        form.appendChild(csrfInput);

        Object.entries(payload).forEach(([key, value]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value ?? '';
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // Print functionality
    document.getElementById('printBtn').addEventListener('click', function() {
        window.print();
    });

    // Set today's date as default for date filter
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateFrom').valueAsDate = new Date();
    document.getElementById('dateTo').valueAsDate = new Date();
</script>
