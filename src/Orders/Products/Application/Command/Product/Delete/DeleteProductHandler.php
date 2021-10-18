<?php

declare(strict_types=1);

namespace App\Orders\Products\Application\Command\Product\Delete;

use App\Orders\Products\Domain\Service\Product\ProductDeleter;
use App\Orders\Products\Domain\Service\Product\ProductFinder;

final class DeleteProductHandler
{
    private ProductFinder $productFinder;
    private ProductDeleter $productDeleter;

    public function __construct(ProductFinder $productFinder, ProductDeleter $productDeleter)
    {
        $this->productFinder = $productFinder;
        $this->productDeleter = $productDeleter;
    }

    public function handle(DeleteProductCommand $command): void
    {
        $product = $this->productFinder->execute($command->id());

        $this->productDeleter->execute($product->id());
    }
}
