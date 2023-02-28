<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221030254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pack_prize DROP FOREIGN KEY FK_E33C01B01919B217');
        $this->addSql('ALTER TABLE pack_prize DROP FOREIGN KEY FK_E33C01B0BBE43214');
        $this->addSql('DROP TABLE pack_prize');
        $this->addSql('ALTER TABLE pack DROP qty');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_prize (pack_id INT NOT NULL, prize_id INT NOT NULL, INDEX IDX_E33C01B0BBE43214 (prize_id), INDEX IDX_E33C01B01919B217 (pack_id), PRIMARY KEY(pack_id, prize_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pack_prize ADD CONSTRAINT FK_E33C01B01919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_prize ADD CONSTRAINT FK_E33C01B0BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack ADD qty SMALLINT NOT NULL');
    }
}
