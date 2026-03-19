<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Reports</title>
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
            size: A4;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
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

        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .status-declined {
            background: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 3px;
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
    @foreach($reports->chunk(50) as $chunk)
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

        <div class="report-title">Certificate Requests Report</div>
        <div class="report-info">
            Generated on {{ now()->format('F d, Y H:i') }}
        </div>

        @if($chunk->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 18%;">Requestor Name</th>
                        <th style="width: 15%;">Certificate Type</th>
                        <th style="width: 30%;">Purpose</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 15%;">Requested By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $request)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                            <td>
                                @if($request->user)
                                    {{ $request->user->firstName }} {{ $request->user->lastName }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $request->certificate_type ?? '-' }}</td>
                            <td>{{ Str::limit($request->purpose ?? '', 80) }}</td>
                            <td>
                                <span class="status-{{ strtolower($request->status) }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>{{ $request->user->role ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                No certificate requests found for the selected period.
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
                {{ \App\Models\Setting::get('contact_number', '09170000000') }} ·
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
