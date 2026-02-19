<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->report_name }} - Print</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --header-blue: #4a7ebb;
            --text: #111;
            --muted: #666;
        }

        body {
            margin: 0;
            background: #f0f0f0;
            font-family: 'Times New Roman', serif;
            color: var(--text);
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header-logo { width: 80px; height: auto; }
        .header-text { flex-grow: 1; }
        .republic { font-size: 14px; margin-bottom: 2px; }
        
        .office-title { 
            font-size: 22px; 
            font-family: 'Goudy Text MT', 'Old English Text MT', serif; 
            font-weight: bold;
            margin: 0;
        }

        .address-line { font-size: 13px; margin-top: 2px; }

        .cert-title {
            text-align: center;
            font-size: 28px;
            font-weight: normal;
            color: var(--header-blue);
            letter-spacing: 8px;
            margin: 30px 0 20px 0;
            text-transform: uppercase;
        }

        .report-info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: var(--muted);
        }

        .filter-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .filter-tag {
            display: inline-block;
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 12px;
            margin: 3px;
            font-size: 11px;
        }

        .content-body {
            font-size: 13px;
            line-height: 1.6;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px;
        }

        .table th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b;
            font-weight: 700;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #cbd5e1;
            white-space: nowrap;
        }

        .table td {
            padding: 6px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .table tbody tr:hover {
            background: #f1f5f9;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 15mm;
            left: 20mm;
            right: 20mm;
            border-top: 1px solid #eee;
            padding-top: 10px;
            color: var(--muted);
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .confidential-notice {
            text-align: center;
            font-size: 9px;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media print {
            body { background: white; padding: 0; }
            .page { box-shadow: none; width: 100%; height: 100%; }
            .print-button { display: none; }
        }

        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 18px;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            z-index: 100;
        }

        .back-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 10px 18px;
            background: #666;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            z-index: 100;
        }
    </style>
</head>
<body>
    <a href="{{ route('admin.reports.view', $report->id) }}" class="back-button">← Back to Report</a>
    <button class="print-button" onclick="window.print()">Print Report</button>

    <div class="page">
        <div class="header-container">
            <img src="{{ asset('images/Brgy-logo-1.png') }}" class="header-logo" alt="Barangay Logo">
            <div class="header-text">
                <div class="republic">Republic of the Philippines</div>
                <h1 class="office-title">Office of the Barangay Chairman</h1>
                <div class="address-line">Barangay 249 Zone 23 District II Tondo Manila</div>
                <div class="address-line">City of Manila</div>
            </div>
            <div style="display: flex; gap: 5px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Ph_seal_ncr_manila.svg/250px-Ph_seal_ncr_manila.svg.png" class="header-logo" style="width: 60px;" alt="Manila Seal">
                <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" class="header-logo" style="width: 60px;" alt="Bagong Pilipinas">
            </div>
        </div>

        <div class="cert-title">{{ strtoupper($report->report_type) }} Reports</div>

        <div class="report-info">
            <div><strong>Report Title:</strong> {{ $report->report_name }}</div>
            <div><strong>Generated:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</div>
            <div><strong>Total Records:</strong> {{ number_format($report->total_records) }}</div>
        </div>

        {{-- @if($report->filters_used)
            @php $used = json_decode($report->filters_used, true); @endphp
            <div class="filter-info">
                <strong>Applied Filters:</strong><br>
                @foreach($used as $key => $val)
                    @continue(in_array($key, ['report_name', 'generated_by', 'report_form_type']))
                    @continue($val === null || $val === '')
                    <span class="filter-tag">
                        <strong>{{ ucwords(str_replace(['_', '-'], ' ', $key)) }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}
                    </span>
                @endforeach
            </div>
        @endif  --}}

        <div class="content-body">
            @php $type = strtolower($report->report_type); @endphp
            
            <table class="table">
                <thead>
                    <tr>
                        @if($type == 'population')
                            <th data-col="full_name">Full Name</th>
                            <th data-col="birthdate">Birthdate</th>
                            <th data-col="age">Age</th>
                            <th data-col="sex">Sex</th>
                            <th data-col="street">Street</th>
                            <th data-col="parent_status">Parent Status</th>
                            @if(\Schema::hasColumn('residents', 'civil_status'))
                                <th data-col="civil_status">Civil Status</th>
                            @endif
                        @elseif($type == 'blotter')
                            <th data-col="plaintiff">Plaintiff</th>
                            <th data-col="defendant">Defendant</th>
                            <th data-col="status">Status</th>
                        @elseif($type == 'certificate')
                            <th data-col="resident">Resident</th>
                            <th data-col="certificate_type">Certificate Type</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            @if($type == 'population')
                                <td data-col="full_name">{{ ucwords(strtolower($row->firstName)) }} {{ ucwords(strtolower($row->middleName)) }} {{ ucwords(strtolower($row->lastName)) }}</td>
                                <td data-col="birthdate">{{ $row->birthday }}</td>
                                <td data-col="age">{{ $row->age }}</td>
                                <td data-col="sex">{{ ucfirst($row->sex) }}</td>
                                <td data-col="street">{{ $row->street }}</td>
                                <td data-col="parent_status">{{ ucfirst($row->parent) }}</td>
                                @if(\Schema::hasColumn('residents', 'civil_status'))
                                    <td data-col="civil_status">{{ $row->civil_status ?? '' }}</td>
                                @endif
                            @elseif($type == 'blotter')
                                <td data-col="plaintiff">{{ $row->plaintiffName }} {{ $row->plaintiffLastName }}</td>
                                <td data-col="defendant">{{ $row->defendantName }} {{ $row->defendantLastName }}</td>
                                <td data-col="status">{{ ucfirst($row->status) }}</td>
                            @elseif($type == 'certificate')
                                <td data-col="resident">{{ $row->requesterName }}</td>
                                <td data-col="certificate_type">{{ ucfirst(str_replace('_', ' ', $row->certificate_type)) }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; color: #666;">No records matched the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <footer class="footer">
            <div class="footer-content">
                <div>
                    <div>Date Printed: <span id="print-date"></span></div>
                </div>
                <div style="text-align: right;">
                    <div>Barangay 249, Zone 23, District II</div>
                    <div>Page 1 of 1</div>
                </div>
            </div>
            <div class="confidential-notice">
                This document is for official use only. Unauthorized reproduction is strictly prohibited.
            </div>
        </footer>
    </div>

    <script>
        // Automatically sets the current date and time in the footer
        const now = new Date();
        document.getElementById('print-date').innerText = now.toLocaleString();

        // Handle column visibility based on URL parameters
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const colsParam = params.get('cols');
            
            if (colsParam) {
                const visibleCols = new Set(colsParam.split(','));
                const table = document.querySelector('.table');
                
                if (table) {
                    // Hide header columns
                    const headerCells = table.querySelectorAll('thead th');
                    headerCells.forEach((th, index) => {
                        const isVisible = visibleCols.has(th.getAttribute('data-col') || `col_${index}`);
                        th.style.display = isVisible ? '' : 'none';
                    });
                    
                    // Hide body columns
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((td, index) => {
                            const dataCol = td.getAttribute('data-col');
                            const isVisible = visibleCols.has(dataCol || `col_${index}`);
                            td.style.display = isVisible ? '' : 'none';
                        });
                    });
                }
            }
        });
    </script>
</body>
</html>
