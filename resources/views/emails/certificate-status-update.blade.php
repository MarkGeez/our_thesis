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
        .header-approved {
            background-color: #198754;
        }
        .header-declined {
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
    $request = $certificateRequest;
    $status = $request->status;
    $isApproved = $status === 'approved';
    $headerClass = $isApproved ? 'header-approved' : 'header-declined';
    $statusLabel = $isApproved ? 'Approved for Pickup' : 'Rejected';
    $certificateType = ucfirst((string) $request->certificate_type);
@endphp

<div class="container">
    <div class="header {{ $headerClass }}">
        <h2 style="margin:0;">Certificate Request {{ $statusLabel }}</h2>
    </div>

    <div class="content">
        <p>Hello {{ ucfirst($request->user->firstName ?? 'Requester') }},</p>

        @if($isApproved)
            <p>Your {{ $certificateType }} certificate request has been approved and is ready for pickup.</p>
        @else
            <p>Your {{ $certificateType }} certificate request has been rejected.</p>
        @endif

        <div class="details">
            <p style="margin:0 0 6px 0;"><strong>Request ID:</strong> {{ $request->formatted_id }}</p>
            <p style="margin:0 0 6px 0;"><strong>Certificate Type:</strong> {{ $certificateType }}</p>
            <p style="margin:0;"><strong>Status:</strong> {{ $statusLabel }}</p>
            @if(!$isApproved && !empty($request->decline_reason))
                <p style="margin:6px 0 0 0;"><strong>Reason:</strong> {{ $request->decline_reason }}</p>
            @endif
        </div>

        @if($isApproved)
            <p>You can now go to the Barangay Chairman's for certificate printing.</p>
        @endif

        <p>Thank you,<br>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
