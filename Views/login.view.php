<?php
$message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            font-weight: bold;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container button {
            background-color: #ff5722;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="/login" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
        <?php if ($message): ?>
            <p class="error-message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>

