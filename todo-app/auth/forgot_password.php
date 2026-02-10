<?php
require_once "../config/db.php";
require_once "../helpers/mailer.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", time() + 3600);

    mysqli_query($conn, "
        UPDATE users
        SET password_reset_token='$token',
            password_reset_expires_at='$expires'
        WHERE email='$email'
    ");

    $resetLink = "http://localhost:8000/auth/reset_password.php?token=$token";

    $message = "
        <h3>Reset Password</h3>
        <p>Click below to reset your password:</p>
        <a href='$resetLink'>Reset Password</a>
    ";

    sendMail($email, "Password Reset", $message);

    echo "A reset link has been sent.";
}
?>

<form method="POST">
    Email: <input name="email"><br>
    <button>Send Reset Link</button>
</form>
