<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 8mm 14mm 12mm 14mm;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 6px;
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
            margin: 12px 0 8px 0;
            text-transform: uppercase;
        }

        .report-info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--muted);
        }

        .content-body {
            font-size: 13px;
            line-height: 1.6;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px; /* Slightly smaller to ensure 28 rows fit comfortably */
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
            padding: 5px 6px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) { background: #f8fafc; }

        .footer {
            position: absolute;
            bottom: 6mm;
            left: 14mm;
            right: 14mm;
            font-family: Arial, sans-serif;
        }

        .footer-rule {
            height: 3px;
            background: linear-gradient(90deg, var(--navy) 0%, var(--header-blue) 100%);
            border-radius: 2px;
            margin-bottom: 0;
        }
        .footer-rule-thin {
            height: 1px;
            background: #d1dff5;
            margin-bottom: 6px;
            margin-top: 2px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        .footer-contact-row {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 8.5px;
            color: #444;
            line-height: 1.4;
        }
        .footer-contact-row .dot {
            width: 3px; height: 3px; border-radius: 50%;
            background: var(--header-blue); flex-shrink: 0;
        }

        .footer-center { text-align: center; flex-shrink: 0; }
        .footer-date-label { font-size: 7.5px; text-transform: uppercase; letter-spacing: 1px; color: #888; }
        .footer-date-value { font-size: 9px; font-weight: 700; color: var(--navy); }
        .footer-page { margin-top: 3px; font-size: 11px; color: #888; }

        .footer-office { text-align: right; font-size: 8.5px; color: #444; line-height: 1.5; }
        .footer-office-name { font-weight: 700; font-size: 9px; color: var(--navy); text-transform: uppercase; }

        .report-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--muted);
        }

        .report-info-left {
            text-align: left;
        }

        .stats-summary {
            display: grid;
            grid-auto-flow: column;
            grid-template-rows: repeat(3, auto);
            justify-content: end;
            align-content: start;
            column-gap: 56px;
            gap: 2px;
            
        }

        .stat-pill {
            display: inline-flex;
            align-items: baseline;
            gap: 4px;
            white-space: nowrap;
            padding: 0;
            border: 0;
            border-radius: 0;
            font-size: 12px;
            background: transparent;
            font-weight: 400;
            color: #334155;
        }

        .stat-pill .stat-count {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-pill .stat-label {
            color: #334155;
            font-weight: 600;
            margin-left: 15px;
        }

        .confidential-notice {
            margin-top: 5px; padding: 3px 10px;
            background: linear-gradient(90deg, #f0f4ff 0%, #e8eeff 100%);
            border: 1px solid #c7d4f0; border-radius: 3px;
            text-align: center; font-size: 7.5px; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--navy); font-weight: 600;
        }

        @media print {
            body { background: white; padding: 0; }
            .page { 
                box-shadow: none; 
                margin-bottom: 0; 
                page-break-after: always; 
            }
            .page:last-child { page-break-after: auto; }
            .print-button, .back-button { display: none; }
        }

        .print-button, .back-button {
            position: fixed; bottom: 20px; padding: 10px 18px;
            color: white; border: none; border-radius: 4px;
            cursor: pointer; z-index: 100; text-decoration: none; font-size: 14px;
        }
        .print-button { right: 20px; background: var(--navy); }
        .back-button { left: 20px; background: #666; }

        body.pdf-mode .print-button,
        body.pdf-mode .back-button {
            display: none !important;
        }
    </style>
</head>
<body>
    <a href="{{ route('admin.reports.view', $report->id) }}" class="back-button">← Back to Report</a>
    <button class="print-button" onclick="window.print()">Print Report</button>

    @php 
        $type = strtolower($report->report_type);
        $filtersUsed = is_array($report->filters_used)
            ? $report->filters_used
            : (json_decode($report->filters_used, true) ?? []);
        $householdScope = ($type === 'household' && (($filtersUsed['report_scope'] ?? 'summary') === 'family_members'))
            ? 'family_members'
            : 'summary';
        $allData = collect($data);
        $chunks = $allData->chunk(25);
        $totalPages = count($chunks);

        // ── Stats computation ─────────────────────────────────────────────
        $stats = [];

        if ($type === 'blotter') {
            $statusGroups = $allData->groupBy(fn($r) => strtolower($r->status ?? 'unknown'));
            $stats[] = ['label' => 'Total Cases',     'value' => $allData->count(),                            'color' => 'black'];
            $stats[] = ['label' => 'Pending',         'value' => $statusGroups->get('pending',   collect())->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'Resolved',        'value' => $statusGroups->get('resolved',  collect())->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Dismissed',       'value' => $statusGroups->get('dismissed', collect())->count(), 'color' => 'slate'];

        } elseif ($type === 'certificate') {
            $statusGroups  = $allData->groupBy(fn($r) => strtolower($r->status ?? 'unknown'));
            $stats[] = ['label' => 'Total Requests', 'value' => $allData->count(),                              'color' => 'black'];
            $stats[] = ['label' => 'Approved',        'value' => ($statusGroups->get('approved',  collect())->count() ?: $statusGroups->get('released', collect())->count()),  'color' => 'green'];
            $stats[] = ['label' => 'Pending',         'value' => $statusGroups->get('pending',    collect())->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'Rejected',        'value' => $statusGroups->get('rejected',   collect())->count(), 'color' => 'red'];

        } elseif ($type === 'population') {
            $params     = request()->input('cols', '');
            $visCols    = $params ? explode(',', $params) : [];
            $showSex    = empty($visCols) || in_array('sex', $visCols);
            $showParent = empty($visCols) || in_array('parent_status', $visCols);
            $showAge    = empty($visCols) || in_array('age', $visCols);
            $showCivil  = empty($visCols) || in_array('civil_status', $visCols);

            $stats[] = ['label' => 'Total Residents', 'value' => $allData->count(), 'color' => 'black'];

            if ($showSex) {
                $sexGroups = $allData->groupBy(fn($r) => strtolower($r->sex ?? 'unknown'));
                $stats[] = ['label' => 'Male',   'value' => ($sexGroups->get('male',   collect())->count() ?: $sexGroups->get('m', collect())->count()), 'color' => 'black'];
                $stats[] = ['label' => 'Female', 'value' => ($sexGroups->get('female', collect())->count() ?: $sexGroups->get('f', collect())->count()), 'color' => 'black'];
            }

            if ($showAge) {
                $minors  = $allData->filter(fn($r) => (int)($r->age ?? 0) < 18)->count();
                $seniors = $allData->filter(fn($r) => (int)($r->age ?? 0) >= 60)->count();
                $stats[] = ['label' => 'Minors (< 18)',    'value' => $minors,  'color' => 'black'];
                $stats[] = ['label' => 'Seniors (60+)',    'value' => $seniors, 'color' => 'black'];
            }

            if ($showParent) {
                $parentGroups = $allData->groupBy(fn($r) => strtolower($r->parent ?? 'unknown'));
                $parentCount = 0;
                $notParentCount = 0;

                foreach ($parentGroups as $pKey => $pGroup) {
                    $normalized = trim(strtolower((string) $pKey));
                    if (in_array($normalized, ['', 'unknown', 'n/a'])) {
                        continue;
                    }

                    if (in_array($normalized, ['no', 'n', 'false', '0', 'not a parent', 'not parent', 'non-parent'])) {
                        $notParentCount += $pGroup->count();
                        continue;
                    }

                    if (str_contains($normalized, 'not') && str_contains($normalized, 'parent')) {
                        $notParentCount += $pGroup->count();
                        continue;
                    }

                    $parentCount += $pGroup->count();
                }

                if ($parentCount > 0) {
                    $stats[] = ['label' => 'Parent', 'value' => $parentCount, 'color' => 'black'];
                }

                if ($notParentCount > 0) {
                    $stats[] = ['label' => 'Not A Parent', 'value' => $notParentCount, 'color' => 'black'];
                }
            }
        } elseif ($type === 'household') {
            if ($householdScope === 'family_members') {
                $stats[] = ['label' => 'Tagged Members', 'value' => $allData->count(), 'color' => 'black'];
                $stats[] = ['label' => 'Families (Heads)', 'value' => $allData->pluck('encoded_by')->filter()->unique()->count(), 'color' => 'black'];
                $stats[] = ['label' => 'Houses Covered', 'value' => $allData->pluck('household.house_id')->filter()->unique()->count(), 'color' => 'black'];
                $stats[] = ['label' => 'Streets Covered', 'value' => $allData->pluck('household.house.street.street_name')->filter()->unique()->count(), 'color' => 'black'];
            } else {
                $stats[] = ['label' => 'Total Households', 'value' => $allData->count(), 'color' => 'black'];
                $stats[] = ['label' => 'Total House Heads', 'value' => $allData->sum(fn($r) => (int) ($r->head_count ?? 0)), 'color' => 'black'];
                $stats[] = ['label' => 'Family Members', 'value' => $allData->sum(fn($r) => (int) ($r->family_members_count ?? 0)), 'color' => 'black'];
                $stats[] = ['label' => 'Houses Covered', 'value' => $allData->pluck('house_id')->filter()->unique()->count(), 'color' => 'black'];
                $stats[] = ['label' => 'Streets Covered', 'value' => $allData->pluck('house.street.street_name')->filter()->unique()->count(), 'color' => 'black'];
            }
        }

        // Remove zero-value stats (cleaner output)
        $stats = array_filter($stats, fn($s) => $s['value'] > 0 || in_array($s['label'], ['Total Cases', 'Total Requests', 'Total Residents', 'Total Households']));
    @endphp

    <div id="pdfContent">
    @foreach($chunks as $index => $rowChunk)
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

        {{-- Only show report summary info on the first page --}}
        @if($loop->first)
        <div class="report-info-row">
            <div class="report-info-left">
                <div><strong>Report Name:</strong> {{ $report->report_name }}</div>
                <div><strong>Generated:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</div>
                <div><strong>Total Records:</strong> {{ number_format($report->total_records) }}</div>
            </div>
            @if(!empty($stats))
                <div class="stats-summary">
                    @foreach($stats as $stat)
                        <div class="stat-pill {{ $stat['color'] }}">
                            <span class="stat-label">{{ $stat['label'] }}:</span>
                            <span class="stat-count">{{ number_format($stat['value']) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        <div class="content-body">
            <table class="table">
                <thead>
                    <tr>
                        @if($type == 'population')
                            <th data-col="full_name">Full Name</th>
                            <th data-col="birthdate">Birthdate</th>
                            <th data-col="age">Age</th>
                            <th data-col="sex">Sex</th>
                            <th data-col="street">Street</th>
                            <th data-col="house_no">House No.</th>
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
                            <th data-col="certificate_status">Status</th>
                            <th data-col="certificate_date">Date</th>
                        @elseif($type == 'household' && $householdScope === 'family_members')
                            <th data-col="house_head">House Head</th>
                            <th data-col="family_member">Family Member</th>
                            <th data-col="relationship">Relationship</th>
                            <th data-col="street">Street</th>
                            <th data-col="house_no">House No.</th>
                        @elseif($type == 'household')
                            <th data-col="household_id">Household ID</th>
                            <th data-col="house_heads">House Head(s)</th>
                            <th data-col="street">Street</th>
                            <th data-col="house_no">House No.</th>
                            <th data-col="family_members">Family Members</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($rowChunk as $row)
                        <tr>
                            @if($type == 'population')
                                @php
                                    $residentHouse = optional(optional($row->households->first())->house);
                                    $residentStreet = optional($residentHouse->street)->street_name ?? ($row->street ?? null);
                                    $residentHouseNo = $residentHouse->house_no ?? ($row->houseNo ?? null);
                                @endphp
                                <td data-col="full_name">{{ ucwords(strtolower($row->firstName)) }} {{ ucwords(strtolower($row->middleName)) }} {{ ucwords(strtolower($row->lastName)) }}</td>
                                <td data-col="birthdate">{{ $row->birthday }}</td>
                                <td data-col="age">{{ $row->age }}</td>
                                <td data-col="sex">{{ ucfirst($row->sex) }}</td>
                                <td data-col="street">{{ $residentStreet ?? 'N/A' }}</td>
                                <td data-col="house_no">{{ $residentHouseNo ?? 'N/A' }}</td>
                                <td data-col="parent_status">{{ ucfirst($row->parent) }}</td>
                                @if(\Schema::hasColumn('residents', 'civil_status'))
                                    <td data-col="civil_status">{{ $row->civil_status ?? '' }}</td>
                                @endif
                            @elseif($type == 'blotter')
                                <td data-col="plaintiff">{{ ucwords(strtolower($row->plaintiffName)) }} {{ ucwords(strtolower($row->plaintiffLastName)) }}</td>
                                <td data-col="defendant">{{ ucwords(strtolower($row->defendantName)) }} {{ ucwords(strtolower($row->defendantLastName)) }}</td>
                                <td data-col="status">{{ ucfirst($row->status) }}</td>
                            @elseif($type == 'certificate')
                                <td data-col="resident">{{ ucwords(strtolower($row->requesterName)) }}</td>
                                <td data-col="certificate_type">{{ ucfirst(str_replace('_', ' ', $row->certificate_type)) }}</td>
                                <td data-col="certificate_status">{{ ucfirst($row->status) }}</td>
                                <td data-col="certificate_date">{{ $row->created_at ? $row->created_at->format('M d, Y') : '' }}</td>
                            @elseif($type == 'household' && $householdScope === 'family_members')
                                <td data-col="house_head">
                                    {{ trim(ucwords(strtolower(($row->user->firstName ?? '') . ' ' . ($row->user->middleName ?? '') . ' ' . ($row->user->lastName ?? '')))) ?: 'N/A' }}
                                </td>
                                <td data-col="family_member">
                                    {{ trim(ucwords(strtolower(($row->resident->firstName ?? '') . ' ' . ($row->resident->middleName ?? '') . ' ' . ($row->resident->lastName ?? '')))) ?: 'N/A' }}
                                </td>
                                <td data-col="relationship">{{ $row->relationship ?: 'N/A' }}</td>
                                <td data-col="street">{{ $row->household->house->street->street_name ?? 'N/A' }}</td>
                                <td data-col="house_no">{{ $row->household->house->house_no ?? 'N/A' }}</td>
                            @elseif($type == 'household')
                                @php
                                    $houseHeads = $row->residents
                                        ->filter(fn($r) => (bool) data_get($r, 'pivot.is_household_head'))
                                        ->map(function ($r) {
                                            return trim(ucwords(strtolower(($r->firstName ?? '') . ' ' . ($r->middleName ?? '') . ' ' . ($r->lastName ?? ''))));
                                        })
                                        ->filter()
                                        ->values();
                                @endphp
                                <td data-col="household_id">{{ $row->id }}</td>
                                <td data-col="house_heads">{{ $houseHeads->isNotEmpty() ? $houseHeads->implode(', ') : 'N/A' }}</td>
                                <td data-col="street">{{ $row->house->street->street_name ?? 'N/A' }}</td>
                                <td data-col="house_no">{{ $row->house->house_no ?? 'N/A' }}</td>
                                <td data-col="family_members">{{ number_format((int) ($row->family_members_count ?? 0)) }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <footer class="footer">
            <div class="footer-rule"></div>
            <div class="footer-rule-thin"></div>

            <div class="footer-content">
                <div class="footer-contact">
    <div class="footer-contact-row">
        <i class="fas fa-map-marker-alt"></i>
        <span>{{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila') }}</span>
    </div>
    <div class="footer-contact-row">
        <i class="fas fa-envelope"></i>
        <span>{{ \App\Models\Setting::get('contact_email', '<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="bfddcdd8c68d8b86ffdad2ded6d391dcd0d2">[email&#160;protected]</a>') }}</span>
    </div>
    <div class="footer-contact-row">
        <i class="fas fa-phone-alt"></i>
        <span>{{ \App\Models\Setting::get('contact_number', '0999-123-4567') }}</span>
    </div>
</div>

                <div class="footer-center">
                    <div class="footer-date-label">Date Printed</div>
                    <div class="footer-date-value print-date-display">—</div>
                    <div class="footer-page">Page {{ $index + 1 }} of {{ $totalPages }}</div>
                </div>

                <div class="footer-office">
                    <div class="footer-office-name">Barangay 249</div>
                    <div>Tondo, Manila</div>
                </div>
            </div>

            <div class="confidential-notice">
                &#9632;&nbsp; For Official Use Only &mdash; Unauthorized Reproduction is Strictly Prohibited &nbsp;&#9632;
            </div>
        </footer>
    </div>
    @endforeach
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set Print Date for all pages
            const now = new Date();
            const dateStr = now.toLocaleString('en-PH', {
                month: 'short', day: 'numeric', year: 'numeric',
                hour: 'numeric', minute: '2-digit', hour12: true
            });
            document.querySelectorAll('.print-date-display').forEach(el => el.innerText = dateStr);

            // Handle column visibility
            const params = new URLSearchParams(window.location.search);
            const colsParam = params.get('cols');
            
            if (colsParam) {
                const visibleCols = new Set(colsParam.split(','));
                document.querySelectorAll('.table').forEach(table => {
                    const headerCells = table.querySelectorAll('thead th');
                    headerCells.forEach((th, idx) => {
                        const isVisible = visibleCols.has(th.getAttribute('data-col') || `col_${idx}`);
                        th.style.display = isVisible ? '' : 'none';
                    });
                    
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((td, idx) => {
                            const dataCol = td.getAttribute('data-col');
                            const isVisible = visibleCols.has(dataCol || `col_${idx}`);
                            td.style.display = isVisible ? '' : 'none';
                        });
                    });
                });
            }

            // Convert to PDF using the same print-template layout.
            const mode = params.get('mode');
            if (mode === 'pdf') {
                document.body.classList.add('pdf-mode');
                const fileSafeReportName = (@json($report->report_name) || 'report')
                    .replace(/[<>:"/\\|?*]+/g, '_')
                    .trim();
                const filename = (fileSafeReportName || 'report') + '.pdf';
                const content = document.getElementById('pdfContent');

                if (content && window.html2pdf) {
                    const options = {
                        margin: 0,
                        filename: filename,
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2, useCORS: true },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                        pagebreak: { mode: ['css', 'legacy'] },
                    };

                    setTimeout(function () {
                        window.html2pdf().set(options).from(content).save();
                    }, 150);
                }
            }
        });
    </script>
</body>
</html>