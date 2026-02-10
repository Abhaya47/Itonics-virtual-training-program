<?php
require_once __DIR__ . '/config.php';

$host = 'localhost';
$db   = 'quiz_app';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");