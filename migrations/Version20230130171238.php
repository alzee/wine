<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130171238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD reg_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA80990B26CC FOREIGN KEY (reg_id) REFERENCES reg (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7215BA80990B26CC ON org (reg_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA80990B26CC');
        $this->addSql('DROP INDEX UNIQ_7215BA80990B26CC ON org');
        $this->addSql('ALTER TABLE org DROP reg_id');
    }
}
