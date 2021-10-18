<?php
declare(strict_types=1);

namespace App\Orders\Sellers\Application\Command\Seller\Register;

final class RegisterSellerCommand
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
