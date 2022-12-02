<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202163844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer ADD referrer_id INT DEFAULT NULL, ADD refcode VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE consumer ADD CONSTRAINT FK_705B3727798C22DB FOREIGN KEY (referrer_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_705B3727798C22DB ON consumer (referrer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer DROP FOREIGN KEY FK_705B3727798C22DB');
        $this->addSql('DROP INDEX IDX_705B3727798C22DB ON consumer');
        $this->addSql('ALTER TABLE consumer DROP referrer_id, DROP refcode');
    }
}
