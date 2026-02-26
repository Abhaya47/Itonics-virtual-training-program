<?php

include '../config/database.php';
include '../includes/functions.php';

$id = $_GET['id'];
$student = mysqli_fetch_assoc(getStudentById($conn, $id));

if (isset($_POST['submit'])){
    updateStudent($conn, $id, $_POST['name'], $_POST['email']);
    header("Location: index.php");
}
?>

<h2>Edit Student</h2>
<form method="POST">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required><br><br>
<label for="email">Email:</label><br>
<input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required><br><br>
<input type="submit" name="submit" value="Update Student">
</form>