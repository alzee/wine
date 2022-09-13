<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913102501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD upstream_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA80245F9855 FOREIGN KEY (upstream_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_7215BA80245F9855 ON org (upstream_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA80245F9855');
        $this->addSql('DROP INDEX IDX_7215BA80245F9855 ON org');
        $this->addSql('ALTER TABLE org DROP upstream_id');
    }
}
