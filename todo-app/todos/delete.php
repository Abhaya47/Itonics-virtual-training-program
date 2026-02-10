<?php
require_once "../middleware/auth.php";
require_once "../config/db.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "DELETE FROM todos WHERE id=$id AND user_id=$user_id");
header("Location: index.php");
