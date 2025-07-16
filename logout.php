<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Logout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .logout-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
        }
        h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }
        .btn {
            background: #d4fc79;
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .btn:hover {
            background: #96e6a1;
            transform: scale(1.05);
        }
        @media (max-width: 600px) {
            .logout-container {
                padding: 20px;
            }
            h2 {
                font-size: 1.5em;
            }
            p {
                font-size: 1em;
            }
            .btn {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Logged Out</h2>
        <p>You have been successfully logged out.</p>
        <button class="btn" onclick="navigateToLogin()">Login Again</button>
    </div>
    <script>
        function navigateToLogin() {
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>
