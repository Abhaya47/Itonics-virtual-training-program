<?php

include '../config/database.php';
include '../includes/functions.php';

deleteEnrollment($conn, $_GET['id']);
header("Location: index.php");
?>