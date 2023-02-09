<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209050853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scan ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE scan ADD CONSTRAINT FK_C4B3B3AE9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C4B3B3AE9395C3F3 ON scan (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scan DROP FOREIGN KEY FK_C4B3B3AE9395C3F3');
        $this->addSql('DROP INDEX IDX_C4B3B3AE9395C3F3 ON scan');
        $this->addSql('ALTER TABLE scan DROP customer_id');
    }
}
