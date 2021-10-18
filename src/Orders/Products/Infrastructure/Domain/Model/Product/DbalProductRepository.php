<?php

declare(strict_types=1);

namespace App\Orders\Products\Infrastructure\Domain\Model\Product;

use App\Orders\Products\Domain\Model\Product\Product;
use App\Orders\Products\Domain\Model\Product\ProductRepository;
use App\Orders\Products\Domain\Model\Product\ValueObject\Seller;
use App\System\Infrastructure\DbalRepository;
use Doctrine\DBAL\FetchMode;

final class DbalProductRepository extends DbalRepository implements ProductRepository
{
    private const PRODUCT_TABLE = 'product';

    public function add(Product $product): void
    {
        $this->connection()->insert(
            self::PRODUCT_TABLE,
            [
                'id' => $product->id(),
                'name' => $product->name(),
                'price' => $product->price(),
                'seller_id' => $product->seller()->id(),
            ],
        );
    }

    public function delete(string $id): void
    {
        $this->connection()->delete(
            self::PRODUCT_TABLE,
            [
                'id' => $id,
            ],
        );
    }

    public function find(string $id): ?Product
    {
        $stmt = $this->connection()->prepare("
            SELECT
                p.id AS id,
                p.name AS name,
                p.price AS price,
                p.seller_id AS seller_id
            FROM drinksco.product AS p
            WHERE p.id = :id
        ");

        $stmt->bindValue('id', $id);
        $stmt->execute();

        if (0 === $stmt->rowCount()) {
            return null;
        }

        $product = $stmt->fetch(FetchMode::ASSOCIATIVE);

        return $this->mapProduct($product);
    }

    private function mapProduct($seller): Product
    {
        return Product::from(
            $seller['id'],
            $seller['name'],
            (int) $seller['price'],
            Seller::from($seller['seller_id']),
        );
    }
}
