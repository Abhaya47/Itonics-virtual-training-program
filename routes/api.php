<?php

/**
 * Routes Configuration
 * Define all application routes here (Laravel-like)
 */

use App\Core\Router;
use App\Controllers\LaptopController;

$router = new Router();

// API Routes for Laptops
$router->get('/api/laptops', [LaptopController::class, 'index']);
$router->get('/api/laptops/{id}', [LaptopController::class, 'show']);
$router->post('/api/laptops', [LaptopController::class, 'store']);
$router->put('/api/laptops/{id}', [LaptopController::class, 'update']);
$router->delete('/api/laptops/{id}', [LaptopController::class, 'destroy']);

return $router;
