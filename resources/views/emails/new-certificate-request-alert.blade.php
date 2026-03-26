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
            background-color: #198754;
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
    $requester = $certificateRequest->user;
    $fullName = trim(implode(' ', array_filter([
        $requester?->firstName,
        $requester?->middleName,
        $requester?->lastName,
    ])));
    $certificateType = ucfirst((string) $certificateRequest->certificate_type);
@endphp

<div class="container">
    <div class="header">
        <h2 style="margin:0;">New Certificate Request</h2>
    </div>

    <div class="content">
        <p>A new certificate request was submitted and is now waiting in the Certificate Request Management module.</p>

        <div class="details">
            <p style="margin:0 0 6px 0;"><strong>Request ID:</strong> {{ $certificateRequest->formatted_id }}</p>
            <p style="margin:0 0 6px 0;"><strong>Requester:</strong> {{ $fullName !== '' ? $fullName : 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Email:</strong> {{ $requester?->email ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Contact Number:</strong> {{ $requester?->contactNumber ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Certificate Type:</strong> {{ $certificateType }}</p>
            <p style="margin:0 0 6px 0;"><strong>Purpose:</strong> {{ $certificateRequest->purpose_other ?: ($certificateRequest->purpose ?: 'N/A') }}</p>
            <p style="margin:0 0 6px 0;"><strong>Address:</strong> {{ $certificateRequest->address ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Status:</strong> {{ ucfirst((string) $certificateRequest->status) }}</p>
            <p style="margin:0;"><strong>Submitted At:</strong> {{ optional($certificateRequest->created_at)->format('F d, Y g:i A') }}</p>
        </div>

        <p>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
