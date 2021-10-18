<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Model\Item\ValueObject;

final class Product
{
    private string $id;
    private int $price;

    public function __construct(string $id, int $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    public static function from(string $id, int $price): self
    {
        return new self($id, $price);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function price(): int
    {
        return $this->price;
    }
}
