<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student' || empty($_GET['quiz_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$quiz_id = (int)$_GET['quiz_id'];

// Check if already attempted
$stmt = $conn->prepare("SELECT 1 FROM attempts WHERE quiz_id = ? AND student_id = ?");
$stmt->bind_param("ii", $quiz_id, $_SESSION['user_id']);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo "<p class='error'>You have already submitted this quiz.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit();
}
$stmt->close();

$stmt = $conn->prepare("SELECT id, question_text, option1, option2, option3, option4 FROM questions WHERE quiz_id = ? ORDER BY id");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($questions)) {
    echo "<p class='error'>This quiz has no questions.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit();
}
?>

<h2>Quiz #<?= $quiz_id ?></h2>

<form method="post" action="<?= BASE_URL ?>actions/submit_quiz.php">
    <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
            
    <?php foreach ($questions as $q): ?>
        <fieldset>
            <legend><?= htmlspecialchars($q['question_text']) ?></legend>
            <label><input type="radio" name="q_<?= $q['id'] ?>" value="1" required> <?= htmlspecialchars($q['option1']) ?></label><br>
            <label><input type="radio" name="q_<?= $q['id'] ?>" value="2"> <?= htmlspecialchars($q['option2']) ?></label><br>
            <label><input type="radio" name="q_<?= $q['id'] ?>" value="3"> <?= htmlspecialchars($q['option3']) ?></label><br>
            <label><input type="radio" name="q_<?= $q['id'] ?>" value="4"> <?= htmlspecialchars($q['option4']) ?></label>
        </fieldset>
    <?php endforeach; ?>

    <button type="submit" class="btn-submit">Submit Quiz</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>