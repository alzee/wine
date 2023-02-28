<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224032308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA80642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7215BA80642B8210 ON org (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA80642B8210');
        $this->addSql('DROP INDEX IDX_7215BA80642B8210 ON org');
        $this->addSql('ALTER TABLE org DROP admin_id');
    }
}
