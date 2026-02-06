<?php 

include '../config/database.php';
include '../includes/functions.php';

if (isset($_POST['submit'])){
    addStudent($conn, $_POST['name'], $_POST['email']);
    header("Location: index.php");
}
?>

<h2>Create New Student</h2>
<form method="POST">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" required><br><br>
<label for="email">Email:</label><br>
<input type="email" id="email" name="email" required><br><br>
<input type="submit" name="submit" value="Create Student">
</form>
