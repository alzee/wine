<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916025255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE returns DROP FOREIGN KEY FK_8B164CA54584665A');
        $this->addSql('DROP INDEX IDX_8B164CA54584665A ON returns');
        $this->addSql('ALTER TABLE returns DROP product_id, DROP quantity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE returns ADD product_id INT NOT NULL, ADD quantity SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE returns ADD CONSTRAINT FK_8B164CA54584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_8B164CA54584665A ON returns (product_id)');
    }
}
