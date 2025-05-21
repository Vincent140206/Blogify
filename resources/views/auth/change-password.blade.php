<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Blogify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .left-section {
            flex: 2;
            background: url('{{ asset('images/Blue Bg.png') }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 5vh;
        }
        .left-section img {
            width: 160px;
            margin-bottom: 30px;
        }
        .left-section h1 {
            font-size: 3rem;
            text-align: center;
            font-weight: bold;
        }
        .right-section {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-box h2 {
            color: #2876E9;
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 20px;
            background: #e0e0e0;
            font-size: 1rem;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #2876E9;
            color: #fff;
            border: none;
            border-radius: 20px;
            font-size: 1.1rem;
            margin-top: 15px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-box button:hover {
            background: #1565c0;
        }
        .register-link {
            margin-top: 18px;
            font-size: 1rem;
        }
        .register-link b {
            color: #000;
        }
        .social-login {
            display: flex;
            gap: 20px;
            margin-top: 25px;
        }
        .social-login button {
            background: #f5f5f5;
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            font-size: 1.7rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.2s;
        }
        .social-login button:hover {
            box-shadow: 0 2px 8px rgba(33,150,243,0.2);
        }
        h4 {
            margin-top: 1px;
            margin-bottom: 1px; 
            font-size: 1rem;
            font-weight: normal;
        }
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }
            .left-section, .right-section {
                flex: none;
                width: 100%;
                height: 50vh;
            }
        }
    </style>
</head>
<body>
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