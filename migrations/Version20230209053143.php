<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209053143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_restaurant ADD CONSTRAINT FK_584FEF6A9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_584FEF6A9395C3F3 ON order_restaurant (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_restaurant DROP FOREIGN KEY FK_584FEF6A9395C3F3');
        $this->addSql('DROP INDEX IDX_584FEF6A9395C3F3 ON order_restaurant');
        $this->addSql('ALTER TABLE order_restaurant DROP customer_id');
    }
}
