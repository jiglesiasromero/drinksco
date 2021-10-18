<?php

declare(strict_types=1);

namespace App\Orders\Products\Domain\Model\Product\Exception;

final class ProductNotFoundException extends \Exception
{
    private string $id;

    private function __construct(string $id, string $message)
    {
        parent::__construct($message);

        $this->id = $id;
    }

    public static function fromId(string $id): self
    {
        return new self($id, 'Product not found by id ' . $id);
    }

    public function id(): string
    {
        return $this->id;
    }
}
