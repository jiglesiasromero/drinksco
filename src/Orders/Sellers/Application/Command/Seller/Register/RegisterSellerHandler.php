<?php
declare(strict_types=1);

namespace App\Orders\Sellers\Application\Command\Seller\Register;

use App\Orders\Sellers\Domain\Service\Seller\SellerCreator;

final class RegisterSellerHandler
{
    private SellerCreator $sellerCreator;

    public function __construct(SellerCreator $sellerCreator)
    {
        $this->sellerCreator = $sellerCreator;
    }

    public function handle(RegisterSellerCommand $command): void
    {
        $this->sellerCreator->execute($command->name());
    }
}
