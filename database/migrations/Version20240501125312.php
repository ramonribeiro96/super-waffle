<?php

declare(strict_types=1);

namespace SuperWaffle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501125312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create checkouts';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQLPlatform'."
        );
        $this->addSql('CREATE TABLE checkouts (
            id INTEGER NOT NULL, 
            product_price NUMERIC(10,2) NOT NULL,
            product_tax_percent NUMERIC(4,2) NOT NULL,
            created_at TIMESTAMP DEFAULT NOW(),
            amount NUMERIC(3) NOT NULL,  
            product INTEGER REFERENCES products (id) ON DELETE CASCADE, 
            product_taxes INTEGER REFERENCES product_taxes (id) ON DELETE CASCADE, 
            product_type INTEGER REFERENCES product_type (id) ON DELETE CASCADE, 
            PRIMARY KEY(id))'
        );

        $this->addSql('CREATE INDEX IDX_checkouts_id_products ON checkouts (product)');
        $this->addSql('CREATE INDEX IDX_checkouts_id_product_type ON checkouts (product_type)');
        $this->addSql('CREATE INDEX IDX_checkouts_id_product_tax ON checkouts (product_taxes)');

        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQLPlatform'."
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQLPlatform'."
        );
        $this->addSql('DROP TABLE checkouts');
    }
}
