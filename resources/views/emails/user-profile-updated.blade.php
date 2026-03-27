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
<div class="container">
    <div class="header">
        <h2 style="margin:0;">Profile Updated</h2>
    </div>

    <div class="content">
        <p>Hello {{ ucfirst($user->firstName ?? 'User') }},</p>

        <p>Your account profile information was recently updated in the Barangay 249 Management System.</p>
        <p>If you made this change, no further action is needed.</p>
        <p>If you did not expect this update, please contact the barangay office as soon as possible.</p>

        <p>Thank you,<br>Barangay 249 Management System</p>

        <div class="footer">
            <p style="margin:0;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</div>
</body>
</html>
