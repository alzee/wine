<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907145621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE retail (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, consumer_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity SMALLINT NOT NULL, amount INT NOT NULL, voucher INT NOT NULL, INDEX IDX_FB899E15B092A811 (store_id), INDEX IDX_FB899E1537FDBD6D (consumer_id), INDEX IDX_FB899E154584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retail ADD CONSTRAINT FK_FB899E15B092A811 FOREIGN KEY (store_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE retail ADD CONSTRAINT FK_FB899E1537FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE retail ADD CONSTRAINT FK_FB899E154584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retail DROP FOREIGN KEY FK_FB899E15B092A811');
        $this->addSql('ALTER TABLE retail DROP FOREIGN KEY FK_FB899E1537FDBD6D');
        $this->addSql('ALTER TABLE retail DROP FOREIGN KEY FK_FB899E154584665A');
        $this->addSql('DROP TABLE retail');
    }
}
