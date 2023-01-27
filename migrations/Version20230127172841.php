<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127172841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP INDEX UNIQ_4ED172538635941A, ADD INDEX IDX_4ED172538635941A (retail_return_id)');
        $this->addSql('ALTER TABLE reward DROP INDEX UNIQ_4ED17253DBA7DEBD, ADD INDEX IDX_4ED17253DBA7DEBD (ret_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP INDEX IDX_4ED17253DBA7DEBD, ADD UNIQUE INDEX UNIQ_4ED17253DBA7DEBD (ret_id)');
        $this->addSql('ALTER TABLE reward DROP INDEX IDX_4ED172538635941A, ADD UNIQUE INDEX UNIQ_4ED172538635941A (retail_return_id)');
    }
}
