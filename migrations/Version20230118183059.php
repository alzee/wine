<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118183059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw ADD consumer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE withdraw ADD CONSTRAINT FK_B5DE5F9E37FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_B5DE5F9E37FDBD6D ON withdraw (consumer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw DROP FOREIGN KEY FK_B5DE5F9E37FDBD6D');
        $this->addSql('DROP INDEX IDX_B5DE5F9E37FDBD6D ON withdraw');
        $this->addSql('ALTER TABLE withdraw DROP consumer_id');
    }
}
