<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321005940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD salesman_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA809F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7215BA809F7F22E2 ON org (salesman_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA809F7F22E2');
        $this->addSql('DROP INDEX IDX_7215BA809F7F22E2 ON org');
        $this->addSql('ALTER TABLE org DROP salesman_id');
    }
}
