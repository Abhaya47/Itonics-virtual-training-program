<?php

/**
 * Main Entry Point
 * Serves the frontend view or handles API routing
 */

// Check if this is an API request
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/api') !== false) {
    // Redirect to API handler
    require __DIR__ . '/api.php';
    exit;
}

// Serve the main view
$viewFile = __DIR__ . '/index.html';

if (file_exists($viewFile)) {
    readfile($viewFile);
} else {
    echo "Page  not found";
}
