-- MariaDB dump 10.19  Distrib 10.6.10-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: wine
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,7,1,555),(2,8,1,5),(3,9,2,5),(4,9,1,5),(5,9,2,5),(6,12,3,5),(7,12,3,5),(8,1,3,1),(9,3,1,2),(10,15,1,5),(11,15,2,5),(12,16,3,2),(13,16,8,2),(14,17,3,1),(15,18,1,1),(16,19,1,1),(17,20,3,1),(18,22,3,1),(19,23,1,0),(20,24,1,1),(21,25,1,5),(22,26,3,1),(23,27,8,1),(24,27,3,1),(25,28,2,5),(26,29,28,5),(27,30,1,2),(28,30,28,2),(29,31,29,3),(30,32,29,3),(31,33,30,2),(32,34,1,1),(33,35,1,5),(34,36,28,50),(35,37,28,10),(36,38,30,3),(37,39,30,5),(38,40,29,2),(39,41,1,5),(40,42,1,1),(41,43,1,2),(42,44,30,1),(43,45,1,8),(44,46,30,3),(45,47,30,2),(46,48,30,3),(47,49,1,4),(48,50,30,3),(49,51,30,1),(50,52,28,20),(51,53,37,10),(52,54,37,10),(53,NULL,37,10),(54,56,28,1000),(55,57,28,5),(56,58,37,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_restaurant`
--

LOCK TABLES `order_restaurant` WRITE;
/*!40000 ALTER TABLE `order_restaurant` DISABLE KEYS */;
INSERT INTO `order_restaurant` VALUES (1,'123',100,'2022-09-06 14:37:56',50,1,6,NULL),(2,'124',100,'2022-09-06 14:43:54',30,1,6,NULL),(3,'125',10000,'2022-09-07 14:38:12',1500,1,1,'111'),(4,'126',10000,'2022-09-07 14:41:40',1500,1,6,NULL),(5,'113',10000,'2022-09-07 14:46:37',2000,1,6,'safas'),(6,NULL,NULL,'2022-09-20 10:19:17',100,1,6,NULL),(7,NULL,NULL,'2022-09-20 10:20:09',100,1,6,NULL),(8,NULL,NULL,'2022-09-21 16:12:00',30000,1,17,NULL),(9,NULL,NULL,'2022-09-28 17:53:34',21800,1,17,NULL),(10,NULL,NULL,'2022-09-30 10:51:01',5,7,6,NULL),(11,NULL,NULL,'2022-09-30 12:31:32',135,7,17,NULL),(12,NULL,NULL,'2022-09-30 18:35:07',5000,7,6,NULL),(13,NULL,NULL,'2022-09-30 20:58:10',12900,8,17,NULL),(14,NULL,NULL,'2022-09-30 21:08:58',13600,8,17,NULL),(15,NULL,NULL,'2022-09-30 21:13:50',100,7,6,NULL),(16,NULL,NULL,'2022-09-30 21:17:18',22200,8,17,NULL),(17,NULL,NULL,'2022-10-03 09:20:07',23900,16,24,NULL),(19,NULL,NULL,'2022-10-03 09:28:59',75000,17,24,NULL),(20,NULL,NULL,'2022-10-03 10:01:13',38000,12,24,NULL),(21,NULL,NULL,'2022-10-03 10:11:32',20000,16,24,NULL),(22,NULL,NULL,'2022-10-04 10:26:46',10000,12,24,NULL),(23,NULL,NULL,'2022-10-05 14:21:48',21300,8,17,NULL),(24,NULL,NULL,'2022-10-05 14:28:44',9800,8,17,NULL),(25,NULL,NULL,'2022-10-06 16:58:19',11300,8,17,NULL),(26,NULL,NULL,'2022-10-06 17:08:42',9600,8,17,NULL),(27,NULL,NULL,'2022-10-07 10:07:49',1500,19,17,NULL),(28,NULL,NULL,'2022-10-07 10:10:19',18500,19,17,NULL),(29,NULL,NULL,'2022-10-07 11:36:45',10000,7,6,NULL),(30,NULL,NULL,'2022-10-07 11:38:14',10000,7,6,NULL);
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
INSERT INTO `orders` VALUES (1,1,3,10000,1000,5,'2022-09-06 09:17:17',NULL),(2,1,3,1000,500,5,'2022-09-06 11:05:35',NULL),(3,5,1,1000,500,5,'2022-09-06 11:13:16','14ffsdfadf'),(4,5,2,50000,5000,5,'2022-09-06 17:03:01',NULL),(5,5,2,50000,5000,5,'2022-09-06 17:04:48',NULL),(6,5,2,500000,50000,5,'2022-09-06 17:20:26',NULL),(7,5,2,100,100,0,'2022-09-15 15:30:49',NULL),(8,5,2,500,500,0,'2022-09-15 15:45:04',NULL),(9,5,2,600,600,0,'2022-09-15 15:45:40',NULL),(10,5,2,700,700,0,'2022-09-15 15:50:36',NULL),(11,1,3,500,500,0,'2022-09-15 16:16:55',NULL),(12,1,3,50000,50000,0,'2022-09-15 16:18:01',NULL),(13,1,3,600,600,0,'2022-09-15 16:22:37',NULL),(14,1,3,7700,7700,5,'2022-09-15 16:23:09',NULL),(15,5,1,3000000,300000,5,'2022-09-16 01:29:27','11'),(16,1,3,210000,21000,5,'2022-09-16 01:34:26',NULL),(17,1,3,0,0,4,'2022-09-16 03:48:33',NULL),(18,5,1,500000,50000,5,'2022-09-16 10:02:20','11123'),(19,5,1,500000,50000,0,'2022-09-17 10:09:50',NULL),(20,1,3,5000,500,0,'2022-09-17 10:32:21',NULL),(21,1,3,0,0,0,'2022-09-17 10:34:46',NULL),(22,1,3,5000,500,4,'2022-09-17 10:35:04','11'),(23,5,1,0,0,0,'2022-09-18 02:48:43',NULL),(24,5,1,500000,50000,0,'2022-09-18 02:49:27',NULL),(25,5,1,2500000,250000,0,'2022-09-18 02:49:44',NULL),(26,1,6,500000,50000,5,'2022-09-20 04:35:06',NULL),(27,1,6,600000,60000,5,'2022-09-20 06:07:40','ets'),(28,5,1,500000,50000,5,'2022-09-21 02:48:18',NULL),(29,5,15,900000,250000,5,'2022-09-21 15:30:39',NULL),(30,5,15,1360000,200000,5,'2022-09-21 15:39:21',NULL),(31,15,16,540000,150000,5,'2022-09-21 15:44:49',NULL),(32,15,17,540000,150000,5,'2022-09-21 16:06:03',NULL),(33,15,16,1000000,100000,5,'2022-09-29 16:18:53',''),(34,5,1,500000,50000,5,'2022-09-29 16:43:08','1'),(35,5,1,2500000,250000,5,'2022-09-29 16:48:44','5'),(36,5,1,9000000,2500000,5,'2022-09-29 17:04:11','送50张X500元'),(37,5,15,1800000,500000,5,'2022-09-29 17:05:56','10张500元'),(38,15,17,1500000,150000,5,'2022-09-29 17:10:38',''),(39,15,17,2500000,250000,5,'2022-09-29 17:16:26',''),(40,15,17,360000,100000,5,'2022-09-29 17:17:30',''),(41,5,1,2500000,250000,5,'2022-09-29 21:54:42','测试销售-4'),(42,5,1,500000,50000,5,'2022-09-30 08:31:09',NULL),(43,5,15,1000000,100000,5,'2022-09-30 12:21:58',''),(44,15,17,500000,50000,5,'2022-09-30 12:25:51',''),(45,5,15,4000000,400000,5,'2022-09-30 18:25:54',''),(46,15,17,1500000,150000,5,'2022-09-30 18:27:41',''),(47,15,17,1000000,100000,5,'2022-09-30 18:29:38',''),(48,15,16,1500000,150000,5,'2022-09-30 19:16:55',''),(49,5,15,2000000,200000,5,'2022-09-30 20:18:38',''),(50,15,17,1500000,150000,5,'2022-09-30 20:25:20',''),(51,15,17,500000,50000,5,'2022-09-30 20:33:42',''),(52,5,23,3600000,1000000,5,'2022-10-03 09:01:30','已打款'),(53,23,24,1800000,500000,5,'2022-10-03 09:16:42',NULL),(54,23,25,1800000,500000,5,'2022-10-03 09:51:34',''),(56,5,23,180000000,50000000,5,'2022-10-05 14:50:15',NULL),(57,5,15,900000,250000,5,'2022-10-06 16:15:32',NULL),(58,23,25,360000,100000,5,'2022-10-07 10:08:22','');
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
INSERT INTO `org` VALUES (1,'代理商1号','王一代','131111111','代理商1号地址','代理商1号区域',1,790000,5,0,47213,110.79801,32.62918,'s1.jpg',NULL,0),(2,'代理商2号','王二代','13111111111','代理商2号地址','代理商2号区域',1,500000,5,0,50000,110.79801,32.62918,'s1.jpg',NULL,0),(3,'门店1号','王一店','13111111111','山西路12号','门店1号区域',2,480000,1,0,50000,110.79801,32.62918,'s1.jpg','2022-10-04 15:49:05',0),(4,'门店2号','王二店','13111111111','万达三楼','门店2号区域',2,500000,2,0,50000,110.79801,32.62918,'s1.jpg',NULL,0),(5,'总公司','王总','1311111110','总部地址','总部区域',0,4242427295,NULL,0,50000,110.79801,32.62918,'s1.jpg',NULL,0),(6,'餐厅1号','王一餐','1311111158','五堰商场负一楼','餐厅1号区域',3,270000,1,0.95,52886,110.78305908203,32.639387749566,'s1.jpg',NULL,10000),(7,'顾客','王一代','+8613207262011','No. 10','代理商1号区域',4,500000,NULL,0,50000,110.79801,32.62918,'s1.jpg',NULL,0),(8,'代理商3号','王三代','13111111111','代理商3号地址','代理商3号区域',1,500000,5,0,50000,110.79801,32.62918,'s1.jpg',NULL,0),(9,'代理商4号','t1','1','t1','t1',1,500000,5,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(10,'餐厅2号','1','1','解放大道','1',3,500000,1,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(11,'门店3号','1','1','万秀城','1',2,500000,1,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(12,'门店4号','111','111','香港街18号','111',2,500000,1,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(13,'代理商5号','11','11','11','11',1,500000,5,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(14,'门店5号','s2111','11','深圳街34号','11',2,500000,1,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(15,'郧阳老酒库','王总','135666688888','测试地址','郧阳区',1,350000,5,0.95,124000,110.79801,32.62918,'s1.jpg',NULL,0),(16,'新合作商店','李总','13655558888','郧阳区城关镇5号','郧阳区',2,300000,15,1,50000,110.79801,32.62918,'s1.jpg',NULL,0),(17,'土厨','李总','13244446666','天津路116号','茅箭区',3,30000,15,0.8,18500,110.80163872613,32.625829264323,'s1.jpg',NULL,0),(18,'代理商测试1','1','1','1','1',1,0,5,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(19,'代理商测试2','1','1','1','1',1,0,5,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(20,'代理商测试2','代理商测试2','52','代理商测试2','代理商测试2',1,0,5,0.95,50000,110.79801,32.62918,'s1.jpg',NULL,0),(21,'九头鸟东岳路店','1','1','东岳路17号','1',3,0,1,0.95,0,110.79801,32.62918,'s1.jpg',NULL,0),(22,'武商量贩','1','1','人民北路28号','1',2,0,1,0.95,0,32.625821126302,110.80163384332,'s1.jpg',NULL,0),(23,'老酒库直营部','老酒库','15871092005','京广中心老酒库','十堰城区',1,50250000,5,0.95,0,32.625821126302,110.80163384332,'s1.jpg',NULL,98900),(24,'大洋酒店','王总','136555555','大洋五洲','天津路',3,0,23,0.9,68000,110.801902398,32.626060926649,'s1.jpg',NULL,0),(25,'汪桂芬','汪桂芬','13797833728','京广中心','十堰',2,350000,23,1,0,110.80164469401,32.625818142361,'s1.jpg',NULL,0),(26,'福润酒店','程燕','13387131991','火车站北广场','十堰城区',3,0,23,1,0,32.625821126302,110.80163384332,'e08ebeb88105e4895abcdf9951661c3.jpg','2022-10-05 16:13:28',0);
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
INSERT INTO `product` VALUES (1,'五粮液10年-测试','500mlx6',500000,20,'11111',50000,5,'wuliangye.jpg','2022-10-04 16:20:12'),(2,'白云边12年','500mlx6',100000,102,'11112',10000,5,'baiyunbian.jpg','2022-10-04 16:19:12'),(3,'五粮液10年','500mlx6',500000,17,'11111',50000,1,'wuliangye.jpg',NULL),(4,'五粮液10年','500mlx6',500000,5,'11111',50000,3,'wuliangye.jpg',NULL),(5,'白云边12年','500mlx6',100000,2,'11112',10000,2,'baiyunbian.jpg',NULL),(6,'五粮液10年','500mlx6',500000,0,'11111',50000,2,'wuliangye.jpg',NULL),(8,'白云边12年','500mlx6',100000,2,'11112',10000,1,'baiyunbian.jpg',NULL),(9,'白云边12年','500mlx6',100000,1,'11112',10000,3,'baiyunbian.jpg',NULL),(26,'五粮液10年','500mlx6',500000,-2,'11111',50000,6,'wuliangye.jpg',NULL),(27,'白云边12年','500mlx6',100000,-6,'11112',10000,6,'baiyunbian.jpg',NULL),(28,'42°剑南老窖-窖龄60','1X6',180000,-523,'12345',50000,5,'11.jpg',NULL),(29,'42°剑南老窖-窖龄60','1X6',180000,4,'12345',50000,15,'11.jpg',NULL),(30,'五粮液10年','500mlx6',500000,3,'11111',50000,15,'wuliangye.jpg',NULL),(31,'42°剑南老窖-窖龄60','1X6',180000,3,'12345',50000,16,'11.jpg',NULL),(32,'42°剑南老窖-窖龄60','1X6',180000,-2,'12345',50000,17,'11.jpg',NULL),(35,'五粮液10年','500mlx6',500000,2,'11111',50000,17,'wuliangye.jpg',NULL),(36,'五粮液10年','500mlx6',500000,3,'11111',50000,16,'wuliangye.jpg',NULL),(37,'42°剑南老窖-窖龄60','1X6',180000,1005,'12345',50000,23,'11.jpg',NULL),(38,'42°剑南老窖-窖龄60','1X6',180000,0,'12345',50000,24,'11.jpg',NULL),(39,'42°剑南老窖-窖龄60','1X6',180000,7,'12345',50000,25,'11.jpg',NULL),(41,'52°剑南老窖-窖龄60','500ML*6',200000,10000,'1002.02',50000,5,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail`
--

LOCK TABLES `retail` WRITE;
/*!40000 ALTER TABLE `retail` DISABLE KEYS */;
INSERT INTO `retail` VALUES (2,3,1,4,2,10000,1000,'2022-09-16 02:03:51'),(4,16,1,31,1,180000,50000,'2022-09-21 15:57:00'),(5,17,1,32,1,180000,50000,'2022-09-21 16:10:21'),(6,6,1,26,1,500000,50000,'2022-09-28 12:08:08'),(7,6,7,26,1,500000,50000,'2022-09-30 10:30:01'),(8,6,7,26,2,1000000,100000,'2022-09-30 10:32:04'),(9,6,7,26,3,1500000,150000,'2022-09-30 11:07:10'),(10,17,7,35,1,500000,50000,'2022-09-30 12:30:25'),(11,6,7,26,1,500000,50000,'2022-09-30 18:37:03'),(12,17,8,35,3,1500000,150000,'2022-09-30 20:53:41'),(13,17,8,35,1,500000,50000,'2022-09-30 20:57:48'),(14,6,7,27,1,100000,10000,'2022-09-30 21:09:25'),(15,6,7,27,2,200000,20000,'2022-09-30 21:12:25'),(16,6,7,27,3,300000,30000,'2022-09-30 21:13:12'),(17,6,7,27,1,100000,10000,'2022-09-30 21:14:29'),(18,17,8,35,2,1000000,100000,'2022-09-30 21:18:32'),(19,6,7,26,1,500000,50000,'2022-09-30 21:19:35'),(20,6,7,27,2,200000,20000,'2022-09-30 21:19:55'),(21,17,8,35,1,500000,50000,'2022-09-30 21:21:00'),(22,24,16,38,2,360000,100000,'2022-10-03 09:19:37'),(23,24,17,38,3,540000,150000,'2022-10-03 09:28:29'),(24,25,19,39,1,180000,50000,'2022-10-03 09:54:33'),(25,25,13,39,1,180000,50000,'2022-10-03 09:55:17'),(26,25,17,39,1,180000,50000,'2022-10-03 09:55:50'),(27,25,12,39,1,180000,50000,'2022-10-03 10:00:04'),(28,6,7,26,1,500000,50000,'2022-10-06 16:14:09'),(29,17,8,32,3,540000,150000,'2022-10-06 16:57:32'),(33,6,7,27,1,100000,10000,'2022-10-07 10:55:18'),(34,3,7,9,1,100000,10000,'2022-10-07 10:59:30'),(35,3,7,9,1,100000,10000,'2022-10-07 11:00:19'),(36,17,8,32,1,180000,50000,'2022-10-07 11:23:34');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retail_return`
--

LOCK TABLES `retail_return` WRITE;
/*!40000 ALTER TABLE `retail_return` DISABLE KEYS */;
INSERT INTO `retail_return` VALUES (1,3,1,9,1,100000,10000,'2022-09-20 06:45:54'),(2,3,1,9,1,100000,10000,'2022-09-20 06:47:07'),(3,6,1,27,1,100000,10000,'2022-09-20 06:47:49'),(4,16,1,31,1,180000,50000,'2022-09-21 15:58:07'),(5,6,7,26,6,3000000,300000,'2022-09-30 11:09:57'),(6,6,7,26,1,500000,50000,'2022-09-30 18:37:40'),(7,6,7,27,2,200000,20000,'2022-09-30 21:14:06'),(8,17,8,35,1,500000,50000,'2022-09-30 21:21:14'),(9,25,17,39,1,180000,50000,'2022-10-03 09:57:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_items`
--

LOCK TABLES `return_items` WRITE;
/*!40000 ALTER TABLE `return_items` DISABLE KEYS */;
INSERT INTO `return_items` VALUES (1,3,3,1),(2,4,3,1),(3,4,8,1),(4,5,3,1),(5,5,8,1),(6,6,3,5),(7,7,1,4),(8,8,1,1),(9,9,3,1),(10,10,3,1),(11,11,2,5),(12,14,1,5),(13,15,1,5),(14,16,1,5),(15,17,3,5),(16,18,8,5),(17,19,3,5),(18,20,2,1),(19,21,1,1),(20,22,30,1),(21,23,37,2),(22,24,37,2),(23,25,37,1),(24,26,37,2),(25,27,28,2);
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
INSERT INTO `returns` VALUES (1,3,1,1000,500,5,'2022-09-06 15:32:17',NULL),(2,2,5,500000,50000,5,'2022-09-06 17:27:53',NULL),(3,3,1,0,0,0,'2022-09-16 03:31:28',NULL),(4,3,1,105000,10500,5,'2022-09-16 03:45:29',NULL),(5,3,1,105000,10500,5,'2022-09-16 03:54:32',NULL),(6,3,1,25000,2500,5,'2022-09-16 04:14:25',NULL),(7,1,5,2000000,200000,0,'2022-09-17 10:10:00',NULL),(8,1,5,500000,50000,0,'2022-09-17 10:10:08',NULL),(9,3,1,5000,500,4,'2022-09-17 10:35:38','11'),(10,6,1,500000,50000,5,'2022-09-20 04:56:44',NULL),(11,1,5,500000,50000,5,'2022-09-21 02:49:14',NULL),(12,5,1,0,0,5,'2022-09-29 17:01:22','测试退货1'),(13,5,1,0,0,5,'2022-09-29 17:03:12','测试退货1'),(14,5,1,2500000,250000,5,'2022-09-29 17:06:53','退货测试-1'),(15,5,1,2500000,250000,5,'2022-09-29 17:07:45','退货测试-1'),(16,1,5,2500000,250000,5,'2022-09-29 17:14:10','退货测试-11'),(17,10,1,2500000,250000,5,'2022-09-29 17:17:47','测试餐厅退货-1'),(18,6,1,500000,50000,5,'2022-09-29 17:19:14','测试餐厅退货-2'),(19,3,1,2500000,250000,5,'2022-09-29 17:21:46','测试门店退货-1'),(20,1,5,100000,10000,5,'2022-09-29 22:04:26','测试退货-1'),(21,15,5,500000,50000,5,'2022-09-30 12:22:13',''),(22,17,15,500000,50000,5,'2022-09-30 12:27:41',''),(23,24,23,360000,100000,5,'2022-10-03 09:40:24',''),(24,24,23,360000,100000,5,'2022-10-03 09:40:30',''),(25,24,23,180000,50000,5,'2022-10-03 09:41:30',''),(26,25,23,360000,100000,5,'2022-10-03 09:58:15',''),(27,15,5,360000,100000,5,'2022-10-06 16:16:04',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scan`
--

LOCK TABLES `scan` WRITE;
/*!40000 ALTER TABLE `scan` DISABLE KEYS */;
INSERT INTO `scan` VALUES (2,7,6,'1664501106597'),(3,7,6,'1664501106597'),(4,7,6,'1664501106597'),(5,7,6,'1664501106597'),(6,7,6,'1664501106597'),(7,7,17,'1664512212391'),(8,7,17,'1664512276788'),(9,7,6,'1664501106597'),(10,7,6,'1664501106597'),(11,7,6,'1664501106597'),(12,8,17,'1664542359353'),(13,8,17,'1664542359353'),(14,8,17,'1664542359353'),(15,8,17,'1664543324730'),(16,7,6,'1664501106597'),(17,7,6,'1664501106597'),(18,7,6,'1664501106597'),(19,7,6,'1664501106597'),(20,7,6,'1664501106597'),(21,7,6,'1664501106597'),(22,8,17,'1664543828653'),(23,8,17,'1664543828653'),(24,7,6,'1664501106597'),(25,7,6,'1664501106597'),(26,8,17,'1664543828653'),(27,8,17,'1664543828653'),(28,16,24,'1664759960965'),(29,16,24,'1664759998718'),(31,17,24,'1664760466310'),(32,17,24,'1664760523714'),(33,19,25,'1664762052709'),(34,13,25,'1664762063548'),(35,17,25,'1664762043626'),(36,17,25,'1664762212920'),(37,12,25,'1664762387340'),(38,12,24,'1664762433282'),(39,16,24,'1664763075628'),(40,12,24,'1664850382657'),(41,8,17,'1664950884145'),(42,8,17,'1664951317448'),(43,7,6,'1664501106597'),(44,8,17,'1665046607797'),(45,8,17,'1665046607797'),(46,8,17,'1665047312505'),(50,19,17,'1665108460368'),(51,19,17,'1665108605784'),(52,7,3,'1664501106597'),(53,7,3,'1664501106597'),(56,7,6,'1664501106597');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (6,'u4','[\"ROLE_RESTAURANT\"]','sdfg',6,NULL),(7,'u6','[\"ROLE_STORE\"]','sdafas',4,NULL),(9,'admin','[\"ROLE_HEAD\", \"ROLE_ADMIN\"]','$2y$13$6eWONnmy7sz4qPKWu7.0Z.QGboS/uyCRS2n/sicq/R4ukBdiVIkxW',5,NULL),(13,'s1','[\"ROLE_STORE\"]','$2y$13$dbHC6AGEuX3IQVl/nCQ5auJrD444QSwFPFVlyZ2qDZh6wW4YdUq/i',3,NULL),(14,'r1','[\"ROLE_RESTAURANT\"]','$2y$13$2Qv96WX3LXzwvlIL5JtzGetghjvo/hRSQ72TieeltmXOHRtSTtYMi',6,NULL),(15,'h1','[\"ROLE_HEAD\"]','$2y$13$RWxYfcuFFxM5.wXVrniE5OI96dlx2NGMVaraJrl0akRc92y1kJojG',5,NULL),(24,'xinhezuo','[\"ROLE_STORE\"]','$2y$13$zfsvdnAkEySgyIabJ4hVn.uRZNwfH1CN3YXacy6edSyO3rU7qbWq2',16,NULL),(25,'tuchu','[\"ROLE_RESTAURANT\"]','$2y$13$UwDh8.fCvwCUQXwe2F5D9eWXqD79WozGGA7yyfjiCfRMLUqLGc.n2',17,NULL),(27,'ljk','[\"ROLE_AGENCY\"]','$2y$13$2Vc0IMuLuGmhaS2rBsKIp.JF2KlZsDqMnHBBRWGfiL7PippmG91i2',23,NULL),(28,'dayang','[\"ROLE_RESTAURANT\"]','$2y$13$ikK65j3uOZeexngZAMNAK.Hbyf1LVliEVWqRIPJJtDGxz22tnOQXG',24,NULL),(29,'wgf','[\"ROLE_STORE\"]','$2y$13$2zIYAVWCnszbOAS2n/usUumDriqhmVgUDSYLs1Y9JCmazMGK6ztkq',25,NULL),(30,'dsx','[\"ROLE_STORE\"]','$2y$13$k3ugZP5xlJaD1Y2vx803ouqcQ8MWnyyzoqPismg54dN/rqhbvJXuK',25,NULL),(31,'湖北老酒库','[\"ROLE_HEAD\"]','$2y$13$sqrk/YH3qZlBDTiqSCmBLOVVAOD0oi214oTcgwdwnQeXCbaSRbf1u',5,NULL),(34,'a13387131991','[\"ROLE_RESTAURANT\"]','$2y$13$D4yDORAebUuRlYGJHnwRm.hdkVwciNJR2AaF6BTwEVj/hircKOg2G',26,NULL),(35,'13655558888','[\"ROLE_AGENCY\"]','$2y$13$osnbJlFIbpv3sxJnncyGOOK6psZHLYMmtzgycnGFwVepe72WLnBOO',1,NULL),(36,'aaa','[\"ROLE_AGENCY\"]','$2y$13$rcsl52QlgLDs9gBUEwR7jOC/viCayvWusTqRTF6KxdcEPFVIeQldq',15,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher`
--

LOCK TABLES `voucher` WRITE;
/*!40000 ALTER TABLE `voucher` DISABLE KEYS */;
INSERT INTO `voucher` VALUES (1,105,6,-50000,'2022-09-20 06:06:28',NULL,NULL),(2,5,1,50000,'2022-09-20 06:06:28',NULL,NULL),(3,100,1,-60000,'2022-09-20 06:08:38',NULL,NULL),(4,0,6,60000,'2022-09-20 06:08:38',NULL,NULL),(7,13,3,10000,'2022-09-20 06:45:55',NULL,NULL),(8,113,7,-10000,'2022-09-20 06:45:55',NULL,1),(9,13,3,10000,'2022-09-20 06:47:08',NULL,NULL),(10,113,7,-10000,'2022-09-20 06:47:08',NULL,1),(11,13,6,10000,'2022-09-20 06:47:49',NULL,NULL),(12,113,7,-10000,'2022-09-20 06:47:49',NULL,1),(13,255,1,100,'2022-09-20 09:08:01','uu',NULL),(14,112,7,-100,'2022-09-20 10:19:18',NULL,1),(15,12,6,100,'2022-09-20 10:19:18',NULL,NULL),(16,112,7,-100,'2022-09-20 10:20:10',NULL,1),(17,12,6,100,'2022-09-20 10:20:10',NULL,NULL),(18,100,5,-50000,'2022-09-21 02:48:18',NULL,NULL),(19,0,1,50000,'2022-09-21 02:48:18',NULL,NULL),(20,105,1,-50000,'2022-09-21 02:49:14',NULL,NULL),(21,5,5,50000,'2022-09-21 02:49:14',NULL,NULL),(22,100,5,-250000,'2022-09-21 15:30:39',NULL,NULL),(23,0,15,250000,'2022-09-21 15:30:39',NULL,NULL),(24,100,5,-200000,'2022-09-21 15:39:22',NULL,NULL),(25,0,15,200000,'2022-09-21 15:39:22',NULL,NULL),(26,100,15,-150000,'2022-09-21 15:44:49',NULL,NULL),(27,0,16,150000,'2022-09-21 15:44:49',NULL,NULL),(28,103,16,-50000,'2022-09-21 15:57:00',NULL,NULL),(29,3,7,50000,'2022-09-21 15:57:00',NULL,1),(30,13,16,50000,'2022-09-21 15:58:07',NULL,NULL),(31,113,7,-50000,'2022-09-21 15:58:07',NULL,1),(32,100,15,-150000,'2022-09-21 16:06:03',NULL,NULL),(33,0,17,150000,'2022-09-21 16:06:03',NULL,NULL),(34,103,17,-50000,'2022-09-21 16:10:21',NULL,NULL),(35,3,7,50000,'2022-09-21 16:10:21',NULL,1),(36,112,7,-30000,'2022-09-21 16:12:00',NULL,1),(37,12,17,30000,'2022-09-21 16:12:00',NULL,NULL),(38,103,6,-50000,'2022-09-28 12:08:08',NULL,NULL),(39,3,7,50000,'2022-09-28 12:08:08',NULL,1),(41,112,7,-21800,'2022-09-28 17:53:34',NULL,1),(42,12,17,21800,'2022-09-28 17:53:34',NULL,NULL),(43,100,15,0,'2022-09-29 16:18:53',NULL,NULL),(44,0,16,0,'2022-09-29 16:18:53',NULL,NULL),(45,100,5,0,'2022-09-29 16:43:08',NULL,NULL),(46,0,1,0,'2022-09-29 16:43:08',NULL,NULL),(47,100,5,0,'2022-09-29 16:48:44',NULL,NULL),(48,0,1,0,'2022-09-29 16:48:44',NULL,NULL),(49,105,5,0,'2022-09-29 17:01:22',NULL,NULL),(50,5,1,0,'2022-09-29 17:01:22',NULL,NULL),(51,105,5,0,'2022-09-29 17:03:12',NULL,NULL),(52,5,1,0,'2022-09-29 17:03:12',NULL,NULL),(53,100,5,0,'2022-09-29 17:04:11',NULL,NULL),(54,0,1,0,'2022-09-29 17:04:11',NULL,NULL),(55,100,5,0,'2022-09-29 17:05:56',NULL,NULL),(56,0,15,0,'2022-09-29 17:05:56',NULL,NULL),(57,105,5,0,'2022-09-29 17:06:53',NULL,NULL),(58,5,1,0,'2022-09-29 17:06:53',NULL,NULL),(59,105,5,0,'2022-09-29 17:07:45',NULL,NULL),(60,5,1,0,'2022-09-29 17:07:45',NULL,NULL),(61,100,15,0,'2022-09-29 17:10:38',NULL,NULL),(62,0,17,0,'2022-09-29 17:10:38',NULL,NULL),(63,105,1,0,'2022-09-29 17:14:10',NULL,NULL),(64,5,5,0,'2022-09-29 17:14:10',NULL,NULL),(65,100,15,0,'2022-09-29 17:16:26',NULL,NULL),(66,0,17,0,'2022-09-29 17:16:26',NULL,NULL),(67,100,15,0,'2022-09-29 17:17:30',NULL,NULL),(68,0,17,0,'2022-09-29 17:17:30',NULL,NULL),(69,105,10,0,'2022-09-29 17:17:47',NULL,NULL),(70,5,1,0,'2022-09-29 17:17:47',NULL,NULL),(71,105,6,0,'2022-09-29 17:19:14',NULL,NULL),(72,5,1,0,'2022-09-29 17:19:14',NULL,NULL),(73,105,3,0,'2022-09-29 17:21:46',NULL,NULL),(74,5,1,0,'2022-09-29 17:21:46',NULL,NULL),(75,100,5,-250000,'2022-09-29 21:54:42',NULL,NULL),(76,0,1,250000,'2022-09-29 21:54:42',NULL,NULL),(77,105,1,-10000,'2022-09-29 22:04:26',NULL,NULL),(78,5,5,10000,'2022-09-29 22:04:26',NULL,NULL),(79,100,5,-50000,'2022-09-30 08:31:09',NULL,NULL),(80,0,1,50000,'2022-09-30 08:31:09',NULL,NULL),(81,103,6,-50000,'2022-09-30 10:30:01',NULL,NULL),(82,3,7,50000,'2022-09-30 10:30:01',NULL,7),(83,103,6,-100000,'2022-09-30 10:32:04',NULL,NULL),(84,3,7,100000,'2022-09-30 10:32:04',NULL,7),(85,112,7,-5,'2022-09-30 10:51:01',NULL,7),(86,12,6,5,'2022-09-30 10:51:01',NULL,NULL),(87,103,6,-150000,'2022-09-30 11:07:10',NULL,NULL),(88,3,7,150000,'2022-09-30 11:07:10',NULL,7),(89,13,6,300000,'2022-09-30 11:09:57',NULL,NULL),(90,113,7,-300000,'2022-09-30 11:09:57',NULL,7),(91,100,5,-100000,'2022-09-30 12:21:58',NULL,NULL),(92,0,15,100000,'2022-09-30 12:21:58',NULL,NULL),(93,105,15,-50000,'2022-09-30 12:22:13',NULL,NULL),(94,5,5,50000,'2022-09-30 12:22:13',NULL,NULL),(95,100,15,-50000,'2022-09-30 12:25:51',NULL,NULL),(96,0,17,50000,'2022-09-30 12:25:51',NULL,NULL),(97,105,17,-50000,'2022-09-30 12:27:41',NULL,NULL),(98,5,15,50000,'2022-09-30 12:27:41',NULL,NULL),(99,103,17,-50000,'2022-09-30 12:30:25',NULL,NULL),(100,3,7,50000,'2022-09-30 12:30:25',NULL,7),(101,112,7,-135,'2022-09-30 12:31:32',NULL,7),(102,12,17,135,'2022-09-30 12:31:32',NULL,NULL),(103,110,6,-4,'2022-09-30 15:35:39',NULL,NULL),(104,100,1,4,'2022-09-30 15:35:39',NULL,NULL),(111,110,6,-5000,'2022-09-30 15:49:30',NULL,NULL),(112,100,1,5000,'2022-09-30 15:49:30',NULL,NULL),(113,110,6,-1100,'2022-09-30 15:50:09',NULL,NULL),(114,100,1,1100,'2022-09-30 15:50:09',NULL,NULL),(115,110,6,-5,'2022-09-30 15:52:46',NULL,NULL),(116,100,1,5,'2022-09-30 15:52:46',NULL,NULL),(117,110,6,-4,'2022-09-30 15:55:11',NULL,NULL),(118,100,1,4,'2022-09-30 15:55:11',NULL,NULL),(119,110,6,-5000,'2022-09-30 15:57:56',NULL,NULL),(120,100,1,5000,'2022-09-30 15:57:56',NULL,NULL),(121,110,6,-1100,'2022-09-30 16:03:06',NULL,NULL),(122,100,1,1100,'2022-09-30 16:03:06',NULL,NULL),(123,110,6,-5,'2022-09-30 16:03:17',NULL,NULL),(124,100,1,5,'2022-09-30 16:03:17',NULL,NULL),(125,110,1,-1,'2022-09-30 17:09:03',NULL,NULL),(126,100,5,-400000,'2022-09-30 18:25:54',NULL,NULL),(127,0,15,400000,'2022-09-30 18:25:54',NULL,NULL),(128,110,1,-5000,'2022-09-30 18:26:29',NULL,NULL),(129,110,1,-10000,'2022-09-30 18:26:36',NULL,NULL),(130,100,15,-150000,'2022-09-30 18:27:41',NULL,NULL),(131,0,17,150000,'2022-09-30 18:27:41',NULL,NULL),(138,100,15,-100000,'2022-09-30 18:29:38',NULL,NULL),(139,0,17,100000,'2022-09-30 18:29:38',NULL,NULL),(142,112,7,-5000,'2022-09-30 18:35:07',NULL,7),(143,12,6,5000,'2022-09-30 18:35:07',NULL,NULL),(144,103,6,-50000,'2022-09-30 18:37:03',NULL,NULL),(145,3,7,50000,'2022-09-30 18:37:03',NULL,7),(146,13,6,50000,'2022-09-30 18:37:40',NULL,NULL),(147,113,7,-50000,'2022-09-30 18:37:40',NULL,7),(148,110,17,-50000,'2022-09-30 18:55:21',NULL,NULL),(149,100,15,50000,'2022-09-30 18:55:21',NULL,NULL),(152,100,15,-150000,'2022-09-30 19:16:55',NULL,NULL),(153,0,16,150000,'2022-09-30 19:16:55',NULL,NULL),(154,100,5,-200000,'2022-09-30 20:18:38',NULL,NULL),(155,0,15,200000,'2022-09-30 20:18:38',NULL,NULL),(156,100,15,-150000,'2022-09-30 20:25:20',NULL,NULL),(157,0,17,150000,'2022-09-30 20:25:20',NULL,NULL),(158,100,15,-50000,'2022-09-30 20:33:42',NULL,NULL),(159,0,17,50000,'2022-09-30 20:33:42',NULL,NULL),(160,103,17,-150000,'2022-09-30 20:53:41',NULL,NULL),(161,3,7,150000,'2022-09-30 20:53:41',NULL,8),(162,103,17,-50000,'2022-09-30 20:57:48',NULL,NULL),(163,3,7,50000,'2022-09-30 20:57:48',NULL,8),(164,112,7,-12900,'2022-09-30 20:58:10',NULL,8),(165,12,17,12900,'2022-09-30 20:58:10',NULL,NULL),(166,112,7,-13600,'2022-09-30 21:08:58',NULL,8),(167,12,17,13600,'2022-09-30 21:08:58',NULL,NULL),(168,103,6,-10000,'2022-09-30 21:09:25',NULL,NULL),(169,3,7,10000,'2022-09-30 21:09:25',NULL,7),(170,103,6,-20000,'2022-09-30 21:12:25',NULL,NULL),(171,3,7,20000,'2022-09-30 21:12:25',NULL,7),(172,103,6,-30000,'2022-09-30 21:13:12',NULL,NULL),(173,3,7,30000,'2022-09-30 21:13:12',NULL,7),(174,112,7,-100,'2022-09-30 21:13:50',NULL,7),(175,12,6,100,'2022-09-30 21:13:50',NULL,NULL),(176,110,17,-12900,'2022-09-30 21:13:56',NULL,NULL),(177,100,15,12900,'2022-09-30 21:13:56',NULL,NULL),(180,13,6,20000,'2022-09-30 21:14:06',NULL,NULL),(181,113,7,-20000,'2022-09-30 21:14:06',NULL,7),(184,103,6,-10000,'2022-09-30 21:14:29',NULL,NULL),(185,3,7,10000,'2022-09-30 21:14:29',NULL,7),(190,112,7,-22200,'2022-09-30 21:17:18',NULL,8),(191,12,17,22200,'2022-09-30 21:17:18',NULL,NULL),(192,103,17,-100000,'2022-09-30 21:18:32',NULL,NULL),(193,3,7,100000,'2022-09-30 21:18:32',NULL,8),(194,103,6,-50000,'2022-09-30 21:19:35',NULL,NULL),(195,3,7,50000,'2022-09-30 21:19:35',NULL,7),(196,103,6,-20000,'2022-09-30 21:19:55',NULL,NULL),(197,3,7,20000,'2022-09-30 21:19:55',NULL,7),(198,103,17,-50000,'2022-09-30 21:21:00',NULL,NULL),(199,3,7,50000,'2022-09-30 21:21:00',NULL,8),(200,13,17,50000,'2022-09-30 21:21:14',NULL,NULL),(201,113,7,-50000,'2022-09-30 21:21:14',NULL,8),(202,100,5,-1000000,'2022-10-03 09:01:30',NULL,NULL),(203,0,23,1000000,'2022-10-03 09:01:30',NULL,NULL),(204,100,23,-500000,'2022-10-03 09:16:42',NULL,NULL),(205,0,24,500000,'2022-10-03 09:16:42',NULL,NULL),(206,103,24,-100000,'2022-10-03 09:19:37',NULL,NULL),(207,3,7,100000,'2022-10-03 09:19:37',NULL,16),(208,112,7,-23900,'2022-10-03 09:20:07',NULL,16),(209,12,24,23900,'2022-10-03 09:20:07',NULL,NULL),(210,110,24,-23900,'2022-10-03 09:22:45',NULL,NULL),(211,100,23,23900,'2022-10-03 09:22:45',NULL,NULL),(214,103,24,-150000,'2022-10-03 09:28:29',NULL,NULL),(215,3,7,150000,'2022-10-03 09:28:29',NULL,17),(216,112,7,-75000,'2022-10-03 09:28:59',NULL,17),(217,12,24,75000,'2022-10-03 09:28:59',NULL,NULL),(218,110,24,-75000,'2022-10-03 09:37:30',NULL,NULL),(219,100,23,75000,'2022-10-03 09:37:30',NULL,NULL),(220,105,24,-100000,'2022-10-03 09:40:24',NULL,NULL),(221,5,23,100000,'2022-10-03 09:40:24',NULL,NULL),(222,105,24,-100000,'2022-10-03 09:40:30',NULL,NULL),(223,5,23,100000,'2022-10-03 09:40:30',NULL,NULL),(224,105,24,-50000,'2022-10-03 09:41:30',NULL,NULL),(225,5,23,50000,'2022-10-03 09:41:30',NULL,NULL),(226,100,23,-500000,'2022-10-03 09:51:34',NULL,NULL),(227,0,25,500000,'2022-10-03 09:51:34',NULL,NULL),(228,103,25,-50000,'2022-10-03 09:54:33',NULL,NULL),(229,3,7,50000,'2022-10-03 09:54:33',NULL,19),(230,103,25,-50000,'2022-10-03 09:55:17',NULL,NULL),(231,3,7,50000,'2022-10-03 09:55:17',NULL,13),(232,103,25,-50000,'2022-10-03 09:55:50',NULL,NULL),(233,3,7,50000,'2022-10-03 09:55:50',NULL,17),(234,13,25,50000,'2022-10-03 09:57:26',NULL,NULL),(235,113,7,-50000,'2022-10-03 09:57:26',NULL,17),(236,105,25,-100000,'2022-10-03 09:58:15',NULL,NULL),(237,5,23,100000,'2022-10-03 09:58:15',NULL,NULL),(238,103,25,-50000,'2022-10-03 10:00:04',NULL,NULL),(239,3,7,50000,'2022-10-03 10:00:04',NULL,12),(240,112,7,-38000,'2022-10-03 10:01:13',NULL,12),(241,12,24,38000,'2022-10-03 10:01:13',NULL,NULL),(244,112,7,-20000,'2022-10-03 10:11:32',NULL,16),(245,12,24,20000,'2022-10-03 10:11:32',NULL,NULL),(246,112,7,-10000,'2022-10-04 10:26:46',NULL,12),(247,12,24,10000,'2022-10-04 10:26:46',NULL,NULL),(248,112,7,-21300,'2022-10-05 14:21:48',NULL,8),(249,12,17,21300,'2022-10-05 14:21:48',NULL,NULL),(250,112,7,-9800,'2022-10-05 14:28:44',NULL,8),(251,12,17,9800,'2022-10-05 14:28:44',NULL,NULL),(252,100,5,-50000000,'2022-10-05 14:50:15',NULL,NULL),(253,0,23,50000000,'2022-10-05 14:50:15',NULL,NULL),(254,103,6,-50000,'2022-10-06 16:14:09',NULL,NULL),(255,3,7,50000,'2022-10-06 16:14:09',NULL,7),(256,100,5,-250000,'2022-10-06 16:15:32',NULL,NULL),(257,0,15,250000,'2022-10-06 16:15:32',NULL,NULL),(258,105,15,-100000,'2022-10-06 16:16:04',NULL,NULL),(259,5,5,100000,'2022-10-06 16:16:04',NULL,NULL),(260,103,17,-150000,'2022-10-06 16:57:32',NULL,NULL),(261,3,7,150000,'2022-10-06 16:57:32',NULL,8),(262,112,7,-11300,'2022-10-06 16:58:19',NULL,8),(263,12,17,11300,'2022-10-06 16:58:19',NULL,NULL),(264,112,7,-9600,'2022-10-06 17:08:42',NULL,8),(265,12,17,9600,'2022-10-06 17:08:42',NULL,NULL),(272,112,7,-1500,'2022-10-07 10:07:49',NULL,19),(273,12,17,1500,'2022-10-07 10:07:49',NULL,NULL),(274,100,23,-100000,'2022-10-07 10:08:22',NULL,NULL),(275,0,25,100000,'2022-10-07 10:08:22',NULL,NULL),(276,112,7,-18500,'2022-10-07 10:10:19',NULL,19),(277,12,17,18500,'2022-10-07 10:10:19',NULL,NULL),(278,110,17,-11100,'2022-10-07 10:27:22',NULL,NULL),(279,100,15,11100,'2022-10-07 10:27:22',NULL,NULL),(280,103,6,-10000,'2022-10-07 10:55:18',NULL,NULL),(281,3,7,10000,'2022-10-07 10:55:18',NULL,7),(282,103,3,-10000,'2022-10-07 10:59:30',NULL,NULL),(283,3,7,10000,'2022-10-07 10:59:30',NULL,7),(284,103,3,-10000,'2022-10-07 11:00:19',NULL,NULL),(285,3,7,10000,'2022-10-07 11:00:19',NULL,7),(286,103,17,-50000,'2022-10-07 11:23:34',NULL,NULL),(287,3,7,50000,'2022-10-07 11:23:34',NULL,8),(292,112,7,-10000,'2022-10-07 11:36:45',NULL,7),(293,12,6,10000,'2022-10-07 11:36:45',NULL,NULL),(294,112,7,-10000,'2022-10-07 11:38:14',NULL,7),(295,12,6,10000,'2022-10-07 11:38:14',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES (1,'2022-09-15 08:03:17',5000,5,NULL,NULL,1,5,5000),(2,'2022-09-15 08:04:45',7000,0,NULL,NULL,1,5,7000),(3,'2022-09-15 09:04:34',5000,5,NULL,NULL,6,1,5000),(4,'2022-09-15 16:41:11',5000,0,NULL,NULL,1,5,5000),(5,'2022-09-18 03:04:20',500000,0,NULL,NULL,1,5,500000),(6,'2022-09-18 03:28:08',1,0,NULL,NULL,1,5,1),(7,'2022-09-18 03:28:36',10,0,NULL,NULL,1,5,10),(8,'2022-09-18 03:30:31',9,0,NULL,NULL,1,5,9),(9,'2022-09-18 03:30:45',9,0,NULL,NULL,1,5,9),(10,'2022-09-18 03:31:08',10,0,NULL,NULL,1,5,10),(11,'2022-09-18 03:33:05',900,0,NULL,NULL,1,5,900),(12,'2022-09-18 03:39:37',347000,0,NULL,NULL,1,5,347000),(13,'2022-09-18 03:45:23',347100,0,NULL,NULL,1,5,347100),(14,'2022-09-18 03:50:13',500000,0,NULL,NULL,1,5,500000),(15,'2022-09-18 03:50:18',500000,0,NULL,NULL,1,5,500000),(16,'2022-09-18 03:52:34',347000,0,NULL,NULL,1,5,347000),(17,'2022-09-21 04:04:47',1100,5,NULL,NULL,6,1,1100),(18,'2022-09-21 04:05:02',10000,5,NULL,NULL,1,5,10000),(19,'2022-09-21 04:06:56',50000,4,NULL,NULL,6,1,50000),(20,'2022-09-21 16:14:15',130000,4,NULL,NULL,17,15,130000),(21,'2022-09-30 11:28:07',1,5,NULL,'string',1,5,1),(22,'2022-09-30 11:31:10',5,5,NULL,NULL,6,1,5),(23,'2022-09-30 11:47:03',1,0,NULL,NULL,6,1,1),(24,'2022-09-30 11:55:06',4,0,NULL,NULL,6,1,4),(25,'2022-09-30 18:38:54',50000,5,NULL,NULL,17,15,50000),(26,'2022-09-30 20:47:56',42700,0,NULL,NULL,6,1,42700),(27,'2022-09-30 20:59:32',12900,5,NULL,NULL,17,15,12900),(28,'2022-09-30 21:07:41',100,0,NULL,NULL,6,1,100),(29,'2022-09-30 21:08:46',100,0,NULL,NULL,6,1,100),(30,'2022-09-30 21:10:08',26500,4,NULL,NULL,17,15,26500),(31,'2022-10-03 09:21:34',23900,5,NULL,NULL,24,23,23900),(32,'2022-10-03 09:32:12',75000,5,NULL,NULL,24,23,75000),(33,'2022-10-03 09:37:54',98900,0,NULL,NULL,23,5,98900),(34,'2022-10-03 10:08:36',38000,0,NULL,NULL,24,23,38000),(35,'2022-10-03 10:13:18',58000,0,NULL,NULL,24,23,58000),(36,'2022-10-04 10:28:34',68000,0,NULL,NULL,24,23,68000),(37,'2022-10-04 10:29:00',68000,0,NULL,NULL,24,23,68000),(38,'2022-10-04 10:57:31',68000,0,NULL,NULL,24,23,68000),(39,'2022-10-05 14:41:42',6900,0,NULL,NULL,17,15,5520),(40,'2022-10-05 16:47:36',10000,0,NULL,NULL,6,1,9500),(41,'2022-10-06 16:37:29',98900,0,NULL,NULL,23,5,98900),(42,'2022-10-06 17:08:25',78200,0,NULL,NULL,17,15,78200),(43,'2022-10-07 10:09:56',11100,5,NULL,NULL,17,15,11100),(44,'2022-10-07 10:27:38',120000,4,NULL,'请提现500元的倍数提现',15,5,120000);
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

-- Dump completed on 2022-10-07 13:05:06
