<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208060200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD referrer_id INT DEFAULT NULL, ADD openid VARCHAR(255) DEFAULT NULL, ADD voucher INT UNSIGNED NOT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD avatar VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD reward INT NOT NULL, ADD withdrawable INT NOT NULL, ADD withdrawing INT NOT NULL, ADD nick VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649798C22DB FOREIGN KEY (referrer_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649444F97DD ON user (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491E36857 ON user (openid)');
        $this->addSql('CREATE INDEX IDX_8D93D649798C22DB ON user (referrer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649798C22DB');
        $this->addSql('DROP INDEX UNIQ_8D93D649444F97DD ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6491E36857 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649798C22DB ON user');
        $this->addSql('ALTER TABLE user DROP referrer_id, DROP openid, DROP voucher, DROP name, DROP avatar, DROP updated_at, DROP created_at, DROP reward, DROP withdrawable, DROP withdrawing, DROP nick');
    }
}
