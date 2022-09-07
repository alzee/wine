<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907141027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant ADD note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE returns ADD note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE withdraw ADD note VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant DROP note');
        $this->addSql('ALTER TABLE orders DROP note');
        $this->addSql('ALTER TABLE returns DROP note');
        $this->addSql('ALTER TABLE withdraw DROP note');
    }
}
