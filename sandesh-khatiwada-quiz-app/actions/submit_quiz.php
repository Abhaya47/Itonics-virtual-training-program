<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student' || $_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['quiz_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$quiz_id    = (int)$_POST['quiz_id'];
$student_id = $_SESSION['user_id'];

//Case: Already attempted
$stmt = $conn->prepare("SELECT 1 FROM attempts WHERE quiz_id = ? AND student_id = ?");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    die("You have already attempted this quiz.");
}
$stmt->close();

// Get correct answers
$stmt = $conn->prepare("SELECT id, correct_option FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$correct = [];
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $correct[$row['id']] = $row['correct_option'];
}
$stmt->close();

if (empty($correct)) {
    die("No questions found for this quiz.");
}

$score = 0;
foreach ($correct as $qid => $ans) {
    if (isset($_POST["q_$qid"]) && (int)$_POST["q_$qid"] === $ans) {
        $score++;
    }
}

$total = count($correct);

// Save result
$stmt = $conn->prepare("INSERT INTO attempts (student_id, quiz_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $student_id, $quiz_id, $score);
$stmt->execute();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Submitted</h1>
        <p>Your score: <strong><?= $score ?> / <?= $total ?></strong></p> <br><br>
        <p><a href="<?= BASE_URL ?>student/available_quizzes.php" class="btn">Back to Quizzes</a></p>
    </div>
</body>
</html>