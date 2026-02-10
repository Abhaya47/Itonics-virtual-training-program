<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $num         = (int)($_POST['num_questions'] ?? 0);

    if (empty($title))          $errors[] = "Title is required.";
    if ($num < 1)               $errors[] = "At least 1 question required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO quizzes (title, description, teacher_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $description, $_SESSION['user_id']);
        $stmt->execute();
        $quiz_id = $conn->insert_id;
        $stmt->close();

        header("Location: " . BASE_URL . "teacher/add_questions.php?quiz_id=$quiz_id&num=$num");
        exit();
    }
}
?>

<h2>Create New Quiz</h2>

<?php foreach ($errors as $e): ?>
    <p class="error"><?= htmlspecialchars($e) ?></p>
<?php endforeach; ?>

<form method="post">
    <input type="text"     name="title"        placeholder="Quiz Title" required>
    <textarea name="description" placeholder="Description (optional)"></textarea>
    <input type="number"   name="num_questions" min="1" placeholder="Number of questions" required>
    <button type="submit">Next → Add Questions</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>