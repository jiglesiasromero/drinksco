<?php

declare(strict_types=1);

namespace App\Orders\Products\Application\Command\Product\Register;

final class RegisterProductCommand
{
    private string $name;
    private int $price;
    private string $sellerId;

    public function __construct(string $name, int $price, string $sellerId)
    {
        $this->name = $name;
        $this->price = $price;
        $this->sellerId = $sellerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function sellerId(): string
    {
        return $this->sellerId;
    }
}
