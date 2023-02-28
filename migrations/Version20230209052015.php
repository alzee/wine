<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209052015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE withdraw ADD CONSTRAINT FK_B5DE5F9E9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B5DE5F9E9395C3F3 ON withdraw (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw DROP FOREIGN KEY FK_B5DE5F9E9395C3F3');
        $this->addSql('DROP INDEX IDX_B5DE5F9E9395C3F3 ON withdraw');
        $this->addSql('ALTER TABLE withdraw DROP customer_id');
    }
}
