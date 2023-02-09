<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209040506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA80798C22DB');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA80798C22DB FOREIGN KEY (referrer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA80798C22DB');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA80798C22DB FOREIGN KEY (referrer_id) REFERENCES consumer (id)');
    }
}
