<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221024629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, qty SMALLINT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_prize (pack_id INT NOT NULL, prize_id INT NOT NULL, INDEX IDX_E33C01B01919B217 (pack_id), INDEX IDX_E33C01B0BBE43214 (prize_id), PRIMARY KEY(pack_id, prize_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_prize ADD CONSTRAINT FK_E33C01B01919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_prize ADD CONSTRAINT FK_E33C01B0BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pack_prize DROP FOREIGN KEY FK_E33C01B01919B217');
        $this->addSql('ALTER TABLE pack_prize DROP FOREIGN KEY FK_E33C01B0BBE43214');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_prize');
    }
}
