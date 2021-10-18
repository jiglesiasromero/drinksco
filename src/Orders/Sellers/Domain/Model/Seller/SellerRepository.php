<?php
declare(strict_types=1);

namespace App\Orders\Sellers\Domain\Model\Seller;

interface SellerRepository
{
    public function add(Seller $seller): void;

    public function find(string $id): ?Seller;

    public function delete(string $id): void;
}
