<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218040645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE claim (id INT AUTO_INCREMENT NOT NULL, retail_id INT NOT NULL, store_id INT NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A769DE2770A3840 (retail_id), INDEX IDX_A769DE27B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE2770A3840 FOREIGN KEY (retail_id) REFERENCES retail (id)');
        $this->addSql('ALTER TABLE claim ADD CONSTRAINT FK_A769DE27B092A811 FOREIGN KEY (store_id) REFERENCES org (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE2770A3840');
        $this->addSql('ALTER TABLE claim DROP FOREIGN KEY FK_A769DE27B092A811');
        $this->addSql('DROP TABLE claim');
    }
}
