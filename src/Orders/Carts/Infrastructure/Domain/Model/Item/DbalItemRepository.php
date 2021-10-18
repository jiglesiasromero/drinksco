<?php

declare(strict_types=1);

namespace App\Orders\Carts\Infrastructure\Domain\Model\Item;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Product;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Status;
use App\System\Infrastructure\DbalRepository;
use Doctrine\DBAL\FetchMode;

final class DbalItemRepository extends DbalRepository implements ItemRepository
{
    private const CART_TABLE = 'cart_items';

    public function add(Item $item): void
    {
        $this->connection()->insert(
            self::CART_TABLE,
            [
                'id' => $item->id(),
                'product_id' => $item->product()->id(),
                'quantity' => $item->quantity(),
                'price' => $item->product()->price(),
                'cart_id' => $item->cartId(),
                'status' => $item->status()->value(),
            ],
        );
    }

    public function findByCart(string $cartId): array
    {
        $stmt = $this->connection()->prepare("
            SELECT
                c.id AS id,
                c.product_id AS product_id,
                c.quantity AS quantity,
                c.price AS price,
                c.cart_id AS cart_id,
                c.status AS status
            FROM drinksco.cart_items AS c
            WHERE c.cart_id = :cartId
        ");

        $stmt->bindValue('cartId', $cartId);
        $stmt->execute();

        if (0 === $stmt->rowCount()) {
            return [];
        }

        $items = $stmt->fetchAll(FetchMode::ASSOCIATIVE);

        return $this->mapItems($items);
    }

    public function delete(string $id): void
    {
        $this->connection()->delete(
            self::CART_TABLE,
            [
                'id' => $id,
            ],
        );
    }

    public function find(string $id): ?Item
    {
        $stmt = $this->connection()->prepare("
            SELECT
                c.id AS id,
                c.product_id AS product_id,
                c.quantity AS quantity,
                c.price AS price,
                c.cart_id AS cart_id,
                c.status AS status
            FROM drinksco.cart_items AS c
            WHERE c.id = :id
        ");

        $stmt->bindValue('id', $id);
        $stmt->execute();

        if (0 === $stmt->rowCount()) {
            return null;
        }

        $item = $stmt->fetch(FetchMode::ASSOCIATIVE);

        return $this->mapItem($item);
    }

    public function update(Item $item): void
    {
        $this->connection()->update(
            self::CART_TABLE,
            [
                'product_id' => $item->product()->id(),
                'quantity' => $item->quantity(),
                'price' => $item->product()->price(),
                'cart_id' => $item->cartId(),
                'status' => $item->status()->value(),
            ],
            [
                'id' => $item->id(),
            ],
        );
    }

    private function mapItems(array $items): array
    {
        $itemList = [];

        foreach ($items as $item) {
            $itemList[] = $this->mapItem($item);
        }

        return $itemList;
    }

    private function mapItem(array $item): Item
    {
        return Item::from(
            $item['id'],
            Product::from($item['product_id'], (int) $item['price']),
            (int) $item['quantity'],
            $item['cart_id'],
            Status::from($item['status']),
        );
    }
}
