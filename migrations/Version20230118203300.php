<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118203300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, consumer_id INT DEFAULT NULL, retail_id INT DEFAULT NULL, org_id INT DEFAULT NULL, ord_id INT DEFAULT NULL, type SMALLINT NOT NULL, amount SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4ED1725337FDBD6D (consumer_id), INDEX IDX_4ED1725370A3840 (retail_id), INDEX IDX_4ED17253F4837C1B (org_id), INDEX IDX_4ED17253E636D3F5 (ord_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED1725337FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED1725370A3840 FOREIGN KEY (retail_id) REFERENCES retail (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253F4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253E636D3F5 FOREIGN KEY (ord_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED1725337FDBD6D');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED1725370A3840');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253F4837C1B');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253E636D3F5');
        $this->addSql('DROP TABLE reward');
    }
}
