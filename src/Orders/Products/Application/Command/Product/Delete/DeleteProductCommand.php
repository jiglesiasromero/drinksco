<?php

declare(strict_types=1);

namespace App\Orders\Products\Application\Command\Product\Delete;

final class DeleteProductCommand
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
