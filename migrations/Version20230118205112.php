<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118205112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE share (id INT AUTO_INCREMENT NOT NULL, org_id INT DEFAULT NULL, retail_id INT DEFAULT NULL, type SMALLINT NOT NULL, amount SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EF069D5AF4837C1B (org_id), INDEX IDX_EF069D5A70A3840 (retail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5AF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5A70A3840 FOREIGN KEY (retail_id) REFERENCES retail (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5AF4837C1B');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5A70A3840');
        $this->addSql('DROP TABLE share');
    }
}
