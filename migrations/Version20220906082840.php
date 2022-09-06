<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906082840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE returns (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, product_id INT NOT NULL, quantity SMALLINT NOT NULL, amount INT NOT NULL, voucher INT NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, date DATETIME NOT NULL, INDEX IDX_8B164CA5F624B39D (sender_id), INDEX IDX_8B164CA5E92F8F78 (recipient_id), INDEX IDX_8B164CA54584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE returns ADD CONSTRAINT FK_8B164CA5F624B39D FOREIGN KEY (sender_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE returns ADD CONSTRAINT FK_8B164CA5E92F8F78 FOREIGN KEY (recipient_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE returns ADD CONSTRAINT FK_8B164CA54584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE returns DROP FOREIGN KEY FK_8B164CA5F624B39D');
        $this->addSql('ALTER TABLE returns DROP FOREIGN KEY FK_8B164CA5E92F8F78');
        $this->addSql('ALTER TABLE returns DROP FOREIGN KEY FK_8B164CA54584665A');
        $this->addSql('DROP TABLE returns');
    }
}
