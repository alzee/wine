<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127163901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD ret_id INT DEFAULT NULL, ADD retail_return_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253DBA7DEBD FOREIGN KEY (ret_id) REFERENCES returns (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172538635941A FOREIGN KEY (retail_return_id) REFERENCES retail_return (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED17253DBA7DEBD ON reward (ret_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED172538635941A ON reward (retail_return_id)');
        $this->addSql('ALTER TABLE share ADD retail_return_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5A8635941A FOREIGN KEY (retail_return_id) REFERENCES retail_return (id)');
        $this->addSql('CREATE INDEX IDX_EF069D5A8635941A ON share (retail_return_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253DBA7DEBD');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED172538635941A');
        $this->addSql('DROP INDEX UNIQ_4ED17253DBA7DEBD ON reward');
        $this->addSql('DROP INDEX UNIQ_4ED172538635941A ON reward');
        $this->addSql('ALTER TABLE reward DROP ret_id, DROP retail_return_id');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5A8635941A');
        $this->addSql('DROP INDEX IDX_EF069D5A8635941A ON share');
        $this->addSql('ALTER TABLE share DROP retail_return_id');
    }
}
