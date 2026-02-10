<?php

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation for email and password
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // User found, verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role']    = $row['role'];

                // Redirect based on role
                $redirect = ($row['role'] === 'teacher')
                    ? 'teacher/dashboard.php'
                    : 'student/dashboard.php';

                header("Location: " . BASE_URL . $redirect);
                exit();
            }
        }

        // If we reach here, it means login failed
        $errors[] = "Invalid username or password.";

        $stmt->close();
    }
}
?>

<div class="auth-container">
    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <p class="error"><?= htmlspecialchars($err) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="post" class="login-form">
        <div class="form-group">
            <input 
                type="text" 
                name="username" 
                placeholder="Username" 
                value="<?= htmlspecialchars($username ?? '') ?>" 
                required 
                autofocus
            >
        </div>

        <div class="form-group">
            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p class="auth-link">
        Don't have an account? 
        <a href="<?= BASE_URL ?>auth/register.php">Register here</a>
    </p>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>