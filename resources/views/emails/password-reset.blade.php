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
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            margin: 20px 0;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .note {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Hello {{ ucfirst($user->firstName) }},</p>

            <p>We received a request to reset the password for your account. If you made this request, click the button below to reset your password.</p>

            <center>
                <a href="{{ $resetUrl }}" class="button" style="color: white;">Reset Password</a>
            </center>

            <p>Or copy and paste this link in your browser:</p>
            <p><a href="{{ $resetUrl }}" style="word-break: break-all;">{{ $resetUrl }}</a></p>

            <div class="note">
                <strong>Note:</strong> This link will expire in 60 minutes. If you did not request a password reset, you can ignore this email.
            </div>

            <p>If you're having trouble clicking the button, copy and paste the URL above into your web browser.</p>

            <p>Best regards,<br>
            Barangay 249 Management System</p>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Barangay 249, Tondo, Manila. All rights reserved.</p>
                <p>This is an automated email. Please do not reply to this message.</p>
            </div>
        </div>
    </div>
</body>
</html>
