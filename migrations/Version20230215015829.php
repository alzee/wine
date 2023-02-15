<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215015829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box ADD batch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE box ADD CONSTRAINT FK_8A9483AF39EBE7A FOREIGN KEY (batch_id) REFERENCES batch (id)');
        $this->addSql('CREATE INDEX IDX_8A9483AF39EBE7A ON box (batch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box DROP FOREIGN KEY FK_8A9483AF39EBE7A');
        $this->addSql('DROP INDEX IDX_8A9483AF39EBE7A ON box');
        $this->addSql('ALTER TABLE box DROP batch_id');
    }
}
