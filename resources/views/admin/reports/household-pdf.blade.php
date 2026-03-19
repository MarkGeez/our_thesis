<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household Report</title>
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

        .household-block {
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 12px;
            background: #f9f9f9;
            break-inside: avoid;
        }

        .household-header {
            background: var(--navy);
            color: white;
            padding: 8px;
            margin: -12px -12px 10px -12px;
            font-weight: bold;
            font-size: 11px;
        }

        .household-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 10px;
            font-size: 9px;
        }

        .info-item {
            display: flex;
        }

        .info-label {
            font-weight: bold;
            color: var(--navy);
            min-width: 80px;
        }

        .info-value {
            flex-grow: 1;
        }

        .members-list {
            background: white;
            border: 1px solid #ddd;
            padding: 8px;
            margin-top: 10px;
            font-size: 8px;
            border-radius: 3px;
        }

        .members-title {
            font-weight: bold;
            color: var(--navy);
            margin-bottom: 6px;
            font-size: 9px;
        }

        .member-item {
            padding: 3px 0;
            border-bottom: 1px dotted #ddd;
            line-height: 1.3;
        }

        .member-item:last-child {
            border-bottom: none;
        }

        .member-head {
            font-weight: 600;
            color: var(--header-blue);
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
    @foreach($reports->chunk(30) as $chunk)
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

        <div class="report-title">Household Report</div>
        <div class="report-info">
            Generated on {{ now()->format('F d, Y H:i') }}
        </div>

        @if($chunk->count() > 0)
            @foreach($chunk as $household)
                <div class="household-block">
                    <div class="household-header">
                        Household #{{ $household->id }} - House No. {{ $household->house->house_no ?? '-' }}
                    </div>

                    <div class="household-info">
                        <div class="info-item">
                            <span class="info-label">Street:</span>
                            <span class="info-value">{{ $household->house->street->street_name ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Property Type:</span>
                            <span class="info-value">{{ $household->house->property_type ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Head of Household:</span>
                            <span class="info-value">
                                @if($household->head)
                                    {{ $household->head->firstName }} {{ $household->head->lastName }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Members:</span>
                            <span class="info-value">{{ $household->residents->count() }}</span>
                        </div>
                    </div>

                    <div class="members-list">
                        <div class="members-title"><i>Family Members:</i></div>
                        @if($household->residents->count() > 0)
                            @foreach($household->residents as $resident)
                                <div class="member-item">
                                    {{ $resident->firstName }} {{ $resident->lastName }}
                                    @if($resident->pivot->is_household_head)
                                        <span class="member-head">(Head)</span>
                                    @endif
                                    - Age: {{ $resident->age ?? '-' }}, {{ ucfirst($resident->sex ?? '') }}
                                </div>
                            @endforeach
                        @else
                            <div class="member-item">No members recorded</div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-data">
                No household records found.
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
