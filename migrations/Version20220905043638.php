<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905043638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_agency (id INT AUTO_INCREMENT NOT NULL, agency_id INT NOT NULL, product_id INT NOT NULL, stock SMALLINT NOT NULL, price INT NOT NULL, INDEX IDX_12BC8742CDEADB2A (agency_id), INDEX IDX_12BC87424584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_agency ADD CONSTRAINT FK_12BC8742CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE product_agency ADD CONSTRAINT FK_12BC87424584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_agency DROP FOREIGN KEY FK_12BC8742CDEADB2A');
        $this->addSql('ALTER TABLE product_agency DROP FOREIGN KEY FK_12BC87424584665A');
        $this->addSql('DROP TABLE product_agency');
    }
}
