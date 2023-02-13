<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213021630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retail ADD bottle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE retail ADD CONSTRAINT FK_FB899E15DCF9352B FOREIGN KEY (bottle_id) REFERENCES bottle (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB899E15DCF9352B ON retail (bottle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retail DROP FOREIGN KEY FK_FB899E15DCF9352B');
        $this->addSql('DROP INDEX UNIQ_FB899E15DCF9352B ON retail');
        $this->addSql('ALTER TABLE retail DROP bottle_id');
    }
}
