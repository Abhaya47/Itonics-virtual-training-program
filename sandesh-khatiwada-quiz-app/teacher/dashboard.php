<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}
?>

<h2>Teacher Dashboard</h2>
<p>Welcome, Teacher! Use the menu to create or manage your quizzes.</p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>