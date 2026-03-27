<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .header {
            color: #fff;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .header-ongoing {
            background-color: #f59e0b;
            color: #1f2937;
        }
        .header-resolved {
            background-color: #198754;
        }
        .header-rejected {
            background-color: #dc3545;
        }
        .content {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
            padding: 20px;
        }
        .details {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 12px;
            margin: 16px 0;
        }
        .footer {
            margin-top: 18px;
            font-size: 12px;
            color: #666;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
@php
    $statusLabel = match ($complaint->status) {
        'on-going' => 'On-going',
        'resolved' => 'Resolved',
        'rejected' => 'Rejected',
        default => ucfirst((string) $complaint->status),
    };

    $headerClass = match ($complaint->status) {
        'resolved' => 'header-resolved',
        'rejected' => 'header-rejected',
        default => 'header-ongoing',
    };
@endphp

<div class="container">
    <div class="header {{ $headerClass }}">
        <h2 style="margin:0;">Complaint {{ $statusLabel }}</h2>
    </div>

    <div class="content">
        <p>Hello {{ ucfirst($complaint->complainant->firstName ?? 'Resident') }},</p>

        <p>Your complaint has been updated by the barangay admin.</p>

        <div class="details">
            <p style="margin:0 0 6px 0;"><strong>Complaint ID:</strong> {{ $complaint->formatted_id }}</p>
            <p style="margin:0 0 6px 0;"><strong>Status:</strong> {{ $statusLabel }}</p>
            <p style="margin:0;"><strong>Address:</strong> {{ $complaint->address }}</p>
            @if(!empty($complaint->remarks))
                <p style="margin:6px 0 0 0;"><strong>Remarks:</strong><br>{!! nl2br(e($complaint->remarks)) !!}</p>
            @endif
        </div>

        <p>Thank you,<br>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
