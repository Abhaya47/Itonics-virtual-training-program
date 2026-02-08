<?php

namespace App\Controllers;

use App\Repositories\LaptopRepository;
use App\Models\Laptop;

/**
 * LaptopController Class
 * Handles all laptop-related API requests
 */
class LaptopController
{
    private LaptopRepository $repository;

    public function __construct()
    {
        $this->repository = new LaptopRepository();
    }

    /**
     * GET /api/laptops - Get all laptops with optional search and sort
     */
    public function index(): void
    {
        header('Content-Type: application/json');
        
        $search = $_GET['search'] ?? '';
        $sortBy = $_GET['sort_by'] ?? 'id';
        $sortDir = $_GET['sort_dir'] ?? 'asc';

        if (!empty($search)) {
            $laptops = $this->repository->search($search);
        } else {
            $laptops = $this->repository->sort($sortBy, $sortDir);
        }

        echo json_encode([
            'success' => true,
            'data' => $laptops,
            'count' => count($laptops)
        ]);
    }

    /**
     * GET /api/laptops/{id} - Get a single laptop
     */
    public function show(int $id): void
    {
        header('Content-Type: application/json');
        
        $laptop = $this->repository->find($id);
        
        if ($laptop) {
            echo json_encode([
                'success' => true,
                'data' => $laptop->toArray()
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Laptop not found'
            ]);
        }
    }

    /**
     * POST /api/laptops - Create a new laptop
     */
    public function store(): void
    {
        header('Content-Type: application/json');
        
        $data = $this->getRequestData();
        
        $laptop = new Laptop($data);
        $errors = $laptop->validate();
        
        if (!empty($errors)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }

        $newLaptop = $this->repository->create($data);
        
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Laptop created successfully',
            'data' => $newLaptop->toArray()
        ]);
    }

    /**
     * PUT /api/laptops/{id} - Update a laptop
     */
    public function update(int $id): void
    {
        header('Content-Type: application/json');
        
        $data = $this->getRequestData();
        
        $laptop = new Laptop($data);
        $errors = $laptop->validate();
        
        if (!empty($errors)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }

        $updatedLaptop = $this->repository->update($id, $data);
        
        if ($updatedLaptop) {
            echo json_encode([
                'success' => true,
                'message' => 'Laptop updated successfully',
                'data' => $updatedLaptop->toArray()
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Laptop not found'
            ]);
        }
    }

    /**
     * DELETE /api/laptops/{id} - Delete a laptop
     */
    public function destroy(int $id): void
    {
        header('Content-Type: application/json');
        
        $deleted = $this->repository->delete($id);
        
        if ($deleted) {
            echo json_encode([
                'success' => true,
                'message' => 'Laptop deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Laptop not found'
            ]);
        }
    }

    /**
     * Get request data from JSON body or POST data
     */
    private function getRequestData(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            return json_decode($json, true) ?? [];
        }
        
        return $_POST;
    }
}
