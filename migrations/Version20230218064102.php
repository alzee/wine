<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218064102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim ADD prize_id INT NOT NULL');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE27BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id)');
        $this->addSql('CREATE INDEX IDX_A769DE27BBE43214 ON claim (prize_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE27BBE43214');
        $this->addSql('DROP INDEX IDX_A769DE27BBE43214 ON claim');
        $this->addSql('ALTER TABLE claim DROP prize_id');
    }
}
