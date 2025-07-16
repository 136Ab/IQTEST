<?php
session_start();
require_once 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// Fetch questions
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate score
$score = 0;
$total_questions = count($questions);
$answers = $_SESSION['answers'] ?? [];

foreach ($questions as $question) {
    if (isset($answers[$question['id']]) && $answers[$question['id']] == $question['correct_option']) {
        $score++;
    }
}

// Calculate IQ score (simple formula: percentage * 100 + 50 for a 50-150 scale)
$percentage = ($score / $total_questions) * 100;
$iq_score = round(($percentage * 1) + 50);

// Feedback based on score
$feedback = '';
if ($iq_score >= 130) {
    $feedback = "Exceptional! Your cognitive abilities are in the top percentile, showcasing strong logical reasoning and problem-solving skills.";
} elseif ($iq_score >= 110) {
    $feedback = "Above average! You have solid cognitive skills with potential for further growth in pattern recognition and analytical thinking.";
} elseif ($iq_score >= 90) {
    $feedback = "Average performance. Your skills are well-balanced, with room to improve in logical and numerical reasoning.";
} else {
    $feedback = "Below average. Focus on practicing pattern recognition and logical reasoning to enhance your cognitive abilities.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #84fab0, #8fd3f4);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .results-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        h2 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }
        .score {
            font-size: 3em;
            color: #84fab0;
            margin: 20px 0;
        }
        p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .btn {
            background: #8fd3f4;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.2em;
            cursor: pointer;
            margin: 10px;
            transition: background 0.3s, transform 0.2s;
        }
        .btn:hover {
            background: #84fab0;
            transform: scale(1.05);
        }
        @media (max-width: 600px) {
            h2 {
                font-size: 2em;
            }
            .score {
                font-size: 2.5em;
            }
            p {
                font-size: 1em;
            }
            .btn {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="results-container">
        <h2>Your IQ Test Results</h2>
        <div class="score"><?php echo $iq_score; ?></div>
        <p>Score: <?php echo $score; ?> out of <?php echo $total_questions; ?> correct</p>
        <p><?php echo htmlspecialchars($feedback); ?></p>
        <button class="btn" onclick="retakeTest()">Retake Test</button>
        <button class="btn" onclick="shareResults()">Share Results</button>
        <button class="btn" onclick="navigateToLogout()">Logout</button>
    </div>
    <script>
        function retakeTest() {
            window.location.href = 'quiz.php';
        }
        function shareResults() {
            alert('Share your IQ score of <?php echo $iq_score; ?> with friends!');
        }
        function navigateToLogout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
