<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JDpharmacy Login</title>
    <style>
        .login {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .login input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .login button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .login button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to JDpharmacy</h1>
    </div>
    <div class="login">
        <h2>Pharmacist Login</h2>
        <?php
        session_start();
        // Check if error message is set in session
        if (isset($_SESSION['error_message'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_SESSION['error_message']) . '</p>';
            // Clear the error message from session after displaying it
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="process_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
    <div class="forgot-password">
        <p>Forgot your password? <a href="reset-password.php">Reset it here</a></p>
    </div>
</body>
</html>