<?php

include '../config/database.php';
include '../includes/functions.php';

deleteStudent($conn, $_GET['id']);
header("Location: index.php");
?>