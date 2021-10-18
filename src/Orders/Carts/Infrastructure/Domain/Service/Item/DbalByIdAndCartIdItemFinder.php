<?php
declare(strict_types=1);

namespace App\Orders\Carts\Infrastructure\Domain\Service\Item;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Product;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Status;
use App\Orders\Carts\Domain\Service\Item\ByIdAndCartIdItemFinder;
use App\System\Infrastructure\DbalRepository;
use Doctrine\DBAL\FetchMode;

final class DbalByIdAndCartIdItemFinder extends DbalRepository implements ByIdAndCartIdItemFinder
{
    public function execute(string $itemId, string $cartId): ?Item
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
            WHERE c.product_id = :productId
            AND c.cart_id = :cartId;
        ");

        $stmt->bindValue('productId', $itemId);
        $stmt->bindValue('cartId', $cartId);
        $stmt->execute();

        if (0 === $stmt->rowCount()) {
            return null;
        }

        $item = $stmt->fetch(FetchMode::ASSOCIATIVE);

        return $this->mapItem($item);
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
