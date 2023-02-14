<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214011909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batch_prize (id INT AUTO_INCREMENT NOT NULL, prize_id INT NOT NULL, batch_id INT NOT NULL, qty INT NOT NULL, INDEX IDX_7C5A00A6BBE43214 (prize_id), INDEX IDX_7C5A00A6F39EBE7A (batch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE batch_prize ADD CONSTRAINT FK_7C5A00A6BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id)');
        $this->addSql('ALTER TABLE batch_prize ADD CONSTRAINT FK_7C5A00A6F39EBE7A FOREIGN KEY (batch_id) REFERENCES batch (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batch_prize DROP FOREIGN KEY FK_7C5A00A6BBE43214');
        $this->addSql('ALTER TABLE batch_prize DROP FOREIGN KEY FK_7C5A00A6F39EBE7A');
        $this->addSql('DROP TABLE batch_prize');
    }
}
