<?php
require_once "../config/db.php";
require_once "../session.php";
require_once "../helpers/mailer.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {

        if ($user['email_verified_at'] === null) {

            if (empty($user['email_verification_token'])) {

                $token = bin2hex(random_bytes(32));

                mysqli_query($conn, "
                    UPDATE users
                    SET email_verification_token='$token'
                    WHERE id={$user['id']}
                ");
            } else {
                $token = $user['email_verification_token'];
            }

            $link = "http://localhost:8000/auth/verify_email.php?token=$token";

            $message = "
                <h3>Email Verification Required</h3>
                <p>Please verify your email before logging in.</p>
                <a href='$link'>Verify Email</a>
            ";

            sendMail($user['email'], "Verify your email", $message);

            echo "Your email is not verified. We have sent you a verification link.";
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        header("Location: ../todos/index.php");
        exit;

    } else {
        echo "Invalid email or password.";
    }
}
?>

<form method="POST">
    Email: <input name="email"><br>
    Password: <input type="password" name="password"><br>
    <button>Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>
<p><a href="forgot_password.php">Forgot Password?</a></p>