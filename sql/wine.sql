-- MariaDB dump 10.19  Distrib 10.5.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: wine1
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
-- Table structure for table `agency`
--

DROP TABLE IF EXISTS `agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agency`
--

LOCK TABLES `agency` WRITE;
/*!40000 ALTER TABLE `agency` DISABLE KEYS */;
/*!40000 ALTER TABLE `agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumer`
--

DROP TABLE IF EXISTS `consumer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumer`
--

LOCK TABLES `consumer` WRITE;
/*!40000 ALTER TABLE `consumer` DISABLE KEYS */;
INSERT INTO `consumer` VALUES (1,'111',58000);
/*!40000 ALTER TABLE `consumer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dealer`
--

DROP TABLE IF EXISTS `dealer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dealer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dealer`
--

LOCK TABLES `dealer` WRITE;
/*!40000 ALTER TABLE `dealer` DISABLE KEYS */;
/*!40000 ALTER TABLE `dealer` ENABLE KEYS */;
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
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220905032624','2022-09-06 08:44:42',98),('DoctrineMigrations\\Version20220905034646','2022-09-06 08:44:42',22),('DoctrineMigrations\\Version20220905034844','2022-09-06 08:44:43',26),('DoctrineMigrations\\Version20220905035935','2022-09-06 08:44:43',144),('DoctrineMigrations\\Version20220905040247','2022-09-06 08:44:43',48),('DoctrineMigrations\\Version20220905040757','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041124','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041645','2022-09-06 08:44:43',92),('DoctrineMigrations\\Version20220905042134','2022-09-06 08:44:43',94),('DoctrineMigrations\\Version20220905042511','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905042659','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905043004','2022-09-06 08:44:43',11),('DoctrineMigrations\\Version20220905043638','2022-09-06 08:44:43',199),('DoctrineMigrations\\Version20220905043837','2022-09-06 08:44:43',177),('DoctrineMigrations\\Version20220905044029','2022-09-06 08:44:43',172),('DoctrineMigrations\\Version20220905044154','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906030233','2022-09-06 08:44:44',23),('DoctrineMigrations\\Version20220906030331','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906032412','2022-09-06 08:44:44',8),('DoctrineMigrations\\Version20220906034230','2022-09-06 08:44:44',13),('DoctrineMigrations\\Version20220906044555','2022-09-06 08:44:44',10),('DoctrineMigrations\\Version20220906052433','2022-09-06 08:44:44',70),('DoctrineMigrations\\Version20220906074723','2022-09-06 08:44:44',25),('DoctrineMigrations\\Version20220906080145','2022-09-06 08:44:44',20),('DoctrineMigrations\\Version20220906081528','2022-09-06 08:44:44',248),('DoctrineMigrations\\Version20220906082840','2022-09-06 08:44:44',247),('DoctrineMigrations\\Version20220906083319','2022-09-06 08:44:44',132),('DoctrineMigrations\\Version20220906111008','2022-09-06 11:10:12',58),('DoctrineMigrations\\Version20220906112856','2022-09-06 11:28:58',55),('DoctrineMigrations\\Version20220906113057','2022-09-06 11:30:58',157),('DoctrineMigrations\\Version20220906113840','2022-09-06 11:38:41',148),('DoctrineMigrations\\Version20220906114120','2022-09-06 11:41:21',57),('DoctrineMigrations\\Version20220906115333','2022-09-06 11:53:35',57),('DoctrineMigrations\\Version20220906120020','2022-09-06 12:00:21',141),('DoctrineMigrations\\Version20220906120335','2022-09-06 12:03:37',56),('DoctrineMigrations\\Version20220906120912','2022-09-06 12:09:13',73),('DoctrineMigrations\\Version20220906143539','2022-09-06 14:35:40',88),('DoctrineMigrations\\Version20220906143722','2022-09-06 14:37:23',157),('DoctrineMigrations\\Version20220906144624','2022-09-06 14:46:25',97),('DoctrineMigrations\\Version20220906145231','2022-09-06 14:52:32',161),('DoctrineMigrations\\Version20220906145806','2022-09-06 14:58:08',126),('DoctrineMigrations\\Version20220906153137','2022-09-06 15:31:39',73),('DoctrineMigrations\\Version20220906162721','2022-09-06 16:27:22',153),('DoctrineMigrations\\Version20220906182338','2022-09-06 18:23:39',57),('DoctrineMigrations\\Version20220907141027','2022-09-07 14:10:29',126),('DoctrineMigrations\\Version20220907141920','2022-09-07 14:19:21',189),('DoctrineMigrations\\Version20220907145621','2022-09-07 14:56:22',272),('DoctrineMigrations\\Version20220907152801','2022-09-07 15:28:02',206);
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
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398CDEADB2A` (`agency_id`),
  KEY `IDX_F52993984584665A` (`product_id`),
  CONSTRAINT `FK_F52993984584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_F5299398CDEADB2A` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_agency`
--

DROP TABLE IF EXISTS `order_agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B34FD633B092A811` (`store_id`),
  CONSTRAINT `FK_B34FD633B092A811` FOREIGN KEY (`store_id`) REFERENCES `store` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_agency`
--

LOCK TABLES `order_agency` WRITE;
/*!40000 ALTER TABLE `order_agency` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_agency` ENABLE KEYS */;
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
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `voucher` int(11) NOT NULL,
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
-- Table structure for table `order_store`
--

DROP TABLE IF EXISTS `order_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC92C8AB1E7706E` (`restaurant_id`),
  CONSTRAINT `FK_7CC92C8AB1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_store`
--

LOCK TABLES `order_store` WRITE;
/*!40000 ALTER TABLE `order_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_store` ENABLE KEYS */;
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
  `product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `amount` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E52FFDEE8DE820D9` (`seller_id`),
  KEY `IDX_E52FFDEE6C755722` (`buyer_id`),
  KEY `IDX_E52FFDEE4584665A` (`product_id`),
  CONSTRAINT `FK_E52FFDEE4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_E52FFDEE6C755722` FOREIGN KEY (`buyer_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_E52FFDEE8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,1,1,2,10000,1000,1,5,'2022-09-06 09:17:17',NULL),(2,1,3,3,1,1000,500,2,5,'2022-09-06 11:05:35',NULL),(3,5,1,1,1,1000,500,1,5,'2022-09-06 11:13:16',NULL),(4,5,2,2,1,50000,5000,1,5,'2022-09-06 17:03:01',NULL),(5,5,2,2,1,50000,5000,1,5,'2022-09-06 17:04:48',NULL),(6,5,2,1,1,500000,50000,1,5,'2022-09-06 17:20:26',NULL);
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
  `voucher` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org`
--

LOCK TABLES `org` WRITE;
/*!40000 ALTER TABLE `org` DISABLE KEYS */;
INSERT INTO `org` VALUES (1,'代理商1号','王一代','131111111','代理商1号地址','代理商1号区域',1,2450),(2,'代理商2号','王二代','13111111111','代理商2号地址','代理商2号区域',1,5000),(3,'门店1号','王一店','13111111111','门店1号地址','门店1号区域',2,50000),(4,'门店2号','王二店','13111111111','门店2号地址','门店2号区域',2,0),(5,'总公司','王总','13111111111','总部地址','总部区域',0,-10000),(6,'餐厅1号','王一餐','13111111111','餐厅1号地址','餐厅1号区域',3,3500),(7,'顾客','王一代','+8613207262011','No. 10','代理商1号区域',4,0);
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
  `price` int(11) NOT NULL,
  `stock` smallint(6) NOT NULL,
  `sn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher` smallint(6) NOT NULL,
  `org_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04ADF4837C1B` (`org_id`),
  CONSTRAINT `FK_D34A04ADF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'五粮液10年','500mlx6',5000,47,'11111',500,5),(2,'白云边12年','500mlx6',500,98,'11112',50,5),(3,'五粮液10年','500mlx6',5000,3,'11111',500,1),(4,'五粮液10年','500mlx6',5000,1,'11111',500,3),(5,'白云边12年','500mlx6',500,2,'11112',50,2),(6,'五粮液10年','500mlx6',5000,0,'11111',500,2);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_agency`
--

DROP TABLE IF EXISTS `product_agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12BC8742CDEADB2A` (`agency_id`),
  KEY `IDX_12BC87424584665A` (`product_id`),
  CONSTRAINT `FK_12BC87424584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_12BC8742CDEADB2A` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_agency`
--

LOCK TABLES `product_agency` WRITE;
/*!40000 ALTER TABLE `product_agency` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_restaurant`
--

DROP TABLE IF EXISTS `product_restaurant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_78F24D14B1E7706E` (`restaurant_id`),
  KEY `IDX_78F24D144584665A` (`product_id`),
  CONSTRAINT `FK_78F24D144584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_78F24D14B1E7706E` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_restaurant`
--

LOCK TABLES `product_restaurant` WRITE;
/*!40000 ALTER TABLE `product_restaurant` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_restaurant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_store`
--

DROP TABLE IF EXISTS `product_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E0B232BB092A811` (`store_id`),
  KEY `IDX_5E0B232B4584665A` (`product_id`),
  CONSTRAINT `FK_5E0B232B4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_5E0B232BB092A811` FOREIGN KEY (`store_id`) REFERENCES `store` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_store`
--

LOCK TABLES `product_store` WRITE;
/*!40000 ALTER TABLE `product_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant`
--

LOCK TABLES `restaurant` WRITE;
/*!40000 ALTER TABLE `restaurant` DISABLE KEYS */;
INSERT INTO `restaurant` VALUES (1,'餐厅1号','王一餐','13111111','餐厅一号地址',50);
/*!40000 ALTER TABLE `restaurant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retail`
--

DROP TABLE IF EXISTS `retail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` smallint(6) NOT NULL,
  `amount` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB899E15B092A811` (`store_id`),
  KEY `IDX_FB899E1537FDBD6D` (`consumer_id`),
  KEY `IDX_FB899E154584665A` (`product_id`),
  CONSTRAINT `FK_FB899E1537FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_FB899E154584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_FB899E15B092A811` FOREIGN KEY (`store_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail`
--

LOCK TABLES `retail` WRITE;
/*!40000 ALTER TABLE `retail` DISABLE KEYS */;
INSERT INTO `retail` VALUES (1,4,1,1,1,10000,5000),(3,3,1,4,1,500000,50000);
/*!40000 ALTER TABLE `retail` ENABLE KEYS */;
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
  `product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `amount` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B164CA5F624B39D` (`sender_id`),
  KEY `IDX_8B164CA5E92F8F78` (`recipient_id`),
  KEY `IDX_8B164CA54584665A` (`product_id`),
  CONSTRAINT `FK_8B164CA54584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_8B164CA5E92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_8B164CA5F624B39D` FOREIGN KEY (`sender_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` VALUES (1,3,1,4,1,1000,500,5,'2022-09-06 15:32:17',NULL),(2,2,5,6,1,500000,50000,5,'2022-09-06 17:27:53',NULL);
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  KEY `IDX_8D93D649F4837C1B` (`org_id`),
  CONSTRAINT `FK_8D93D649F4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'u1','[]','89jjj',1),(3,'u2','[\"ROLE_AGENCY\"]','asdfaf',1),(4,'u3','[\"ROLE_HEAD\"]','sadf',5),(6,'u4','[\"ROLE_RESTAURANT\"]','sdfg',6),(7,'u6','[\"ROLE_STORE\"]','sdafas',4),(8,'u7','[\"ROLE_AGENCY\"]','111',1),(9,'admin','[\"ROLE_HEAD\", \"ROLE_ADMIN\"]','$2y$13$6eWONnmy7sz4qPKWu7.0Z.QGboS/uyCRS2n/sicq/R4ukBdiVIkxW',5);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher`
--

LOCK TABLES `voucher` WRITE;
/*!40000 ALTER TABLE `voucher` DISABLE KEYS */;
INSERT INTO `voucher` VALUES (1,1,6,5000,'2022-09-06 16:41:57',NULL,NULL),(2,10,5,-5000,'2022-09-06 17:03:50',NULL,NULL),(3,0,5,5000,'2022-09-06 17:03:50',NULL,NULL),(4,10,5,-5000,'2022-09-06 17:04:59',NULL,NULL),(5,0,2,5000,'2022-09-06 17:04:59',NULL,NULL),(6,10,5,-50000,'2022-09-06 17:20:56',NULL,NULL),(7,0,2,50000,'2022-09-06 17:20:56',NULL,NULL),(8,12,2,-50000,'2022-09-06 17:28:45',NULL,NULL),(9,2,5,50000,'2022-09-06 17:28:45',NULL,NULL),(10,14,2,-5000,'2022-09-06 17:39:16',NULL,NULL),(11,16,7,-1500,'2022-09-07 14:38:12',NULL,1),(12,6,1,1500,'2022-09-07 14:38:12',NULL,NULL),(13,16,7,-1500,'2022-09-07 14:41:41',NULL,1),(14,6,6,1500,'2022-09-07 14:41:41',NULL,NULL),(15,16,7,-2000,'2022-09-07 14:46:37',NULL,1),(16,6,6,2000,'2022-09-07 14:46:37',NULL,NULL),(17,17,3,-50000,'2022-09-07 15:19:01',NULL,NULL),(18,7,7,50000,'2022-09-07 15:19:01',NULL,1);
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
  `amount` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `org_id` int(11) NOT NULL,
  `discount` double NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5DE5F9EF4837C1B` (`org_id`),
  CONSTRAINT `FK_B5DE5F9EF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES (1,'2022-09-06 14:52:48',50,5,1,1,NULL),(2,'2022-09-06 14:53:22',30,5,6,0.9,NULL),(3,'2022-09-06 17:37:49',5000,5,2,1,NULL);
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

-- Dump completed on 2022-09-08  0:59:20
