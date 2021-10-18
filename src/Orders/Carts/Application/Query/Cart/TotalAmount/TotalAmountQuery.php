<?php

declare(strict_types=1);

namespace App\Orders\Carts\Application\Query\Cart\TotalAmount;

final class TotalAmountQuery
{
    private string $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}
