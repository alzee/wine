<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124093916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org ADD city_id INT DEFAULT NULL, ADD industry_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA808BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE org ADD CONSTRAINT FK_7215BA802B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('CREATE INDEX IDX_7215BA808BAC62AF ON org (city_id)');
        $this->addSql('CREATE INDEX IDX_7215BA802B19A734 ON org (industry_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA808BAC62AF');
        $this->addSql('ALTER TABLE org DROP FOREIGN KEY FK_7215BA802B19A734');
        $this->addSql('DROP INDEX IDX_7215BA808BAC62AF ON org');
        $this->addSql('DROP INDEX IDX_7215BA802B19A734 ON org');
        $this->addSql('ALTER TABLE org DROP city_id, DROP industry_id');
    }
}
