<?php

namespace App\Models;

/**
 * Laptop Model Class
 * Represents a laptop entity with its properties
 */
class Laptop
{
    public int $id;
    public string $brand;
    public string $model;
    public int $year;
    public string $processor;
    public string $ram;
    public string $storage;
    public float $price_npr;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->brand = $data['brand'] ?? '';
        $this->model = $data['model'] ?? '';
        $this->year = $data['year'] ?? date('Y');
        $this->processor = $data['processor'] ?? '';
        $this->ram = $data['ram'] ?? '';
        $this->storage = $data['storage'] ?? '';
        $this->price_npr = $data['price_npr'] ?? 0;
    }

    /**
     * Convert object to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'processor' => $this->processor,
            'ram' => $this->ram,
            'storage' => $this->storage,
            'price_npr' => $this->price_npr
        ];
    }

    /**
     * Format price in NPR
     */
    public function getFormattedPrice(): string
    {
        return 'NPR ' . number_format($this->price_npr, 2);
    }

    /**
     * Validate laptop data
     */
    public function validate(): array
    {
        $errors = [];
        
        if (empty($this->brand)) {
            $errors[] = 'Brand is required';
        }
        if (empty($this->model)) {
            $errors[] = 'Model is required';
        }
        if ($this->year < 2000 || $this->year > date('Y') + 1) {
            $errors[] = 'Year must be between 2000 and ' . (date('Y') + 1);
        }
        if ($this->price_npr <= 0) {
            $errors[] = 'Price must be greater than 0';
        }

        return $errors;
    }
}
