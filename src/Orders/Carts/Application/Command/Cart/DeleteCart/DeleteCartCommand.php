<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Cart\DeleteCart;

final class DeleteCartCommand
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
