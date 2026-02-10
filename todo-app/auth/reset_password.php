<?php
require_once '../config/db.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Invalid reset link");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
    $sql = "SELECT id FROM users WHERE password_reset_token='$token'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die("Invalid or expired token");
    }

    mysqli_query($conn, "
        UPDATE users
        SET password='$newPassword', password_reset_token=NULL, password_reset_expires_at=NULL
        WHERE id={$user['id']}
    ");

    header("Location: login.php");
    exit;
}
?>

<form method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    New Password: <input type="password" name="password"><br>
    <button>Reset Password</button>
</form>