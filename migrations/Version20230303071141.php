<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303071141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collect ADD customer_id INT DEFAULT NULL, ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collect ADD CONSTRAINT FK_A40662F49395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE collect ADD CONSTRAINT FK_A40662F4B092A811 FOREIGN KEY (store_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_A40662F49395C3F3 ON collect (customer_id)');
        $this->addSql('CREATE INDEX IDX_A40662F4B092A811 ON collect (store_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collect DROP FOREIGN KEY FK_A40662F49395C3F3');
        $this->addSql('ALTER TABLE collect DROP FOREIGN KEY FK_A40662F4B092A811');
        $this->addSql('DROP INDEX IDX_A40662F49395C3F3 ON collect');
        $this->addSql('DROP INDEX IDX_A40662F4B092A811 ON collect');
        $this->addSql('ALTER TABLE collect DROP customer_id, DROP store_id');
    }
}
