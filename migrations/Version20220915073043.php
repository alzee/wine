<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915073043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw ADD applicant_id INT NOT NULL, ADD approver_id INT NOT NULL');
        $this->addSql('ALTER TABLE withdraw ADD CONSTRAINT FK_B5DE5F9E97139001 FOREIGN KEY (applicant_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE withdraw ADD CONSTRAINT FK_B5DE5F9EBB23766C FOREIGN KEY (approver_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_B5DE5F9E97139001 ON withdraw (applicant_id)');
        $this->addSql('CREATE INDEX IDX_B5DE5F9EBB23766C ON withdraw (approver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE withdraw DROP FOREIGN KEY FK_B5DE5F9E97139001');
        $this->addSql('ALTER TABLE withdraw DROP FOREIGN KEY FK_B5DE5F9EBB23766C');
        $this->addSql('DROP INDEX IDX_B5DE5F9E97139001 ON withdraw');
        $this->addSql('DROP INDEX IDX_B5DE5F9EBB23766C ON withdraw');
        $this->addSql('ALTER TABLE withdraw DROP applicant_id, DROP approver_id');
    }
}
