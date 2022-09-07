<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907141920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voucher ADD consumer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voucher ADD CONSTRAINT FK_1392A5D837FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_1392A5D837FDBD6D ON voucher (consumer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voucher DROP FOREIGN KEY FK_1392A5D837FDBD6D');
        $this->addSql('DROP INDEX IDX_1392A5D837FDBD6D ON voucher');
        $this->addSql('ALTER TABLE voucher DROP consumer_id');
    }
}
