<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906113057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant ADD consumer_id INT NOT NULL, DROP openid');
        $this->addSql('ALTER TABLE order_restaurant ADD CONSTRAINT FK_584FEF6A37FDBD6D FOREIGN KEY (consumer_id) REFERENCES consumer (id)');
        $this->addSql('CREATE INDEX IDX_584FEF6A37FDBD6D ON order_restaurant (consumer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant DROP FOREIGN KEY FK_584FEF6A37FDBD6D');
        $this->addSql('DROP INDEX IDX_584FEF6A37FDBD6D ON order_restaurant');
        $this->addSql('ALTER TABLE order_restaurant ADD openid VARCHAR(255) NOT NULL, DROP consumer_id');
    }
}
