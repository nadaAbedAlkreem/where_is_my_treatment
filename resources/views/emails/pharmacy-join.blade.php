<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subscription Accepted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            color: #00aaff;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
        }

        .highlight {
            background-color: #f1f1f1;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin: 10px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">Welcome to "Where is My Treatment?"</div>

    <div class="content">
        <p>Dear Pharmacy Owner,</p>

        <p>We are pleased to inform you that your subscription request has been <strong>approved</strong>.</p>

        <p>You can now log in to the application using the following credentials:</p>

        <p class="highlight">Email: {{ $email }}</p>
        <p class="highlight">Temporary Password: {{ $password }}</p>
        <p class="highlight">Link to your pharmacy dashboard: {{ $link }}</p>

        <hr>

        <p><strong>How to Use Your Pharmacy Dashboard:</strong></p>

        <ul>
            <li><strong>Hiring System:</strong> You can invite employees (pharmacists or assistants) to join your pharmacy team. Each employee will have their own account with customized permissions set by you.</li>
            <li><strong>Inventory Management:</strong> Easily add, update, and track medications in your pharmacy’s inventory. You can categorize items, monitor stock levels, and receive alerts for low inventory.</li>
            <li><strong>Order Tracking:</strong> Manage incoming and outgoing medicine orders efficiently through the system.</li>
            <li><strong>Reports:</strong> View real-time analytics and inventory reports to support better decision-making.</li>
        </ul>

        <p>For security reasons, please make sure to <strong>change your password</strong> after the first login.</p>

        <p>If you have any questions or need support, feel free to contact our support team.</p>

        <p>Best regards,<br>The Where is My Treatment? Team</p>

    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Where is My Treatment? — All rights reserved.
    </div>
</div>
</body>
</html>
