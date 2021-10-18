<?php

declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\AddItem;

final class AddItemCommand
{
    private string $productId;
    private string $cartId;

    public function __construct(string $productId, string $cartId)
    {
        $this->productId = $productId;
        $this->cartId = $cartId;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}
