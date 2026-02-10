<?php

define('BASE_URL', '/PHP101/task/Itonics/sandesh-khatiwada-quiz-app/');


define('BASE_PATH', dirname(__DIR__) . '/');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kathmandu');