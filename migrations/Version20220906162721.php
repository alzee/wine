<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906162721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voucher ADD org_id INT DEFAULT NULL, ADD voucher INT NOT NULL, ADD date DATETIME NOT NULL, DROP name, CHANGE value type SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE voucher ADD CONSTRAINT FK_1392A5D8F4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_1392A5D8F4837C1B ON voucher (org_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voucher DROP FOREIGN KEY FK_1392A5D8F4837C1B');
        $this->addSql('DROP INDEX IDX_1392A5D8F4837C1B ON voucher');
        $this->addSql('ALTER TABLE voucher ADD name VARCHAR(255) NOT NULL, DROP org_id, DROP voucher, DROP date, CHANGE type value SMALLINT NOT NULL');
    }
}
