<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Population Report</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --header-blue: #4a7ebb;
            --text: #111;
            --muted: #666;
        }

        body {
            margin: 0;
            font-family: 'Times New Roman', serif;
            color: var(--text);
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        .page {
            width: 100%;
            padding: 10mm;
            background: white;
            position: relative;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            border-bottom: 2px solid var(--navy);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-logo {
            width: 50px;
            height: auto;
        }

        .header-text {
            flex-grow: 1;
        }

        .republic {
            font-size: 11px;
            margin-bottom: 2px;
        }

        .office-title {
            font-size: 13px;
            font-family: 'Goudy Text MT', 'Old English Text MT', serif;
            font-weight: bold;
            margin: 0;
        }

        .address-line {
            font-size: 9px;
            margin-top: 2px;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: var(--header-blue);
            letter-spacing: 3px;
            margin: 15px 0;
            text-transform: uppercase;
        }

        .report-info {
            font-size: 10px;
            text-align: center;
            margin-bottom: 15px;
            color: var(--muted);
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .stat-box {
            border: 1px solid var(--navy);
            padding: 8px;
            background: #f0f4f8;
            border-radius: 4px;
            text-align: center;
        }

        .stat-value {
            font-size: 14px;
            font-weight: bold;
            color: var(--navy);
        }

        .stat-label {
            font-size: 8px;
            color: var(--muted);
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 8px;
        }

        thead {
            background: var(--navy);
            color: white;
        }

        th {
            padding: 8px;
            text-align: left;
            border: 1px solid var(--navy);
            font-weight: bold;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(odd) {
            background: #f9f9f9;
        }

        .footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 20px;
            font-size: 8px;
            color: var(--muted);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .footer-column {
            flex: 1;
        }

        .footer-label {
            text-transform: uppercase;
            font-weight: bold;
            color: var(--navy);
            margin-bottom: 2px;
            font-size: 7px;
        }

        .footer-text {
            line-height: 1.3;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
            font-size: 14px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @php
        $totalCount = $reports->count();
        $maleCount = $reports->filter(fn($r) => $r->sex === 'male')->count();
        $femaleCount = $reports->filter(fn($r) => $r->sex === 'female')->count();
        $seniorCount = $reports->filter(fn($r) => $r->age >= 60)->count();
    @endphp

    @foreach($reports->chunk(40) as $chunk)
    <div class="page">
        <div class="header-container">
            <img src="{{ asset('images/Brgy-logo-1.png') }}" class="header-logo" alt="Barangay Logo">
            <div class="header-text">
                <div class="republic">Republic of the Philippines</div>
                <h1 class="office-title">Office of the Barangay Chairman</h1>
                <div class="address-line">Barangay 249 Zone 23 District II Tondo Manila</div>
                <div class="address-line">City of Manila</div>
            </div>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Ph_seal_ncr_manila.svg/250px-Ph_seal_ncr_manila.svg.png" class="header-logo" style="width: 50px;" alt="Manila Seal">
        </div>

        <div class="report-title">Population Report</div>
        <div class="report-info">
            Generated on {{ now()->format('F d, Y H:i') }}
        </div>

        @if($loop->first)
            <div class="summary-stats">
                <div class="stat-box">
                    <div class="stat-value">{{ $totalCount }}</div>
                    <div class="stat-label">Total Residents</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $maleCount }}</div>
                    <div class="stat-label">Male</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $femaleCount }}</div>
                    <div class="stat-label">Female</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $seniorCount }}</div>
                    <div class="stat-label">Senior Citizens (60+)</div>
                </div>
            </div>
        @endif

        @if($chunk->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 18%;">Full Name</th>
                        <th style="width: 8%;">Age</th>
                        <th style="width: 8%;">Gender</th>
                        <th style="width: 12%;">Birthday</th>
                        <th style="width: 12%;">Religion</th>
                        <th style="width: 12%;">Civil Status</th>
                        <th style="width: 10%;">Phone</th>
                        <th style="width: 12%;">Education</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $resident)
                        <tr>
                            <td>{{ $resident->id }}</td>
                            <td>{{ $resident->firstName }} {{ $resident->middleName ?? '' }} {{ $resident->lastName }}</td>
                            <td style="text-align: center;">{{ $resident->age ?? '-' }}</td>
                            <td style="text-align: center;">{{ ucfirst($resident->sex ?? '-') }}</td>
                            <td>{{ $resident->birthday ? \Carbon\Carbon::parse($resident->birthday)->format('M d, Y') : '-' }}</td>
                            <td>{{ $resident->religion ?? '-' }}</td>
                            <td>{{ $resident->civil_status ?? '-' }}</td>
                            <td>{{ $resident->contactNo ?? '-' }}</td>
                            <td>{{ $resident->educationalAttainment ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                No resident records found for the selected criteria.
            </div>
        @endif

        <div class="footer">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-label">Address</div>
                    <div class="footer-text">
                        {{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila') }}
                    </div>
                </div>
                <div class="footer-column">
                    <div class="footer-label">Contact</div>
                    <div class="footer-text">
                        {{ \App\Models\Setting::get('contact_number', '0999-123-4567') }} · 
                        {{ \App\Models\Setting::get('contact_email', 'brgy249@email.com') }}
                    </div>
                </div>
                <div class="footer-column" style="text-align: right;">
                    <div class="footer-label">Barangay Details</div>
                    <div class="footer-text">
                        Barangay 249, Zone 23, District II<br>
                        City of Manila<br>
                        <span style="font-size: 7px; color: var(--muted);">Page {{ $loop->iteration }} • Generated: {{ now()->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
