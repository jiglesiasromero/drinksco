<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730133440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Cart Items table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE cart_items (
                id         VARCHAR(36)  NOT NULL,
                product_id VARCHAR(255) NOT NULL,
                quantity   INT          NOT NULL,
                price      INT          NOT NULL,
                cart_id    VARCHAR(36)  NOT NULL,
                status     VARCHAR(12)  NOT NULL
            );
        ');

        $this->addSql('
            INSERT INTO cart_items (id, product_id, quantity, price, cart_id, status)
            VALUES
                (
                    "ad10c963-c1fe-48a8-b452-f0cc82cbb97b",
                    "31d8f674-c17d-4edc-b5d4-fd3845c08d81",
                    1,
                    23,
                    "1d0a59df-6f1b-4c72-b952-4412a76d17ba",
                    "PENDING"
                ),
                (
                    "7ef1b135-cb80-4751-8a19-40aee13257c4",
                    "31d8f674-c17d-4edc-b5d4-fd3845c08d81",
                    1,
                    24,
                    "513be874-ea4b-45d4-9655-3cce845352ba",
                    "PENDING"
                ),
                (
                    "5b4104ab-ae82-4c33-a540-a419f6f26ded",
                    "8f192aa2-55e9-4fe7-8659-c8031e61eeee",
                    1,
                    25,
                    "1d0a59df-6f1b-4c72-b952-4412a76d17ba",
                    "PENDING"
                ),
                (
                    "33e92129-acf7-447e-9cc9-4537a83b8acf",
                    "31d8f674-c17d-4edc-b5d4-fd3845c08d81",
                    3,
                    26,
                    "670f45e8-da4d-4b4c-9875-eb3a666cdf9d",
                    "PENDING"
                );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE cart');
    }
}
