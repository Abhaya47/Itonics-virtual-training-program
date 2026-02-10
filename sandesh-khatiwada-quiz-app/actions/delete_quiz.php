<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher' || empty($_GET['quiz_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

$quiz_id = (int)$_GET['quiz_id'];


$stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ? AND teacher_id = ?");
$stmt->bind_param("ii", $quiz_id, $_SESSION['user_id']);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

header("Location: " . BASE_URL . "teacher/my_quizzes.php" . ($affected ? "?msg=deleted" : ""));
exit();