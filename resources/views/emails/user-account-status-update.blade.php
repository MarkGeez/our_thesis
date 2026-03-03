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
        .header-rejected {
            background-color: #dc3545;
        }
        .content {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
            padding: 20px;
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
    $isApproved = $user->status === 'approved';
    $isRejected = in_array($user->status, ['declined', 'rejected'], true);
    $statusLabel = $isApproved ? 'Approved' : ($isRejected ? 'Rejected' : ucfirst((string) $user->status));
@endphp

<div class="container">
    <div class="header {{ $isApproved ? 'header-approved' : 'header-rejected' }}">
        <h2 style="margin:0;">Account {{ $statusLabel }}</h2>
    </div>

    <div class="content">
        <p>Hello {{ ucfirst($user->firstName ?? 'User') }},</p>

        @if($isApproved)
            <p>Your account request has been approved. You can now log in and use the system.</p>
        @else
            <p>Your account request has been rejected. If you believe this is a mistake, please contact the barangay office.</p>
        @endif

        <p>Thank you,<br>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
