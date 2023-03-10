<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310104519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org CHANGE voucher voucher INT UNSIGNED NOT NULL, CHANGE discount discount DOUBLE PRECISION UNSIGNED NOT NULL, CHANGE withdrawing withdrawing INT UNSIGNED NOT NULL, CHANGE share share INT UNSIGNED NOT NULL, CHANGE share_withdrawable share_withdrawable INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org CHANGE voucher voucher INT NOT NULL, CHANGE discount discount DOUBLE PRECISION NOT NULL, CHANGE withdrawing withdrawing INT NOT NULL, CHANGE share share INT NOT NULL, CHANGE share_withdrawable share_withdrawable INT NOT NULL');
    }
}
