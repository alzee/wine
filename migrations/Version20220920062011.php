<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920062011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE retail_return (id INT AUTO_INCREMENT NOT NULL, store_id INT NOT NULL, consumer_id INT NOT NULL, product_id INT NOT NULL, quantity SMALLINT NOT NULL, amount INT NOT NULL, voucher INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_A1B65F93B092A811 (store_id), INDEX IDX_A1B65F9337FDBD6D (consumer_id), INDEX IDX_A1B65F934584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F93B092A811 FOREIGN KEY (store_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F9337FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F934584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F93B092A811');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F9337FDBD6D');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F934584665A');
        $this->addSql('DROP TABLE retail_return');
    }
}
