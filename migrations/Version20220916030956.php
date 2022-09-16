<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916030956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE return_items (id INT AUTO_INCREMENT NOT NULL, ret_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_38A94521DBA7DEBD (ret_id), INDEX IDX_38A945214584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE return_items ADD CONSTRAINT FK_38A94521DBA7DEBD FOREIGN KEY (ret_id) REFERENCES returns (id)');
        $this->addSql('ALTER TABLE return_items ADD CONSTRAINT FK_38A945214584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE return_items DROP FOREIGN KEY FK_38A94521DBA7DEBD');
        $this->addSql('ALTER TABLE return_items DROP FOREIGN KEY FK_38A945214584665A');
        $this->addSql('DROP TABLE return_items');
    }
}
