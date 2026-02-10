<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? '';

    if (empty($username))               $errors[] = "Username is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6)          $errors[] = "Password must be at least 6 characters.";
    if (!in_array($role, ['teacher','student'])) $errors[] = "Please select a valid role.";

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hash, $role);

        if ($stmt->execute()) {
            $success = "Account created! You can now <a href='".BASE_URL."auth/login.php'>log in</a>.";
        } else {
            $errors[] = "Username or email already exists.";
        }
        $stmt->close();
    }
}
?>

<h2>Register</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php else: ?>
    <?php foreach ($errors as $err): ?>
        <p class="error"><?= htmlspecialchars($err) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <input type="text"     name="username"  placeholder="Username"     required value="<?= htmlspecialchars($username??'') ?>">
        <input type="email"    name="email"     placeholder="Email"        required value="<?= htmlspecialchars($email??'') ?>">
        <input type="password" name="password"  placeholder="Password"     required>
        <select name="role" required>
            <option value="">Select role</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="<?= BASE_URL ?>auth/login.php">Log in</a></p>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>