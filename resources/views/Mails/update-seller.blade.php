<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update on Your Marketplace Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #555555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #ffffff;
            background-color: #3498db;
            border-radius: 5px;
        }

        .changes {
            margin-top: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .change-item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update on Your Marketplace Account</h1>

        <p>Dear {{ $sellerName }},</p>

        <p>We wanted to inform you that there have been updates to your account information. Please review the changes below:</p>

        <div class="changes">
            <div class="change-item"><strong>Updated Email:</strong> Test</div>
            <div class="change-item"><strong>Updated Contact Number:</strong> Test</div>
            <!-- Add more lines for additional changes as needed -->
        </div>

        <p>If you have initiated these changes, you can disregard this email. However, if you did not make these changes or have any concerns, please contact our support team immediately.</p>

        <p>Thank you for choosing our marketplace.</p>

        <a href="link" class="button">Log In Now</a>

        <p>Best regards,<br>
        Your Marketplace Team</p>
    </div>
</body>
</html>
