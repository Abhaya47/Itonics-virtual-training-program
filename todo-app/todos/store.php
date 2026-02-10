<?php
require_once "../middleware/auth.php";
require_once "../config/db.php";

$title = $_POST['title'];
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "INSERT INTO todos (user_id, title) VALUES ($user_id, '$title')");
header("Location: index.php");
