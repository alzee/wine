<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112025615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE org_ref_reward org_ref_reward INT UNSIGNED NOT NULL, CHANGE partner_reward partner_reward INT UNSIGNED NOT NULL, CHANGE off_industry_store_reward off_industry_store_reward INT UNSIGNED NOT NULL, CHANGE off_industry_agency_reward off_industry_agency_reward INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE org_ref_reward org_ref_reward INT NOT NULL, CHANGE partner_reward partner_reward INT NOT NULL, CHANGE off_industry_store_reward off_industry_store_reward INT NOT NULL, CHANGE off_industry_agency_reward off_industry_agency_reward INT NOT NULL');
    }
}
