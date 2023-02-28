<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209035904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA809393F8FE');
        $this->addSql('DROP INDEX IDX_7215BA809393F8FE ON org');
        $this->addSql('ALTER TABLE org DROP partner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD partner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA809393F8FE FOREIGN KEY (partner_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_7215BA809393F8FE ON org (partner_id)');
    }
}
