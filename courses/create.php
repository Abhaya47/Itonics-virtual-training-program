<?php 

include "../config/database.php";
include "../includes/functions.php";

if (isset($_POST['submit'])){
    addCourse($conn, $_POST['name'], $_POST['code']);
    header("Location: index.php");
}
?>

<h2>Create New Course</h2>
<form method="POST">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" required><br><br>
<label for="code">Code:</label><br> 
<input type="text" id="code" name="code" required><br><br>
<input type="submit" name="submit" value="Create Course">
</form>