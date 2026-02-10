<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Quiz App</div>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'teacher'): ?>
                        <li><a href="<?= BASE_URL ?>teacher/dashboard.php">Dashboard</a></li>
                        <li><a href="<?= BASE_URL ?>teacher/create_quiz.php">Create Quiz</a></li>
                        <li><a href="<?= BASE_URL ?>teacher/my_quizzes.php">My Quizzes</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>student/dashboard.php">Dashboard</a></li>
                        <li><a href="<?= BASE_URL ?>student/available_quizzes.php">Available Quizzes</a></li>
                    <?php endif; ?>
                    <li><a href="<?= BASE_URL ?>auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>auth/login.php">Login</a></li>
                    <li><a href="<?= BASE_URL ?>auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">