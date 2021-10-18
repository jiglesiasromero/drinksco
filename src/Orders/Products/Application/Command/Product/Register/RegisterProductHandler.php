<?php

declare(strict_types=1);

namespace App\Orders\Products\Application\Command\Product\Register;

use App\Orders\Products\Domain\Service\Product\ProductCreator;
use App\Orders\Sellers\Domain\Service\Seller\SellerFinder;

final class RegisterProductHandler
{
    private SellerFinder $sellerFinder;
    private ProductCreator $productCreator;

    public function __construct(SellerFinder $sellerFinder, ProductCreator $productCreator)
    {
        $this->sellerFinder = $sellerFinder;
        $this->productCreator = $productCreator;
    }

    public function handle(RegisterProductCommand $command): void
    {
        $seller = $this->sellerFinder->execute($command->sellerId());

        $this->productCreator->execute($command->name(), $command->price(), $seller->id());
    }
}
