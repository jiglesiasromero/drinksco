<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Model\Product\ValueObject;

final class Seller
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function from(string $id): self
    {
        return new self($id);
    }

    public function id(): string
    {
        return $this->id;
    }
}
