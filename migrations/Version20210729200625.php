<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210729200625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Product table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE product (
                id        VARCHAR(36)  NOT NULL,
                name      VARCHAR(255) NOT NULL,
                price     INT          NOT NULL,
                seller_id VARCHAR(36)  NOT NULL
            );
        ');

        $this->addSql('
            INSERT INTO product (id, name, price, seller_id)
            VALUES 
                (
                    "33905367-8f02-45f8-b9a0-5c70b4dfac49", 
                    "Piz Buin Allergy SPF50+", 
                    23, 
                    "12b84d21-eff2-495d-a212-2970630f8373"
                ),
                (
                    "8f192aa2-55e9-4fe7-8659-c8031e61eeee",
                    "Photoderm Max Aqua Fluide Dorado SPF50+", 
                    46, 
                    "92aedde5-e82b-40cb-b94a-2ff8b29b926d"
                ),
                   (
                    "42cce177-d076-4032-8532-a5c79058ae7e", 
                    "Pierre Fabre Dexeryl", 
                    15, 
                    "12b84d21-eff2-495d-a212-2970630f8373"
                ),
                (
                    "31d8f674-c17d-4edc-b5d4-fd3845c08d81",
                    "Babé jabón de aceite", 
                    46, 
                    "92aedde5-e82b-40cb-b94a-2ff8b29b926d"
                );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE product');
    }
}
