<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124142747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conf DROP ref_reward, DROP partner_reward, DROP off_industry_store_reward, DROP off_industry_agency_reward');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conf ADD ref_reward INT UNSIGNED NOT NULL, ADD partner_reward INT UNSIGNED NOT NULL, ADD off_industry_store_reward INT UNSIGNED NOT NULL, ADD off_industry_agency_reward INT UNSIGNED NOT NULL');
    }
}
