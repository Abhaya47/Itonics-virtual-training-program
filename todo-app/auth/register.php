<?php
require_once "../config/db.php";
require_once "../session.php";
require_once "../helpers/mailer.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $token = bin2hex(random_bytes(32));
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, email_verification_token)
        VALUES ('$name', '$email', '$password', '$token')";
    mysqli_query($conn, $sql);
    //Send Verification Email
   
    $verifyLink = "http://localhost:8000/auth/verify_email.php?token=$token";

    $message = "
        <h3>Verify your email</h3>
        <p>Click the link below to verify your email:</p>
        <a href='$verifyLink'>Verify Email</a>
    ";

    sendMail($email, "Verify your email", $message);

    header("Location: login.php");
}
?>

<form method="POST">
    Name: <input name="name"><br>
    Email: <input name="email"><br>
    Password: <input type="password" name="password"><br>
    <button>Register</button>
</form>
