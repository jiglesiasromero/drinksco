<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Model\Item;

interface ItemRepository
{
    public function add(Item $item): void;

    public function findByCart(string $cartId): array;

    public function delete(string $id): void;

    public function find(string $id): ?Item;

    public function update(Item $item): void;
}
