<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217125748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box ADD org_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE box ADD CONSTRAINT FK_8A9483AF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_8A9483AF4837C1B ON box (org_id)');
        $this->addSql('update box set org_id = (select id from org where type = 0 limit 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box DROP FOREIGN KEY FK_8A9483AF4837C1B');
        $this->addSql('DROP INDEX IDX_8A9483AF4837C1B ON box');
        $this->addSql('ALTER TABLE box DROP org_id');
    }
}
