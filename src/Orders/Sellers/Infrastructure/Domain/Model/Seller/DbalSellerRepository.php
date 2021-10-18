<?php
declare(strict_types=1);

namespace App\Orders\Sellers\Infrastructure\Domain\Model\Seller;

use App\Orders\Sellers\Domain\Model\Seller\Seller;
use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;
use App\System\Infrastructure\DbalRepository;
use Doctrine\DBAL\FetchMode;

final class DbalSellerRepository extends DbalRepository implements SellerRepository
{
    private CONST SELLER_TABLE = 'seller';

    public function add(Seller $seller): void
    {
        $this->connection()->insert(
            self::SELLER_TABLE,
            [
                'id' => $seller->id(),
                'name' => $seller->name(),
            ],
        );
    }

    public function find(string $id): ?Seller
    {
        $stmt = $this->connection()->prepare("
            SELECT
                s.id AS id,
                s.name AS name
            FROM drinksco.seller AS s
            WHERE s.id = :id
        ");

        $stmt->bindValue('id', $id);
        $stmt->execute();

        if (0 === $stmt->rowCount()) {
            return null;
        }

        $seller = $stmt->fetch(FetchMode::ASSOCIATIVE);

        return $this->mapSeller($seller);
    }

    public function delete(string $id): void
    {
        $this->connection()->delete(
            self::SELLER_TABLE,
            [
                'id' => $id,
            ],
        );
    }

    private function mapSeller($seller): Seller
    {
        return Seller::from($seller['id'], $seller['name']);
    }
}
