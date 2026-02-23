<style>
    @media print {
        .no-print, .no-print * { display: none !important; }
        .report-card { border: 0 !important; box-shadow: none !important; }
    }
    .report-view-container { padding: 1.5rem; }
    .report-card { border: 0; border-radius: 14px; overflow: hidden; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); background: #fff; }
    .report-header { background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); border-bottom: 1px solid #e2e8f0; padding: 1.25rem; }
    .report-meta { color: #64748b; font-size: 0.9rem; }
    .filter-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; }
    .filter-chip { display: inline-flex; align-items: center; background: #e2e8f0; color: #1e293b; border-radius: 999px; padding: 0.3rem 0.75rem; font-size: 0.75rem; margin: 0.2rem 0.3rem 0.2rem 0; }
    .table thead th { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important; color: #1e293b !important; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.4px; border: none !important; white-space: nowrap; }
    .table tbody td { vertical-align: middle; }
    .col-controls { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.85rem; }
    .col-controls-title { font-weight: 700; color: #0f172a; font-size: 0.9rem; margin-bottom: 0.6rem; }
    .col-controls-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.5rem 0.75rem; }
    @media (max-width: 992px) { .col-controls-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 576px) { .col-controls-grid { grid-template-columns: 1fr; } }
    .col-check { display: flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.5rem; border-radius: 10px; background: #fff; border: 1px solid #e2e8f0; }
    .col-check:hover { background: #f1f5f9; }
    .col-actions { display: flex; gap: 0.5rem; margin-top: 0.75rem; flex-wrap: wrap; }
    .col-actions .btn { border-radius: 10px; }
    .sort-controls { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.85rem; }
</style>

<div class="report-view-container">
    <div class="report-card">
        <div class="report-header d-flex justify-content-between align-items-start gap-3">
            <div>
                <h4 class="mb-1">{{ $report->report_name }}</h4>
                <div class="report-meta">
                    Type: {{ ucfirst($report->report_type) }} | 
                    Generated: {{ $report->created_at->format('M d, Y h:i A') }} | 
                    Total Records: {{ number_format($report->total_records) }}
                </div>
            </div>
            <div class="d-flex gap-2 no-print">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
                <a href="#" id="printTemplateBtn" class="btn btn-primary btn-sm" target="_blank">
                    <i class="fa fa-print me-1"></i> Print with Template
                </a>
                <a href="#" id="pdfTemplateBtn" class="btn btn-success btn-sm" target="_blank">
                    <i class="fa fa-file-pdf me-1"></i> Convert to PDF
                </a>{{--  
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fa fa-print me-1"></i> Print
                </button>--}}
            </div>
        </div>

        <div class="card-body p-4">
            @if($report->filters_used)
                @php
                    $used = is_array($report->filters_used)
                        ? $report->filters_used
                        : (json_decode($report->filters_used, true) ?? []);
                @endphp
                <div class="filter-box mb-4">
                    <div class="fw-semibold mb-2">Applied Filters</div>
                    @foreach($used as $key => $val)
                        @continue(in_array($key, ['report_name', 'generated_by']))
                        @continue($val === null || $val === '')
                        <span class="filter-chip">
                            {{ ucwords(str_replace(['_', '-'], ' ', $key)) }}: {{ is_array($val) ? json_encode($val) : $val }}
                        </span>
                    @endforeach
                </div>
            @endif

            @php
                $type = strtolower($report->report_type);
                $householdScope = ($type === 'household' && (($used['report_scope'] ?? 'summary') === 'family_members'))
                    ? 'family_members'
                    : 'summary';
            @endphp

            <div class="col-controls mb-3 no-print" id="colControls">
                <div class="col-controls-title">Show or hide columns</div>
                <div class="col-controls-grid" id="colCheckboxGrid"></div>
                <div class="col-actions">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnColsAll">Select all</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnColsNone">Clear</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnColsApply">Apply</button>
                </div>
            </div>
            @if($type === 'household')
                <div class="sort-controls mb-3 no-print">
                    <div class="col-controls-title">Sort Household View</div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">Sort By</label>
                            <select id="householdSortBy" class="form-select form-select-sm">
                                <option value="letter">By Letter</option>
                                <option value="house_head">By House Head</option>
                                <option value="street">Street</option>
                                <option value="house_no">House No.</option>
                                @if($householdScope === 'family_members')
                                    <option value="relationship">Relationship</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Order</label>
                            <select id="householdSortOrder" class="form-select form-select-sm">
                                <option value="asc">A - Z</option>
                                <option value="desc">Z - A</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm" id="btnHouseholdSortApply">Apply Sort</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnHouseholdSortReset">Reset</button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="reportTable">
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
                        @forelse($data as $row)
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
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">No records matched the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const reportType = @json(strtolower($report->report_type));
        const householdScope = @json(($householdScope ?? 'summary'));
        const storageKey = "report_cols_visible_" + reportType + (reportType === "household" ? "_" + householdScope : "");
        const table = document.getElementById("reportTable");
        const grid = document.getElementById("colCheckboxGrid");
        const btnAll = document.getElementById("btnColsAll");
        const btnNone = document.getElementById("btnColsNone");
        const btnApply = document.getElementById("btnColsApply");
        const householdSortBy = document.getElementById("householdSortBy");
        const householdSortOrder = document.getElementById("householdSortOrder");
        const btnHouseholdSortApply = document.getElementById("btnHouseholdSortApply");
        const btnHouseholdSortReset = document.getElementById("btnHouseholdSortReset");

        if (!table || !grid) return;

        const headerCells = Array.from(table.querySelectorAll("thead th[data-col]"));
        const columns = headerCells.map(th => ({ 
            key: th.getAttribute("data-col"), 
            label: (th.textContent || "").trim() 
        })).filter(c => c.key && c.label);

        function readSaved() {
            try {
                const raw = localStorage.getItem(storageKey);
                if (!raw) return null;
                const parsed = JSON.parse(raw);
                return Array.isArray(parsed) ? parsed : null;
            } catch (e) { return null; }
        }

        function saveSelected(keys) {
            localStorage.setItem(storageKey, JSON.stringify(keys));
        }

        function setAllChecks(checked) {
            const checks = Array.from(grid.querySelectorAll("input[type='checkbox'][data-col]"));
            checks.forEach(c => c.checked = checked);
        }

        function getSelectedFromChecks() {
            const checks = Array.from(grid.querySelectorAll("input[type='checkbox'][data-col]"));
            return checks.filter(c => c.checked).map(c => c.getAttribute("data-col"));
        }

        function applySelected(keys) {
            const selected = new Set(keys);
            const ths = Array.from(table.querySelectorAll("thead th[data-col]"));
            ths.forEach(th => {
                const k = th.getAttribute("data-col");
                th.style.display = selected.has(k) ? "" : "none";
            });
            const tds = Array.from(table.querySelectorAll("tbody td[data-col]"));
            tds.forEach(td => {
                const k = td.getAttribute("data-col");
                td.style.display = selected.has(k) ? "" : "none";
            });
        }

        function renderChecks(savedKeys) {
            const saved = new Set(savedKeys || []);
            const hasSaved = Array.isArray(savedKeys) && savedKeys.length > 0;
            grid.innerHTML = columns.map(col => {
                const checked = hasSaved ? saved.has(col.key) : true;
                return `
                    <label class="col-check">
                        <input class="form-check-input" type="checkbox" data-col="${col.key}" ${checked ? "checked" : ""}>
                        <span>${col.label}</span>
                    </label>
                `;
            }).join("");
        }

        const saved = readSaved();
        renderChecks(saved);
        applySelected(Array.isArray(saved) && saved.length > 0 ? saved : columns.map(c => c.key));

        function getCellText(row, colKey) {
            const cell = row.querySelector(`td[data-col="${colKey}"]`);
            return ((cell && cell.textContent) ? cell.textContent : "").trim();
        }

        const sortableRows = Array.from(table.querySelectorAll("tbody tr"))
            .filter(row => row.querySelector("td[data-col]"));
        sortableRows.forEach((row, idx) => {
            row.dataset.originalIndex = String(idx);
        });

        function sortHouseholdRows(sortBy, sortOrder) {
            if (reportType !== "household" || sortableRows.length === 0) return;

            const rows = Array.from(sortableRows);
            if (!sortBy) {
                rows.sort((a, b) => Number(a.dataset.originalIndex) - Number(b.dataset.originalIndex));
            } else {
                rows.sort((a, b) => {
                    let aVal = "";
                    let bVal = "";

                    if (sortBy === "house_head") {
                        const headCol = householdScope === "family_members" ? "house_head" : "house_heads";
                        aVal = getCellText(a, headCol);
                        bVal = getCellText(b, headCol);
                    } else if (sortBy === "street") {
                        aVal = getCellText(a, "street");
                        bVal = getCellText(b, "street");
                    } else if (sortBy === "house_no") {
                        aVal = getCellText(a, "house_no");
                        bVal = getCellText(b, "house_no");
                    } else if (sortBy === "relationship") {
                        aVal = getCellText(a, "relationship");
                        bVal = getCellText(b, "relationship");
                    } else {
                        aVal = getCellText(a, "street");
                        bVal = getCellText(b, "street");
                    }

                    const cmp = aVal.localeCompare(bVal, undefined, { sensitivity: "base", numeric: true });
                    return sortOrder === "desc" ? -cmp : cmp;
                });
            }

            const tbody = table.querySelector("tbody");
            rows.forEach(row => tbody.appendChild(row));
        }

        if (btnAll) btnAll.addEventListener("click", () => setAllChecks(true));
        if (btnNone) btnNone.addEventListener("click", () => setAllChecks(false));
        if (btnApply) {
            btnApply.addEventListener("click", () => {
                const selected = getSelectedFromChecks();
                if (selected.length === 0) {
                    localStorage.removeItem(storageKey);
                    applySelected(columns.map(c => c.key));
                    setAllChecks(true);
                    return;
                }
                saveSelected(selected);
                applySelected(selected);
            });
        }

        if (btnHouseholdSortApply) {
            btnHouseholdSortApply.addEventListener("click", () => {
                sortHouseholdRows(
                    householdSortBy ? householdSortBy.value : "letter",
                    householdSortOrder ? householdSortOrder.value : "asc"
                );
            });
        }

        if (btnHouseholdSortReset) {
            btnHouseholdSortReset.addEventListener("click", () => {
                sortHouseholdRows("", "asc");
            });
        }
    })();

    // Handle Print/PDF template actions - pass visible columns to print template
    document.addEventListener('DOMContentLoaded', function() {
        const printTemplateBtn = document.getElementById('printTemplateBtn');
        const pdfTemplateBtn = document.getElementById('pdfTemplateBtn');

        function buildTemplateUrl(mode) {
            const checks = Array.from(document.querySelectorAll("input[type='checkbox'][data-col]"));
            const visibleCols = checks.filter(c => c.checked).map(c => c.getAttribute('data-col')).join(',');
            const params = new URLSearchParams();
            if (visibleCols) params.set('cols', visibleCols);
            if (mode) params.set('mode', mode);
            const qs = params.toString();
            return "{{ route('admin.reports.print-template', $report->id) }}" + (qs ? ('?' + qs) : '');
        }

        if (printTemplateBtn) {
            printTemplateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.open(buildTemplateUrl('print'), '_blank');
            });
        }

        if (pdfTemplateBtn) {
            pdfTemplateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.open(buildTemplateUrl('pdf'), '_blank');
            });
        }

    });
</script>