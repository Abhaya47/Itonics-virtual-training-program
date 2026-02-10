<?php
$conn = mysqli_connect("localhost", "root", "", "itonics_student_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>