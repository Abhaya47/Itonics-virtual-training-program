<?php
require_once "../config/db.php";

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Invalid verification link");
}

$sql = "SELECT id FROM users WHERE email_verification_token='$token'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Invalid or expired token");
}

mysqli_query($conn, "
    UPDATE users
    SET email_verified_at = NOW(),
        email_verification_token = NULL
    WHERE id = {$user['id']}
");

echo "Email verified successfully. You can now login.";
?>
<p><a href="login.php">Go to Login</a></p>
