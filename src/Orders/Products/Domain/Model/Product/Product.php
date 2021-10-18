<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Model\Product;

use App\Orders\Products\Domain\Model\Product\ValueObject\Seller;
use Ramsey\Uuid\Uuid;

final class Product
{
    private string $id;
    private string $name;
    private int $price;
    private Seller $seller;

    private function __construct(string $id, string $name, int $price, Seller $seller)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->seller = $seller;
    }

    public static function create(string $name, int $price, Seller $seller): self
    {
        return new self(Uuid::uuid4()->toString(), $name, $price, $seller);
    }

    public static function from(string $id, string $name, int $price, Seller $seller): self
    {
        return new self($id, $name, $price, $seller);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function seller(): Seller
    {
        return $this->seller;
    }
}
