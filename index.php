<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Homepage</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
        }
        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .start-btn, .logout-btn {
            background: #6e8efb;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
            margin: 10px;
        }
        .start-btn:hover, .logout-btn:hover {
            background: #a777e3;
            transform: scale(1.05);
        }
        .nav {
            margin-top: 20px;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }
            p {
                font-size: 1em;
            }
            .start-btn, .logout-btn {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Challenge your mind with our comprehensive IQ test designed to assess your logical reasoning, numerical ability, and pattern recognition skills. Discover your cognitive strengths and get personalized feedback!</p>
        <button class="start-btn" onclick="navigateToQuiz()">Start Test</button>
        <div class="nav">
            <button class="logout-btn" onclick="navigateToLogout()">Logout</button>
        </div>
    </div>
    <script>
        function navigateToQuiz() {
            window.location.href = 'quiz.php';
        }
        function navigateToLogout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
