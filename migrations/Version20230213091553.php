<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213091553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE box_prize (id INT AUTO_INCREMENT NOT NULL, box_id INT NOT NULL, prize_id INT NOT NULL, qty SMALLINT NOT NULL, INDEX IDX_28E25729D8177B3F (box_id), INDEX IDX_28E25729BBE43214 (prize_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE box_prize ADD CONSTRAINT FK_28E25729D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE box_prize ADD CONSTRAINT FK_28E25729BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box_prize DROP FOREIGN KEY FK_28E25729D8177B3F');
        $this->addSql('ALTER TABLE box_prize DROP FOREIGN KEY FK_28E25729BBE43214');
        $this->addSql('DROP TABLE box_prize');
    }
}
