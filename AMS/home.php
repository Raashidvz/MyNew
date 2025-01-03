
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Design with Animation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #000000, #0a1c24, #002d40, #00bfff, #ffffff);
            background-size: 400% 400%;
            animation: gradientFlow 15s ease infinite;
            color: #ffffff;
            height: 100vh;
            overflow: hidden;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: relative;
        }

        .section {
            width: 100%;
            max-width: 1100px;
            display: flex;
            justify-content: space-between;
            position: relative;
            transition: transform 1s ease;
        }

        /* Hero Section */
        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 50%;
        }

        .hero-text h1 {
            font-size: 64px;
            font-weight: bold;
            margin-bottom: 20px;
            max-width: 600px;
            color: #00bfff;
            text-shadow: 2px 2px 20px rgba(0, 191, 255, 0.5);
        }

        .hero-text p {
            font-size: 20px;
            color: #b0c4c4;
            max-width: 500px;
            margin-bottom: 40px;
        }

        .cta-btn {
            background-color: #00bfff;
            color: #000000;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.5s ease, box-shadow 0.5s ease;
            box-shadow: 0 4px 10px rgba(0, 191, 255, 0.4);
        }

        .cta-btn:hover {
            background-color: #009acd;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 191, 255, 0.6);
        }

        /* Form Sections */
        .login-container,
        .password-container {
            width: 50%;
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            color: #333;
            display: none;
        }

        .form-container.active {
            display: block;
            animation: fadeIn 2s ease forwards;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input[type="text"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .login-btn,
        .password-btn {
            width: 100%;
            padding: 10px;
            background-color: #00bfff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover,
        .password-btn:hover {
            background-color: #009acd;
        }

        .form-container p {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .form-container a {
            text-decoration: none;
            color: #009acd;
            cursor: pointer;
        }

        .shift-left {
            transform: translateX(-7%);
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateX(50%);
            }

            100% {
                opacity: 1;
                transform: translateX(10%);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="section">
            <!-- Hero Section -->
            <section class="hero">
                <div class="hero-text">
                    <h1>Funiversity</h1>
                    <p>"The beautiful thing about learning is that no one can take it away from you."</p>
                    <button class="cta-btn" id="startBtn">Let's Start</button>
                </div>
            </section>

            <!-- Login Form Section -->
            <div class="login-container form-container" id="loginForm">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="login-btn">Login</button>
                </form>
                <p>Do you want to <a id="changePasswordLink">change your password</a>?</p>
            </div>

            <!-- Password Change Form Section -->
            <div class="password-container form-container" id="passwordForm">
                <h2>Change Password</h2>
                <form action="change_pswd.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="old-password">Old Password</label>
                        <input type="password" id="old-password" name="old-password" required>
                    </div>
                    <div class="input-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>
                    <button type="submit" name="change-password" class="password-btn">Change Password</button>
                </form>
                <p>Back to <a id="backToLogin">login</a>?</p>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle animations and form switching
        document.getElementById('startBtn').addEventListener('click', function () {
            document.querySelector('.section').classList.add('shift-left');
            document.getElementById('loginForm').classList.add('active');
        });

        document.getElementById('changePasswordLink').addEventListener('click', function () {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('passwordForm').classList.add('active');
        });

        document.getElementById('backToLogin').addEventListener('click', function () {
            document.getElementById('passwordForm').classList.remove('active');
            document.getElementById('loginForm').classList.add('active');
        });
    </script>
</body>

</html>
