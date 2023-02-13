<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213085827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `prize` VALUES (1,'再来一瓶',NULL,365,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (2,'双向再来一瓶',NULL,365,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (3,'代金券',50,365,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (4,'代金券(随机面额)',30,365,null,0,60)");
        $this->addSql("INSERT INTO `prize` VALUES (5,'微信红包',50,365,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (6,'微信红包(随机面额)',6,365,null,0,11)");
        $this->addSql("INSERT INTO `prize` VALUES (7,'集齐兑一瓶',3,365,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (8,'谢谢惠顾',NULL,0,null,0,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (100,'手表',null,365,0.0001,1,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (101,'手机',null,365,0.00001,1,NULL)");
        $this->addSql("INSERT INTO `prize` VALUES (102,'车',null,365,0.0000001,1,NULL)");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("truncate table prize");

    }
}
