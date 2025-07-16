<?php
session_start();
require_once 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// Initialize session for answers
if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

// Fetch questions
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['answers'] = $_POST['answers'] ?? [];
    // Store responses in database
    foreach ($_SESSION['answers'] as $question_id => $selected_option) {
        $stmt = $pdo->prepare("INSERT INTO responses (user_id, session_id, question_id, selected_option) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], session_id(), $question_id, $selected_option]);
    }
    echo "<script>window.location.href = 'results.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Quiz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f6d365, #fda085);
            color: #333;
        }
        .quiz-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 0 auto;
        }
        h2 {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .question {
            margin-bottom: 20px;
        }
        .question p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .options label {
            display: block;
            padding: 10px;
            background: #f9f9f9;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .options label:hover {
            background: #e0e0e0;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        .submit-btn, .logout-btn {
            background: #fda085;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.2em;
            cursor: pointer;
            display: inline-block;
            margin: 10px;
            transition: background 0.3s;
        }
        .submit-btn:hover, .logout-btn:hover {
            background: #f6d365;
        }
        .nav {
            text-align: center;
        }
        @media (max-width: 600px) {
            .quiz-container {
                padding: 20px;
            }
            h2 {
                font-size: 1.5em;
            }
            .question p {
                font-size: 1em;
            }
            .submit-btn, .logout-btn {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h2>IQ Test - Questions</h2>
        <form method="POST">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <p><?php echo ($index + 1) . ". " . htmlspecialchars($question['question_text']); ?></p>
                    <div class="options">
                        <?php
                        $options = [$question['option_a'], $question['option_b'], $question['option_c'], $question['option_d']];
                        foreach ($options as $i => $option):
                        ?>
                            <label>
                                <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $i + 1; ?>" required>
                                <?php echo htmlspecialchars($option); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Submit Test</button>
            <div class="nav">
                <button class="logout-btn" onclick="navigateToLogout()">Logout</button>
            </div>
        </form>
    </div>
    <script>
        function navigateToLogout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
