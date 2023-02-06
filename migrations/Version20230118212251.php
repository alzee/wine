<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118212251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD referrer_id INT NOT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253798C22DB FOREIGN KEY (referrer_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_4ED17253798C22DB ON reward (referrer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253798C22DB');
        $this->addSql('DROP INDEX IDX_4ED17253798C22DB ON reward');
        $this->addSql('ALTER TABLE reward DROP referrer_id');
    }
}
