<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314065831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B09F7F22E2');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B04584665A');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B07096A49F');
        $this->addSql('DROP TABLE borrow');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow (id INT AUTO_INCREMENT NOT NULL, salesman_id INT NOT NULL, product_id INT NOT NULL, claim_id INT NOT NULL, qty SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status SMALLINT NOT NULL, INDEX IDX_55DBA8B04584665A (product_id), UNIQUE INDEX UNIQ_55DBA8B07096A49F (claim_id), INDEX IDX_55DBA8B09F7F22E2 (salesman_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B09F7F22E2 FOREIGN KEY (salesman_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B07096A49F FOREIGN KEY (claim_id) REFERENCES claim (id)');
    }
}
