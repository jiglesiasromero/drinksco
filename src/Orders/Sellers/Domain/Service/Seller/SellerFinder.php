<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Domain\Service\Seller;

use App\Orders\Sellers\Domain\Model\Seller\Exception\SellerNotFoundException;
use App\Orders\Sellers\Domain\Model\Seller\Seller;
use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;

final class SellerFinder
{
    private SellerRepository $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function execute(string $id): Seller
    {
        $seller = $this->sellerRepository->find($id);

        if (null === $seller) {
            throw SellerNotFoundException::fromId($id);
        }

        return $seller;
    }
}
