<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Application\Command\Seller\Delete;

final class DeleteSellerCommand
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
