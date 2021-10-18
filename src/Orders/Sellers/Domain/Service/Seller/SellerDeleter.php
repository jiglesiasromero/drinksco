<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Domain\Service\Seller;

use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;

final class SellerDeleter
{
    private SellerRepository $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function execute(string $id): void
    {
        $this->sellerRepository->delete($id);
    }
}
