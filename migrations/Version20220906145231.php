<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906145231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw ADD org_id INT NOT NULL, ADD discount SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE withdraw ADD CONSTRAINT FK_B5DE5F9EF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_B5DE5F9EF4837C1B ON withdraw (org_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw DROP FOREIGN KEY FK_B5DE5F9EF4837C1B');
        $this->addSql('DROP INDEX IDX_B5DE5F9EF4837C1B ON withdraw');
        $this->addSql('ALTER TABLE withdraw DROP org_id, DROP discount');
    }
}
