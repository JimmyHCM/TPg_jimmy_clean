/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tpgFront
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `appRequest`
--

DROP TABLE IF EXISTS `appRequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appRequest` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `appNo` int(10) unsigned NOT NULL,
  `request` char(1) DEFAULT NULL,
  `requestTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146131 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appRequest`
--

LOCK TABLES `appRequest` WRITE;
/*!40000 ALTER TABLE `appRequest` DISABLE KEYS */;
/*!40000 ALTER TABLE `appRequest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `application` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `createDate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` char(1) DEFAULT NULL,
  `lastLogon` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `studStatus` tinyint(2) unsigned DEFAULT 0,
  `appStatus` char(1) DEFAULT 'C',
  `mediaSurvey` char(1) DEFAULT 'N',
  `uni1` char(100) DEFAULT NULL,
  `uni2` char(100) DEFAULT NULL,
  `uni3` char(100) DEFAULT NULL,
  `degree1` char(100) DEFAULT NULL,
  `degree2` char(100) DEFAULT NULL,
  `degree3` char(50) DEFAULT NULL,
  `isChina1` char(1) DEFAULT NULL,
  `isChina2` char(1) DEFAULT NULL,
  `isChina3` char(1) DEFAULT NULL,
  `statusMsg` text DEFAULT NULL,
  `multiApp` char(1) NOT NULL DEFAULT 'N',
  `multiID` int(5) unsigned NOT NULL DEFAULT 0,
  `currCode` int(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationNew`
--

DROP TABLE IF EXISTS `applicationNew`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicationNew` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `email` char(60) DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicationNew`
--

LOCK TABLES `applicationNew` WRITE;
/*!40000 ALTER TABLE `applicationNew` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicationNew` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationProcessed`
--

DROP TABLE IF EXISTS `applicationProcessed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicationProcessed` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `email` char(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicationProcessed`
--

LOCK TABLES `applicationProcessed` WRITE;
/*!40000 ALTER TABLE `applicationProcessed` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicationProcessed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationTemp`
--

DROP TABLE IF EXISTS `applicationTemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicationTemp` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `email` char(60) DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicationTemp`
--

LOCK TABLES `applicationTemp` WRITE;
/*!40000 ALTER TABLE `applicationTemp` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicationTemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avgMark`
--

DROP TABLE IF EXISTS `avgMark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `avgMark` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `appNo` int(10) unsigned DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `avgMarkC1` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkP1` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkP2` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkP3` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkP4` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkP5` decimal(5,1) NOT NULL DEFAULT 0.0,
  `avgMarkByStud1` char(10) DEFAULT NULL,
  `avgMarkByStud2` char(10) DEFAULT NULL,
  `avgMarkByStud3` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avgMark`
--

LOCK TABLES `avgMark` WRITE;
/*!40000 ALTER TABLE `avgMark` DISABLE KEYS */;
/*!40000 ALTER TABLE `avgMark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatHistoryApp`
--

DROP TABLE IF EXISTS `chatHistoryApp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatHistoryApp` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `newMessage` text DEFAULT NULL,
  `allMessage` mediumtext DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatHistoryApp`
--

LOCK TABLES `chatHistoryApp` WRITE;
/*!40000 ALTER TABLE `chatHistoryApp` DISABLE KEYS */;
/*!40000 ALTER TABLE `chatHistoryApp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currInfo`
--

DROP TABLE IF EXISTS `currInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `currInfo` (
  `currCode` int(3) unsigned NOT NULL DEFAULT 0,
  `currTitle` char(20) DEFAULT NULL,
  `titleDisplay` char(65) DEFAULT NULL,
  `fee` int(7) unsigned DEFAULT NULL,
  `totalCredit` char(6) DEFAULT NULL,
  `RSfooterLFT` varchar(500) DEFAULT NULL,
  `RSfooterLPT` varchar(500) DEFAULT NULL,
  `feeL` int(7) unsigned DEFAULT NULL,
  `feeNL` int(7) unsigned DEFAULT NULL,
  `instaL2FT` int(7) unsigned DEFAULT NULL,
  `instaL4PT` int(7) unsigned DEFAULT NULL,
  `instaNL2FT` int(7) unsigned DEFAULT NULL,
  `instaNL4PT` int(7) unsigned DEFAULT NULL,
  `RSfooterNLFT` varchar(500) DEFAULT NULL,
  `RSfooterNLPT` varchar(500) DEFAULT NULL,
  `dept` char(5) DEFAULT NULL,
  `chatBox` char(1) DEFAULT 'N',
  PRIMARY KEY (`currCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currInfo`
--

LOCK TABLES `currInfo` WRITE;
/*!40000 ALTER TABLE `currInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `currInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enggStaff`
--

DROP TABLE IF EXISTS `enggStaff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `enggStaff` (
  `portalID` char(8) NOT NULL,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` char(60) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  PRIMARY KEY (`portalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enggStaff`
--

LOCK TABLES `enggStaff` WRITE;
/*!40000 ALTER TABLE `enggStaff` DISABLE KEYS */;
/*!40000 ALTER TABLE `enggStaff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediaLog`
--

DROP TABLE IF EXISTS `mediaLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mediaLog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appNo` int(10) unsigned NOT NULL,
  `media1` char(30) DEFAULT NULL,
  `media2` char(30) DEFAULT NULL,
  `media3` char(30) DEFAULT NULL,
  `media4` char(30) DEFAULT NULL,
  `media5` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54545 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediaLog`
--

LOCK TABLES `mediaLog` WRITE;
/*!40000 ALTER TABLE `mediaLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `mediaLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediaMap`
--

DROP TABLE IF EXISTS `mediaMap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mediaMap` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `mediaName` char(30) DEFAULT NULL,
  `order` int(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediaMap`
--

LOCK TABLES `mediaMap` WRITE;
/*!40000 ALTER TABLE `mediaMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `mediaMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiApp`
--

DROP TABLE IF EXISTS `multiApp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `multiApp` (
  `multiID` int(8) unsigned NOT NULL,
  `appNo` int(10) unsigned DEFAULT NULL,
  `appNoList` tinytext DEFAULT NULL,
  `isNew` char(1) DEFAULT 'N',
  PRIMARY KEY (`multiID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiApp`
--

LOCK TABLES `multiApp` WRITE;
/*!40000 ALTER TABLE `multiApp` DISABLE KEYS */;
/*!40000 ALTER TABLE `multiApp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offerReply`
--

DROP TABLE IF EXISTS `offerReply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `offerReply` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 1100000000,
  `replyStatus` char(1) DEFAULT NULL,
  `currCode` int(3) unsigned DEFAULT NULL,
  `appName` char(60) DEFAULT NULL,
  `studyMode` char(1) DEFAULT NULL,
  `acadPlanCode` char(10) DEFAULT NULL,
  `issueDate` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `replyDate` date DEFAULT NULL,
  `provisional` char(1) DEFAULT NULL,
  `recommendation` char(2) DEFAULT NULL,
  `signature` char(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admYear` int(4) unsigned DEFAULT NULL,
  `isLocal` char(1) DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offerReply`
--

LOCK TABLES `offerReply` WRITE;
/*!40000 ALTER TABLE `offerReply` DISABLE KEYS */;
/*!40000 ALTER TABLE `offerReply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rsUpload`
--

DROP TABLE IF EXISTS `rsUpload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rsUpload` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `appNo` int(10) unsigned NOT NULL,
  `recommendation` char(2) DEFAULT NULL,
  `uploadTime` datetime DEFAULT NULL,
  `replyStatus` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26230 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rsUpload`
--

LOCK TABLES `rsUpload` WRITE;
/*!40000 ALTER TABLE `rsUpload` DISABLE KEYS */;
/*!40000 ALTER TABLE `rsUpload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessionsLog`
--

DROP TABLE IF EXISTS `sessionsLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessionsLog` (
  `sessionID` varchar(40) NOT NULL DEFAULT '0',
  `ipAddress` varchar(45) NOT NULL DEFAULT '0',
  `userAgent` varchar(120) NOT NULL DEFAULT '0',
  `lastActivity` int(10) unsigned NOT NULL DEFAULT 0,
  `userData` text NOT NULL,
  PRIMARY KEY (`sessionID`),
  KEY `lastActivityIdx` (`lastActivity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessionsLog`
--

LOCK TABLES `sessionsLog` WRITE;
/*!40000 ALTER TABLE `sessionsLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessionsLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `streamInfo`
--

DROP TABLE IF EXISTS `streamInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `streamInfo` (
  `acadPlanCode` char(10) NOT NULL,
  `acadPlanTitle` char(50) DEFAULT NULL,
  PRIMARY KEY (`acadPlanCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `streamInfo`
--

LOCK TABLES `streamInfo` WRITE;
/*!40000 ALTER TABLE `streamInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `streamInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supportDoc`
--

DROP TABLE IF EXISTS `supportDoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `supportDoc` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 0,
  `createDate` datetime DEFAULT NULL,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fileStatus` char(65) DEFAULT NULL,
  `englishTest` char(5) DEFAULT NULL,
  `other1` char(12) DEFAULT NULL,
  `other2` char(12) DEFAULT NULL,
  `other3` char(12) DEFAULT NULL,
  `pNo` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `currStud` char(1) NOT NULL DEFAULT 'N',
  `titleC1` char(15) DEFAULT NULL,
  `titleP1` char(15) DEFAULT NULL,
  `titleP2` char(15) DEFAULT NULL,
  `titleP3` char(15) DEFAULT NULL,
  UNIQUE KEY `appNoSupportDoc` (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supportDoc`
--

LOCK TABLES `supportDoc` WRITE;
/*!40000 ALTER TABLE `supportDoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `supportDoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supportDocHistory`
--

DROP TABLE IF EXISTS `supportDocHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `supportDocHistory` (
  `appNo` int(10) unsigned NOT NULL,
  `createDate` datetime DEFAULT NULL,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fileStatus` char(65) DEFAULT NULL,
  `englishTest` enum('T','I','G','S','C') DEFAULT NULL,
  `other1` char(12) DEFAULT NULL,
  `other2` char(12) DEFAULT NULL,
  `other3` char(12) DEFAULT NULL,
  `pNo` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `currStud` char(1) NOT NULL DEFAULT 'N',
  `titleC1` char(15) DEFAULT NULL,
  `titleP1` char(15) DEFAULT NULL,
  `titleP2` char(15) DEFAULT NULL,
  `titleP3` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supportDocHistory`
--

LOCK TABLES `supportDocHistory` WRITE;
/*!40000 ALTER TABLE `supportDocHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `supportDocHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supportDocReview`
--

DROP TABLE IF EXISTS `supportDocReview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `supportDocReview` (
  `appNo` int(10) unsigned NOT NULL DEFAULT 0,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fileStatus` char(65) DEFAULT NULL,
  PRIMARY KEY (`appNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supportDocReview`
--

LOCK TABLES `supportDocReview` WRITE;
/*!40000 ALTER TABLE `supportDocReview` DISABLE KEYS */;
/*!40000 ALTER TABLE `supportDocReview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Host` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `User` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `Password` char(41) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `Select_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Insert_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Update_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Delete_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Drop_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Reload_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Shutdown_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Process_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `File_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Grant_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `References_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Index_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Alter_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Show_db_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Super_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_tmp_table_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Lock_tables_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Execute_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Repl_slave_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Repl_client_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_view_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Show_view_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_routine_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Alter_routine_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_user_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Event_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Trigger_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `Create_tablespace_priv` enum('N','Y') NOT NULL DEFAULT 'N',
  `ssl_type` enum('','ANY','X509','SPECIFIED') NOT NULL DEFAULT '',
  `ssl_cipher` blob NOT NULL,
  `x509_issuer` blob NOT NULL,
  `x509_subject` blob NOT NULL,
  `max_questions` int(11) unsigned NOT NULL DEFAULT 0,
  `max_updates` int(11) unsigned NOT NULL DEFAULT 0,
  `max_connections` int(11) unsigned NOT NULL DEFAULT 0,
  `max_user_connections` int(11) NOT NULL DEFAULT 0,
  `plugin` char(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `authentication_string` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variations`
--

DROP TABLE IF EXISTS `variations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `variations` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `lastModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` varchar(25) DEFAULT NULL,
  `replaceBy` varchar(500) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variations`
--

LOCK TABLES `variations` WRITE;
/*!40000 ALTER TABLE `variations` DISABLE KEYS */;
/*!40000 ALTER TABLE `variations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-13 10:01:26
