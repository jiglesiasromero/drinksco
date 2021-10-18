<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210728191731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Seller table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE seller (
                id   VARCHAR(36)  NOT NULL,
                name VARCHAR(255) NOT NULL
            );
        ');

        $this->addSql('
            INSERT INTO seller (id, name)
            VALUES ("12b84d21-eff2-495d-a212-2970630f8373", "Farmacia Pere Brufau Tudela"),
            ("92aedde5-e82b-40cb-b94a-2ff8b29b926d", "Farmacia San Pedro"),
            ("c28b4d13-48d0-4751-b140-ff79ef5fc9ee", "Farmacia Alcala");
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE seller');
    }
}
