<style>
    @media print {
        .no-print, .no-print * {
            display: none !important;
        }
    }
</style>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">{{ $report->report_name }}</h4>
                <small class="text-muted">
                    Type: {{ ucfirst($report->report_type) }}
                    | Generated: {{ $report->created_at }}
                    | Total: {{ $report->total_records }}
                </small>
            </div>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary btn-sm no-print">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button onclick="window.print()" class="btn btn-primary btn-sm no-print">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- display filters used --}}
            @if($report->filters_used)
                @php $used = json_decode($report->filters_used, true); @endphp
                <div class="mb-3">
                    <strong>Filters:</strong>
                    <ul class="mb-0">
                        @foreach($used as $key => $val)
                            @continue(in_array($key, ['report_name','generated_by']))
                            @if($val === null || $val === '')
                                @continue
                            @endif
                            <li>{{ ucwords(str_replace(['_','-'], ' ', $key)) }}: {{ is_array($val) ? json_encode($val) : $val }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php $type = strtolower($report->report_type); @endphp
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            @if($type == 'population')
                                <th>Full Name</th>
                                <th>Birthdate</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Street</th>
                                <th>Parent Status</th>
                                @if(\Schema::hasColumn('residents', 'civil_status'))
                                    <th>Civil Status</th>
                                @endif
                            @elseif($type == 'blotter')
                                <th>Plaintiff</th>
                                <th>Defendant</th>
                                <th>Status</th>
                            @elseif($type == 'certificate')
                                <th>Resident</th>
                                <th>Certificate Type</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            @if($type == 'population')
                                <td>{{ $row->firstName }} {{ $row->lastName }}</td>
                                <td>{{ $row->birthday }}</td>
                                <td>{{ $row->age }}</td>
                                <td>{{ ucfirst($row->sex) }}</td>
                                <td>{{ $row->street }}</td>
                                <td>{{ ucfirst($row->parent) }}</td>
                                @if(\Schema::hasColumn('residents', 'civil_status'))
                                    <td>{{ $row->civil_status ?? '' }}</td>
                                @endif
                            @elseif($type == 'blotter')
                                <td>{{ $row->plaintiffName }} {{ $row->plaintiffLastName }}</td>
                                <td>{{ $row->defendantName }} {{ $row->defendantLastName }}</td>
                                <td>{{ $row->status }}</td>
                            @elseif($type == 'certificate')
                                <td>{{ $row->resident_name }}</td>
                                <td>{{ $row->certificate_type }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
