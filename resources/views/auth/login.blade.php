<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Blogify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="login-page">
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
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf  
                    <h4>E-Mail</h4>
                    <input type="text" name="email" required>
                    <h4>Password</h4>
                    <input type="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
                <div class="register-link">
                    Don’t have an account? <a href="{{ route('register') }}"><b>Register!</b></a>
                </div>
                <div class="social-login">
                    <button title="Login with Google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/1200px-Google_%22G%22_logo.svg.png" alt="Google" width="28">
                    </button>
                    <button title="Login with Facebook">
                        <img src="https://cdn.freebiesupply.com/logos/large/2x/facebook-logo-2019.png" alt="Facebook" width="28">
                    </button>
                </div>
                <div class="forgot-password">
                    <a href="{{ route('password.forgot') }}"><b>Forgot Password?</b></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>