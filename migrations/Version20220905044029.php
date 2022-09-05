<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905044029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_restaurant (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, product_id INT NOT NULL, stock SMALLINT NOT NULL, price INT NOT NULL, INDEX IDX_78F24D14B1E7706E (restaurant_id), INDEX IDX_78F24D144584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_restaurant ADD CONSTRAINT FK_78F24D14B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE product_restaurant ADD CONSTRAINT FK_78F24D144584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_restaurant DROP FOREIGN KEY FK_78F24D14B1E7706E');
        $this->addSql('ALTER TABLE product_restaurant DROP FOREIGN KEY FK_78F24D144584665A');
        $this->addSql('DROP TABLE product_restaurant');
    }
}
