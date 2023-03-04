<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304102309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE return_items_box (return_items_id INT NOT NULL, box_id INT NOT NULL, INDEX IDX_7CDA698E7DCA49D3 (return_items_id), INDEX IDX_7CDA698ED8177B3F (box_id), PRIMARY KEY(return_items_id, box_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE return_items_box ADD CONSTRAINT FK_7CDA698E7DCA49D3 FOREIGN KEY (return_items_id) REFERENCES return_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE return_items_box ADD CONSTRAINT FK_7CDA698ED8177B3F FOREIGN KEY (box_id) REFERENCES box (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE return_items_box DROP FOREIGN KEY FK_7CDA698E7DCA49D3');
        $this->addSql('ALTER TABLE return_items_box DROP FOREIGN KEY FK_7CDA698ED8177B3F');
        $this->addSql('DROP TABLE return_items_box');
    }
}
