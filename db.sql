-- MySQL dump 10.13  Distrib 5.1.63, for apple-darwin10.3.0 (i386)
--
-- Host: localhost    Database: miniblog
-- ------------------------------------------------------
-- Server version	5.1.63

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ty_admin`
--

DROP TABLE IF EXISTS `ty_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_admin` (
  `username` varchar(10) NOT NULL,
  `psd` varchar(100) NOT NULL,
  `flag` char(20) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_admin`
--

LOCK TABLES `ty_admin` WRITE;
/*!40000 ALTER TABLE `ty_admin` DISABLE KEYS */;
INSERT INTO `ty_admin` VALUES ('tianyu0915','637fa3823cd6a09823c40ca120744209','');
/*!40000 ALTER TABLE `ty_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_articles`
--

DROP TABLE IF EXISTS `ty_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_articles` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `class_id` int(5) DEFAULT NULL,
  `title` char(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key_workds` char(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_articles`
--

LOCK TABLES `ty_articles` WRITE;
/*!40000 ALTER TABLE `ty_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `ty_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_articles_class`
--

DROP TABLE IF EXISTS `ty_articles_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_articles_class` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_articles_class`
--

LOCK TABLES `ty_articles_class` WRITE;
/*!40000 ALTER TABLE `ty_articles_class` DISABLE KEYS */;
INSERT INTO `ty_articles_class` VALUES (2,'???'),(1,'加密');
/*!40000 ALTER TABLE `ty_articles_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_articles_content`
--

DROP TABLE IF EXISTS `ty_articles_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_articles_content` (
  `id` int(5) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_articles_content`
--

LOCK TABLES `ty_articles_content` WRITE;
/*!40000 ALTER TABLE `ty_articles_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `ty_articles_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_articles_responses`
--

DROP TABLE IF EXISTS `ty_articles_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_articles_responses` (
  `article_id` int(5) NOT NULL,
  `r_id` int(5) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`article_id`,`r_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_articles_responses`
--

LOCK TABLES `ty_articles_responses` WRITE;
/*!40000 ALTER TABLE `ty_articles_responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `ty_articles_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_config`
--

DROP TABLE IF EXISTS `ty_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_config` (
  `k` varchar(32) NOT NULL,
  `v` text,
  `r` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_config`
--

LOCK TABLES `ty_config` WRITE;
/*!40000 ALTER TABLE `ty_config` DISABLE KEYS */;
INSERT INTO `ty_config` VALUES ('version','BETA 1.0',0),('about','TY一直试图写一个很长、看上去很专业的关于页面，但最终无果',0),('admin_email','tianyu0915@gmail.com',0),('title','TY的微博',1),('domain','',1),('logo','logo.png',1),('douban_show','<script src=\"http://t.douban.com/js/radiowidget_plain.js?doubanid=T-y&maxresults=3&color=0\"></script>',0),('zztj','',1),('WB_AKEY','2454797598',1),('WB_SKEY','af720bd936293b5511539fcf3fb1cc7b',1),('sina_oauth_token','361181f66c3062e8920c5d18666346bc',1),('sina_oauth_secret','8a72f36e3e88e91becf9a0dc3050cc2f',1),('update_to_sina','1',1),('keywords','西安,PHP,程序员,敏捷WEB开发',1),('description','热爱互联网，热衷于敏捷WEB开发，TY每天都在进步...',1),('about_text','<h3>新特性：</h3>\r\n				<ul>\r\n				<li>支持与新浪微博的链接，可将站内微博同步到新浪</li>\r\n				<li>加入了手机版，可通过手机访问、管理微博</li>\r\n				<li>加入了IP黑名单功能，防止恶意攻击</li>\r\n				</ul>\r\n				<h3>BUG修复：</h3>\r\n				<ul>\r\n				<li>优化了部分页面显示效果</li>\r\n				<li>优化程序的注释代码</li>\r\n				<li>修复chrome浏览器显示不正常的问题</li>\r\n				</ul>',0),('share_to','<script language=\"javascript\" type=\"text/javascript\" src=\"http://www.bshare.cn/button.js#uuid=&amp;style=3&amp;fs=4&amp;textcolor=#FFF&amp;bgcolor=#F90&amp;text=分享到...\"></script>',1),('widget_link','1',0),('widget_develop','1',0),('widget_douban','1',0),('self_introduction','',0),('screen_name','TY',0),('sex','男',0),('location','陕西-西安',0),('profession','学生',0),('qq_js','<a target=\"_blank\" href=\"http://sighttp.qq.com/authd?IDKEY=86282b0b6df0b77845403338508f6ea3ffa3b4da4540cff8\"><img class=\"qq\" border=\"0\"  src=\"http://wpa.qq.com/imgd?IDKEY=86282b0b6df0b77845403338508f6ea3ffa3b4da4540cff8&pic=46\" alt=\"点击这里和我在线交谈\" title=\"点击这里和我在线交谈\"></a>',0);
/*!40000 ALTER TABLE `ty_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_ip`
--

DROP TABLE IF EXISTS `ty_ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_ip` (
  `ip` char(50) NOT NULL,
  `flag` char(10) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_ip`
--

LOCK TABLES `ty_ip` WRITE;
/*!40000 ALTER TABLE `ty_ip` DISABLE KEYS */;
INSERT INTO `ty_ip` VALUES ('127.0.0.1','');
/*!40000 ALTER TABLE `ty_ip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_links`
--

DROP TABLE IF EXISTS `ty_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_links` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `worlds` char(30) NOT NULL,
  `www_url` char(40) NOT NULL,
  `wap_url` char(40) DEFAULT NULL,
  `email` char(20) NOT NULL,
  `date` datetime NOT NULL,
  `sort` int(3) DEFAULT NULL,
  `pass_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`worlds`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_links`
--

LOCK TABLES `ty_links` WRITE;
/*!40000 ALTER TABLE `ty_links` DISABLE KEYS */;
INSERT INTO `ty_links` VALUES (22,'黑李白的博客','http://blog.ibolee.com','','info@ibolee.com','0000-00-00 00:00:00',3,1),(20,'Jacy\'s Notes','http://jacy.me/','','jacy.hao@gmail.com','0000-00-00 00:00:00',1,1),(18,'顾宗祥博客','http://www.zxgrow.com','','tianyu0915@gmail.com','0000-00-00 00:00:00',2,1),(25,'WordpressThemes','http://www.puppin.org/','','yuebinliu@gmail.com','0000-00-00 00:00:00',5,1),(24,'流水西否','http://gsdme.com/','','tianyu0915@gmail.com','2011-01-28 00:00:00',4,1),(29,'柚子.如是说','http://www.xuxuan.name/','','xuxuan@yeah.net','2011-01-30 00:00:00',6,1);
/*!40000 ALTER TABLE `ty_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_msgs`
--

DROP TABLE IF EXISTS `ty_msgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_msgs` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `text` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` datetime NOT NULL,
  `ip` varchar(600) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `flag` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_msgs`
--

LOCK TABLES `ty_msgs` WRITE;
/*!40000 ALTER TABLE `ty_msgs` DISABLE KEYS */;
INSERT INTO `ty_msgs` VALUES (181,'asdf','2011-01-25 15:26:33','127.0.0.1',1);
/*!40000 ALTER TABLE `ty_msgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_viewer`
--

DROP TABLE IF EXISTS `ty_viewer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_viewer` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ip` char(20) NOT NULL,
  `time` datetime NOT NULL,
  `wap` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_viewer`
--

LOCK TABLES `ty_viewer` WRITE;
/*!40000 ALTER TABLE `ty_viewer` DISABLE KEYS */;
INSERT INTO `ty_viewer` VALUES (1,'123.23.223.','2010-08-14 17:36:20',0),(41,'127.0.0.1','2010-08-14 22:44:02',0),(42,'127.0.0.1','2010-08-15 12:22:33',0),(43,'127.0.0.1','2010-08-19 23:59:13',0),(44,'127.0.0.1','2010-08-20 00:20:52',0),(45,'127.0.0.1','2010-09-11 18:41:15',0),(46,'127.0.0.1','2010-09-13 23:22:10',0),(47,'127.0.0.1','2010-09-14 23:19:43',0),(48,'127.0.0.1','2010-09-16 23:54:17',0),(49,'127.0.0.1','2010-09-17 18:54:43',0),(50,'127.0.0.1','2010-09-19 23:24:19',0),(51,'127.0.0.1','2010-09-21 21:14:01',0),(52,'127.0.0.1','2010-09-23 18:05:11',1),(53,'127.0.0.1','2010-09-24 23:59:58',0),(54,'127.0.0.1','2010-09-25 13:22:25',0),(55,'127.0.0.1','2010-09-26 18:59:45',0),(56,'127.0.0.1','2010-10-07 18:07:51',0),(57,'127.0.0.1','2010-10-10 23:01:28',0),(58,'127.0.0.1','2010-10-19 12:13:35',0),(59,'127.0.0.1','2010-11-07 17:32:09',0),(60,'127.0.0.1','2010-11-11 21:58:08',0),(61,'127.0.0.1','2010-11-12 13:19:43',0),(62,'127.0.0.1','2010-11-15 12:18:49',0),(63,'127.0.0.1','2010-11-17 20:58:53',0),(64,'127.0.0.1','2010-11-18 23:07:48',0),(65,'127.0.0.1','2010-11-19 13:23:46',0),(66,'127.0.0.1','2010-11-21 22:00:58',0),(67,'127.0.0.1','2010-11-22 23:05:38',0),(68,'127.0.0.1','2010-11-23 23:03:59',0),(69,'127.0.0.1','2010-11-24 23:02:35',0),(70,'127.0.0.1','2010-11-25 22:44:47',0),(71,'127.0.0.1','2010-11-26 13:26:40',0),(72,'127.0.0.1','2010-11-27 22:42:25',0),(73,'127.0.0.1','2010-11-28 15:09:39',0),(74,'127.0.0.1','2010-11-29 12:48:46',0),(75,'127.0.0.1','2010-12-01 17:46:50',0),(76,'127.0.0.1','2010-12-05 17:54:08',0),(77,'127.0.0.1','2010-12-06 13:11:28',0),(78,'127.0.0.1','2010-12-09 22:20:06',0),(79,'127.0.0.1','2010-12-10 19:48:32',0),(80,'127.0.0.1','2010-12-13 16:59:31',0),(81,'127.0.0.1','2010-12-14 18:39:16',1),(82,'127.0.0.1','2010-12-15 21:44:06',1),(83,'127.0.0.1','2010-12-16 18:18:54',0),(84,'127.0.0.1','2010-12-18 17:59:48',0);
/*!40000 ALTER TABLE `ty_viewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_works`
--

DROP TABLE IF EXISTS `ty_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_works` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` char(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pic` char(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` char(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '文件类型',
  `file` char(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '文件格式',
  `date` char(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `down_link` char(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_works`
--

LOCK TABLES `ty_works` WRITE;
/*!40000 ALTER TABLE `ty_works` DISABLE KEYS */;
INSERT INTO `ty_works` VALUES (7,'考试年历表','works-1.jpg','平面设计','PSD','2009',NULL),(8,'西安翻译学院笔记本封面','works-2.jpg','平面设计','PSD','2010',NULL),(9,'《我的团长我的团》海报','works-3.jpg','平面设计','PSD','2010',NULL),(1,'某工作室网站','works-6.jpg','web程序设计','PHP+MYSQL','2009',NULL),(2,'单用户微博系统','works-5.jpg','web程序设计','PHP+MYSQL','2010',NULL),(3,'学生信息管理系统','works-4.jpg','web程序设计','PHP+SQLserver','2009',NULL);
/*!40000 ALTER TABLE `ty_works` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_worlds`
--

DROP TABLE IF EXISTS `ty_worlds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_worlds` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `text` varchar(450) CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `last_time` datetime DEFAULT NULL,
  `iswap` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=301 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_worlds`
--

LOCK TABLES `ty_worlds` WRITE;
/*!40000 ALTER TABLE `ty_worlds` DISABLE KEYS */;
INSERT INTO `ty_worlds` VALUES (299,'test','2012-10-16 14:30:45',NULL,NULL),(300,'hello world','2012-10-16 14:30:51',NULL,NULL);
/*!40000 ALTER TABLE `ty_worlds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_worlds_pics`
--

DROP TABLE IF EXISTS `ty_worlds_pics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_worlds_pics` (
  `w_id` int(5) NOT NULL,
  `p_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  PRIMARY KEY (`w_id`,`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_worlds_pics`
--

LOCK TABLES `ty_worlds_pics` WRITE;
/*!40000 ALTER TABLE `ty_worlds_pics` DISABLE KEYS */;
/*!40000 ALTER TABLE `ty_worlds_pics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ty_worlds_responses`
--

DROP TABLE IF EXISTS `ty_worlds_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ty_worlds_responses` (
  `w_id` int(5) NOT NULL,
  `r_id` int(5) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) CHARACTER SET utf8 NOT NULL,
  `ip` char(20) CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `flag` smallint(1) DEFAULT '0',
  `name` char(50) COLLATE utf8_bin DEFAULT NULL,
  `url` char(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`w_id`,`r_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ty_worlds_responses`
--

LOCK TABLES `ty_worlds_responses` WRITE;
/*!40000 ALTER TABLE `ty_worlds_responses` DISABLE KEYS */;
INSERT INTO `ty_worlds_responses` VALUES (111,1,'','222','0000-00-00 00:00:00',0,NULL,NULL),(111,2,'','222','0000-00-00 00:00:00',0,NULL,NULL),(111,3,'','222','0000-00-00 00:00:00',0,NULL,NULL),(111,4,'','222','0000-00-00 00:00:00',0,NULL,NULL),(111,5,'','222','0000-00-00 00:00:00',0,'22','22');
/*!40000 ALTER TABLE `ty_worlds_responses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-16 14:46:04
