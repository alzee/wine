<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314064928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settle (id INT AUTO_INCREMENT NOT NULL, salesman_id INT NOT NULL, claim_id INT DEFAULT NULL, product_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2E9360CA9F7F22E2 (salesman_id), INDEX IDX_2E9360CA7096A49F (claim_id), INDEX IDX_2E9360CA4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE settle ADD CONSTRAINT FK_2E9360CA9F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE settle ADD CONSTRAINT FK_2E9360CA7096A49F FOREIGN KEY (claim_id) REFERENCES claim (id)');
        $this->addSql('ALTER TABLE settle ADD CONSTRAINT FK_2E9360CA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settle DROP FOREIGN KEY FK_2E9360CA9F7F22E2');
        $this->addSql('ALTER TABLE settle DROP FOREIGN KEY FK_2E9360CA7096A49F');
        $this->addSql('ALTER TABLE settle DROP FOREIGN KEY FK_2E9360CA4584665A');
        $this->addSql('DROP TABLE settle');
    }
}
