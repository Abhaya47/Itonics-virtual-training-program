<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$uid = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT q.id, q.title, q.description, q.created_at,
           a.score IS NOT NULL AS attempted, a.score
    FROM quizzes q
    LEFT JOIN attempts a ON q.id = a.quiz_id AND a.student_id = ?
    ORDER BY q.created_at DESC
");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Available Quizzes</h2>

<?php if ($result->num_rows === 0): ?>
    <p>No quizzes available yet.</p>
<?php else: ?>
    <div class="quiz-list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="quiz-item">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['description'] ?: 'No description') ?></p>
            <small>Created: <?= $row['created_at'] ?></small>
            <?php if ($row['attempted']): ?>
                <p class="score-info">Your score: <strong><?= $row['score'] ?></strong></p>
            <?php else: ?>
                <a href="<?= BASE_URL ?>student/take_quiz.php?quiz_id=<?= $row['id'] ?>" class="btn">Take Quiz</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
$stmt->close();
require_once __DIR__ . '/../includes/footer.php';
?>