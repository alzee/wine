<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213015052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bottle (id INT AUTO_INCREMENT NOT NULL, box_id INT NOT NULL, sn VARCHAR(255) NOT NULL, INDEX IDX_ACA9A955D8177B3F (box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A955D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A955D8177B3F');
        $this->addSql('DROP TABLE bottle');
    }
}
