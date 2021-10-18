<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Service\Product;

use App\Orders\Products\Domain\Model\Product\Product;
use App\Orders\Products\Domain\Model\Product\ProductRepository;
use App\Orders\Products\Domain\Model\Product\ValueObject\Seller;

final class ProductCreator
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $name, int $price, string $sellerId): void
    {
        $product = Product::create($name, $price, Seller::from($sellerId));

        $this->productRepository->add($product);
    }
}
