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
            background-color: #0d6efd;
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
    $fullName = trim(implode(' ', array_filter([
        $user->firstName,
        $user->middleName,
        $user->lastName,
    ])));
@endphp

<div class="container">
    <div class="header">
        <h2 style="margin:0;">New User Registration</h2>
    </div>

    <div class="content">
        <p>A new user has registered and is waiting for review in the Users module.</p>

        <div class="details">
            <p style="margin:0 0 6px 0;"><strong>User ID:</strong> {{ $user->formatted_id }}</p>
            <p style="margin:0 0 6px 0;"><strong>Full Name:</strong> {{ ucwords($fullName !== '' ? $fullName : 'N/A') }}</p>
            <p style="margin:0 0 6px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin:0 0 6px 0;"><strong>Contact Number:</strong> {{ $user->contactNumber ?? 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Birthday:</strong> {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('F d, Y') : 'N/A' }}</p>
            <p style="margin:0 0 6px 0;"><strong>Role:</strong> {{ ucfirst((string) $user->role) }}</p>
            <p style="margin:0 0 6px 0;"><strong>Status:</strong> {{ ucfirst((string) $user->status) }}</p>
            <p style="margin:0;"><strong>Registered At:</strong> {{ $user->registrationDate ? \Carbon\Carbon::parse($user->registrationDate)->format('F d, Y g:i A') : optional($user->created_at)->format('F d, Y g:i A') }}</p>
        </div>

        @if(!empty($user->proofOfIdentity))
            <p style="margin-top: 12px;">
                <strong>Proof of Identity:</strong>
                <a href="{{ asset('storage/' . ltrim((string) $user->proofOfIdentity, '/')) }}">View uploaded file</a>
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
