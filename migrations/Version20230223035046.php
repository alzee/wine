<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223035046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_items_box (order_items_id INT NOT NULL, box_id INT NOT NULL, INDEX IDX_3544ACC68A484C35 (order_items_id), INDEX IDX_3544ACC6D8177B3F (box_id), PRIMARY KEY(order_items_id, box_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_items_box ADD CONSTRAINT FK_3544ACC68A484C35 FOREIGN KEY (order_items_id) REFERENCES order_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_items_box ADD CONSTRAINT FK_3544ACC6D8177B3F FOREIGN KEY (box_id) REFERENCES box (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_items_box DROP FOREIGN KEY FK_3544ACC68A484C35');
        $this->addSql('ALTER TABLE order_items_box DROP FOREIGN KEY FK_3544ACC6D8177B3F');
        $this->addSql('DROP TABLE order_items_box');
    }
}
