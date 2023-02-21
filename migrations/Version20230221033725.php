<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221033725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('update org set voucher = 2147483647 where type = 0');
        $this->addSql('ALTER TABLE org CHANGE voucher voucher INT NOT NULL');
        $this->addSql('ALTER TABLE stock CHANGE stock stock INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE voucher voucher INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org CHANGE voucher voucher INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE stock CHANGE stock stock INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE voucher voucher INT UNSIGNED NOT NULL');
    }
}
