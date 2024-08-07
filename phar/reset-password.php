<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <div class="header">
        <h1>Forgot Password</h1>
    </div>
    <div class="forgot-password">
        <h2>Reset Your Password</h2>
        <form action="process_forgot_password.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>