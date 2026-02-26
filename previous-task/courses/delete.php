<?php

include '../config/database.php';
include '../includes/functions.php';

deleteCourse($conn, $_GET['id']);
header("Location: index.php");
?>