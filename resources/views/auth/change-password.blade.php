<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Blogify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="change-password-page">
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <img src="{{ asset('images/Blogify.png') }}" alt="Blogify Logo">
            <h1>
                Welcome to<br>
                Blogify!
            </h1>
        </div>
        <!-- Right Section -->
        <div class="right-section">
            <div class="login-box">
                <h2>Recovery</h2>
                <form method="POST" action="{{ route('password.recovery') }}">
                    @csrf
                    <h4>E-Mail</h4>
                    <input type="text" name="email" required>
                    <h4>Username</h4>
                    <input type="text" name="name" required>
                    <h4>Old Password</h4>
                    <input type="password" name="current_password" required>
                    <h4>New Password</h4>
                    <input type="password" name="new_password" required>
                    <h4>Confirm Password</h4>
                    <input type="password" name="password_confirmation" required>
                    <button type="submit">Change</button>
                </form>
                <div class="register-link">
                    Already have an account? <a href="{{ route('login') }}"><b>Login!</b></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>