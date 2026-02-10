<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher' || empty($_GET['quiz_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$quiz_id = (int)$_GET['quiz_id'];

// Security: must own the quiz
$stmt = $conn->prepare("SELECT 1 FROM quizzes WHERE id = ? AND teacher_id = ?");
$stmt->bind_param("ii", $quiz_id, $_SESSION['user_id']);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header("Location: " . BASE_URL . "teacher/my_quizzes.php");
    exit();
}
$stmt->close();

$stmt = $conn->prepare("
    SELECT u.username, a.score, a.attempted_at 
    FROM attempts a 
    JOIN users u ON a.student_id = u.id 
    WHERE a.quiz_id = ? 
    ORDER BY a.attempted_at DESC
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Scores – Quiz #<?= $quiz_id ?></h2>

<?php if ($result->num_rows === 0): ?>
    <p>No students have attempted this quiz yet.</p>
<?php else: ?>
    <table class="score-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Score</th>
                <th>Attempted</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['score'] ?></td>
                <td><?= $row['attempted_at'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
$stmt->close();
require_once __DIR__ . '/../includes/footer.php';
?>