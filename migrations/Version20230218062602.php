<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218062602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bottle ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A9559395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ACA9A9559395C3F3 ON bottle (customer_id)');
        $this->addSql('ALTER TABLE claim ADD bottle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE27DCF9352B FOREIGN KEY (bottle_id) REFERENCES bottle (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A769DE27DCF9352B ON claim (bottle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A9559395C3F3');
        $this->addSql('DROP INDEX IDX_ACA9A9559395C3F3 ON bottle');
        $this->addSql('ALTER TABLE bottle DROP customer_id');
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE27DCF9352B');
        $this->addSql('DROP INDEX UNIQ_A769DE27DCF9352B ON claim');
        $this->addSql('ALTER TABLE claim DROP bottle_id');
    }
}
