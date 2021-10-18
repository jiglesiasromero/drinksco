<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Service\Product;

use App\Orders\Products\Domain\Model\Product\Exception\ProductNotFoundException;
use App\Orders\Products\Domain\Model\Product\Product;
use App\Orders\Products\Domain\Model\Product\ProductRepository;

final class ProductFinder
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $id): Product
    {
        $product = $this->productRepository->find($id);

        if (null === $product) {
            throw ProductNotFoundException::fromId($id);
        }

        return $product;
    }
}
