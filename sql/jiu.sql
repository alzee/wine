-- MariaDB dump 10.19  Distrib 10.6.10-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jiu
-- ------------------------------------------------------
-- Server version	10.6.10-MariaDB-1

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
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_705B37271E36857` (`openid`),
  UNIQUE KEY `UNIQ_705B3727444F97DD` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumer`
--

LOCK TABLES `consumer` WRITE;
/*!40000 ALTER TABLE `consumer` DISABLE KEYS */;
INSERT INTO `consumer` VALUES (1,'111',77000,'王一顾','13211111111',NULL,NULL,NULL),(2,'1111',0,'111','132000',NULL,NULL,NULL),(3,'o855e5Xr-164d3rtJpi51Nedfnf0',0,NULL,NULL,NULL,NULL,NULL),(4,'o855e5Sh95I4i8VNQYaVrTgdNQG0',0,'o855e5Sh',NULL,NULL,NULL,NULL),(5,'o855e5SUjwPANOCYss0txpL0Rz88',0,'o855e5SU',NULL,NULL,NULL,NULL),(6,'o9qqq4n8ZruhaGdLhv5FVkP5DJJ8',0,'o9qqq4n8',NULL,NULL,NULL,NULL),(7,'o9qqq4huIhamZWrdNdFCQCKrgjJs',224765,'姓名1','11111',NULL,NULL,NULL),(8,'o9qqq4kmB55qMS6WVD2bToLQnbDM',399300,'杨英','13866668899',NULL,NULL,NULL),(9,'o9qqq4uPSBq2oi7b64jru8T3nzPg',0,'o9qqq4uP',NULL,NULL,NULL,NULL),(10,'o9qqq4vMg2e5QeeD3wLsvU56pqcg',0,'刘马','13971911217',NULL,NULL,NULL),(11,'o9qqq4oC2FIsE9nLyGCP_4LD25Tk',0,'左佑','13545034354',NULL,NULL,NULL),(12,'o9qqq4nrji6c6TtCF_l0X4HWPnrM',2000,'彭正华','18772515971',NULL,NULL,NULL),(13,'o9qqq4hDFLCrz_Z1NkbnWN2O6rYk',50000,'王希兵','13733591301',NULL,NULL,NULL),(14,'o9qqq4k-FORhO_VpXk9JU1NfWViU',0,'徐勤林','18772953311',NULL,NULL,NULL),(15,'o9qqq4kpxtrnQNBNI1pZX9UNfTas',0,'董军浩','15623842378',NULL,NULL,NULL),(16,'o9qqq4tOixGLq4iARzji63RJjDUw',56100,'汪桂芬','13797833728',NULL,NULL,NULL),(17,'o9qqq4icYSN-_fJpwQ5pXCfSWWWI',75000,'jds','13960289285',NULL,NULL,NULL),(18,'o9qqq4uWI93ARCk7k49w-S06G7GQ',0,'文裕6138','18671976138',NULL,NULL,NULL),(19,'o9qqq4o-CeaEwufVuPbv8b1ieiz8',30000,'张红云','13297155180',NULL,NULL,NULL),(20,'o9qqq4vPiOMnwVunzDuJ66-DJ6K0',0,'张红','15871092005',NULL,NULL,NULL),(21,'o9qqq4rTfzr-YNh29f3KvoNRypKw',0,'黄琴','13085260668',NULL,NULL,NULL),(22,'o9qqq4rwUCe8ln-Sv1qO8M76FhsA',0,'o9qqq4rw',NULL,NULL,NULL,NULL),(23,'o9qqq4ieEmuKdnjuMdwAhHJfgWaQ',0,'o9qqq4ie',NULL,NULL,NULL,NULL),(24,'o9qqq4uR3M2pcFuFCr16tuI6rl74',0,'o9qqq4uR',NULL,NULL,NULL,NULL),(25,'o9qqq4s2A__glqsxFTce_5vugjZ4',0,'程玮萌','17740504029',NULL,NULL,NULL);
/*!40000 ALTER TABLE `consumer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220905032624','2022-09-06 08:44:42',98),('DoctrineMigrations\\Version20220905034646','2022-09-06 08:44:42',22),('DoctrineMigrations\\Version20220905034844','2022-09-06 08:44:43',26),('DoctrineMigrations\\Version20220905035935','2022-09-06 08:44:43',144),('DoctrineMigrations\\Version20220905040247','2022-09-06 08:44:43',48),('DoctrineMigrations\\Version20220905040757','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041124','2022-09-06 08:44:43',24),('DoctrineMigrations\\Version20220905041645','2022-09-06 08:44:43',92),('DoctrineMigrations\\Version20220905042134','2022-09-06 08:44:43',94),('DoctrineMigrations\\Version20220905042511','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905042659','2022-09-06 08:44:43',20),('DoctrineMigrations\\Version20220905043004','2022-09-06 08:44:43',11),('DoctrineMigrations\\Version20220905043638','2022-09-06 08:44:43',199),('DoctrineMigrations\\Version20220905043837','2022-09-06 08:44:43',177),('DoctrineMigrations\\Version20220905044029','2022-09-06 08:44:43',172),('DoctrineMigrations\\Version20220905044154','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906030233','2022-09-06 08:44:44',23),('DoctrineMigrations\\Version20220906030331','2022-09-06 08:44:44',9),('DoctrineMigrations\\Version20220906032412','2022-09-06 08:44:44',8),('DoctrineMigrations\\Version20220906034230','2022-09-06 08:44:44',13),('DoctrineMigrations\\Version20220906044555','2022-09-06 08:44:44',10),('DoctrineMigrations\\Version20220906052433','2022-09-06 08:44:44',70),('DoctrineMigrations\\Version20220906074723','2022-09-06 08:44:44',25),('DoctrineMigrations\\Version20220906080145','2022-09-06 08:44:44',20),('DoctrineMigrations\\Version20220906081528','2022-09-06 08:44:44',248),('DoctrineMigrations\\Version20220906082840','2022-09-06 08:44:44',247),('DoctrineMigrations\\Version20220906083319','2022-09-06 08:44:44',132),('DoctrineMigrations\\Version20220906111008','2022-09-06 11:10:12',58),('DoctrineMigrations\\Version20220906112856','2022-09-06 11:28:58',55),('DoctrineMigrations\\Version20220906113057','2022-09-06 11:30:58',157),('DoctrineMigrations\\Version20220906113840','2022-09-06 11:38:41',148),('DoctrineMigrations\\Version20220906114120','2022-09-06 11:41:21',57),('DoctrineMigrations\\Version20220906115333','2022-09-06 11:53:35',57),('DoctrineMigrations\\Version20220906120020','2022-09-06 12:00:21',141),('DoctrineMigrations\\Version20220906120335','2022-09-06 12:03:37',56),('DoctrineMigrations\\Version20220906120912','2022-09-06 12:09:13',73),('DoctrineMigrations\\Version20220906143539','2022-09-06 14:35:40',88),('DoctrineMigrations\\Version20220906143722','2022-09-06 14:37:23',157),('DoctrineMigrations\\Version20220906144624','2022-09-06 14:46:25',97),('DoctrineMigrations\\Version20220906145231','2022-09-06 14:52:32',161),('DoctrineMigrations\\Version20220906145806','2022-09-06 14:58:08',126),('DoctrineMigrations\\Version20220906153137','2022-09-06 15:31:39',73),('DoctrineMigrations\\Version20220906162721','2022-09-06 16:27:22',153),('DoctrineMigrations\\Version20220906182338','2022-09-06 18:23:39',57),('DoctrineMigrations\\Version20220907141027','2022-09-07 14:10:29',126),('DoctrineMigrations\\Version20220907141920','2022-09-07 14:19:21',189),('DoctrineMigrations\\Version20220907145621','2022-09-07 14:56:22',272),('DoctrineMigrations\\Version20220907152801','2022-09-07 15:28:02',206),('DoctrineMigrations\\Version20220913072842','2022-09-14 00:29:01',74),('DoctrineMigrations\\Version20220913094839','2022-09-14 00:29:01',4),('DoctrineMigrations\\Version20220913102501','2022-09-14 00:29:01',29),('DoctrineMigrations\\Version20220914005419','2022-09-14 00:54:21',55),('DoctrineMigrations\\Version20220914100935','2022-09-15 00:50:35',92),('DoctrineMigrations\\Version20220914103307','2022-09-15 00:50:35',30),('DoctrineMigrations\\Version20220914123056','2022-09-15 00:50:35',3),('DoctrineMigrations\\Version20220915013706','2022-09-15 01:37:25',68),('DoctrineMigrations\\Version20220915073043','2022-09-15 07:59:47',282),('DoctrineMigrations\\Version20220915080140','2022-09-15 08:01:45',106),('DoctrineMigrations\\Version20220915092811','2022-09-15 09:28:18',78),('DoctrineMigrations\\Version20220915093205','2022-09-15 09:32:07',101),('DoctrineMigrations\\Version20220915094641','2022-09-15 09:46:49',273),('DoctrineMigrations\\Version20220915161230','2022-09-15 16:12:39',56),('DoctrineMigrations\\Version20220915161635','2022-09-15 16:16:42',86),('DoctrineMigrations\\Version20220916004730','2022-09-16 00:47:37',124),('DoctrineMigrations\\Version20220916015129','2022-09-16 01:51:36',64),('DoctrineMigrations\\Version20220916025255','2022-09-16 02:53:14',67),('DoctrineMigrations\\Version20220916030956','2022-09-16 03:10:04',90),('DoctrineMigrations\\Version20220916093835','2022-09-16 09:40:54',63),('DoctrineMigrations\\Version20220917100338','2022-09-17 10:03:53',78),('DoctrineMigrations\\Version20220917143941','2022-09-17 14:40:14',77),('DoctrineMigrations\\Version20220917235726','2022-09-17 23:58:05',139),('DoctrineMigrations\\Version20220918000329','2022-09-18 00:03:40',132),('DoctrineMigrations\\Version20220918002720','2022-09-18 00:27:36',1129),('DoctrineMigrations\\Version20220918023241','2022-09-18 02:33:06',75),('DoctrineMigrations\\Version20220918063801','2022-09-18 06:39:59',79),('DoctrineMigrations\\Version20220918065856','2022-09-18 06:59:01',60),('DoctrineMigrations\\Version20220920021307','2022-09-20 02:13:10',60),('DoctrineMigrations\\Version20220920062011','2022-09-20 06:20:19',115),('DoctrineMigrations\\Version20220920062457','2022-09-20 06:25:19',80),('DoctrineMigrations\\Version20220920100845','2022-09-20 10:09:02',65),('DoctrineMigrations\\Version20220920101640','2022-09-20 10:17:36',86),('DoctrineMigrations\\Version20220921025953','2022-09-21 03:00:11',73),('DoctrineMigrations\\Version20220926133141','2022-09-26 22:07:18',28),('DoctrineMigrations\\Version20220928080207','2022-09-28 18:35:28',25),('DoctrineMigrations\\Version20220929010236','2022-09-29 14:44:39',38),('DoctrineMigrations\\Version20220929134157','2022-09-29 21:54:18',30),('DoctrineMigrations\\Version20220929140237','2022-09-29 22:03:47',21),('DoctrineMigrations\\Version20220930021048','2022-09-30 10:28:39',55),('DoctrineMigrations\\Version20221004021625','2022-10-04 12:32:31',23),('DoctrineMigrations\\Version20221004034859','2022-10-04 12:32:31',22),('DoctrineMigrations\\Version20221005080222','2022-10-05 16:47:12',23),('DoctrineMigrations\\Version20221005090108','2022-10-05 17:03:50',20),('DoctrineMigrations\\Version20221007050245','2022-10-07 13:03:56',132);
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
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node`
--

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` VALUES (1,'剑南老窖窖龄酒(30)','<div>剑南老窖窖龄酒(30)<br><br></div><div>剑南系列美酒是精品白酒中的性价比代表，卓尔不群的产品品质，独特协调的风味，窖香浓郁，尾净悠长，味觉层次丰富，彰显中档白酒的高雅气度，是白酒产品中的珍品。</div><div><br></div><div>原料： 水、高粱、大米、糯米、小麦、玉米&nbsp; &nbsp;&nbsp;</div><div>产品标准号：Q/JNC0003S（一级）</div><div>净含量：500ml</div><div>酒精度：52%(vol)、46%(vol)、42%(vol)、38%(vol)&nbsp;</div>',0,'2022-09-18 06:50:46','22.jpg',NULL),(2,'剑南老窖窖龄酒(60)','<div>剑南老窖窖龄酒(60)<br><br></div><div>剑南系列美酒是精品白酒中的性价比代表，卓尔不群的产品品质，独特协调的风味，窖香浓郁，尾净悠长，味觉层次丰富，彰显中档白酒的高雅气度，是白酒产品中的珍品。</div><div><br></div><div>原料： 水、高粱、大米、糯米、小麦、玉米&nbsp; &nbsp;&nbsp;</div><div>产品标准号：Q/JNC0003S（优级）</div><div>净含量：500ml</div><div>酒精度：52%(vol)、46%(vol)、42%(vol)、38%(vol)&nbsp;</div><div><br><br></div>',0,'2022-09-18 07:07:14','11.jpg',NULL),(3,'剑南老窖窖龄酒(收藏版)','<div>剑南老窖窖龄酒(收藏版)<br><br></div><div>剑南系列美酒是精品白酒中的性价比代表，卓尔不群的产品品质，独特协调的风味，窖香浓郁，尾净悠长，味觉层次丰富，彰显中档白酒的高雅气度，是白酒产品中的珍品。</div><div><br></div><div>原料： 水、高粱、大米、糯米、小麦、玉米&nbsp; &nbsp;&nbsp;</div><div>产品标准号：Q/JNC0003S（优级）</div><div>净含量：500ml</div><div>酒精度：52%(vol)、46%(vol)、42%(vol)、38%(vol)&nbsp;</div><div><br><br></div>',0,'2022-09-18 09:38:23','33.jpg',NULL),(4,'你买酒 我请客','<div>你买酒 我请客<br>购42°剑南老窖窖龄60 一件 送价值500元餐券。</div>',1,'2022-09-18 09:39:13','111.png',NULL),(5,'剑南老窖','<div>购 42度剑南老窖窖龄30年一件&nbsp; 送专柜价2980元依波手表1支<br><br></div>',1,'2022-09-18 09:39:23','222.jpg',NULL);
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
  `ord_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62809DB04584665A` (`product_id`),
  KEY `IDX_62809DB0E636D3F5` (`ord_id`),
  CONSTRAINT `FK_62809DB04584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_62809DB0E636D3F5` FOREIGN KEY (`ord_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
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
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_restaurant`
--

LOCK TABLES `order_restaurant` WRITE;
/*!40000 ALTER TABLE `order_restaurant` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
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
  `withdrawable` int(10) unsigned NOT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `withdrawing` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7215BA80245F9855` (`upstream_id`),
  CONSTRAINT `FK_7215BA80245F9855` FOREIGN KEY (`upstream_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org`
--

LOCK TABLES `org` WRITE;
/*!40000 ALTER TABLE `org` DISABLE KEYS */;
INSERT INTO `org` VALUES (1,'代理商1号','王一代','131111111','代理商1号地址','代理商1号区域',1,0,5,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(2,'代理商2号','王二代','13111111111','代理商2号地址','代理商2号区域',1,0,5,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(3,'门店1号','王一店','13111111111','山西路12号','门店1号区域',2,0,1,0,0,110.79801,32.62918,'s1.jpg','2022-10-04 15:49:05',0),(4,'门店2号','王二店','13111111111','万达三楼','门店2号区域',2,0,2,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(5,'总公司','王总','1311111110','总部地址','总部区域',0,4242427295,NULL,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(6,'餐厅1号','王一餐','1311111158','五堰商场负一楼','餐厅1号区域',3,0,1,0.95,0,110.78305908203,32.639387749566,'s1.jpg',NULL,0),(7,'顾客','王一代','+8613207262011','No. 10','代理商1号区域',4,0,NULL,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(8,'代理商3号','王三代','13111111111','代理商3号地址','代理商3号区域',1,0,5,0,0,110.79801,32.62918,'s1.jpg',NULL,0),(9,'代理商4号','t1','1','t1','t1',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(10,'餐厅2号','1','1','解放大道','1',3,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(11,'门店3号','1','1','万秀城','1',2,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(12,'门店4号','111','111','香港街18号','111',2,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(13,'代理商5号','11','11','11','11',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(14,'门店5号','s2111','11','深圳街34号','11',2,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(15,'郧阳老酒库','王总','135666688888','测试地址','郧阳区',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(16,'新合作商店','李总','13655558888','郧阳区城关镇5号','郧阳区',2,0,15,1,0,110.79801,32.62918,'s1.jpg',NULL,0),(17,'土厨','李总','13244446666','天津路116号','茅箭区',3,0,15,0.8,0,110.80163872613,32.625829264323,'s1.jpg',NULL,0),(18,'代理商测试1','1','1','1','1',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(19,'代理商测试2','1','1','1','1',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(20,'代理商测试2','代理商测试2','52','代理商测试2','代理商测试2',1,0,5,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(21,'九头鸟东岳路店','1','1','东岳路17号','1',3,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(22,'武商量贩','1','1','人民北路28号','1',2,0,1,0.95,0,32.625821126302,110.80163384332,'s1.jpg',NULL,0),(23,'老酒库直营部','老酒库','15871092005','京广中心老酒库','十堰城区',1,0,5,0.95,0,32.625821126302,110.80163384332,'s1.jpg',NULL,0),(24,'大洋酒店','王总','136555555','大洋五洲','天津路',3,0,23,0.9,0,110.801902398,32.626060926649,'s1.jpg',NULL,0),(25,'汪桂芬','汪桂芬','13797833728','京广中心','十堰',2,0,23,1,0,110.80164469401,32.625818142361,'s1.jpg',NULL,0),(26,'福润酒店','程燕','13387131991','火车站北广场','十堰城区',3,0,23,1,0,32.625821126302,110.80163384332,'e08ebeb88105e4895abcdf9951661c3.jpg','2022-10-05 16:13:28',0);
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
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn_org` (`sn`,`org_id`),
  KEY `IDX_D34A04ADF4837C1B` (`org_id`),
  CONSTRAINT `FK_D34A04ADF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'五粮液10年-测试','500mlx6',500000,20,'11111',50000,5,'wuliangye.jpg','2022-10-04 16:20:12'),(2,'白云边12年','500mlx6',100000,102,'11112',10000,5,'baiyunbian.jpg','2022-10-04 16:19:12'),(28,'42°剑南老窖-窖龄60','1X6',180000,-523,'12345',50000,5,'11.jpg',NULL),(41,'52°剑南老窖-窖龄60','500ML*6',200000,10000,'1002.02',50000,5,NULL,NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail`
--

LOCK TABLES `retail` WRITE;
/*!40000 ALTER TABLE `retail` DISABLE KEYS */;
/*!40000 ALTER TABLE `retail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retail_return`
--

DROP TABLE IF EXISTS `retail_return`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retail_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `voucher` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A1B65F93B092A811` (`store_id`),
  KEY `IDX_A1B65F9337FDBD6D` (`consumer_id`),
  KEY `IDX_A1B65F934584665A` (`product_id`),
  CONSTRAINT `FK_A1B65F9337FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_A1B65F934584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_A1B65F93B092A811` FOREIGN KEY (`store_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail_return`
--

LOCK TABLES `retail_return` WRITE;
/*!40000 ALTER TABLE `retail_return` DISABLE KEYS */;
/*!40000 ALTER TABLE `retail_return` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_items`
--

DROP TABLE IF EXISTS `return_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ret_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_38A94521DBA7DEBD` (`ret_id`),
  KEY `IDX_38A945214584665A` (`product_id`),
  CONSTRAINT `FK_38A945214584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_38A94521DBA7DEBD` FOREIGN KEY (`ret_id`) REFERENCES `returns` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_items`
--

LOCK TABLES `return_items` WRITE;
/*!40000 ALTER TABLE `return_items` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scan`
--

DROP TABLE IF EXISTS `scan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consumer_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `rand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4B3B3AE37FDBD6D` (`consumer_id`),
  KEY `IDX_C4B3B3AEF4837C1B` (`org_id`),
  CONSTRAINT `FK_C4B3B3AE37FDBD6D` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`),
  CONSTRAINT `FK_C4B3B3AEF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scan`
--

LOCK TABLES `scan` WRITE;
/*!40000 ALTER TABLE `scan` DISABLE KEYS */;
/*!40000 ALTER TABLE `scan` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (6,'u4','[\"ROLE_RESTAURANT\"]','sdfg',6,NULL),(7,'u6','[\"ROLE_STORE\"]','sdafas',4,NULL),(9,'admin','[\"ROLE_HEAD\", \"ROLE_ADMIN\"]','$2y$13$6eWONnmy7sz4qPKWu7.0Z.QGboS/uyCRS2n/sicq/R4ukBdiVIkxW',5,NULL),(13,'s1','[\"ROLE_STORE\"]','$2y$13$dbHC6AGEuX3IQVl/nCQ5auJrD444QSwFPFVlyZ2qDZh6wW4YdUq/i',3,NULL),(14,'r1','[\"ROLE_RESTAURANT\"]','$2y$13$2Qv96WX3LXzwvlIL5JtzGetghjvo/hRSQ72TieeltmXOHRtSTtYMi',6,NULL),(15,'h1','[\"ROLE_HEAD\"]','$2y$13$RWxYfcuFFxM5.wXVrniE5OI96dlx2NGMVaraJrl0akRc92y1kJojG',5,NULL),(24,'xinhezuo','[\"ROLE_STORE\"]','$2y$13$zfsvdnAkEySgyIabJ4hVn.uRZNwfH1CN3YXacy6edSyO3rU7qbWq2',16,NULL),(25,'tuchu','[\"ROLE_RESTAURANT\"]','$2y$13$UwDh8.fCvwCUQXwe2F5D9eWXqD79WozGGA7yyfjiCfRMLUqLGc.n2',17,NULL),(27,'ljk','[\"ROLE_AGENCY\"]','$2y$13$2Vc0IMuLuGmhaS2rBsKIp.JF2KlZsDqMnHBBRWGfiL7PippmG91i2',23,NULL),(28,'dayang','[\"ROLE_RESTAURANT\"]','$2y$13$ikK65j3uOZeexngZAMNAK.Hbyf1LVliEVWqRIPJJtDGxz22tnOQXG',24,NULL),(29,'wgf','[\"ROLE_STORE\"]','$2y$13$2zIYAVWCnszbOAS2n/usUumDriqhmVgUDSYLs1Y9JCmazMGK6ztkq',25,NULL),(30,'dsx','[\"ROLE_STORE\"]','$2y$13$k3ugZP5xlJaD1Y2vx803ouqcQ8MWnyyzoqPismg54dN/rqhbvJXuK',25,NULL),(31,'湖北老酒库','[\"ROLE_HEAD\"]','$2y$13$sqrk/YH3qZlBDTiqSCmBLOVVAOD0oi214oTcgwdwnQeXCbaSRbf1u',5,NULL),(34,'a13387131991','[\"ROLE_RESTAURANT\"]','$2y$13$D4yDORAebUuRlYGJHnwRm.hdkVwciNJR2AaF6BTwEVj/hircKOg2G',26,NULL),(35,'13655558888','[\"ROLE_AGENCY\"]','$2y$13$osnbJlFIbpv3sxJnncyGOOK6psZHLYMmtzgycnGFwVepe72WLnBOO',1,NULL),(36,'aaa','[\"ROLE_AGENCY\"]','$2y$13$rcsl52QlgLDs9gBUEwR7jOC/viCayvWusTqRTF6KxdcEPFVIeQldq',15,NULL),(37,'a1','[\"ROLE_AGENCY\"]','$2y$13$dGfilSQeO.86X6aSqWtcWOtRTfC8FszyGDwqeOSqD29FN8ifI/v8e',1,NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher`
--

LOCK TABLES `voucher` WRITE;
/*!40000 ALTER TABLE `voucher` DISABLE KEYS */;
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
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicant_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `actual_amount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5DE5F9EF4837C1B` (`org_id`),
  KEY `IDX_B5DE5F9E97139001` (`applicant_id`),
  KEY `IDX_B5DE5F9EBB23766C` (`approver_id`),
  CONSTRAINT `FK_B5DE5F9E97139001` FOREIGN KEY (`applicant_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_B5DE5F9EBB23766C` FOREIGN KEY (`approver_id`) REFERENCES `org` (`id`),
  CONSTRAINT `FK_B5DE5F9EF4837C1B` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
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

-- Dump completed on 2022-10-07 14:35:39
