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
            height: 297mm;
            padding: 8mm 14mm 12mm 14mm;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
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
            flex: 1 1 0;       /* take ALL remaining space between header and footer */
            min-height: 0;     /* allow shrinking below natural height */
            overflow: hidden;  /* never let rows bleed out of the bounded box */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px; /* Slightly smaller to ensure 28 rows fit comfortably */
            table-layout: fixed;
        }

        .table th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b;
            font-weight: 700;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #cbd5e1;
            white-space: nowrap;
            overflow-wrap: anywhere;
        }

        .table td {
            padding: 5px 6px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
            text-align: left;
            word-break: break-word;
            overflow-wrap: anywhere;
            hyphens: auto;
            white-space: normal;
        }

        .table tbody tr:nth-child(even) { background: #f8fafc; }
        .table tbody tr {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .table td[data-col="details"],
        .table td[data-col="status_history"],
        .table td[data-col="remarks"] {
            line-height: 1.35;
            font-size: 10px;
        }

        .table.blotter-table th[data-col="plaintiff"],
        .table.blotter-table td[data-col="plaintiff"] { width: 16%; }
        .table.blotter-table th[data-col="defendant"],
        .table.blotter-table td[data-col="defendant"] { width: 16%; }
        .table.blotter-table th[data-col="status"],
        .table.blotter-table td[data-col="status"] { width: 10%; }
        .table.blotter-table th[data-col="details"],
        .table.blotter-table td[data-col="details"] { width: 24%; }
        .table.blotter-table th[data-col="status_history"],
        .table.blotter-table td[data-col="status_history"] { width: 34%; }

        .table.complaint-table th[data-col="complainant"],
        .table.complaint-table td[data-col="complainant"] { width: 14%; }
        .table.complaint-table th[data-col="respondent"],
        .table.complaint-table td[data-col="respondent"] { width: 14%; }
        .table.complaint-table th[data-col="status"],
        .table.complaint-table td[data-col="status"] { width: 10%; }
        .table.complaint-table th[data-col="address"],
        .table.complaint-table td[data-col="address"] { width: 17%; }
        .table.complaint-table th[data-col="details"],
        .table.complaint-table td[data-col="details"] { width: 18%; }
        .table.complaint-table th[data-col="remarks"],
        .table.complaint-table td[data-col="remarks"] { width: 21%; }
        .table.complaint-table th[data-col="complaint_date"],
        .table.complaint-table td[data-col="complaint_date"] { width: 6%; }

        .table.activity-table th[data-col="activity_user"],
        .table.activity-table td[data-col="activity_user"] { width: 16%; }
        .table.activity-table th[data-col="module"],
        .table.activity-table td[data-col="module"] { width: 14%; }
        .table.activity-table th[data-col="action"],
        .table.activity-table td[data-col="action"] { width: 12%; }
        .table.activity-table th[data-col="description"],
        .table.activity-table td[data-col="description"] { width: 34%; }
        .table.activity-table th[data-col="record_id"],
        .table.activity-table td[data-col="record_id"] { width: 8%; }
        .table.activity-table th[data-col="logged_at"],
        .table.activity-table td[data-col="logged_at"] { width: 16%; }

        .table.officials-table th[data-col="position"],
        .table.officials-table td[data-col="position"] { width: 18%; }
        .table.officials-table th[data-col="official_name"],
        .table.officials-table td[data-col="official_name"] { width: 22%; }
        .table.officials-table th[data-col="term_start"],
        .table.officials-table td[data-col="term_start"] { width: 14%; }
        .table.officials-table th[data-col="term_end"],
        .table.officials-table td[data-col="term_end"] { width: 14%; }
        .table.officials-table th[data-col="term_status"],
        .table.officials-table td[data-col="term_status"] { width: 14%; }
        .table.officials-table th[data-col="notes"],
        .table.officials-table td[data-col="notes"] { width: 18%; }

        .table.archives-table th[data-col="archive_type"],
        .table.archives-table td[data-col="archive_type"] { width: 14%; }
        .table.archives-table th[data-col="archived_by"],
        .table.archives-table td[data-col="archived_by"] { width: 14%; }
        .table.archives-table th[data-col="record_id"],
        .table.archives-table td[data-col="record_id"] { width: 9%; }
        .table.archives-table th[data-col="reason"],
        .table.archives-table td[data-col="reason"] { width: 17%; }
        .table.archives-table th[data-col="details"],
        .table.archives-table td[data-col="details"] { width: 30%; }
        .table.archives-table th[data-col="archived_at"],
        .table.archives-table td[data-col="archived_at"] { width: 16%; }

        .table.announcements-table th[data-col="title"],
        .table.announcements-table td[data-col="title"] { width: 16%; }
        .table.announcements-table th[data-col="publisher"],
        .table.announcements-table td[data-col="publisher"] { width: 14%; }
        .table.announcements-table th[data-col="event_start"],
        .table.announcements-table td[data-col="event_start"] { width: 10%; }
        .table.announcements-table th[data-col="event_end"],
        .table.announcements-table td[data-col="event_end"] { width: 10%; }
        .table.announcements-table th[data-col="details"],
        .table.announcements-table td[data-col="details"] { width: 38%; }
        .table.announcements-table th[data-col="published_at"],
        .table.announcements-table td[data-col="published_at"] { width: 12%; }

        .table.feedback-table th[data-col="feedback_user"],
        .table.feedback-table td[data-col="feedback_user"] { width: 18%; }
        .table.feedback-table th[data-col="message"],
        .table.feedback-table td[data-col="message"] { width: 56%; }
        .table.feedback-table th[data-col="message_length"],
        .table.feedback-table td[data-col="message_length"] { width: 10%; }
        .table.feedback-table th[data-col="submitted_at"],
        .table.feedback-table td[data-col="submitted_at"] { width: 16%; }

        .table.table-compact {
            font-size: 10px;
        }

        .table.table-compact th,
        .table.table-compact td {
            padding: 4px 5px;
        }

        .table.table-ultra-compact {
            font-size: 9px;
        }

        .table.table-ultra-compact th,
        .table.table-ultra-compact td {
            padding: 3px 4px;
        }

        .footer {
            /* Flex child — always sits below content-body, never overlaps it */
            flex-shrink: 0;
            margin-top: auto;           /* push to bottom when content is short */
            padding-top: 4px;
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
            .table thead { display: table-header-group; }
            .table tfoot { display: table-footer-group; }
            .table tbody tr {
                break-inside: auto;
                page-break-inside: auto;
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
        $rowsPerPage = match ($type) {
            'blotter' => 8,
            'certificate' => 25,
            'complaint' => 18,
            'activity' => 20,
            'officials' => 20,
            'archives' => 16,
            'announcements' => 18,
            'feedback' => 18,
            'population' => 25,
            'household' => $householdScope === 'family_members' ? 12 : 14,
            default => 18,
        };
        if ($type === 'blotter') {
            // Variable-height blotter rows are weighted so long entries are moved to the next page.
            $maxPageWeight = $rowsPerPage;
            $chunks = collect();
            $currentChunk = collect();
            $currentWeight = 0;

            foreach ($allData as $blotterRow) {
                $detailsText = (string) ($blotterRow->blotterDescription ?? '');
                $historyText = collect($blotterRow->updates ?? [])->map(function ($update) {
                    return trim((string) ($update->status ?? '') . ' ' . (string) ($update->remarks ?? ''));
                })->implode(' ');

                $detailsPenalty = intdiv(strlen($detailsText), 180);
                $historyPenalty = intdiv(strlen($historyText), 220);
                $rowWeight = max(1, min(4, 1 + $detailsPenalty + $historyPenalty));

                if ($currentChunk->isNotEmpty() && ($currentWeight + $rowWeight > $maxPageWeight)) {
                    $chunks->push($currentChunk);
                    $currentChunk = collect();
                    $currentWeight = 0;
                }

                $currentChunk->push($blotterRow);
                $currentWeight += $rowWeight;
            }

            if ($currentChunk->isNotEmpty()) {
                $chunks->push($currentChunk);
            }
        } else {
            $chunks = $allData->chunk($rowsPerPage);
        }

        $totalPages = count($chunks);

        // ── Stats computation ─────────────────────────────────────────────
        $stats = [];

        if ($type === 'blotter') {
            $statusGroups = $allData->groupBy(fn($r) => strtolower($r->current_status ?? $r->status ?? 'unknown'));
            $stats[] = ['label' => 'Total Cases',     'value' => $allData->count(),                            'color' => 'black'];
            $stats[] = ['label' => 'Pending',         'value' => $statusGroups->only(['first', 'second', 'third'])->flatten(1)->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'Ongoing',         'value' => $statusGroups->only(['brgyhearing'])->flatten(1)->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Closed',          'value' => $statusGroups->only(['coldcase', 'criminalcase', 'referredtopnp', 'resolved'])->flatten(1)->count(), 'color' => 'slate'];

        } elseif ($type === 'certificate') {
            $statusGroups  = $allData->groupBy(fn($r) => strtolower($r->status ?? 'unknown'));
            $stats[] = ['label' => 'Total Requests', 'value' => $allData->count(),                              'color' => 'black'];
            $stats[] = ['label' => 'Approved',        'value' => ($statusGroups->get('approved',  collect())->count() ?: $statusGroups->get('released', collect())->count()),  'color' => 'green'];
            $stats[] = ['label' => 'Pending',         'value' => $statusGroups->get('pending',    collect())->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'Rejected',        'value' => $statusGroups->get('rejected',   collect())->count(), 'color' => 'red'];

        } elseif ($type === 'complaint') {
            $statusGroups = $allData->groupBy(fn($r) => strtolower((string) ($r->status ?? 'unknown')));
            $stats[] = ['label' => 'Total Complaints', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Pending', 'value' => $statusGroups->get('pending', collect())->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'On-going', 'value' => $statusGroups->get('on-going', collect())->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Resolved', 'value' => $statusGroups->get('resolved', collect())->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Rejected', 'value' => $statusGroups->get('rejected', collect())->count(), 'color' => 'red'];
        } elseif ($type === 'activity') {
            $actionGroups = $allData->groupBy(fn($r) => strtolower((string) ($r->action ?? 'unknown')));
            $stats[] = ['label' => 'Total Logs', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Created', 'value' => $actionGroups->get('created', collect())->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Updated', 'value' => $actionGroups->get('updated', collect())->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'Deleted', 'value' => $actionGroups->get('deleted', collect())->count(), 'color' => 'red'];
            $stats[] = ['label' => 'Modules', 'value' => $allData->pluck('module')->filter()->unique()->count(), 'color' => 'black'];
        } elseif ($type === 'officials') {
            $today = now()->toDateString();
            $activeCount = $allData->filter(fn($r) => $r->start && $r->end && $r->start <= $today && $r->end >= $today)->count();
            $upcomingCount = $allData->filter(fn($r) => $r->start && $r->start > $today)->count();
            $completedCount = $allData->filter(fn($r) => $r->end && $r->end < $today)->count();
            $noTermCount = $allData->filter(fn($r) => !$r->start || !$r->end)->count();
            $stats[] = ['label' => 'Total Officials', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Active', 'value' => $activeCount, 'color' => 'green'];
            $stats[] = ['label' => 'Upcoming', 'value' => $upcomingCount, 'color' => 'amber'];
            $stats[] = ['label' => 'Completed', 'value' => $completedCount, 'color' => 'black'];
            $stats[] = ['label' => 'No Term Dates', 'value' => $noTermCount, 'color' => 'red'];
        } elseif ($type === 'archives') {
            $stats[] = ['label' => 'Total Archives', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Record Types', 'value' => $allData->pluck('record_type')->filter()->unique()->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Archived By Users', 'value' => $allData->pluck('archived_by')->filter()->unique()->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'With Reason', 'value' => $allData->filter(fn($r) => !empty($r->reason))->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Without Reason', 'value' => $allData->filter(fn($r) => empty($r->reason))->count(), 'color' => 'red'];
        } elseif ($type === 'announcements') {
            $stats[] = ['label' => 'Total Announcements', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'With Image', 'value' => $allData->filter(fn($r) => !empty($r->image))->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Without Image', 'value' => $allData->filter(fn($r) => empty($r->image))->count(), 'color' => 'amber'];
            $stats[] = ['label' => 'With Event Dates', 'value' => $allData->filter(fn($r) => !empty($r->eventTime) || !empty($r->eventEnd))->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Published By Users', 'value' => $allData->pluck('user_id')->filter()->unique()->count(), 'color' => 'black'];
        } elseif ($type === 'feedback') {
            $stats[] = ['label' => 'Total Feedback', 'value' => $allData->count(), 'color' => 'black'];
            $stats[] = ['label' => 'Unique Senders', 'value' => $allData->pluck('user_id')->filter()->unique()->count(), 'color' => 'green'];
            $stats[] = ['label' => 'Avg Length', 'value' => (int) round($allData->avg(fn($r) => mb_strlen((string) ($r->message ?? ''))) ?? 0), 'color' => 'black'];
            $stats[] = ['label' => 'Long Messages (200+)', 'value' => $allData->filter(fn($r) => mb_strlen((string) ($r->message ?? '')) >= 200)->count(), 'color' => 'amber'];

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
        $stats = array_filter($stats, fn($s) => $s['value'] > 0 || in_array($s['label'], ['Total Cases', 'Total Requests', 'Total Complaints', 'Total Logs', 'Total Officials', 'Total Archives', 'Total Announcements', 'Total Feedback', 'Total Residents', 'Total Households']));
    @endphp

    <div id="pdfContent">
    @php $globalHeadCounter = 0; @endphp
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
            <table class="table {{ $type == 'blotter' ? 'blotter-table' : '' }} {{ $type == 'complaint' ? 'complaint-table' : '' }} {{ $type == 'activity' ? 'activity-table' : '' }} {{ $type == 'officials' ? 'officials-table' : '' }} {{ $type == 'archives' ? 'archives-table' : '' }} {{ $type == 'announcements' ? 'announcements-table' : '' }} {{ $type == 'feedback' ? 'feedback-table' : '' }}">
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
                            <th data-col="details">Details</th>
                            <th data-col="status_history">Status History</th>
                        @elseif($type == 'certificate')
                            <th data-col="resident">Resident</th>
                            <th data-col="certificate_type">Certificate Type</th>
                            <th data-col="certificate_status">Status</th>
                            <th data-col="certificate_date">Date</th>
                        @elseif($type == 'complaint')
                            <th data-col="complainant">Complainant</th>
                            <th data-col="respondent">Respondent</th>
                            <th data-col="status">Status</th>
                            <th data-col="address">Address</th>
                            <th data-col="details">Details</th>
                            <th data-col="remarks">Respondent <br>Remarks</th>
                            <th data-col="complaint_date">Date</th>
                        @elseif($type == 'activity')
                            <th data-col="activity_user">User</th>
                            <th data-col="module">Module</th>
                            <th data-col="action">Action</th>
                            <th data-col="description">Description</th>
                            <th data-col="record_id">Record ID</th>
                            <th data-col="logged_at">Logged At</th>
                        @elseif($type == 'officials')
                            <th data-col="position">Position</th>
                            <th data-col="official_name">Official Name</th>
                            <th data-col="term_start">Term Start</th>
                            <th data-col="term_end">Term End</th>
                            <th data-col="term_status">Term Status</th>
                            <th data-col="notes">Notes</th>
                        @elseif($type == 'archives')
                            <th data-col="archive_type">Archive Type</th>
                            <th data-col="archived_by">Archived By</th>
                            <th data-col="record_id">Record ID</th>
                            <th data-col="reason">Reason</th>
                            <th data-col="details">Details</th>
                            <th data-col="archived_at">Archived At</th>
                        @elseif($type == 'announcements')
                            <th data-col="title">Title</th>
                            <th data-col="publisher">Published By</th>
                            <th data-col="event_start">Event Start</th>
                            <th data-col="event_end">Event End</th>
                            <th data-col="details">Details</th>
                            <th data-col="published_at">Published At</th>
                        @elseif($type == 'feedback')
                            <th data-col="feedback_user">Submitted By</th>
                            <th data-col="message">Feedback Message</th>
                            <th data-col="message_length">Message Length</th>
                            <th data-col="submitted_at">Submitted At</th>
                        @elseif($type == 'household' && $householdScope === 'family_members')
                            <th data-col="head_no">Head #</th>
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
                    @if($type == 'household' && $householdScope === 'family_members')
                        @php
                            $groupedByHead = collect($rowChunk)->groupBy(function ($row) {
                                return trim(strtolower(
                                    ($row->user->firstName ?? '') . ' ' .
                                    ($row->user->middleName ?? '') . ' ' .
                                    ($row->user->lastName ?? '')
                                ));
                            });
                            $headCounter = $globalHeadCounter;
                        @endphp
                        @foreach($groupedByHead as $rows)
                            @php
                                $headCounter++;
                                $firstRow = $rows->first();
                                $headName = trim(ucwords(strtolower(
                                    ($firstRow->user->firstName ?? '') . ' ' .
                                    ($firstRow->user->middleName ?? '') . ' ' .
                                    ($firstRow->user->lastName ?? '')
                                ))) ?: 'N/A';
                                $rowspan = max(1, $rows->count());
                            @endphp
                            @foreach($rows as $row)
                                <tr>
                                    @if($loop->first)
                                        <td data-col="head_no" rowspan="{{ $rowspan }}">{{ $headCounter }}</td>
                                        <td data-col="house_head" rowspan="{{ $rowspan }}">{{ $headName }}</td>
                                    @endif
                                    <td data-col="family_member">
                                        {{ trim(ucwords(strtolower(($row->resident->firstName ?? '') . ' ' . ($row->resident->middleName ?? '') . ' ' . ($row->resident->lastName ?? '')))) ?: 'N/A' }}
                                    </td>
                                    <td data-col="relationship">{{ $row->relationship ?: 'N/A' }}</td>
                                    <td data-col="street">{{ $row->household->house->street->street_name ?? 'N/A' }}</td>
                                    <td data-col="house_no">{{ $row->household->house->house_no ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        @php $globalHeadCounter = $headCounter; @endphp
                    @else
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
                                @php
                                    $blotterStatusMap = [
                                        'first' => 'First Summon',
                                        'second' => 'Second Summon',
                                        'third' => 'Third Summon',
                                        'brgyHearing' => 'Barangay Hearing',
                                        'coldCase' => 'Cold Case',
                                        'criminalCase' => 'Criminal Case',
                                        'referredToPnp' => 'Referred To PNP',
                                        'resolved' => 'Resolved',
                                    ];
                                    $blotterStatus = $row->current_status ?? $row->status;
                                    $historyUpdates = collect($row->updates ?? []);
                                @endphp
                                <td data-col="plaintiff">{{ trim(ucwords(strtolower(($row->plaintiffName ?? '') . ' ' . ($row->plaintiffMiddleName ?? '') . ' ' . ($row->plaintiffLastName ?? '')))) }}</td>
                                <td data-col="defendant">{{ ucwords(strtolower($row->defendantName)) }} {{ ucwords(strtolower($row->defendantLastName)) }}</td>
                                <td data-col="status">{{ $blotterStatusMap[$blotterStatus] ?? ucfirst((string) $blotterStatus) }}</td>
                                <td data-col="details">{{ $row->blotterDescription ?? 'N/A' }}</td>
                                <td data-col="status_history">
                                    @if($historyUpdates->isNotEmpty())
                                        @foreach($historyUpdates as $history)
                                            @php
                                                $historyStatus = $blotterStatusMap[$history->status] ?? ucfirst((string) $history->status);
                                                $historyDate = $history->date
                                                    ? \Carbon\Carbon::parse($history->date)->format('M d, Y')
                                                    : null;
                                            @endphp
                                            <div><strong>{{ $historyStatus }}</strong>{{ $historyDate ? ' - ' . $historyDate : '' }}</div>
                                            <div>{{ $history->remarks ?: 'No details provided.' }}</div>
                                            @if(!$loop->last)
                                                <div>---</div>
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                            @elseif($type == 'certificate')
                                <td data-col="resident">{{ ucwords(strtolower($row->requesterName)) }}</td>
                                <td data-col="certificate_type">{{ ucfirst(str_replace('_', ' ', $row->certificate_type)) }}</td>
                                <td data-col="certificate_status">{{ ucwords(str_replace('_', ' ', strtolower((string) $row->status))) }}</td>
                                <td data-col="certificate_date">{{ $row->created_at ? $row->created_at->format('M d, Y') : '' }}</td>
                            @elseif($type == 'complaint')
                                @php
                                    $cleanComplainantName = $row->complainant
                                        ? ucwords(strtolower(trim(($row->complainant->firstName ?? '') . ' ' . ($row->complainant->middleName ?? '') . ' ' . ($row->complainant->lastName ?? ''))))
                                        : ucwords(strtolower(trim(preg_replace('/\s+/', ' ', str_replace(',', ' ', (string) $row->complainantName)))));
                                    $remarkLines = collect(preg_split("/\r\n|\n|\r/", (string) ($row->remarks ?? '')))
                                        ->map(fn($line) => trim($line))
                                        ->filter()
                                        ->values();
                                @endphp
                                <td data-col="complainant">{{ $cleanComplainantName ?: 'N/A' }}</td>
                                <td data-col="respondent">
                                    @if($row->respondent)
                                        {{ ucwords(strtolower(trim(($row->respondent->firstName ?? '') . ' ' . ($row->respondent->middleName ?? '') . ' ' . ($row->respondent->lastName ?? '')))) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-col="status">{{ ucwords(str_replace('-', ' ', (string) $row->status)) }}</td>
                                <td data-col="address">{{ $row->address ?: 'N/A' }}</td>
                                <td data-col="details">{{ $row->details ?: 'N/A' }}</td>
                                <td data-col="remarks">
                                    @if($remarkLines->isNotEmpty())
                                        <div style="white-space: pre-line; line-height: 1.35;">{{ $remarkLines->implode("\n") }}</div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-col="complaint_date">{{ $row->created_at ? $row->created_at->format('M d, Y') : '' }}</td>
                            @elseif($type == 'activity')
                                @php
                                    $activityUser = $row->user
                                        ? ucwords(strtolower(trim(($row->user->firstName ?? '') . ' ' . ($row->user->lastName ?? ''))))
                                        : 'N/A';
                                @endphp
                                <td data-col="activity_user">{{ $activityUser !== '' ? $activityUser : 'N/A' }}</td>
                                <td data-col="module">{{ $row->module ? ucwords(strtolower((string) $row->module)) : 'N/A' }}</td>
                                <td data-col="action">{{ $row->action ? ucwords(strtolower((string) $row->action)) : 'N/A' }}</td>
                                <td data-col="description">{{ ($row->resolved_description ?? $row->description) ?: 'N/A' }}</td>
                                <td data-col="record_id">{{ $row->record_id ?? 'N/A' }}</td>
                                <td data-col="logged_at">{{ $row->created_at ? $row->created_at->format('M d, Y g:i A') : 'N/A' }}</td>
                            @elseif($type == 'officials')
                                @php
                                    $officialName = $row->resident
                                        ? ucwords(strtolower(trim(($row->resident->firstName ?? '') . ' ' . ($row->resident->middleName ?? '') . ' ' . ($row->resident->lastName ?? ''))))
                                        : 'N/A';
                                    $today = now()->toDateString();
                                    $termStatus = 'No Term Dates';
                                    if ($row->start && $row->end) {
                                        if ($row->start <= $today && $row->end >= $today) {
                                            $termStatus = 'Active';
                                        } elseif ($row->start > $today) {
                                            $termStatus = 'Upcoming';
                                        } elseif ($row->end < $today) {
                                            $termStatus = 'Completed';
                                        }
                                    }
                                @endphp
                                <td data-col="position">{{ $row->position ?: 'N/A' }}</td>
                                <td data-col="official_name">{{ $officialName !== '' ? $officialName : 'N/A' }}</td>
                                <td data-col="term_start">{{ $row->start ? \Carbon\Carbon::parse($row->start)->format('M d, Y') : 'N/A' }}</td>
                                <td data-col="term_end">{{ $row->end ? \Carbon\Carbon::parse($row->end)->format('M d, Y') : 'N/A' }}</td>
                                <td data-col="term_status">{{ $termStatus }}</td>
                                <td data-col="notes">{{ $row->details ?: 'N/A' }}</td>
                            @elseif($type == 'archives')
                                @php
                                    $archiver = $row->user
                                        ? ucwords(strtolower(trim(($row->user->firstName ?? '') . ' ' . ($row->user->lastName ?? ''))))
                                        : 'N/A';
                                    $archiveData = is_array($row->data) ? $row->data : [];
                                    $archiveLines = collect($archiveData)->map(function ($value, $key) {
                                        $label = \Illuminate\Support\Str::title(str_replace('_', ' ', (string) $key));
                                        $display = is_array($value) ? json_encode($value) : (string) $value;
                                        return $label . ': ' . $display;
                                    })->values();
                                @endphp
                                <td data-col="archive_type">{{ ucwords(str_replace('_', ' ', strtolower((string) $row->record_type))) ?: 'N/A' }}</td>
                                <td data-col="archived_by">{{ $archiver !== '' ? $archiver : 'N/A' }}</td>
                                <td data-col="record_id">{{ $row->record_id ?? 'N/A' }}</td>
                                <td data-col="reason">{{ $row->reason ?: 'N/A' }}</td>
                                <td data-col="details">
                                    @if($archiveLines->isNotEmpty())
                                        <div style="white-space: pre-line; line-height: 1.35;">{{ $archiveLines->implode("\n") }}</div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-col="archived_at">{{ $row->created_at ? $row->created_at->format('M d, Y g:i A') : 'N/A' }}</td>
                            @elseif($type == 'announcements')
                                @php
                                    $publisher = $row->user
                                        ? ucwords(strtolower(trim(($row->user->firstName ?? '') . ' ' . ($row->user->lastName ?? ''))))
                                        : 'N/A';
                                @endphp
                                <td data-col="title">{{ $row->title ?: 'N/A' }}</td>
                                <td data-col="publisher">{{ $publisher !== '' ? $publisher : 'N/A' }}</td>
                                <td data-col="event_start">{{ $row->eventTime ? \Carbon\Carbon::parse($row->eventTime)->format('M d, Y') : 'N/A' }}</td>
                                <td data-col="event_end">{{ $row->eventEnd ? \Carbon\Carbon::parse($row->eventEnd)->format('M d, Y') : 'N/A' }}</td>
                                <td data-col="details">{{ \Illuminate\Support\Str::limit((string) ($row->details ?? ''), 170, '...') ?: 'N/A' }}</td>
                                <td data-col="published_at">{{ $row->created_at ? $row->created_at->format('M d, Y g:i A') : 'N/A' }}</td>
                            @elseif($type == 'feedback')
                                @php
                                    $feedbackUser = $row->user
                                        ? ucwords(strtolower(trim(($row->user->firstName ?? '') . ' ' . ($row->user->lastName ?? ''))))
                                        : 'N/A';
                                    $feedbackMessage = (string) ($row->message ?? '');
                                @endphp
                                <td data-col="feedback_user">{{ $feedbackUser !== '' ? $feedbackUser : 'N/A' }}</td>
                                <td data-col="message">{{ $feedbackMessage !== '' ? $feedbackMessage : 'N/A' }}</td>
                                <td data-col="message_length">{{ mb_strlen($feedbackMessage) }}</td>
                                <td data-col="submitted_at">{{ $row->created_at ? $row->created_at->format('M d, Y g:i A') : 'N/A' }}</td>
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
                    @endif
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
                    <div class="generatedby" style="display: inline-flex;"><div class="footer-date-label">Generated by:</div><div style="color: var(--navy); font-weight: 600;  font-size: 9px;"> @php
                                        $generatorName = $report->generator
                                            ? ucwords(strtolower(trim($report->generator->firstName . ' ' . $report->generator->lastName)))
                                            : ('User #' . $report->generated_by);
                                    @endphp
                                    <span class="text-muted">{{ $generatorName }}</span></div></div>
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
            function updatePageNumbers() {
                const pages = document.querySelectorAll('#pdfContent .page');
                const total = pages.length;
                pages.forEach((page, index) => {
                    const pageLabel = page.querySelector('.footer-page');
                    if (pageLabel) {
                        pageLabel.textContent = `Page ${index + 1} of ${total}`;
                    }
                });
            }

            function moveOverflowRowsToNextPage() {
                const pages = Array.from(document.querySelectorAll('#pdfContent .page'));
                if (!pages.length) return;

                let i = 0;
                while (i < document.querySelectorAll('#pdfContent .page').length) {
                    const allPages = Array.from(document.querySelectorAll('#pdfContent .page'));
                    const currentPage = allPages[i];
                    const currentBody = currentPage.querySelector('.content-body');
                    const currentTbody = currentBody ? currentBody.querySelector('tbody') : null;

                    if (!currentBody || !currentTbody) { i++; continue; }

                    const isOverflowing = () => currentBody.scrollHeight > currentBody.clientHeight + 2;

                    if (!isOverflowing()) { i++; continue; }

                    let nextPage = allPages[i + 1];
                    if (!nextPage) {
                        nextPage = clonePage(currentPage);
                        currentPage.parentNode.insertBefore(nextPage, currentPage.nextSibling);
                    }

                    const nextTbody = nextPage.querySelector('.content-body tbody');
                    if (!nextTbody) { i++; continue; }

                    let guard = 0;
                    while (isOverflowing() && currentTbody.rows.length > 0 && guard < 200) {
                        const lastRow = currentTbody.lastElementChild;
                        nextTbody.insertBefore(lastRow, nextTbody.firstElementChild);
                        guard++;
                    }

                    if (currentTbody.rows.length === 0) { i++; }
                    i++;
                }

                updatePageNumbers();
            }

            // ---------------------------------------------------------------
            // Consolidation pass: after overflow is resolved, pull rows from
            // the NEXT page into the CURRENT page while there is still room.
            // This fixes the "blank space" problem caused by the PHP weight-
            // based chunker being overly conservative with blotter rows.
            // ---------------------------------------------------------------
            function consolidatePages() {
                let changed = true;
                // Repeat until no more rows can be pulled (handles chain reactions)
                while (changed) {
                    changed = false;
                    const allPages = Array.from(document.querySelectorAll('#pdfContent .page'));

                    for (let i = 0; i < allPages.length - 1; i++) {
                        const currentPage = allPages[i];
                        const nextPage    = allPages[i + 1];

                        const currentBody  = currentPage.querySelector('.content-body');
                        const currentTbody = currentBody ? currentBody.querySelector('tbody') : null;
                        const nextBody     = nextPage.querySelector('.content-body');
                        const nextTbody    = nextBody ? nextBody.querySelector('tbody') : null;

                        if (!currentBody || !currentTbody || !nextBody || !nextTbody) continue;
                        if (nextTbody.rows.length === 0) continue;

                        const isOverflowing = () => currentBody.scrollHeight > currentBody.clientHeight + 2;

                        // Try to pull rows one at a time from the top of the next page
                        let guard = 0;
                        while (nextTbody.rows.length > 0 && guard < 200) {
                            const candidate = nextTbody.firstElementChild;

                            // Tentatively move the row into the current page
                            currentTbody.appendChild(candidate);

                            if (isOverflowing()) {
                                // Doesn't fit — put it back and stop pulling for this page
                                nextTbody.insertBefore(candidate, nextTbody.firstElementChild);
                                break;
                            }

                            // It fits — keep it and mark that we made progress
                            changed = true;
                            guard++;
                        }

                        // If the next page is now empty, remove it
                        if (nextTbody.rows.length === 0) {
                            nextPage.remove();
                            break; // Restart the outer while-loop with a fresh page list
                        }
                    }
                }

                updatePageNumbers();
            }

            // Deep-clone a page, clearing its tbody rows but keeping
            // the header, footer, report-info, and empty tbody intact.
            function clonePage(sourcePage) {
                const clone = sourcePage.cloneNode(true);

                // Remove report-info (only shown on first page)
                const infoRow = clone.querySelector('.report-info-row');
                if (infoRow) infoRow.remove();

                // Clear the tbody of the clone — rows will be pushed in
                const tbody = clone.querySelector('.content-body tbody');
                if (tbody) tbody.innerHTML = '';

                // Reset the page-number label — updatePageNumbers() will fix it
                const pageLabel = clone.querySelector('.footer-page');
                if (pageLabel) pageLabel.textContent = '';

                // Reset the print-date (will be set by the date loop below)
                const dateEl = clone.querySelector('.print-date-display');
                if (dateEl) dateEl.textContent = '—';

                return clone;
            }

            function fitTablesToPage() {
                document.querySelectorAll('.page').forEach(page => {
                    const contentBody = page.querySelector('.content-body');
                    const table = contentBody ? contentBody.querySelector('.table') : null;
                    if (!contentBody || !table) return;

                    table.classList.remove('table-compact', 'table-ultra-compact');

                    const isOverflowing = () => contentBody.scrollHeight > contentBody.clientHeight + 2;

                    if (!isOverflowing()) return;
                    table.classList.add('table-compact');
                    if (!isOverflowing()) return;
                    table.classList.add('table-ultra-compact');
                });
            }

            function stampDates() {
                const now = new Date();
                const dateStr = now.toLocaleString('en-PH', {
                    month: 'short', day: 'numeric', year: 'numeric',
                    hour: 'numeric', minute: '2-digit', hour12: true
                });
                document.querySelectorAll('.print-date-display').forEach(el => el.innerText = dateStr);
            }

            // Set Print Date for all pages (including any that get cloned later)
            stampDates();

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

            moveOverflowRowsToNextPage();
            consolidatePages();         // pull rows back up to fill gaps
            fitTablesToPage();
            stampDates(); // re-stamp any pages that were cloned during overflow resolution
            window.addEventListener('beforeprint', function () {
                moveOverflowRowsToNextPage();
                consolidatePages();
                fitTablesToPage();
                stampDates();
            });

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
