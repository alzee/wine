<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112074245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reg ADD submitter_id INT NOT NULL');
        $this->addSql('ALTER TABLE reg ADD CONSTRAINT FK_63680E35919E5513 FOREIGN KEY (submitter_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_63680E35919E5513 ON reg (submitter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reg DROP FOREIGN KEY FK_63680E35919E5513');
        $this->addSql('DROP INDEX IDX_63680E35919E5513 ON reg');
        $this->addSql('ALTER TABLE reg DROP submitter_id');
    }
}
