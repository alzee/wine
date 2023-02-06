<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118212538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED1725337FDBD6D');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253F4837C1B');
        $this->addSql('DROP INDEX IDX_4ED1725337FDBD6D ON reward');
        $this->addSql('DROP INDEX IDX_4ED17253F4837C1B ON reward');
        $this->addSql('ALTER TABLE reward DROP consumer_id, DROP org_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD consumer_id INT DEFAULT NULL, ADD org_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED1725337FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253F4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_4ED1725337FDBD6D ON reward (consumer_id)');
        $this->addSql('CREATE INDEX IDX_4ED17253F4837C1B ON reward (org_id)');
    }
}
