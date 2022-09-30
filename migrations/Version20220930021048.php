<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930021048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scan (id INT AUTO_INCREMENT NOT NULL, consumer_id INT NOT NULL, org_id INT NOT NULL, rand VARCHAR(255) NOT NULL, INDEX IDX_C4B3B3AE37FDBD6D (consumer_id), INDEX IDX_C4B3B3AEF4837C1B (org_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scan ADD CONSTRAINT FK_C4B3B3AE37FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE scan ADD CONSTRAINT FK_C4B3B3AEF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scan DROP FOREIGN KEY FK_C4B3B3AE37FDBD6D');
        $this->addSql('ALTER TABLE scan DROP FOREIGN KEY FK_C4B3B3AEF4837C1B');
        $this->addSql('DROP TABLE scan');
    }
}
