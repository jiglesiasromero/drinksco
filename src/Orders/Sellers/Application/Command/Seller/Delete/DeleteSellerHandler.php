<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Application\Command\Seller\Delete;

use App\Orders\Sellers\Domain\Service\Seller\SellerDeleter;
use App\Orders\Sellers\Domain\Service\Seller\SellerFinder;

final class DeleteSellerHandler
{
    private SellerFinder $sellerFinder;
    private SellerDeleter $sellerDeleter;

    public function __construct(SellerFinder $sellerFinder, SellerDeleter $sellerDeleter)
    {
        $this->sellerFinder = $sellerFinder;
        $this->sellerDeleter = $sellerDeleter;
    }

    public function handle(DeleteSellerCommand $command): void
    {
        $seller = $this->sellerFinder->execute($command->id());

        $this->sellerDeleter->execute($seller->id());
    }
}
