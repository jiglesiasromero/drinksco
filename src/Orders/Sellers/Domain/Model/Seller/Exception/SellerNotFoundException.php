<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Domain\Model\Seller\Exception;

final class SellerNotFoundException extends \Exception
{
    private string $id;

    private function __construct(string $id, string $message)
    {
        parent::__construct($message);

        $this->id = $id;
    }

    public static function fromId(string $id): self
    {
        return new self($id, 'Seller not found by id ' . $id);
    }

    public function id(): string
    {
        return $this->id;
    }
}
