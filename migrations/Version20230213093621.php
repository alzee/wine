<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213093621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box_prize DROP FOREIGN KEY FK_28E25729D8177B3F');
        $this->addSql('DROP INDEX IDX_28E25729D8177B3F ON box_prize');
        $this->addSql('ALTER TABLE box_prize DROP box_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box_prize ADD box_id INT NOT NULL');
        $this->addSql('ALTER TABLE box_prize ADD CONSTRAINT FK_28E25729D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('CREATE INDEX IDX_28E25729D8177B3F ON box_prize (box_id)');
    }
}
