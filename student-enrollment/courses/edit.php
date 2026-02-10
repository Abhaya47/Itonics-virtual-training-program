<?php

include '../config/database.php';
include '../includes/functions.php';

$id = $_GET['id'];
$course = mysqli_fetch_assoc(getCourseById($conn, $id));

if (isset($_POST['submit'])){
    updateCourse($conn, $id, $_POST['name'], $_POST['code']);
    header("Location: index.php");
}
?>
<h2>Edit Course</h2>
<form method="POST">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" value="<?php echo $course['name']; ?>" required><br><br>
<label for="code">Code:</label><br>
<input type="text" id="code" name="code" value="<?php echo $course['code']; ?>" required><br><br>
<input type="submit" name="submit" value="Update Course">
</form>