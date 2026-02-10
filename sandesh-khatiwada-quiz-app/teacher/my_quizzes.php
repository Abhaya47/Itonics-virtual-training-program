<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, title, description, created_at FROM quizzes WHERE teacher_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>My Quizzes</h2>

<?php if ($result->num_rows === 0): ?>
    <p>You haven't created any quizzes yet.</p>
<?php else: ?>
    <div class="quiz-list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="quiz-item">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['description'] ?: 'No description') ?></p>
            <small>Created: <?= $row['created_at'] ?></small>
            <div class="actions">
                <a href="<?= BASE_URL ?>teacher/view_scores.php?quiz_id=<?= $row['id'] ?>">View Scores</a>
                <a href="<?= BASE_URL ?>actions/delete_quiz.php?quiz_id=<?= $row['id'] ?>" 
                   onclick="return confirm('Delete this quiz and all its questions & attempts?');"
                   class="delete">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
$stmt->close();
require_once __DIR__ . '/../includes/footer.php';
?>