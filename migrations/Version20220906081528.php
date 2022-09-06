<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906081528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, buyer_id INT NOT NULL, product_id INT NOT NULL, quantity SMALLINT NOT NULL, amount INT NOT NULL, voucher INT NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, date DATETIME NOT NULL, INDEX IDX_E52FFDEE8DE820D9 (seller_id), INDEX IDX_E52FFDEE6C755722 (buyer_id), INDEX IDX_E52FFDEE4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE8DE820D9 FOREIGN KEY (seller_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6C755722 FOREIGN KEY (buyer_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE8DE820D9');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6C755722');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE4584665A');
        $this->addSql('DROP TABLE orders');
    }
}
