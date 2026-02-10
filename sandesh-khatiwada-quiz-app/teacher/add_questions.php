<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher' || empty($_GET['quiz_id']) || empty($_GET['num'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$quiz_id = (int)$_GET['quiz_id'];
$num     = (int)$_GET['num'];

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $all_ok = true;

    for ($i = 1; $i <= $num; $i++) {
        $q   = trim($_POST["q$i"]   ?? '');
        $o1  = trim($_POST["o1$i"]  ?? '');
        $o2  = trim($_POST["o2$i"]  ?? '');
        $o3  = trim($_POST["o3$i"]  ?? '');
        $o4  = trim($_POST["o4$i"]  ?? '');
        $cor = (int)($_POST["correct$i"] ?? 0);

        if (empty($q) || empty($o1) || empty($o2) || empty($o3) || empty($o4) || !in_array($cor, [1,2,3,4])) {
            $errors[] = "Question $i is incomplete.";
            $all_ok = false;
            continue;
        }

        $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text, option1, option2, option3, option4, correct_option) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssi", $quiz_id, $q, $o1, $o2, $o3, $o4, $cor);
        if (!$stmt->execute()) $all_ok = false;
        $stmt->close();
    }

    if ($all_ok && empty($errors)) {
        $success = true;
    }
}
?>

<h2>Add Questions (<?= $num ?> total)</h2>

<?php if ($success): ?>
    <p class="success">All questions saved successfully!</p>
    <p><a href="<?= BASE_URL ?>teacher/my_quizzes.php">→ View your quizzes</a></p>
<?php else: ?>

    <?php foreach ($errors as $e): ?>
        <p class="error"><?= htmlspecialchars($e) ?></p>
    <?php endforeach; ?>

    <form method="post">
    <?php for ($i = 1; $i <= $num; $i++): ?>
        <fieldset>
            <legend>Question <?= $i ?></legend>
            <textarea name="q<?= $i ?>" placeholder="Question text" required rows="3"></textarea>
            <input type="text" name="o1<?= $i ?>" placeholder="Option 1" required>
            <input type="text" name="o2<?= $i ?>" placeholder="Option 2" required>
            <input type="text" name="o3<?= $i ?>" placeholder="Option 3" required>
            <input type="text" name="o4<?= $i ?>" placeholder="Option 4" required>
            <select name="correct<?= $i ?>" required>
                <option value="">Correct answer</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>
        </fieldset>
    <?php endfor; ?>
        <button type="submit">Save All Questions</button>
    </form>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>