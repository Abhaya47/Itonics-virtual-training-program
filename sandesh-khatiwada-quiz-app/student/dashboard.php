<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}
?>

<h2>Student Dashboard</h2>
<p>Welcome! Check available quizzes from the menu.</p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>