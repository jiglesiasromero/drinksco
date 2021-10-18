<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Model\Product;

interface ProductRepository
{
    public function add(Product $product): void;

    public function find(string $id): ?Product;

    public function delete(string $id): void;
}
