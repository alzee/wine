<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210135920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253DBA7DEBD');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253E636D3F5');
        $this->addSql('DROP INDEX IDX_4ED17253E636D3F5 ON reward');
        $this->addSql('DROP INDEX IDX_4ED17253DBA7DEBD ON reward');
        $this->addSql('ALTER TABLE reward DROP ord_id, DROP ret_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD ord_id INT DEFAULT NULL, ADD ret_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253DBA7DEBD FOREIGN KEY (ret_id) REFERENCES returns (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253E636D3F5 FOREIGN KEY (ord_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_4ED17253E636D3F5 ON reward (ord_id)');
        $this->addSql('CREATE INDEX IDX_4ED17253DBA7DEBD ON reward (ret_id)');
    }
}
