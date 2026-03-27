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
            background-color: #dc3545;
            color: #fff;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
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
    $complainant = $complaint->complainant;
    $fullName = trim(implode(' ', array_filter([
        $complainant?->firstName,
        $complainant?->middleName,
        $complainant?->lastName,
    ])));
@endphp

<div class="container">
    <div class="header">
        <h2 style="margin:0;">New Complaint Entry</h2>
    </div>

    <div class="content">
        <p>A new complaint has been submitted and is now waiting in the Complaints Management module.</p>

        <div class="details">
            <p style="margin:0 0 6px 0;"><strong>Complaint ID:</strong> {{ $complaint->formatted_id }}</p>
            <p style="margin:0 0 6px 0;"><strong>Complainant:</strong> {{ $fullName !== '' ? $fullName : ($complaint->complainantName ?: 'N/A') }}</p>
            <p style="margin:0 0 6px 0;"><strong>Email:</strong> {{ $complainant?->email ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Contact Number:</strong> {{ $complainant?->contactNumber ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Address:</strong> {{ $complaint->address ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Status:</strong> {{ ucfirst((string) $complaint->status) }}</p>
            <p style="margin:0 0 6px 0;"><strong>Complaint Date & Time:</strong> {{ $complaint->complaint_datetime ? $complaint->complaint_datetime->format('F d, Y g:i A') : 'Not provided' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Details:</strong><br>{!! nl2br(e($complaint->details)) !!}</p>
            <p style="margin:0;"><strong>Submitted At:</strong> {{ optional($complaint->created_at)->format('F d, Y g:i A') }}</p>
        </div>

        @if(!empty($complaint->attachment_path))
            <p style="margin-top: 12px;">
                <strong>Attachment:</strong>
                <a href="{{ asset('storage/' . ltrim((string) $complaint->attachment_path, '/')) }}">View uploaded file</a>
            </p>
        @endif

        <p>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
