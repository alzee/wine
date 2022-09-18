<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918023241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_705B37271E36857 ON consumer (openid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_705B3727444F97DD ON consumer (phone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_705B37271E36857 ON consumer');
        $this->addSql('DROP INDEX UNIQ_705B3727444F97DD ON consumer');
    }
}
