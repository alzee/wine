<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215133620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bottle ADD prize_id INT DEFAULT NULL, ADD bid SMALLINT NOT NULL, ADD status SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A955BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id)');
        $this->addSql('CREATE INDEX IDX_ACA9A955BBE43214 ON bottle (prize_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A955BBE43214');
        $this->addSql('DROP INDEX IDX_ACA9A955BBE43214 ON bottle');
        $this->addSql('ALTER TABLE bottle DROP prize_id, DROP bid, DROP status');
    }
}
