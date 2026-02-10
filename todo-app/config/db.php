<?php
$conn = mysqli_connect("localhost", "root", "", "todo_app");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}