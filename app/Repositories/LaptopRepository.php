<?php

namespace App\Repositories;

use App\Models\Laptop;

/**
 * LaptopRepository Class
 * Handles all CRUD operations for laptops using JSON file storage
 */
class LaptopRepository
{
    private string $filePath;

    public function __construct()
    {
        // Support both public folder and root folder execution
        $possiblePaths = [
            __DIR__ . '/../../data/laptops.json',
            __DIR__ . '/../../../data/laptops.json',
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $this->filePath = $path;
                return;
            }
        }
        
        // Default path
        $this->filePath = __DIR__ . '/../../data/laptops.json';
    }

    /**
     * Get all laptops from JSON file
     */
    public function getAll(): array
    {
        $data = $this->readFile();
        return array_map(fn($item) => new Laptop($item), $data);
    }

    /**
     * Get all laptops as array (for JSON response)
     */
    public function getAllAsArray(): array
    {
        return $this->readFile();
    }

    /**
     * Find laptop by ID
     */
    public function find(int $id): ?Laptop
    {
        $data = $this->readFile();
        foreach ($data as $item) {
            if ($item['id'] === $id) {
                return new Laptop($item);
            }
        }
        return null;
    }

    /**
     * Create a new laptop
     */
    public function create(array $data): Laptop
    {
        $laptops = $this->readFile();
        
        // Generate new ID
        $maxId = 0;
        foreach ($laptops as $laptop) {
            if ($laptop['id'] > $maxId) {
                $maxId = $laptop['id'];
            }
        }
        $data['id'] = $maxId + 1;
        
        $laptop = new Laptop($data);
        $laptops[] = $laptop->toArray();
        
        $this->writeFile($laptops);
        
        return $laptop;
    }

    /**
     * Update an existing laptop
     */
    public function update(int $id, array $data): ?Laptop
    {
        $laptops = $this->readFile();
        
        foreach ($laptops as $index => $item) {
            if ($item['id'] === $id) {
                $data['id'] = $id;
                $laptop = new Laptop($data);
                $laptops[$index] = $laptop->toArray();
                $this->writeFile($laptops);
                return $laptop;
            }
        }
        
        return null;
    }

    /**
     * Delete a laptop by ID
     */
    public function delete(int $id): bool
    {
        $laptops = $this->readFile();
        
        foreach ($laptops as $index => $item) {
            if ($item['id'] === $id) {
                array_splice($laptops, $index, 1);
                $this->writeFile($laptops);
                return true;
            }
        }
        
        return false;
    }

    /**
     * Search laptops by keyword
     */
    public function search(string $keyword): array
    {
        $laptops = $this->readFile();
        $keyword = strtolower($keyword);
        
        $results = array_filter($laptops, function($laptop) use ($keyword) {
            return str_contains(strtolower($laptop['brand']), $keyword) ||
                   str_contains(strtolower($laptop['model']), $keyword) ||
                   str_contains(strtolower($laptop['processor']), $keyword) ||
                   str_contains((string)$laptop['year'], $keyword);
        });
        
        return array_values($results);
    }

    /**
     * Sort laptops by field
     */
    public function sort(string $field, string $direction = 'asc'): array
    {
        $laptops = $this->readFile();
        
        usort($laptops, function($a, $b) use ($field, $direction) {
            $valueA = $a[$field] ?? '';
            $valueB = $b[$field] ?? '';
            
            if (is_numeric($valueA) && is_numeric($valueB)) {
                $comparison = $valueA <=> $valueB;
            } else {
                $comparison = strcasecmp((string)$valueA, (string)$valueB);
            }
            
            return $direction === 'desc' ? -$comparison : $comparison;
        });
        
        return $laptops;
    }

    /**
     * Read JSON file
     */
    private function readFile(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        
        $content = file_get_contents($this->filePath);
        return json_decode($content, true) ?? [];
    }

    /**
     * Write to JSON file
     */
    private function writeFile(array $data): void
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $json);
    }
}
