<?php

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\LaptopController;
/**
 * API Entry Point
 * Handles all API requests and routes them to appropriate controllers
 */

// Enable CORS for development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}


// Simple API handler
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$controller = new LaptopController();

try {
    switch ($action) {
        case 'index':
            $controller->index();
            break;
            
        case 'show':
            if ($id) {
                $controller->show($id);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
            }
            break;
            
        case 'store':
            $controller->store();
            break;
            
        case 'update':
            if ($id) {
                $controller->update($id);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
            }
            break;
            
        case 'destroy':
            if ($id) {
                $controller->destroy($id);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
            }
            break;
            
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Action not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
