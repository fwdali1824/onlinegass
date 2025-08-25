<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            text-align: center;
        }
        .user-details {
            margin-top: 20px;
        }
        .user-details strong {
            display: inline-block;
            width: 100px;
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            background-color: #4F46E5;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome, {{ $name }}!</h2>
        </div>
        <p>Thank you for registering with us. Below are your account details:</p>

        <div class="user-details">
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Phone:</strong> {{ $phone }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
        </div>

        <a href="{{ url('/user-login') }}" class="btn">Visit Dashboard</a>

        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
