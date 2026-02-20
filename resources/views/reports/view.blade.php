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
                <a href="#" id="printTemplateBtn" class="btn btn-success btn-sm" target="_blank">
                    <i class="fa fa-print me-1"></i> Print with Template
                </a>{{--  
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fa fa-print me-1"></i> Print
                </button>--}}
            </div>
        </div>

        <div class="card-body p-4">
            @if($report->filters_used)
                @php $used = json_decode($report->filters_used, true); @endphp
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

            @php $type = strtolower($report->report_type); @endphp

            <div class="col-controls mb-3 no-print" id="colControls">
                <div class="col-controls-title">Show or hide columns</div>
                <div class="col-controls-grid" id="colCheckboxGrid"></div>
                <div class="col-actions">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnColsAll">Select all</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnColsNone">Clear</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnColsApply">Apply</button>
                </div>
            </div>

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
                                    <td data-col="plaintiff">{{ ucwords(strtolower($row->plaintiffName)) }} {{ ucwords(strtolower($row->plaintiffLastName)) }}</td>
                                    <td data-col="defendant">{{ ucwords(strtolower($row->defendantName)) }} {{ ucwords(strtolower($row->defendantLastName)) }}</td>
                                    <td data-col="status">{{ ucfirst($row->status) }}</td>
                                @elseif($type == 'certificate')
                                    <td data-col="resident">{{ ucwords(strtolower($row->requesterName)) }}</td>
                                    <td data-col="certificate_type">{{ ucfirst(str_replace('_', ' ', $row->certificate_type)) }}</td>
                                    <td data-col="certificate_status">{{ ucfirst($row->status) }}</td>
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
        const storageKey = "report_cols_visible_" + reportType;
        const table = document.getElementById("reportTable");
        const grid = document.getElementById("colCheckboxGrid");
        const btnAll = document.getElementById("btnColsAll");
        const btnNone = document.getElementById("btnColsNone");
        const btnApply = document.getElementById("btnColsApply");

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
    })();

    // Handle Print with Template button - pass visible columns to print template
    document.addEventListener('DOMContentLoaded', function() {
        const printTemplateBtn = document.getElementById('printTemplateBtn');
        if (!printTemplateBtn) return;
        
        printTemplateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const checks = Array.from(document.querySelectorAll("input[type='checkbox'][data-col]"));
            const visibleCols = checks.filter(c => c.checked).map(c => c.getAttribute('data-col')).join(',');
            const url = "{{ route('admin.reports.print-template', $report->id) }}" + (visibleCols ? '?cols=' + encodeURIComponent(visibleCols) : '');
            window.open(url, '_blank');
        });
    });
</script>