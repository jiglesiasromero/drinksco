<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Service\Product;

use App\Orders\Products\Domain\Model\Product\ProductRepository;

final class ProductDeleter
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $id): void
    {
        $this->productRepository->delete($id);
    }
}
