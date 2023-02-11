<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210135646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED172538635941A');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5A8635941A');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F934584665A');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F939395C3F3');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F9337FDBD6D');
        $this->addSql('ALTER TABLE retail_return DROP FOREIGN KEY FK_A1B65F93B092A811');
        $this->addSql('DROP TABLE retail_return');
        $this->addSql('DROP INDEX IDX_4ED172538635941A ON reward');
        $this->addSql('ALTER TABLE reward DROP retail_return_id');
        $this->addSql('DROP INDEX IDX_EF069D5A8635941A ON share');
        $this->addSql('ALTER TABLE share DROP retail_return_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE retail_return (id INT AUTO_INCREMENT NOT NULL, store_id INT NOT NULL, consumer_id INT NOT NULL, product_id INT NOT NULL, customer_id INT DEFAULT NULL, quantity SMALLINT UNSIGNED NOT NULL, amount INT UNSIGNED NOT NULL, voucher INT UNSIGNED NOT NULL, date DATETIME NOT NULL, INDEX IDX_A1B65F9337FDBD6D (consumer_id), INDEX IDX_A1B65F934584665A (product_id), INDEX IDX_A1B65F939395C3F3 (customer_id), INDEX IDX_A1B65F93B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F934584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F939395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F9337FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE retail_return ADD CONSTRAINT FK_A1B65F93B092A811 FOREIGN KEY (store_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE reward ADD retail_return_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172538635941A FOREIGN KEY (retail_return_id) REFERENCES retail_return (id)');
        $this->addSql('CREATE INDEX IDX_4ED172538635941A ON reward (retail_return_id)');
        $this->addSql('ALTER TABLE share ADD retail_return_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5A8635941A FOREIGN KEY (retail_return_id) REFERENCES retail_return (id)');
        $this->addSql('CREATE INDEX IDX_EF069D5A8635941A ON share (retail_return_id)');
    }
}
