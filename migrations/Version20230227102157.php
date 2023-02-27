<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227102157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim ADD serve_store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE27C51A3724 FOREIGN KEY (serve_store_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_A769DE27C51A3724 ON claim (serve_store_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE27C51A3724');
        $this->addSql('DROP INDEX IDX_A769DE27C51A3724 ON claim');
        $this->addSql('ALTER TABLE claim DROP serve_store_id');
    }
}
