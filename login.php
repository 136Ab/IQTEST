<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check user credentials
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<script>window.location.href = 'index.php';</script>";
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-size: 1.1em;
            color: #555;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .submit-btn {
            background: #a1c4fd;
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .submit-btn:hover {
            background: #c2e9fb;
            transform: scale(1.05);
        }
        .error {
            color: #d32f2f;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .link {
            color: #a1c4fd;
            text-decoration: none;
            font-size: 1em;
        }
        .link:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .login-container {
                padding: 20px;
            }
            h2 {
                font-size: 1.5em;
            }
            input[type="email"], input[type="password"] {
                font-size: 0.9em;
            }
            .submit-btn {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <p>Don't have an account? <a href="#" class="link" onclick="navigateToSignup()">Sign Up</a></p>
    </div>
    <script>
        function navigateToSignup() {
            window.location.href = 'signup.php';
        }
    </script>
</body>
</html>
