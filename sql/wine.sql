-- MariaDB dump 10.19  Distrib 10.5.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: wine
-- ------------------------------------------------------
-- Server version	10.5.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `consumer`
--

DROP TABLE IF EXISTS `consumer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_705B37271E36857` (`openid`),
  UNIQUE KEY `UNIQ_705B3727444F97DD` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumer`
--

LOCK TABLES `consumer` WRITE;
/*!40000 ALTER TABLE `consumer` DISABLE KEYS */;
INSERT INTO `consumer` VALUES (1,'111',59000,'王一顾','13211111111'),(2,'1111',0,'111','132000');
/*!40000 ALTER TABLE `consumer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220905032624','2022-09-06 08:44:42',98),('DoctrineMigrations\\Version20220905034646','2022-09-06 08:44:42',22),('DoctrineMigrations\\Version20220905034844','2022-09-06 08:44:43',26),('DoctrineMigrations\\Version20220905035935','2022-09-06 08:44:43',144),('DoctrineMigrations\\Version20220905040247','2022-09-06 08:44:43',48),('DoctrineMigrations\\Version20220905040757','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041124','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041645','2022-09-06 08:44:43',92),('DoctrineMigrations\\Version20220905042134','2022-09-06 08:44:43',94),('DoctrineMigrations\\Version20220905042511','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905042659','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905043004','2022-09-06 08:44:43',11),('DoctrineMigrations\\Version20220905043638','2022-09-06 08:44:43',199),('DoctrineMigrations\\Version20220905043837','2022-09-06 08:44:43',177),('DoctrineMigrations\\Version20220905044029','2022-09-06 08:44:43',172),('DoctrineMigrations\\Version20220905044154','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906030233','2022-09-06 08:44:44',23),('DoctrineMigrations\\Version20220906030331','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906032412','2022-09-06 08:44:44',8),('DoctrineMigrations\\Version20220906034230','2022-09-06 08:44:44',13),('DoctrineMigrations\\Version20220906044555','2022-09-06 08:44:44',10),('DoctrineMigrations\\Version20220906052433','2022-09-06 08:44:44',70),('DoctrineMigrations\\Version20220906074723','2022-09-06 08:44:44',25),('DoctrineMigrations\\Version20220906080145','2022-09-06 08:44:44',20),('DoctrineMigrations\\Version20220906081528','2022-09-06 08:44:44',248),('DoctrineMigrations\\Version20220906082840','2022-09-06 08:44:44',247),('DoctrineMigrations\\Version20220906083319','2022-09-06 08:44:44',132),('DoctrineMigrations\\Version20220906111008','2022-09-06 11:10:12',58),('DoctrineMigrations\\Version20220906112856','2022-09-06 11:28:58',55),('DoctrineMigrations\\Version20220906113057','2022-09-06 11:30:58',157),('DoctrineMigrations\\Version20220906113840','2022-09-06 11:38:41',148),('DoctrineMigrations\\Version20220906114120','2022-09-06 11:41:21',57),('DoctrineMigrations\\Version20220906115333','2022-09-06 11:53:35',57),('DoctrineMigrations\\Version20220906120020','2022-09-06 12:00:21',141),('DoctrineMigrations\\Version20220906120335','2022-09-06 12:03:37',56),('DoctrineMigrations\\Version20220906120912','2022-09-06 12:09:13',73),('DoctrineMigrations\\Version20220906143539','2022-09-06 14:35:40',88),('DoctrineMigrations\\Version20220906143722','2022-09-06 14:37:23',157),('DoctrineMigrations\\Version20220906144624','2022-09-06 14:46:25',97),('DoctrineMigrations\\Version20220906145231','2022-09-06 14:52:32',161),('DoctrineMigrations\\Version20220906145806','2022-09-06 14:58:08',126),('DoctrineMigrations\\Version20220906153137','2022-09-06 15:31:39',73),('DoctrineMigrations\\Version20220906162721','2022-09-06 16:27:22',153),('DoctrineMigrations\\Version20220906182338','2022-09-06 18:23:39',57),('DoctrineMigrations\\Version20220907141027','2022-09-07 14:10:29',126),('DoctrineMigrations\\Version20220907141920','2022-09-07 14:19:21',189),('DoctrineMigrations\\Version20220907145621','2022-09-07 14:56:22',272),('DoctrineMigrations\\Version20220907152801','2022-09-07 15:28:02',206),('DoctrineMigrations\\Version20220913072842','2022-09-14 00:29:01',74),('DoctrineMigrations\\Version20220913094839','2022-09-14 00:29:01',4),('DoctrineMigrations\\Version20220913102501','2022-09-14 00:29:01',29),('DoctrineMigrations\\Version20220914005419','2022-09-14 00:54:21',55),('DoctrineMigrations\\Version20220914100935','2022-09-15 00:50:35',92),('DoctrineMigrations\\Version20220914103307','2022-09-15 00:50:35',30),('DoctrineMigrations\\Version20220914123056','2022-09-15 00:50:35',3),('DoctrineMigrations\\Version20220915013706','2022-09-15 01:37:25',68),('DoctrineMigrations\\Version20220915073043','2022-09-15 07:59:47',282),('DoctrineMigrations\\Version20220915080140','2022-09-15 08:01:45',106),('DoctrineMigrations\\Version20220915092811','2022-09-15 09:28:18',78),('DoctrineMigrations\\Version20220915093205','2022-09-15 09:32:07',101),('DoctrineMigrations\\Version20220915094641','2022-09-15 09:46:49',273),('DoctrineMigrations\\Version20220915161230','2022-09-15 16:12:39',56),('DoctrineMigrations\\Version20220915161635','2022-09-15 16:16:42',86),('DoctrineMigrations\\Version20220916004730','2022-09-16 00:47:37',124),('DoctrineMigrations\\Version20220916015129','2022-09-16 01:51:36',64),('DoctrineMigrations\\Version20220916025255','2022-09-16 02:53:14',67),('DoctrineMigrations\\Version20220916030956','2022-09-16 03:10:04',90),('DoctrineMigrations\\Version20220916093835','2022-09-16 09:40:54',63),('DoctrineMigrations\\Version20220917100338','2022-09-17 10:03:53',78),('DoctrineMigrations\\Version20220917143941','2022-09-17 14:40:14',77),('DoctrineMigrations\\Version20220917235726','2022-09-17 23:58:05',139),('DoctrineMigrations\\Version20220918000329','2022-09-18 00:03:40',132),('DoctrineMigrations\\Version20220918002720','2022-09-18 00:27:36',1129),('DoctrineMigrations\\Version20220918023241','2022-09-18 02:33:06',75),('DoctrineMigrations\\Version20220918063801','2022-09-18 06:39:59',79),('DoctrineMigrations\\Version20220918065856','2022-09-18 06:59:01',60),('DoctrineMigrations\\Version20220920021307','2022-09-20 02:13:10',60);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node`
--

DROP TABLE IF EXISTS `node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` smallint(6) DEFAULT NULL,
  `date` datetime NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node`
--

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` VALUES (1,'test','<div>at</div>',0,'2022-09-18 06:50:46','400x170.png'),(2,'yu','<div>yuyu</div>',0,'2022-09-18 07:07:14','400x170.png'),(3,'n2','<div>hjh</div>',0,'2022-09-18 09:38:23','400x170.png'),(4,'n4','<div>8</div>',2,'2022-09-18 09:39:13','400x220.png'),(5,'n5','<div>jk</div>',2,'2022-09-18 09:39:23','400x220.png'),(6,'n6','<div>jj</div>',2,'2022-09-18 09:39:34','400x220.png'),(7,'n7','<div>uu</div>',0,'2022-09-18 09:39:44','400x170.png'),(8,'n8','<div>y</div>',1,'2022-09-18 09:40:35','80x80.png'),(9,'n9','<div>hh</div>',1,'2022-09-18 09:40:42','80x80.png'),(10,'n10','<div>yy</div>',1,'2022-09-18 09:40:53','80x80.png'),(11,'n11','<div>hh</div>',1,'2022-09-18 09:41:00','80x80.png'),(12,'n12','<div>yy</div>',1,'2022-09-18 09:41:08','80x80.png');
/*!40000 ALTER TABLE `node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ord_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62809DB04584665A` (`product_id`),
  KEY `IDX_62809DB0E636D3F5` (`ord_id`),
  CONSTRAINT `FK_62809DB04584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_62809DB0E636D3F5` FOREIGN KEY (`ord_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,7,1,555),(2,8,1,5),(3,9,2,5),(4,9,1,5),(5,9,2,5),(6,12,3,5),(7,12,3,5),(8,1,3,1),(9,3,1,2),(10,15,1,5),(11,15,2,5),(12,16,3,2),(13,16,8,2),(14,17,3,1),(15,18,1,1),(16,19,1,1),(17,20,3,1),(18,22,3,1),(19,23,1,0),(20,24,1,1),(21,25,1,5);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_restaurant`
--

DROP TABLE IF EXISTS `order_restaurant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_584FEF6A37FDBD6D` (`consumer_id`),
  KEY `IDX_584FEF6AB1E7706E` (`restaurant_id`),
  CONSTRAINT `FK_584FEF6A37FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_584FEF6AB1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_restaurant`
--

LOCK TABLES `order_restaurant` WRITE;
/*!40000 ALTER TABLE `order_restaurant` DISABLE KEYS */;
INSERT INTO `order_restaurant` VALUES (1,'123',100,'2022-09-06 14:37:56',50,1,6,NULL),(2,'124',100,'2022-09-06 14:43:54',30,1,6,NULL),(3,'125',10000,'2022-09-07 14:38:12',1500,1,1,'111'),(4,'126',10000,'2022-09-07 14:41:40',1500,1,6,NULL),(5,'113',10000,'2022-09-07 14:46:37',2000,1,6,'safas');
/*!40000 ALTER TABLE `order_restaurant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `status` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E52FFDEE8DE820D9` (`seller_id`),
  KEY `IDX_E52FFDEE6C755722` (`buyer_id`),
  CONSTRAINT `FK_E52FFDEE6C755722` FOREIGN KEY (`buyer_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_E52FFDEE8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,3,10000,1000,5,'2022-09-06 09:17:17',NULL),(2,1,3,1000,500,5,'2022-09-06 11:05:35',NULL),(3,5,1,1000,500,5,'2022-09-06 11:13:16','14ffsdfadf'),(4,5,2,50000,5000,5,'2022-09-06 17:03:01',NULL),(5,5,2,50000,5000,5,'2022-09-06 17:04:48',NULL),(6,5,2,500000,50000,5,'2022-09-06 17:20:26',NULL),(7,5,2,100,100,0,'2022-09-15 15:30:49',NULL),(8,5,2,500,500,0,'2022-09-15 15:45:04',NULL),(9,5,2,600,600,0,'2022-09-15 15:45:40',NULL),(10,5,2,700,700,0,'2022-09-15 15:50:36',NULL),(11,1,3,500,500,0,'2022-09-15 16:16:55',NULL),(12,1,3,50000,50000,0,'2022-09-15 16:18:01',NULL),(13,1,3,600,600,0,'2022-09-15 16:22:37',NULL),(14,1,3,7700,7700,5,'2022-09-15 16:23:09',NULL),(15,5,1,3000000,300000,5,'2022-09-16 01:29:27','11'),(16,1,3,210000,21000,5,'2022-09-16 01:34:26',NULL),(17,1,3,0,0,4,'2022-09-16 03:48:33',NULL),(18,5,1,500000,50000,5,'2022-09-16 10:02:20','11123'),(19,5,1,500000,50000,0,'2022-09-17 10:09:50',NULL),(20,1,3,5000,500,0,'2022-09-17 10:32:21',NULL),(21,1,3,0,0,0,'2022-09-17 10:34:46',NULL),(22,1,3,5000,500,4,'2022-09-17 10:35:04','11'),(23,5,1,0,0,0,'2022-09-18 02:48:43',NULL),(24,5,1,500000,50000,0,'2022-09-18 02:49:27',NULL),(25,5,1,2500000,250000,0,'2022-09-18 02:49:44',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `org`
--

DROP TABLE IF EXISTS `org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `upstream_id` int(11) DEFAULT NULL,
  `discount` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7215BA80245F9855` (`upstream_id`),
  CONSTRAINT `FK_7215BA80245F9855` FOREIGN KEY (`upstream_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org`
--

LOCK TABLES `org` WRITE;
/*!40000 ALTER TABLE `org` DISABLE KEYS */;
INSERT INTO `org` VALUES (1,'代理商1号','王一代','131111111','代理商1号地址','代理商1号区域',1,347050,5,0),(2,'代理商2号','王二代','13111111111','代理商2号地址','代理商2号区域',1,5000,5,0),(3,'门店1号','王一店','13111111111','门店1号地址','门店1号区域',2,54200,1,0),(4,'门店2号','王二店','13111111111','门店2号地址','门店2号区域',2,0,2,0),(5,'总公司','王总','13111111111','总部地址','总部区域',0,4294967295,NULL,0),(6,'餐厅1号','王一餐','13111111111','餐厅1号地址','餐厅1号区域',3,3500,1,0),(7,'顾客','王一代','+8613207262011','No. 10','代理商1号区域',4,0,NULL,0),(8,'代理商3号','王三代','13111111111','代理商3号地址','代理商3号区域',1,0,5,0);
/*!40000 ALTER TABLE `org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `stock` smallint(6) NOT NULL,
  `sn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `org_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn_org` (`sn`,`org_id`),
  KEY `IDX_D34A04ADF4837C1B` (`org_id`),
  CONSTRAINT `FK_D34A04ADF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'五粮液10年','500mlx6',500000,41,'11111',50000,5),(2,'白云边12年','500mlx6',100000,93,'11112',10000,5),(3,'五粮液10年','500mlx6',500000,12,'11111',50000,1),(4,'五粮液10年','500mlx6',500000,5,'11111',50000,3),(5,'白云边12年','500mlx6',100000,2,'11112',10000,2),(6,'五粮液10年','500mlx6',500000,0,'11111',50000,2),(8,'白云边12年','500mlx6',100000,4,'11112',10000,1),(9,'白云边12年','500mlx6',100000,1,'11112',10000,3);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retail`
--

DROP TABLE IF EXISTS `retail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB899E15B092A811` (`store_id`),
  KEY `IDX_FB899E1537FDBD6D` (`consumer_id`),
  KEY `IDX_FB899E154584665A` (`product_id`),
  CONSTRAINT `FK_FB899E1537FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_FB899E154584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_FB899E15B092A811` FOREIGN KEY (`store_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail`
--

LOCK TABLES `retail` WRITE;
/*!40000 ALTER TABLE `retail` DISABLE KEYS */;
INSERT INTO `retail` VALUES (2,3,1,4,2,10000,1000,'2022-09-16 02:03:51');
/*!40000 ALTER TABLE `retail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_items`
--

DROP TABLE IF EXISTS `return_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ret_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_38A94521DBA7DEBD` (`ret_id`),
  KEY `IDX_38A945214584665A` (`product_id`),
  CONSTRAINT `FK_38A945214584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_38A94521DBA7DEBD` FOREIGN KEY (`ret_id`) REFERENCES `returns` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_items`
--

LOCK TABLES `return_items` WRITE;
/*!40000 ALTER TABLE `return_items` DISABLE KEYS */;
INSERT INTO `return_items` VALUES (1,3,3,1),(2,4,3,1),(3,4,8,1),(4,5,3,1),(5,5,8,1),(6,6,3,5),(7,7,1,4),(8,8,1,1),(9,9,3,1);
/*!40000 ALTER TABLE `return_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returns`
--

DROP TABLE IF EXISTS `returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `status` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B164CA5F624B39D` (`sender_id`),
  KEY `IDX_8B164CA5E92F8F78` (`recipient_id`),
  CONSTRAINT `FK_8B164CA5E92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_8B164CA5F624B39D` FOREIGN KEY (`sender_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` VALUES (1,3,1,1000,500,5,'2022-09-06 15:32:17',NULL),(2,2,5,500000,50000,5,'2022-09-06 17:27:53',NULL),(3,3,1,0,0,0,'2022-09-16 03:31:28',NULL),(4,3,1,105000,10500,5,'2022-09-16 03:45:29',NULL),(5,3,1,105000,10500,5,'2022-09-16 03:54:32',NULL),(6,3,1,25000,2500,5,'2022-09-16 04:14:25',NULL),(7,1,5,2000000,200000,0,'2022-09-17 10:10:00',NULL),(8,1,5,500000,50000,0,'2022-09-17 10:10:08',NULL),(9,3,1,5000,500,4,'2022-09-17 10:35:38','11');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `org_id` int(11) NOT NULL,
  `plain_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  KEY `IDX_8D93D649F4837C1B` (`org_id`),
  CONSTRAINT `FK_8D93D649F4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'u1','[\"ROLE_AGENCY\"]','$2y$13$HCjVxlipu1iotyJShWn1KusUblYC/vNv9qcbZcLGu..fQ5a4iH/3a',1,NULL),(3,'u2','[\"ROLE_AGENCY\"]','asdfaf',1,NULL),(4,'u3','[\"ROLE_AGENCY\"]','$2y$13$mLk.XtgzGzlvDDloS3G5UuEHKRIXIiBmzbIFHk0EW.uvxyroa37jS',8,NULL),(6,'u4','[\"ROLE_RESTAURANT\"]','sdfg',6,NULL),(7,'u6','[\"ROLE_STORE\"]','sdafas',4,NULL),(8,'u7','[\"ROLE_AGENCY\"]','111',1,NULL),(9,'admin','[\"ROLE_HEAD\", \"ROLE_ADMIN\"]','$2y$13$6eWONnmy7sz4qPKWu7.0Z.QGboS/uyCRS2n/sicq/R4ukBdiVIkxW',5,NULL),(10,'t5','[\"ROLE_AGENCY\"]','$2y$13$xHe1xKIVYpPqvUegZT1y1uRvj.Zp6eR.LHKQv7jkZAE6YKxwL/ewm',8,NULL),(11,'t6','[\"ROLE_AGENCY\"]','$2y$13$828fiOFIhlG9007qRrPhuuIfwG1wvHm.NAFNFgD2Ora3APx14982q',1,NULL),(12,'t7','[\"ROLE_HEAD\"]','$2y$13$AMHn9Oo74jCgfgYR2bk1tuSDDBMiw2E9bevXyoYiyWvXPtMDTf8JW',5,NULL),(13,'s1','[\"ROLE_STORE\"]','$2y$13$dbHC6AGEuX3IQVl/nCQ5auJrD444QSwFPFVlyZ2qDZh6wW4YdUq/i',3,NULL),(14,'r1','[\"ROLE_RESTAURANT\"]','$2y$13$76eI2qzqAwaxpgupQt/MYeelY2b6mbXgM2U/ptk3bN0HGauQh9R0a',6,NULL),(15,'h1','[\"ROLE_HEAD\"]','$2y$13$RWxYfcuFFxM5.wXVrniE5OI96dlx2NGMVaraJrl0akRc92y1kJojG',5,NULL),(16,'a1','[\"ROLE_AGENCY\"]','$2y$13$747oFd.PJKUjAZ/UUxqLx.fuC75XxSsrHH9c07FzXhTWVwh9oiOGa',1,NULL),(17,'12','[\"ROLE_AGENCY\"]','$2y$13$p3V/kT5eC3mJnzA0RDhs4OUMpMbMzsiVDKxfIxe/1gQaRllsxHZ8S',1,NULL),(18,'t24','[\"ROLE_AGENCY\"]','$2y$13$6fSWnsrcXuIIX56B3K46zuSX.J0VR7DCX2koQ5dLhgYsHYvDEY6kW',1,NULL),(19,'rut1','[\"ROLE_AGENCY\"]','$2y$13$vbMAORQZrKY78O3ZJE5yFuggWhWMIkyfrCxnaeIVyVi6P88WxfocK',1,NULL),(21,'admin41','[\"ROLE_AGENCY\"]','$2y$13$Bg7v3rVLnSSu.G8A4kZ/HeSOppT/HsknPKTU51WTs3ie5l0Q8pIQO',1,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher`
--

DROP TABLE IF EXISTS `voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `voucher` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1392A5D8F4837C1B` (`org_id`),
  KEY `IDX_1392A5D837FDBD6D` (`consumer_id`),
  CONSTRAINT `FK_1392A5D837FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_1392A5D8F4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher`
--

LOCK TABLES `voucher` WRITE;
/*!40000 ALTER TABLE `voucher` DISABLE KEYS */;
INSERT INTO `voucher` VALUES (1,1,6,5000,'2022-09-06 16:41:57',NULL,NULL),(2,10,5,-5000,'2022-09-06 17:03:50',NULL,NULL),(3,0,5,5000,'2022-09-06 17:03:50',NULL,NULL),(4,10,5,-5000,'2022-09-06 17:04:59',NULL,NULL),(5,0,2,5000,'2022-09-06 17:04:59',NULL,NULL),(6,10,5,-50000,'2022-09-06 17:20:56',NULL,NULL),(7,0,2,50000,'2022-09-06 17:20:56',NULL,NULL),(8,12,2,-50000,'2022-09-06 17:28:45',NULL,NULL),(9,2,5,50000,'2022-09-06 17:28:45',NULL,NULL),(10,14,2,-5000,'2022-09-06 17:39:16',NULL,NULL),(11,16,7,-1500,'2022-09-07 14:38:12',NULL,1),(12,6,1,1500,'2022-09-07 14:38:12',NULL,NULL),(13,16,7,-1500,'2022-09-07 14:41:41',NULL,1),(14,6,6,1500,'2022-09-07 14:41:41',NULL,NULL),(15,16,7,-2000,'2022-09-07 14:46:37',NULL,1),(16,6,6,2000,'2022-09-07 14:46:37',NULL,NULL),(17,17,3,-50000,'2022-09-07 15:19:01',NULL,NULL),(18,7,7,50000,'2022-09-07 15:19:01',NULL,1),(19,10,5,-300000,'2022-09-16 01:31:58',NULL,NULL),(20,0,1,300000,'2022-09-16 01:31:58',NULL,NULL),(21,11,1,-21000,'2022-09-16 01:35:12',NULL,NULL),(22,1,3,21000,'2022-09-16 01:35:12',NULL,NULL),(23,17,3,-1000,'2022-09-16 02:03:51',NULL,NULL),(24,7,7,1000,'2022-09-16 02:03:51',NULL,1),(25,13,3,-10500,'2022-09-16 03:46:27',NULL,NULL),(26,3,1,10500,'2022-09-16 03:46:27',NULL,NULL),(27,13,3,-10500,'2022-09-16 03:54:54',NULL,NULL),(28,3,1,10500,'2022-09-16 03:54:54',NULL,NULL),(29,13,3,-2500,'2022-09-16 04:14:44',NULL,NULL),(30,3,1,2500,'2022-09-16 04:14:44',NULL,NULL),(35,10,5,-50000,'2022-09-17 10:06:16',NULL,NULL),(36,0,1,50000,'2022-09-17 10:06:16',NULL,NULL),(37,11,1,-7700,'2022-09-17 10:30:50',NULL,NULL),(38,1,3,7700,'2022-09-17 10:30:50',NULL,NULL),(39,30,1,-100,'2022-09-18 03:01:30',NULL,NULL),(40,30,1,-100,'2022-09-18 03:02:15',NULL,NULL);
/*!40000 ALTER TABLE `voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `status` smallint(6) NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `discount` double NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5DE5F9EF4837C1B` (`org_id`),
  KEY `IDX_B5DE5F9E97139001` (`applicant_id`),
  KEY `IDX_B5DE5F9EBB23766C` (`approver_id`),
  CONSTRAINT `FK_B5DE5F9E97139001` FOREIGN KEY (`applicant_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_B5DE5F9EBB23766C` FOREIGN KEY (`approver_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_B5DE5F9EF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES (1,'2022-09-15 08:03:17',5000,0,NULL,1,NULL,1,5),(2,'2022-09-15 08:04:45',7000,0,NULL,1,NULL,1,5),(3,'2022-09-15 09:04:34',5000,4,NULL,1,NULL,6,1),(4,'2022-09-15 16:41:11',5000,4,NULL,1,NULL,1,5),(5,'2022-09-18 03:04:20',500000,0,NULL,1,NULL,1,5),(6,'2022-09-18 03:28:08',1,0,NULL,1,NULL,1,5),(7,'2022-09-18 03:28:36',10,0,NULL,1,NULL,1,5),(8,'2022-09-18 03:30:31',9,0,NULL,1,NULL,1,5),(9,'2022-09-18 03:30:45',9,0,NULL,1,NULL,1,5),(10,'2022-09-18 03:31:08',10,0,NULL,1,NULL,1,5),(11,'2022-09-18 03:33:05',900,0,NULL,1,NULL,1,5),(12,'2022-09-18 03:39:37',347000,0,NULL,1,NULL,1,5),(13,'2022-09-18 03:45:23',347100,0,NULL,1,NULL,1,5),(14,'2022-09-18 03:50:13',500000,0,NULL,1,NULL,1,5),(15,'2022-09-18 03:50:18',500000,0,NULL,1,NULL,1,5),(16,'2022-09-18 03:52:34',347000,0,NULL,1,NULL,1,5);
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-20 10:14:32
