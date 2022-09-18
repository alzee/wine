<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918002720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE order_items CHANGE quantity quantity INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE order_restaurant CHANGE amount amount INT UNSIGNED NOT NULL, CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE orders CHANGE amount amount INT UNSIGNED NOT NULL, CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE retail CHANGE quantity quantity SMALLINT UNSIGNED NOT NULL, CHANGE amount amount INT UNSIGNED NOT NULL, CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE return_items CHANGE quantity quantity INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE returns CHANGE amount amount INT UNSIGNED NOT NULL, CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE withdraw CHANGE amount amount INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE order_items CHANGE quantity quantity INT NOT NULL');
        $this->addSql('ALTER TABLE order_restaurant CHANGE amount amount INT NOT NULL, CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE orders CHANGE amount amount INT NOT NULL, CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE retail CHANGE quantity quantity SMALLINT NOT NULL, CHANGE amount amount INT NOT NULL, CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE return_items CHANGE quantity quantity INT NOT NULL');
        $this->addSql('ALTER TABLE returns CHANGE amount amount INT NOT NULL, CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE withdraw CHANGE amount amount INT NOT NULL');
    }
}
