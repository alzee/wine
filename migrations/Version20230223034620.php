<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223034620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box DROP FOREIGN KEY FK_8A9483A8A484C35');
        $this->addSql('DROP INDEX IDX_8A9483A8A484C35 ON box');
        $this->addSql('ALTER TABLE box DROP order_items_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box ADD order_items_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE box ADD CONSTRAINT FK_8A9483A8A484C35 FOREIGN KEY (order_items_id) REFERENCES order_items (id)');
        $this->addSql('CREATE INDEX IDX_8A9483A8A484C35 ON box (order_items_id)');
    }
}
