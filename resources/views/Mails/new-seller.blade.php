<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Our Marketplace</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background:turquoise;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #F0F0F0;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome To Nazik Platform!</h1>

        <p>Dear {{ $sellerName }},</p>

        <p>Congratulations! You have successfully joined our Platform as a seller. Here are your login details:</p>

        <p><strong>Username:</strong> {{ $username }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>

        <p>You can now log in to your account and start selling your products. If you have any questions or need
            assistance, feel free to contact our support team.</p>

        <p>Thank you for choosing our Platform. We wish you great success!</p>

        <a href="{{ route('dashboard.login') }}" class="button">Log In Now</a>

        <p>Best regards,<br>
            Nazik Team</p>
    </div>
</body>

</html>
