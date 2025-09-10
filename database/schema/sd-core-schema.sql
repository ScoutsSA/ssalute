/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `admin_404_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_404_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `refURL` text,
  `actualURL` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_bad_logons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_bad_logons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `userAgent` varchar(1024) DEFAULT NULL,
  `usingMobile` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`,`date`),
  KEY `username` (`username`,`date`) USING BTREE,
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_banned_ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_banned_ips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `page` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_2` (`ip`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admin_good_logons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_good_logons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `roleID` int DEFAULT NULL,
  `fromSD` int NOT NULL DEFAULT '1',
  `groupID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `regionID` int DEFAULT NULL,
  `countryID` int DEFAULT NULL,
  `userAgent` varchar(1024) DEFAULT NULL,
  `usingMobile` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`date`) USING BTREE,
  KEY `districtID` (`districtID`,`date`) USING BTREE,
  KEY `regionID` (`regionID`,`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_cubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_cubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `cubID` int NOT NULL,
  `userID` int NOT NULL DEFAULT '0',
  `themeID` int NOT NULL DEFAULT '0',
  `advancementID` int NOT NULL,
  `advancementSecondID` int DEFAULT NULL,
  `advancementThirdID` int DEFAULT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `advancementDate` date DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0' COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advancementID` (`advancementID`),
  KEY `cubID` (`cubID`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`latest`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`cubID`,`active`,`advancementID`,`advancementSecondID`,`advancementThirdID`),
  KEY `cubID_2` (`cubID`,`advancementSecondID`,`advancementThirdID`,`active`),
  KEY `assocToRegion` (`assocToRegion`,`advancementID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`advancementID`,`active`,`latest`),
  KEY `assocToGroup_2` (`assocToGroup`,`advancementID`,`active`,`latest`),
  KEY `countryID` (`countryID`,`advancementID`,`active`,`latest`),
  KEY `assocToGroup_3` (`assocToGroup`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`latest`),
  KEY `cubID_5` (`cubID`,`active`),
  KEY `assocToGroup_4` (`assocToGroup`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`advancementDate`),
  KEY `assocToDistrict_2` (`assocToDistrict`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`advancementDate`),
  KEY `assocToRegion_2` (`assocToRegion`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`advancementDate`),
  KEY `countryID_2` (`countryID`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`advancementDate`),
  KEY `cubID_6` (`cubID`,`advancementID`,`active`),
  KEY `cubID_7` (`cubID`,`advancementID`,`advancementThirdID`,`active`,`programType`),
  KEY `assocToGroup_5` (`assocToGroup`,`active`,`advancementDate`),
  KEY `cubID_8` (`cubID`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`themeID`,`active`) USING BTREE,
  KEY `cubID_4` (`cubID`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`programType`,`themeID`) USING BTREE,
  KEY `userID` (`userID`,`PDFLocation`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `type` int NOT NULL DEFAULT '17',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `description` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `advancementFirstID` int NOT NULL,
  `advancementSecondID` int NOT NULL,
  `advancementThirdID` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `advancementFirstID` (`advancementFirstID`),
  KEY `advancementSecondID` (`advancementSecondID`),
  KEY `advancementThirdID` (`advancementThirdID`),
  KEY `assocToGroup` (`assocToGroup`,`userID`,`advancementFirstID`,`advancementSecondID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_meerkats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_meerkats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `meerkatID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `themeID` int NOT NULL DEFAULT '0',
  `advancementID` int NOT NULL,
  `advancementSecondID` int DEFAULT NULL,
  `advancementThirdID` int DEFAULT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `advancementDate` date DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0' COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advancementID` (`advancementID`),
  KEY `cubID` (`advancementID`,`advancementSecondID`,`advancementThirdID`,`latest`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`active`,`advancementID`,`advancementSecondID`,`advancementThirdID`),
  KEY `cubID_2` (`advancementSecondID`,`advancementThirdID`,`active`),
  KEY `assocToRegion` (`assocToRegion`,`advancementID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`advancementID`,`active`,`latest`),
  KEY `assocToGroup_2` (`assocToGroup`,`advancementID`,`active`,`latest`),
  KEY `countryID` (`countryID`,`advancementID`,`active`,`latest`),
  KEY `userID` (`userID`,`active`,`latest`),
  KEY `assocToGroup_3` (`assocToGroup`,`active`,`advancementDate`),
  KEY `userID_3` (`userID`,`active`) USING BTREE,
  KEY `userID_2` (`userID`,`advancementID`,`advancementSecondID`,`advancementThirdID`,`active`,`programType`,`themeID`) USING BTREE,
  KEY `userID_4` (`userID`,`PDFLocation`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `type` int DEFAULT '0',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `note` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `advancementFirstID` int NOT NULL,
  `advancementSecondID` int NOT NULL,
  `advancementThirdID` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `advancementFirstID` (`advancementFirstID`),
  KEY `advancementSecondID` (`advancementSecondID`),
  KEY `advancementThirdID` (`advancementThirdID`),
  KEY `assocToGroup` (`assocToGroup`,`userID`,`advancementFirstID`,`advancementSecondID`,`advancementThirdID`,`active`),
  KEY `assocToGroup_2` (`assocToGroup`,`userID`,`advancementFirstID`,`advancementSecondID`,`active`),
  KEY `type` (`type`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `type` int NOT NULL DEFAULT '17',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `description` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `thumbLocation` varchar(1024) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `advancementFirstID` int NOT NULL,
  `advancementSecondID` int NOT NULL,
  `advancementThirdID` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `advancementFirstID` (`advancementFirstID`),
  KEY `advancementSecondID` (`advancementSecondID`),
  KEY `advancementThirdID` (`advancementThirdID`),
  KEY `assocToGroup` (`assocToGroup`,`userID`,`advancementFirstID`,`advancementSecondID`,`active`),
  KEY `type` (`type`,`userID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_rovers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_rovers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `roverID` int NOT NULL,
  `userID` int NOT NULL DEFAULT '0',
  `themeID` int NOT NULL DEFAULT '0',
  `advancementID` int NOT NULL,
  `advancement2ID` int DEFAULT NULL,
  `advancementDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = Active',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Latest',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roverID` (`roverID`),
  KEY `advancementID` (`advancementID`),
  KEY `roverID_2` (`roverID`,`advancementID`,`advancement2ID`,`latest`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`advancementID`,`active`,`latest`),
  KEY `countryID` (`countryID`,`advancementID`,`active`,`latest`),
  KEY `assocToRegion` (`assocToRegion`,`advancementID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`advancementID`,`active`,`latest`),
  KEY `roverID_3` (`roverID`,`advancementID`,`advancement2ID`,`active`,`programType`),
  KEY `assocToGroup_2` (`assocToGroup`,`active`,`advancementDate`),
  KEY `roverID_4` (`roverID`,`active`) USING BTREE,
  KEY `userID` (`userID`,`PDFLocation`(767)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_scouters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_scouters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assocToGroup` int NOT NULL,
  `scouterID` int NOT NULL,
  `advancementID` int NOT NULL,
  `advancementDate` date NOT NULL,
  `notes` text,
  `latest` int NOT NULL COMMENT '1 = latest',
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `scoutID` (`scouterID`),
  KEY `advancementID` (`advancementID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `advancement_scouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advancement_scouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `scoutID` int NOT NULL,
  `userID` int DEFAULT '0',
  `themeID` int NOT NULL DEFAULT '0',
  `advancementID` int NOT NULL,
  `advancement2ID` int DEFAULT NULL,
  `advancementDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `approvedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advancementID` (`advancementID`),
  KEY `scoutID_2` (`scoutID`,`advancementID`,`advancement2ID`,`latest`,`active`),
  KEY `scoutID_3` (`scoutID`,`assocToGroup`,`advancementID`,`advancement2ID`,`active`),
  KEY `programType` (`programType`,`scoutID`,`advancementID`,`advancement2ID`),
  KEY `createdby` (`createdby`,`programType`,`approvedBy`,`active`),
  KEY `scoutProgramTypeID` (`scoutProgramTypeID`,`scoutID`,`advancementID`,`advancement2ID`,`latest`,`active`),
  KEY `countryID_2` (`countryID`,`advancementID`,`active`,`latest`),
  KEY `assocToRegion` (`assocToRegion`,`advancementID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`advancementID`,`active`,`latest`),
  KEY `assocToGroup` (`assocToGroup`,`advancementID`,`active`,`latest`),
  KEY `scoutID_4` (`scoutID`,`advancementID`,`advancement2ID`,`active`),
  KEY `programType_2` (`programType`,`scoutID`,`advancement2ID`,`active`),
  KEY `scoutID` (`scoutID`,`active`),
  KEY `createdby_2` (`createdby`,`approvedBy`,`active`),
  KEY `scoutID_7` (`scoutID`,`advancementID`,`active`),
  KEY `assocToGroup_3` (`assocToGroup`,`active`,`advancementDate`),
  KEY `countryID` (`countryID`,`advancementID`,`advancement2ID`,`active`) USING BTREE,
  KEY `assocToGroup_2` (`assocToGroup`,`advancementID`,`advancement2ID`,`themeID`,`active`,`advancementDate`) USING BTREE,
  KEY `assocToDistrict_2` (`assocToDistrict`,`advancementID`,`advancement2ID`,`themeID`,`active`,`advancementDate`) USING BTREE,
  KEY `assocToRegion_2` (`assocToRegion`,`advancementID`,`advancement2ID`,`themeID`,`active`,`advancementDate`) USING BTREE,
  KEY `countryID_3` (`countryID`,`advancementID`,`advancement2ID`,`themeID`,`active`,`advancementDate`) USING BTREE,
  KEY `scoutID_6` (`scoutID`,`advancementID`,`advancement2ID`,`active`,`programType`,`themeID`) USING BTREE,
  KEY `userID` (`userID`,`PDFLocation`) USING BTREE,
  KEY `scoutID_5` (`scoutID`,`advancementID`,`themeID`,`active`,`advancement2ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_adult_leader_moves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_adult_leader_moves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `userID` int NOT NULL,
  `fromPosition` int NOT NULL,
  `ToPosition` int NOT NULL,
  `fromGroup` int NOT NULL,
  `toGroup` int NOT NULL,
  `fromDistrict` int NOT NULL,
  `toDistrict` int NOT NULL,
  `effectiveDate` date NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_award_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_award_applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `userID` int NOT NULL,
  `awardHeadingID` int NOT NULL,
  `awardTypeID` int NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `awardDate` datetime DEFAULT NULL,
  `awardedBy` int DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedBy` int DEFAULT NULL,
  `awardType` varchar(255) DEFAULT NULL,
  `awardDescription` text,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_award_headings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_award_headings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_award_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_award_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `awardHeadingID` int NOT NULL,
  `awardTypeID` int NOT NULL,
  `awardDate` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_award_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_award_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `headingID` int NOT NULL,
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `headingID` (`headingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_charge_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_charge_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `chargeTypeID` int NOT NULL,
  `chargeNr` varchar(225) NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `issueDate` date NOT NULL,
  `expireDate` date NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_charge_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_charge_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `forScouts` int NOT NULL DEFAULT '0',
  `shortName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_criminal_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_criminal_check` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `userID` int NOT NULL,
  `criminalType` varchar(255) NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_disciplinary_headings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_disciplinary_headings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_disciplinary_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_disciplinary_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `disciplinaryHeadingID` int NOT NULL,
  `disciplinaryType` int NOT NULL,
  `sanction` varchar(255) NOT NULL,
  `expireDate` date DEFAULT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_disciplinary_offences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_disciplinary_offences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `headingID` int NOT NULL,
  `offense` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_document_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_document_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `aamForm` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_document_types_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_document_types_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `userID` int NOT NULL,
  `assocToRegion` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `documentTypeID` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `assocToDistrict` (`assocToDistrict`),
  KEY `documentTypeID` (`documentTypeID`),
  KEY `userID` (`userID`,`active`),
  KEY `userID_2` (`userID`,`documentTypeID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_documents_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_documents_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `documentTypeID` int NOT NULL,
  `description` varchar(1024) NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `validUntilDate` date NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `assocToDistrict` (`assocToDistrict`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_highest_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_highest_education` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_marital_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_marital_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_past_service_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_past_service_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `userID` int NOT NULL,
  `pastServiceType` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `otherRegionName` varchar(255) DEFAULT NULL,
  `otherDistrictName` varchar(255) DEFAULT NULL,
  `otherGroupName` varchar(255) DEFAULT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `toBeFixed` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_past_service_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_past_service_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `newID` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_police_clearance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_police_clearance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `result` text NOT NULL,
  `documentLocation` varchar(1024) DEFAULT NULL,
  `dateDone` date NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_resign_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_resign_leader` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `resignDate` date NOT NULL,
  `resignReasonID` int NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_resign_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_resign_reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_retire_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_retire_leader` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `retiredDate` date NOT NULL,
  `retiredReasonID` int NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_retire_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_retire_reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_suspend_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_suspend_leader` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `assocToRegion` int DEFAULT '0',
  `assocToDistrict` int DEFAULT '0',
  `assocToGroup` int DEFAULT '0',
  `userID` int NOT NULL,
  `suspendDate` date DEFAULT NULL,
  `suspenReasonID` int DEFAULT NULL,
  `unsuspendDate` datetime DEFAULT NULL,
  `unsuspendedby` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_suspend_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_suspend_reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_terminate_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_terminate_leader` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `terminateDate` date NOT NULL,
  `terminateReasonID` int NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_terminate_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_terminate_reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `courseType` int DEFAULT NULL,
  `assocToRegion` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `agendaPDFLocation` varchar(1024) DEFAULT NULL,
  `materialPDFLocation` varchar(1024) DEFAULT NULL,
  `nrOfDays` int NOT NULL,
  `trainingSeats` int DEFAULT NULL,
  `maxBookings` int DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `forAdultLeadersAndRovers` int NOT NULL DEFAULT '1',
  `forParents` int NOT NULL DEFAULT '0',
  `forScouts` int NOT NULL DEFAULT '0',
  `assocToRegion` int NOT NULL,
  `courseID` varchar(255) NOT NULL,
  `courseNumber` varchar(255) NOT NULL,
  `directorID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `locationID` int NOT NULL,
  `courseCost` int NOT NULL DEFAULT '0',
  `bookingCutOffDate` date NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `previousQuali` varchar(255) DEFAULT NULL,
  `maxBookings` int DEFAULT NULL,
  `warrantCourse` int DEFAULT NULL,
  `ical` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courseID` (`courseID`),
  KEY `assocToRegion` (`assocToRegion`,`active`,`bookingCutOffDate`),
  KEY `countryID` (`countryID`,`assocToRegion`,`startDate`,`active`),
  KEY `countryID_2` (`countryID`,`assocToRegion`,`endDate`,`active`),
  KEY `locationID` (`locationID`,`startDate`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `annualCourseID` int NOT NULL,
  `dayID` int NOT NULL,
  `dayDate` date NOT NULL,
  `userID` int NOT NULL,
  `attendance` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `userID` (`userID`),
  KEY `active` (`active`),
  KEY `annualCourseID` (`annualCourseID`,`userID`,`active`,`dayID`),
  KEY `annualCourseID_2` (`annualCourseID`,`userID`,`active`,`attendance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `status` int NOT NULL COMMENT '1 = Provisional, 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled',
  `assocToRegion` int NOT NULL,
  `bookingLocation` varchar(100) NOT NULL DEFAULT 'AMS',
  `annualCourseID` int NOT NULL,
  `userID` int NOT NULL,
  `instructions` text,
  `previousCourses` text,
  `invoiceLocation` varchar(1024) DEFAULT NULL,
  `POPLocation` varchar(1024) DEFAULT NULL,
  `bugMailCount` int DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `completionConfirmed` int NOT NULL DEFAULT '0',
  `userPIN` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `status` (`status`),
  KEY `active` (`active`,`assocToRegion`),
  KEY `userID_2` (`userID`,`active`,`created`),
  KEY `annualCourseID` (`annualCourseID`,`active`,`status`),
  KEY `userID` (`userID`,`active`,`status`,`created`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_bookings_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_bookings_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `bookingID` int NOT NULL,
  `annualCourseID` int NOT NULL,
  `userID` int NOT NULL,
  `note` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`bookingID`,`annualCourseID`,`active`),
  KEY `annualCourseID` (`annualCourseID`,`userID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_bookings_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_bookings_tracking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `bookingID` int NOT NULL,
  `annualCourseID` int NOT NULL,
  `userID` int NOT NULL,
  `fromStatus` int NOT NULL,
  `toStatus` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annualCourseID` (`annualCourseID`),
  KEY `userID` (`userID`),
  KEY `bookingID` (`bookingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '1',
  `courseID` int NOT NULL,
  `dayNr` int NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courseID` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_lecturers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annualCourseID` int NOT NULL,
  `lecturerID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annualCourseID` (`annualCourseID`,`active`),
  KEY `lecturerID` (`lecturerID`,`annualCourseID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_annual_warrants_available`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_annual_warrants_available` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annualCourseID` int NOT NULL,
  `warrantID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annualCourseID` (`annualCourseID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_courses_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_courses_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `colour` varchar(100) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gpsLat` varchar(255) NOT NULL,
  `gpsLon` varchar(255) NOT NULL,
  `trainingSeats` int NOT NULL,
  `contact` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `cell` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`assocToRegion`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_past`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_past` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `trainingTypeID` int DEFAULT NULL,
  `courseName` text,
  `courseNumber` varchar(255) NOT NULL,
  `completionDate` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `validated` int NOT NULL DEFAULT '0' COMMENT '1 = Validated',
  `validatedDate` datetime DEFAULT NULL,
  `validatedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `userID` (`userID`,`active`,`trainingTypeID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_training_past_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_training_past_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `code` int DEFAULT NULL,
  `calendarColour` varchar(25) DEFAULT NULL,
  `shortName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '2',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_warrant_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_warrant_applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `userID` int NOT NULL,
  `warrantTypeID` int NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `awardDate` datetime DEFAULT NULL,
  `awardedBy` int DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedBy` int DEFAULT NULL,
  `awardType` varchar(255) DEFAULT NULL,
  `awardDescription` text,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `assocToRegion` (`assocToRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_warrant_cancellation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_warrant_cancellation_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_warrant_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_warrant_extensions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int DEFAULT NULL,
  `warrantID` int NOT NULL,
  `userID` int NOT NULL,
  `oldExpireDate` date NOT NULL,
  `newExpireDate` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `warrantID` (`warrantID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_warrant_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_warrant_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL DEFAULT '0',
  `userID` int NOT NULL,
  `roleID` int DEFAULT NULL,
  `warrantTypeID` int DEFAULT NULL,
  `warrantNr` varchar(225) NOT NULL,
  `warrantName` varchar(255) DEFAULT NULL,
  `limited` int NOT NULL DEFAULT '0',
  `appointment` int NOT NULL DEFAULT '0',
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `issueDate` date NOT NULL,
  `expireDate` date NOT NULL,
  `cancellationTypeID` int DEFAULT NULL,
  `cancelationNotes` text,
  `expireEmailCount` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToRegion` (`assocToRegion`),
  KEY `userID` (`userID`,`expireDate`,`active`),
  KEY `userID_2` (`userID`,`countryID`,`assocToRegion`,`assocToDistrict`,`assocToGroup`,`active`,`expireDate`,`roleID`),
  KEY `countryID` (`countryID`,`warrantNr`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ams_warrant_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ams_warrant_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `shortName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `national` int NOT NULL DEFAULT '0',
  `region` int NOT NULL DEFAULT '0',
  `district` int NOT NULL DEFAULT '0',
  `group` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '2',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `api_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` longtext NOT NULL,
  `issuedToUserID` int NOT NULL,
  `information` longtext NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `api_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_usage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(45) DEFAULT NULL,
  `APICalled` varchar(45) DEFAULT NULL,
  `userAgent` longtext,
  `keyUsed` longtext,
  `presented` longtext,
  `response` longtext,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_cubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_cubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `cubID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `firstID` int NOT NULL,
  `secondID` int DEFAULT NULL,
  `badgeDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`),
  KEY `cubID` (`cubID`,`active`,`secondID`),
  KEY `countryID` (`countryID`,`firstID`,`secondID`),
  KEY `countryID_2` (`countryID`,`firstID`,`active`,`latest`),
  KEY `assocToRegion` (`assocToRegion`,`firstID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`firstID`,`active`,`latest`),
  KEY `assocToGroup` (`assocToGroup`,`firstID`,`active`,`latest`),
  KEY `cubID_2` (`cubID`,`firstID`,`secondID`,`active`) USING BTREE,
  KEY `userID` (`userID`,`PDFLocation`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `type` int NOT NULL DEFAULT '17',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `description` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `badgeFirstID` int NOT NULL,
  `badgeSecondID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `advancementFirstID` (`badgeFirstID`),
  KEY `advancementSecondID` (`badgeSecondID`),
  KEY `userID` (`userID`,`badgeFirstID`,`badgeSecondID`,`type`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_meerkats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_meerkats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `meerkatID` int DEFAULT NULL,
  `userID` int NOT NULL,
  `firstID` int NOT NULL,
  `secondID` int DEFAULT NULL,
  `badgeDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `firstID` (`firstID`),
  KEY `cubID` (`userID`,`active`,`secondID`),
  KEY `countryID` (`countryID`,`firstID`,`secondID`),
  KEY `userID` (`userID`,`firstID`,`secondID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `type` int NOT NULL DEFAULT '17',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `note` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `firstID` int NOT NULL,
  `secondID` int NOT NULL,
  `thirdID` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `firstID` (`firstID`),
  KEY `secondID` (`secondID`),
  KEY `thirdID` (`thirdID`),
  KEY `userID` (`userID`,`firstID`,`secondID`,`type`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `type` int NOT NULL DEFAULT '17',
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `description` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `thumbLocation` varchar(1024) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `badgeFirstID` int NOT NULL,
  `badgeSecondID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `userID` (`userID`),
  KEY `advancementFirstID` (`badgeFirstID`),
  KEY `advancementSecondID` (`badgeSecondID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_rovers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_rovers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `roverID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `firstID` int NOT NULL,
  `secondID` int DEFAULT NULL,
  `badgeDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `approvedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`),
  KEY `countryID` (`countryID`,`firstID`,`active`,`latest`),
  KEY `assocToRegion` (`assocToRegion`,`firstID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`firstID`,`active`,`latest`),
  KEY `assocToGroup` (`assocToGroup`,`firstID`,`active`,`latest`),
  KEY `scoutID` (`roverID`,`active`,`secondID`),
  KEY `roverID` (`roverID`,`firstID`,`secondID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `badges_scouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges_scouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `scoutID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `firstID` int NOT NULL,
  `secondID` int DEFAULT NULL,
  `badgeDate` date NOT NULL,
  `notes` text,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `latest` int NOT NULL DEFAULT '0' COMMENT '1 = latest',
  `instructorsName` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `approvedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`),
  KEY `countryID` (`countryID`,`firstID`,`active`,`latest`),
  KEY `assocToRegion` (`assocToRegion`,`firstID`,`active`,`latest`),
  KEY `assocToDistrict` (`assocToDistrict`,`firstID`,`active`,`latest`),
  KEY `assocToGroup` (`assocToGroup`,`firstID`,`active`,`latest`),
  KEY `scoutID_2` (`scoutID`,`firstID`,`secondID`,`active`),
  KEY `scoutID` (`scoutID`,`active`,`secondID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `census_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `census_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `regionID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `XLSLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`) USING BTREE,
  KEY `regionID` (`regionID`,`active`) USING BTREE,
  KEY `districtID` (`districtID`,`active`) USING BTREE,
  KEY `groupID` (`groupID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `accountID` int NOT NULL,
  `qty` int NOT NULL,
  `productID` int NOT NULL,
  `active` int NOT NULL,
  `deliveryAddressID` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountID` (`accountID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_delivery_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_delivery_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `accountID` int DEFAULT NULL,
  `defaultAddress` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `unitNr` varchar(255) DEFAULT NULL,
  `complexName` varchar(255) DEFAULT NULL,
  `streetNr` varchar(10) NOT NULL,
  `streetName` varchar(255) NOT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postCode` varchar(5) NOT NULL,
  `country` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`accountID`),
  KEY `accountID` (`accountID`,`active`,`defaultAddress`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_delivery_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_delivery_providers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_delivery_providers_delivery_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_delivery_providers_delivery_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `providerID` int NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_group_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_group_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `accountID` int NOT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paidOutToGroup` int DEFAULT NULL,
  `paidOutDate` datetime DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupProduct` int DEFAULT NULL,
  `userID` int NOT NULL,
  `countryID` int DEFAULT NULL,
  `regionID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `deliveryAddressID` int NOT NULL,
  `deliveryOption` varchar(255) NOT NULL,
  `deliveryAmountIncVAT` decimal(11,2) NOT NULL DEFAULT '0.00',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `status` int DEFAULT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_orders_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_orders_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orderID` int NOT NULL,
  `userID` int NOT NULL,
  `productID` int NOT NULL,
  `qty` int NOT NULL,
  `unitPriceIncVat` decimal(7,2) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_payfast_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_payfast_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accountID` int NOT NULL,
  `userID` int NOT NULL,
  `status` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accountID` (`accountID`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL DEFAULT '0',
  `stockLocationID` int DEFAULT NULL,
  `stockSupplierID` int DEFAULT NULL,
  `catID` int DEFAULT NULL,
  `subCatID` int DEFAULT NULL,
  `subSubCatID` int DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `thumb` varchar(1024) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `extended` text,
  `featured` int NOT NULL DEFAULT '0',
  `onSale` int NOT NULL DEFAULT '0',
  `priceIncVAT` decimal(7,2) NOT NULL,
  `salePriceIncVAT` decimal(7,2) DEFAULT NULL,
  `costPriceIncVAT` decimal(7,2) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stockLocationID` (`stockLocationID`),
  KEY `catID` (`catID`,`subCatID`,`subSubCatID`),
  KEY `groupID` (`groupID`,`active`),
  KEY `groupID_2` (`groupID`,`featured`,`active`),
  KEY `groupID_3` (`groupID`,`onSale`,`active`),
  KEY `groupID_4` (`groupID`,`catID`,`active`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `extended` (`extended`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productID` int NOT NULL,
  `thumb` varchar(1024) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productID` int NOT NULL,
  `userID` int NOT NULL,
  `review` text NOT NULL,
  `stars` int DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `productID` (`productID`,`active`) USING BTREE,
  KEY `userID` (`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productID` int NOT NULL,
  `stockIn` int DEFAULT NULL,
  `stockOut` int DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_sub_subcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_sub_subcat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catID` int NOT NULL,
  `subCatID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_products_subcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_products_subcat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_search_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_search_queries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `catID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_shoppers_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_shoppers_logins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `fromLocation` varchar(255) NOT NULL,
  `userAgent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_stock_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_stock_locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `physAddress` text NOT NULL,
  `gpsLat` varchar(12) NOT NULL,
  `gpsLon` varchar(12) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `contactCell` varchar(25) NOT NULL,
  `contactEmail` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_stock_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_stock_suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `physAddress` text NOT NULL,
  `gpsLat` varchar(12) NOT NULL,
  `gpsLon` varchar(12) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `contactCell` varchar(25) NOT NULL,
  `contactEmail` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_wallet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_wallet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `accountID` int NOT NULL,
  `transactionType` int NOT NULL,
  `transactionID` varchar(1024) NOT NULL,
  `transactionAmountINCVAT` decimal(10,2) NOT NULL,
  `transactionDate` datetime NOT NULL,
  `active` int NOT NULL,
  `paidToGroup` int NOT NULL DEFAULT '0',
  `paidToGroupDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountID` (`accountID`,`transactionType`,`transactionAmountINCVAT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_wallets_transaction_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_wallets_transaction_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commerce_wish_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commerce_wish_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `accountID` int NOT NULL,
  `productID` int NOT NULL,
  `qty` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountID` (`accountID`,`active`),
  KEY `userID` (`userID`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directory_professional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_professional` (
  `id` int NOT NULL AUTO_INCREMENT,
  `companyName` varchar(255) NOT NULL,
  `countryID` int NOT NULL DEFAULT '196',
  `locationName` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `skills` text NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `pintrest` varchar(255) DEFAULT NULL,
  `googlePlus` varchar(1024) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contactPersonName` varchar(255) NOT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `contactTel` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `approved` int NOT NULL DEFAULT '0',
  `approvedBy` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `declined` int DEFAULT '0',
  `declinedBy` int DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedReason` varchar(1024) DEFAULT NULL,
  `declinedNotes` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`,`approved`,`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directory_professional_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_professional_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `directoryID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `directoryID` (`directoryID`,`active`,`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directory_professional_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_professional_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `directoryID` int NOT NULL,
  `review` text NOT NULL,
  `stars` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `approved` int NOT NULL DEFAULT '0',
  `approvedBy` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `declined` int NOT NULL DEFAULT '0',
  `declinedReasonID` int NOT NULL DEFAULT '0',
  `declinedby` int NOT NULL DEFAULT '0',
  `declinedDate` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `directoryID` (`directoryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directory_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directory_skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `skill` varchar(255) NOT NULL,
  `timesUsed` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `regionID` int NOT NULL,
  `superDistrictID` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `phys_address` text,
  `countryID` int NOT NULL DEFAULT '196',
  `active` int NOT NULL DEFAULT '1',
  `accountID` int NOT NULL DEFAULT '0',
  `censusDone` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regionID` (`regionID`,`active`),
  KEY `phys_country_id` (`countryID`,`regionID`,`active`),
  KEY `countryID` (`countryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `districts_super`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts_super` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `regionID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `accountID` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regionID` (`regionID`,`active`),
  KEY `countryID` (`active`),
  KEY `phys_country_id` (`countryID`,`regionID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `error_logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `error_logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `POST` longtext,
  `errorsFound` longtext,
  `userID` int NOT NULL,
  `roleID` int NOT NULL,
  `nationalID` int NOT NULL,
  `regionID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_booking_setup_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_booking_setup_changes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `gpsLat` varchar(255) DEFAULT NULL,
  `gpsLon` varchar(255) DEFAULT NULL,
  `costPerPerson` int NOT NULL,
  `depositAmount` int NOT NULL,
  `depositRequiredDate` date DEFAULT NULL,
  `MaxBookings` int NOT NULL,
  `lastBookingDate` date NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `bankName` varchar(255) NOT NULL,
  `bankAccountHoldersName` varchar(255) NOT NULL,
  `banlBranchName` varchar(255) NOT NULL,
  `bankBranchCode` varchar(255) NOT NULL,
  `bankAccountNumber` varchar(255) NOT NULL,
  `paymentRederence` varchar(255) NOT NULL,
  `paymentInFullByDate` date DEFAULT NULL,
  `startAge` int DEFAULT NULL,
  `endAge` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competition_score_adjudication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competition_score_adjudication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `scoringAreaID` int NOT NULL,
  `adjudicationScore` int NOT NULL,
  `active` int NOT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`teamID`,`scoringAreaID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `questionID` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `score` int NOT NULL,
  `position` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`questionID`,`answer`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_finances_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_finances_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `amount` int NOT NULL,
  `date` date NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`teamID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_finances_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_finances_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `amount` int NOT NULL,
  `date` date NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`teamID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_gps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_gps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `GPSLong` decimal(11,8) NOT NULL,
  `GPSLat` decimal(11,8) NOT NULL,
  `position` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE,
  KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_groups_attending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_groups_attending` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `groupID` int NOT NULL,
  `teamNumber` int NOT NULL,
  `teamName` varchar(255) NOT NULL,
  `scoreComplete` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_groups_participating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_groups_participating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `internalCompetitionID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_internal_competitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_internal_competitions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_judges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_judges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `judgeTypeID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`userID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_judges_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_judges_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `canAdmin` int NOT NULL DEFAULT '0',
  `canCaptureScores` int NOT NULL DEFAULT '0',
  `canAdminJudges` int NOT NULL DEFAULT '0',
  `canAdminFinances` int NOT NULL DEFAULT '0',
  `canAdminTeams` int NOT NULL DEFAULT '0',
  `medical` int NOT NULL DEFAULT '0',
  `seaWorthiness` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_location_logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_location_logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `regionID` int DEFAULT NULL,
  `roleID` int DEFAULT NULL,
  `userID` int NOT NULL,
  `userAgent` varchar(255) DEFAULT NULL,
  `accuracy` decimal(11,2) DEFAULT NULL COMMENT 'radius of accuracy meters',
  `altitude` decimal(11,3) DEFAULT NULL COMMENT 'meters above sea level',
  `altitudeAccuracy` varchar(255) DEFAULT NULL COMMENT 'radius of altitude accuracy meters',
  `heading` varchar(255) DEFAULT NULL COMMENT 'Degrees from true North',
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `speed` decimal(11,3) DEFAULT NULL COMMENT 'meters per second',
  `speedDone` int NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `used` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`roleID`,`active`,`latitude`,`longitude`,`used`) USING BTREE,
  KEY `For Speed` (`groupID`,`active`,`speed`) USING BTREE,
  KEY `groupID_2` (`groupID`,`roleID`,`active`,`created`) USING BTREE,
  KEY `userID` (`eventID`,`userID`,`speed`,`active`) USING BTREE,
  KEY `eventID` (`eventID`,`groupID`,`active`,`roleID`,`created`) USING BTREE,
  KEY `eventID_2` (`eventID`,`groupID`,`active`,`roleID`,`latitude`,`longitude`) USING BTREE,
  KEY `eventID_3` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `internalCompetitionID` int NOT NULL,
  `scoringAreaID` int NOT NULL,
  `scoringSheetID` int NOT NULL,
  `headingID` int NOT NULL,
  `question` varchar(1024) NOT NULL,
  `position` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`internalCompetitionID`,`scoringAreaID`,`scoringSheetID`,`headingID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_scoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_scoring` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `scoringAreaID` int NOT NULL,
  `scoringSheetID` int NOT NULL,
  `questionID` int NOT NULL,
  `answerID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`scoringSheetID`,`questionID`,`answerID`) USING BTREE,
  KEY `eventID_2` (`eventID`,`scoringAreaID`,`teamID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_scoring_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_scoring_areas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `internalCompetitionID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`internalCompetitionID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_scoring_dnp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_scoring_dnp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `teamID` int NOT NULL,
  `scoringSheetID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`teamID`,`scoringSheetID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_scoring_sheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_scoring_sheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `internalCompetitionID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `startDate` date NOT NULL,
  `startTime` varchar(5) NOT NULL,
  `endDate` date NOT NULL,
  `endTime` varchar(5) NOT NULL,
  `usesGPS` int NOT NULL DEFAULT '0',
  `pdf` int NOT NULL DEFAULT '1',
  `registration` int NOT NULL DEFAULT '0',
  `medicalScore` int NOT NULL DEFAULT '0',
  `seaWorthynessScore` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`internalCompetitionID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_scoring_sheets_headings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_scoring_sheets_headings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `internalCompetitionID` int NOT NULL,
  `scoringSheetID` int NOT NULL,
  `heading` varchar(255) NOT NULL,
  `position` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`,`internalCompetitionID`,`scoringSheetID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_competitions_survey_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_competitions_survey_responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `cookieID` text,
  `userIP` varchar(255) DEFAULT NULL,
  `teamName` varchar(255) DEFAULT NULL,
  `initialRegistration` int DEFAULT NULL,
  `improveInitialRegistration` text,
  `communicationPrior` int DEFAULT NULL,
  `improveCommunicationsPrior` text,
  `communicationDuring` int DEFAULT NULL,
  `qualityCommunicationDuring` int DEFAULT NULL,
  `judging` int DEFAULT NULL,
  `judgesEngageWithPL` int DEFAULT NULL,
  `judgingSuggestions` text,
  `improveCommunicationsDuring` text,
  `improveJudging` text,
  `suggestions` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE,
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `status` int NOT NULL COMMENT '1 = Provisional. 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled',
  `userID` int NOT NULL,
  `travelArrangements` int DEFAULT '0',
  `accommodationArrangements` int DEFAULT '0',
  `apparelOption` int DEFAULT NULL,
  `patrolID` int DEFAULT NULL,
  `canAdmin` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_accomodation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_accomodation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(1024) NOT NULL,
  `cost` int NOT NULL,
  `nrAvailable` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_credit_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_credit_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `amount` int NOT NULL,
  `notes` text,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `description` varchar(1024) NOT NULL,
  `amount` int NOT NULL,
  `transport` int NOT NULL DEFAULT '0',
  `accomodation` int NOT NULL DEFAULT '0',
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `note` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_other_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_other_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_patrol_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_patrol_allocation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `patrolID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`userID`,`active`) USING BTREE,
  KEY `userID` (`userID`,`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_patrols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_patrols` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `amount` int NOT NULL,
  `date` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_pops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_pops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `userID` int NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `roleID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`roleID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_user_booking_transport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_user_booking_transport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` int NOT NULL DEFAULT '0',
  `nrAvailable` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventID` (`eventID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_account_transfers_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_account_transfers_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transferID` int NOT NULL,
  `note` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transferID` (`transferID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `accountName` varchar(255) NOT NULL,
  `accountType` int NOT NULL,
  `assocToRegion` int NOT NULL DEFAULT '0',
  `assocToDistrict` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL DEFAULT '0',
  `nationalAccount` int NOT NULL DEFAULT '0',
  `regionalAccount` int NOT NULL DEFAULT '0',
  `districtAccount` int NOT NULL DEFAULT '0',
  `groupAccount` int NOT NULL DEFAULT '0',
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`,`groupAccount`),
  KEY `id` (`id`,`assocToGroup`,`active`,`groupAccount`),
  KEY `assocToGroup_2` (`assocToGroup`,`active`,`accountType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_accounts_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_accounts_transfers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fromCountryID` int NOT NULL,
  `fromRegionID` int NOT NULL,
  `fromDistrictID` int NOT NULL,
  `fromGroupID` int NOT NULL,
  `toCountryID` int NOT NULL,
  `toRegionID` int NOT NULL,
  `toDistrictID` int NOT NULL,
  `toGroupID` int NOT NULL,
  `accountID` int NOT NULL,
  `action` int NOT NULL COMMENT '1 = From SGL Must Approve, 2 = From Treasurer Must Approve, 3 = To SGL Must Approve',
  `notes` text NOT NULL,
  `fromSGLApproved` int DEFAULT NULL,
  `fromSGLID` int DEFAULT NULL,
  `fromSGLApprovedDate` datetime DEFAULT NULL,
  `fromSGLNotes` text,
  `fromTreasurerApproved` int DEFAULT NULL,
  `fromTreasurerID` int DEFAULT NULL,
  `fromTreasurerApprovedDate` datetime DEFAULT NULL,
  `fromTreasurerNotes` text,
  `toSGLApproved` int DEFAULT NULL,
  `toSGLID` int DEFAULT NULL,
  `toSGLApprovedDate` datetime DEFAULT NULL,
  `toSGLNotes` text,
  `actualTransferDate` datetime DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fromGroupID` (`fromGroupID`,`action`),
  KEY `toGroupID` (`toGroupID`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_accounts_transfers_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_accounts_transfers_stages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_advancements_in_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_advancements_in_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL COMMENT 'Cub Or Scout',
  `eventID` int NOT NULL,
  `firstID` int NOT NULL DEFAULT '0',
  `secondID` int NOT NULL DEFAULT '0',
  `thirdID` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_advancements_in_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_advancements_in_programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL COMMENT 'Cub Or Scout',
  `programID` int NOT NULL,
  `firstID` int NOT NULL DEFAULT '0',
  `secondID` int NOT NULL DEFAULT '0',
  `thirdID` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programID` (`programID`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`programID`,`firstID`,`secondID`,`active`,`thirdID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `userSex` varchar(10) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `programId` int DEFAULT NULL,
  `eventId` int DEFAULT '0',
  `programDate` date NOT NULL,
  `assocToGroup` int NOT NULL,
  `attendance` int NOT NULL COMMENT '1 = Attended',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `moved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `programId` (`programId`,`type`,`assocToGroup`,`attendance`,`programDate`),
  KEY `userId_2` (`userId`,`type`,`attendance`,`programDate`,`programId`),
  KEY `programId_2` (`programId`,`userId`),
  KEY `eventId` (`eventId`,`userId`),
  KEY `programId_3` (`programId`,`attendance`,`type`),
  KEY `eventId_2` (`eventId`,`type`),
  KEY `eventId_3` (`eventId`,`moved`),
  KEY `programId_4` (`programId`,`eventId`,`userId`),
  KEY `programId_5` (`programId`,`attendance`) USING BTREE,
  KEY `userId` (`userId`,`attendance`,`assocToGroup`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_badges_in_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_badges_in_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL COMMENT 'Cub Or Scout',
  `eventID` int NOT NULL,
  `firstID` int NOT NULL DEFAULT '0',
  `secondID` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`eventID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_badges_in_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_badges_in_programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL COMMENT 'Cub Or Scout',
  `programID` int NOT NULL,
  `firstID` int NOT NULL DEFAULT '0',
  `secondID` int NOT NULL DEFAULT '0',
  `thirdID` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`programID`,`active`),
  KEY `assocToGroup_2` (`assocToGroup`,`programID`,`firstID`,`secondID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_committee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_committee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `typeID` int NOT NULL,
  `dateAppointed` date NOT NULL,
  `dateRemoved` date DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `typeID` (`typeID`),
  KEY `assocToGroup` (`assocToGroup`,`userID`,`active`),
  KEY `userID` (`userID`,`typeID`,`assocToGroup`,`active`),
  KEY `assocToGroup_2` (`assocToGroup`,`active`,`typeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_council`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_council` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `typeID` int NOT NULL,
  `dateAppointed` date NOT NULL,
  `dateRemoved` date DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `typeID` (`typeID`),
  KEY `assocToGroup` (`assocToGroup`,`userID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_cub_packs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_cub_packs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_cubs_sixes_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_cubs_sixes_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `packID` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_district_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_district_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `reportMonth` date NOT NULL,
  `area` varchar(255) NOT NULL,
  `boys` int NOT NULL,
  `girls` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_district_reports_cubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_district_reports_cubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `reportMonth` date NOT NULL,
  `LastMonth` date NOT NULL,
  `lastMonthBoys` int NOT NULL,
  `lastMonthGirls` int NOT NULL,
  `thisMonthBoys` int NOT NULL,
  `thisMonthGirls` int NOT NULL,
  `jtpBoys` int NOT NULL,
  `jtpGirls` int NOT NULL,
  `ltpBoys` int NOT NULL,
  `ltpGirls` int NOT NULL,
  `leavingBoys` int NOT NULL,
  `leavingGirls` int NOT NULL,
  `toScoutsBoys` int NOT NULL,
  `toScoutsGirls` int NOT NULL,
  `usMale` int NOT NULL,
  `usFemale` int NOT NULL,
  `parentHelperMale` int NOT NULL,
  `parentHelperFemale` int NOT NULL,
  `committeeMale` int NOT NULL,
  `committeeFemale` int NOT NULL,
  `membershipBoys` int NOT NULL,
  `membershipGirls` int NOT NULL,
  `swBoys` int NOT NULL,
  `swGirls` int NOT NULL,
  `gwBoys` int NOT NULL,
  `gwGirls` int NOT NULL,
  `lwBoys` int NOT NULL,
  `lwGirls` int NOT NULL,
  `badgesBoys` int NOT NULL,
  `badgesGirls` int NOT NULL,
  `advBoys` int NOT NULL,
  `advGirls` int NOT NULL,
  `advancement` text NOT NULL,
  `packActivity` text NOT NULL,
  `groupActivity` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_district_reports_cubs_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_district_reports_cubs_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `reportMonth` varchar(10) NOT NULL,
  `nr` int NOT NULL,
  `date` date NOT NULL,
  `strength` int NOT NULL,
  `present` int NOT NULL,
  `percent` int NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_district_reports_scouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_district_reports_scouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `reportMonth` date NOT NULL,
  `LastMonth` date NOT NULL,
  `lastMonthBoys` int NOT NULL,
  `lastMonthGirls` int NOT NULL,
  `thisMonthBoys` int NOT NULL,
  `thisMonthGirls` int NOT NULL,
  `jttBoys` int NOT NULL,
  `jttGirls` int NOT NULL,
  `lttBoys` int NOT NULL,
  `lttGirls` int NOT NULL,
  `leavingBoys` int NOT NULL,
  `leavingGirls` int NOT NULL,
  `toRoversBoys` int NOT NULL,
  `toRoversGirls` int NOT NULL,
  `usMale` int NOT NULL,
  `usFemale` int NOT NULL,
  `parentHelperMale` int NOT NULL,
  `parentHelperFemale` int NOT NULL,
  `committeeMale` int NOT NULL,
  `committeeFemale` int NOT NULL,
  `membershipBoys` int NOT NULL,
  `membershipGirls` int NOT NULL,
  `pfBoys` int NOT NULL,
  `pfGirls` int NOT NULL,
  `adBoys` int NOT NULL,
  `adGirls` int NOT NULL,
  `fcBoys` int NOT NULL,
  `fcGirls` int NOT NULL,
  `exBoys` int NOT NULL,
  `exGirls` int NOT NULL,
  `spBoys` int NOT NULL,
  `spGirls` int NOT NULL,
  `badgesBoys` int NOT NULL,
  `badgesGirls` int NOT NULL,
  `advBoys` int NOT NULL,
  `advGirls` int NOT NULL,
  `advancement` text NOT NULL,
  `troopActivity` text NOT NULL,
  `groupActivity` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_district_reports_scouts_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_district_reports_scouts_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assocToGroup` int NOT NULL,
  `reportMonth` varchar(10) NOT NULL,
  `nr` int NOT NULL,
  `date` date NOT NULL,
  `strength` int NOT NULL,
  `present` int NOT NULL,
  `percent` int NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `docType` int NOT NULL,
  `docArea` varchar(255) DEFAULT NULL,
  `assocToPerson` int DEFAULT NULL,
  `assocToAccount` int NOT NULL DEFAULT '0',
  `assocToGroup` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(1024) NOT NULL,
  `expiryDate` date DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` date NOT NULL,
  `createdby` int NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`assocToAccount`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_edit_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_edit_record` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int DEFAULT NULL,
  `fromData` longtext,
  `toData` longtext,
  `created` datetime DEFAULT NULL,
  `createdByID` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_group_edit_record_groupID` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_equipment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `locationID` int NOT NULL,
  `purchased` int NOT NULL COMMENT '2 = Purchased, 1 = Donated',
  `purchaseCost` int DEFAULT NULL,
  `replacementCost` int DEFAULT NULL,
  `totalPurchaseCost` int NOT NULL,
  `totalReplacementCost` int NOT NULL,
  `purchaseDate` date NOT NULL,
  `purchaseLocation` text,
  `qty` int NOT NULL,
  `insured` int NOT NULL COMMENT '1 = Insured',
  `expectedLifeFromPurchaseDate` varchar(255) NOT NULL,
  `assetCondition` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_equipment_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_equipment_store` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_event_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_event_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eventID` int NOT NULL,
  `name` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programID` (`eventID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nationalEvent` int NOT NULL DEFAULT '0',
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToRegion` int NOT NULL,
  `associatedToNationalEventID` int NOT NULL DEFAULT '0',
  `associatedToRegionEventID` int NOT NULL DEFAULT '0',
  `associatedToDistrictEventID` int NOT NULL DEFAULT '0',
  `eventFor` int NOT NULL DEFAULT '0' COMMENT '1 = Cubs Only, 2 = Scouts Only, 3 = Rovers Only, 4 = Adults Only, 5 = Group, 6 = Meerkats Only',
  `eventFor2` int NOT NULL DEFAULT '2' COMMENT '1 = Groups, 2 = Adult Leaders',
  `eventAway` int NOT NULL DEFAULT '0' COMMENT '1 = Away, 2 = At Scout Hall',
  `eventPatrolID` int NOT NULL DEFAULT '0',
  `multiID` int DEFAULT NULL,
  `denID` int DEFAULT NULL,
  `packID` int DEFAULT NULL,
  `troopID` int DEFAULT NULL,
  `crewID` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `heldInDistrict` int NOT NULL,
  `uploadedDoc` varchar(1000) DEFAULT NULL COMMENT 'Location Of The Uploaded Doc',
  `locationName` varchar(255) NOT NULL,
  `locationAddress` text NOT NULL,
  `locationLat` varchar(255) DEFAULT NULL,
  `locationLon` varchar(255) DEFAULT NULL,
  `startDate` date NOT NULL,
  `startTime` varchar(15) NOT NULL,
  `endDate` date NOT NULL,
  `endTime` varchar(15) NOT NULL,
  `scouterResponsible` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `costPerPerson` decimal(7,2) DEFAULT NULL,
  `costPerPersonPer` varchar(255) DEFAULT NULL,
  `nightUnderCanvas` int DEFAULT NULL,
  `kmHike` decimal(4,1) DEFAULT NULL,
  `eventTypeID` int NOT NULL,
  `permitDocLocation` varchar(255) DEFAULT NULL,
  `uniqueID` varchar(100) NOT NULL,
  `eventPSPin` int NOT NULL,
  `eventTSPin` int NOT NULL,
  `eventSGLPin` int NOT NULL,
  `eventDCPin` int NOT NULL,
  `eventOtherDCPin` int NOT NULL,
  `active` int NOT NULL,
  `approved` int NOT NULL DEFAULT '1',
  `planningDoc` varchar(255) DEFAULT NULL,
  `marketingDoc` varchar(1024) DEFAULT NULL,
  `competition` int NOT NULL DEFAULT '0',
  `competitionScoringFactor` decimal(11,8) NOT NULL DEFAULT '1.00000000',
  `competitionScoringDefaultPage` int DEFAULT '0',
  `competitionScorePrecheck` int DEFAULT '0',
  `addedIn` int NOT NULL DEFAULT '1',
  `bookingPossible` int NOT NULL DEFAULT '0',
  `latestBookingDate` date DEFAULT NULL,
  `maxNrOfBookings` int NOT NULL DEFAULT '0',
  `managementEmail` varchar(255) DEFAULT NULL,
  `depositRequired` int NOT NULL DEFAULT '0',
  `depositRequiredDate` date DEFAULT NULL,
  `paymentInFullByDate` date DEFAULT NULL,
  `travelArrangements` text,
  `bookingLive` int NOT NULL DEFAULT '0',
  `bankName` varchar(255) DEFAULT NULL,
  `bankAccountName` varchar(255) DEFAULT NULL,
  `bankBranch` varchar(255) DEFAULT NULL,
  `bankCode` varchar(255) DEFAULT NULL,
  `bankAccountNumber` varchar(255) DEFAULT NULL,
  `BAReferenceStart` varchar(6) DEFAULT NULL,
  `startAge` int DEFAULT NULL,
  `endAge` int DEFAULT NULL,
  `GPSTrackingRequired` int NOT NULL DEFAULT '0',
  `noCopy` int NOT NULL DEFAULT '0',
  `surveyURL` varchar(255) DEFAULT NULL,
  `leaderboardURL` varchar(255) DEFAULT NULL,
  `calendarURL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniqueID` (`uniqueID`),
  KEY `assocToGroup` (`assocToGroup`,`countryID`,`active`,`endDate`),
  KEY `assocToDistrict` (`assocToDistrict`,`countryID`,`active`,`endDate`,`eventFor`),
  KEY `countryID` (`countryID`,`nationalEvent`,`active`,`endDate`,`eventFor`),
  KEY `assocToRegion` (`assocToRegion`,`countryID`,`active`,`endDate`,`eventFor`),
  KEY `bookingPossible` (`bookingPossible`,`active`) USING BTREE,
  KEY `competition` (`competition`,`active`,`noCopy`,`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_events_attending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_events_attending` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `eventID` int NOT NULL,
  `userID` int NOT NULL DEFAULT '0',
  `roleID` int NOT NULL,
  `attending` int NOT NULL COMMENT '0 = Not Attending, 1 = Attending, 2 = Maybe Attending',
  `cost` decimal(10,2) DEFAULT '0.00',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`groupID`,`eventID`,`attending`,`active`),
  KEY `eventID` (`eventID`,`groupID`,`roleID`,`active`),
  KEY `groupID` (`groupID`,`eventID`,`userID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_annual_invoice_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_annual_invoice_discounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amountIncludesVAT` int NOT NULL COMMENT '1 = Yes',
  `financialYear` int NOT NULL,
  `active` int NOT NULL COMMENT '1 = active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`),
  KEY `accountID` (`accountID`,`financialYear`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_credit_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_credit_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `invoiceID` int DEFAULT NULL,
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `financialYearID` int NOT NULL,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`accountID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_credit_notes_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_credit_notes_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `invoiceID` int DEFAULT NULL,
  `creditNoteID` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `financialYearID` int NOT NULL,
  `feeArea` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_fee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_fee_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `canBeProrated` int NOT NULL COMMENT '1 = Yes',
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `financialYearID` int NOT NULL,
  `feeTypeID` int NOT NULL,
  `feeAmount` decimal(10,2) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `financialYearID` int NOT NULL,
  `dueDate` date NOT NULL,
  `annualInvoice` int NOT NULL DEFAULT '0',
  `PDFLocation` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`accountID`,`active`,`financialYearID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_invoices_emailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_invoices_emailed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `financialYearID` int NOT NULL,
  `invoiceID` int NOT NULL,
  `sentDate` datetime NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_invoices_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_invoices_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoiceID` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `financialYearID` int NOT NULL,
  `feeArea` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_payments_made`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_payments_made` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoiceID` int NOT NULL DEFAULT '0',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `paymentType` int NOT NULL DEFAULT '1' COMMENT '1 = Group Captured, 2 = From Wallet',
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup_2` (`assocToGroup`,`accountID`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`paymentType`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_financial_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_financial_years` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_meerkat_dens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_meerkat_dens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_meerkats_patrol_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_meerkats_patrol_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `packID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_newsletters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `newsletterDate` date NOT NULL,
  `newsletterTitle` varchar(255) NOT NULL,
  `uploadedFile` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_parents_committee_minutes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_parents_committee_minutes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `newsletterDate` date NOT NULL,
  `newsletterTitle` varchar(255) NOT NULL,
  `uploadedFile` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `programAreaName` varchar(100) DEFAULT NULL,
  `multiID` int NOT NULL DEFAULT '0',
  `denID` int NOT NULL DEFAULT '0',
  `packID` int DEFAULT '0',
  `troopID` int DEFAULT '0',
  `crewID` int NOT NULL DEFAULT '0',
  `programType` int NOT NULL,
  `meerkatProgramTypeID` int NOT NULL DEFAULT '0',
  `cubProgramTypeID` int NOT NULL DEFAULT '0',
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `roverProgramTypeID` int DEFAULT '0',
  `responsibleScouter` int DEFAULT NULL,
  `dutyPatrol` int DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = active',
  `shared` int NOT NULL DEFAULT '0',
  `sharedby` int DEFAULT NULL,
  `sharedDate` date DEFAULT NULL,
  `roverProgramType` int DEFAULT NULL,
  `online` int NOT NULL DEFAULT '0',
  `onlineActive` int NOT NULL DEFAULT '0',
  `onlineEndDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programType` (`programType`,`assocToGroup`,`active`,`date`),
  KEY `programType_2` (`programType`,`date`,`assocToGroup`,`active`),
  KEY `assocToGroup` (`assocToGroup`,`active`,`date`,`programType`),
  KEY `date` (`date`),
  KEY `assocToGroup_2` (`assocToGroup`,`online`,`active`,`date`,`onlineEndDate`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `name` text NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programID` (`programID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `position` int NOT NULL,
  `task` text NOT NULL,
  `needs` text,
  `description` text NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `advancementID` int DEFAULT NULL,
  `badgeID` int DEFAULT NULL,
  `points` int DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `programID` (`programID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks_completion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks_completion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `taskID` int NOT NULL,
  `userID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`programID`,`taskID`) USING BTREE,
  KEY `programID` (`programID`,`taskID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `taskID` int NOT NULL,
  `userID` int NOT NULL,
  `description` text,
  `location` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`programID`,`taskID`) USING BTREE,
  KEY `programID` (`programID`,`taskID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `taskID` int NOT NULL,
  `userID` int NOT NULL,
  `description` text,
  `location` varchar(1024) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`programID`,`taskID`) USING BTREE,
  KEY `programID` (`programID`,`taskID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `taskID` int NOT NULL,
  `userID` int NOT NULL,
  `note` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`programID`,`taskID`) USING BTREE,
  KEY `programID` (`programID`,`taskID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_tasks_penalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_tasks_penalty` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `taskID` int NOT NULL,
  `userID` int NOT NULL,
  `penalty` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`programID`,`taskID`) USING BTREE,
  KEY `programID` (`programID`,`taskID`,`userID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_programs_online_working_on`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_programs_online_working_on` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programID` int NOT NULL,
  `userID` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `programID` (`programID`,`userID`) USING BTREE,
  KEY `userID` (`userID`,`programID`) USING BTREE,
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_rover_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_rover_crews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_rovers_patrol_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_rovers_patrol_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `crewID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_scout_troops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_scout_troops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_scouts_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_scouts_charges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `scoutID` int NOT NULL,
  `chargeID` int NOT NULL,
  `chargeNr` varchar(255) NOT NULL,
  `awardDate` date NOT NULL,
  `expireDate` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_scouts_patrol_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_scouts_patrol_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int DEFAULT NULL,
  `assocToDistrict` int DEFAULT NULL,
  `assocToGroup` int NOT NULL,
  `troopID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`assocToGroup`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_send_logon_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_send_logon_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_star_awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_star_awards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `year` int NOT NULL,
  `area` int NOT NULL,
  `multiID` int NOT NULL,
  `awardID` int NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`),
  KEY `regionID` (`regionID`,`active`),
  KEY `districtID` (`districtID`,`active`),
  KEY `groupID` (`groupID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_user_picture_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_user_picture_changes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `pictureLocation` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_weekly_emails_emailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_weekly_emails_emailed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToGroup` int NOT NULL,
  `accountID` int NOT NULL,
  `userID` int NOT NULL,
  `programID` int NOT NULL,
  `programDate` date NOT NULL,
  `sentDate` datetime NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `mailType` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `group_youth_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_youth_charges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(12) NOT NULL,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `userID` int NOT NULL,
  `chargeTypeID` int NOT NULL,
  `chargeNr` varchar(255) NOT NULL,
  `awardDate` date NOT NULL,
  `expireDate` date NOT NULL,
  `PDFLocation` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sdLiteOnly` int NOT NULL DEFAULT '0',
  `usesGoScan` int DEFAULT '0',
  `usesShop` int NOT NULL DEFAULT '0',
  `usesPayFees` int NOT NULL DEFAULT '0',
  `groupAccountID` int NOT NULL DEFAULT '0',
  `scarf` varchar(255) DEFAULT NULL,
  `groupTypeID` int NOT NULL,
  `description` text,
  `multiDen` int NOT NULL DEFAULT '0',
  `multiPack` int NOT NULL DEFAULT '0',
  `multiTroop` int NOT NULL DEFAULT '0',
  `multiCrew` int NOT NULL DEFAULT '0',
  `meerkatProgramType` int NOT NULL DEFAULT '1',
  `cubProgramType` int NOT NULL DEFAULT '1',
  `scoutProgramType` int NOT NULL DEFAULT '2' COMMENT '1 = Normal Scout Program, 2 = Entsha Scout Program',
  `roverProgramType` int NOT NULL DEFAULT '1',
  `amsOnly` int NOT NULL DEFAULT '0' COMMENT '1 = Yes, 0 = No',
  `hasMeerkats` int NOT NULL DEFAULT '0',
  `hasCubs` int DEFAULT '1' COMMENT '1 = Yes',
  `hasScouts` int DEFAULT '1' COMMENT '1 = Yes',
  `hasRovers` int DEFAULT '0' COMMENT '1 = Yes',
  `hasBranch1` int NOT NULL DEFAULT '0',
  `hasBranch2` int NOT NULL DEFAULT '0',
  `hasBranch3` int NOT NULL DEFAULT '0',
  `hasBranch4` int NOT NULL DEFAULT '0',
  `hasBranch5` int NOT NULL DEFAULT '0',
  `sendWeeklyMails` int NOT NULL DEFAULT '0',
  `assoc_to_district` int NOT NULL,
  `assoc_to_region` int NOT NULL,
  `roverAssocToGroup` int DEFAULT '0',
  `phys_address` text,
  `postalAddress` text,
  `postalCountryID` int DEFAULT '196',
  `phys_country_id` int DEFAULT '196',
  `bankingDetails` text,
  `bankAccountName` varchar(255) DEFAULT NULL,
  `bankName` varchar(255) DEFAULT NULL,
  `branchName` varchar(255) DEFAULT NULL,
  `branchCode` varchar(255) DEFAULT NULL,
  `bankAccountNumber` varchar(255) DEFAULT NULL,
  `invoiceNotes` text,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `googleplus` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `pintrest` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tumblr` varchar(255) DEFAULT NULL,
  `googleMaps` varchar(255) DEFAULT NULL,
  `gpsLat` varchar(255) DEFAULT NULL,
  `gpsLon` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `weatherID` varchar(25) DEFAULT NULL,
  `weatherLocationName` varchar(255) DEFAULT NULL,
  `managedRegionally` int NOT NULL DEFAULT '0' COMMENT '1 = Yrs, 0 = No',
  `canMoveToEntsha` int NOT NULL DEFAULT '1',
  `using20` int NOT NULL DEFAULT '1',
  `groupRegNr` varchar(25) DEFAULT NULL,
  `censusDone` int DEFAULT NULL,
  `groupLastUpdated` datetime DEFAULT NULL,
  `groupLastUpdatedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`,`assoc_to_district`,`assoc_to_region`),
  KEY `roverAssocToGroup` (`roverAssocToGroup`,`active`),
  KEY `active_3` (`active`,`phys_country_id`,`managedRegionally`),
  KEY `phys_country_id` (`phys_country_id`,`active`,`groupTypeID`),
  KEY `assoc_to_district` (`assoc_to_district`,`active`,`groupTypeID`),
  KEY `active_2` (`assoc_to_region`,`active`,`groupTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_entsha_move`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_entsha_move` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regionID` (`regionID`),
  KEY `districtID` (`districtID`),
  KEY `groupID` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_multi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_multi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  `groupID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`type`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `districtID` int NOT NULL,
  `regionID` int NOT NULL,
  `countryID` int NOT NULL DEFAULT '196',
  `ownedRented` int DEFAULT NULL COMMENT '1 = Owned, 2 = Rented',
  `landlordName` varchar(255) DEFAULT NULL,
  `landlordContactPerson` varchar(255) DEFAULT NULL,
  `landlordContactPersonCell` varchar(25) DEFAULT NULL,
  `landlordContactPersonEmail` varchar(255) DEFAULT NULL,
  `propertyDescription` text,
  `ERFno` varchar(1024) DEFAULT NULL,
  `ERFSize` varchar(10) DEFAULT NULL,
  `propertyValuation` int DEFAULT NULL,
  `lastValuationDate` date DEFAULT NULL,
  `improvementValue` int DEFAULT NULL,
  `leaseStartDate` date DEFAULT NULL,
  `leaseEndDate` date DEFAULT NULL,
  `leaseRenewalDate` date DEFAULT NULL,
  `leaseConditions` text,
  `improvementsDescription` text,
  `monthlyRentalAmount` int DEFAULT NULL,
  `monthlyRates` int DEFAULT NULL,
  `monthlyElectricity` int DEFAULT NULL,
  `monthlyWaterSewerage` int DEFAULT NULL,
  `insuranceCompany` varchar(255) DEFAULT NULL,
  `insuranceContactPerson` varchar(255) DEFAULT NULL,
  `insuranceContactPersonEmail` varchar(100) DEFAULT NULL,
  `insuranceContactPersonCell` varchar(15) DEFAULT NULL,
  `insuranceValue` int DEFAULT NULL,
  `insuranceDetails` text,
  `groupNotes` text,
  `created` datetime DEFAULT NULL,
  `createdby` int DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`),
  KEY `districtID` (`districtID`),
  KEY `regionID` (`regionID`),
  KEY `countryID` (`countryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_property_ownership_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_property_ownership_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `owned` int NOT NULL DEFAULT '0',
  `rented` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_property_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_property_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `updatedby` int NOT NULL,
  `updatedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `groups_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `info_sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_sharing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `region` int NOT NULL,
  `type` int NOT NULL COMMENT '1 = Hiking, 2 = Camping, 3 = Supplier',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `gpsLat` varchar(100) DEFAULT NULL,
  `gpsLon` varchar(100) DEFAULT NULL,
  `active` int NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  `approvedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `declined` int NOT NULL DEFAULT '0',
  `declinedby` int DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedReason` varchar(1024) DEFAULT NULL,
  `declinedNotes` text,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`active`,`approved`),
  KEY `active` (`active`,`approved`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `info_sharing_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_sharing_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `infoID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `infoID` (`infoID`,`active`),
  KEY `createdby` (`createdby`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `info_sharing_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_sharing_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `infoID` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `stars` int DEFAULT NULL,
  `active` int NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  `declined` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `approvedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedby` int DEFAULT NULL,
  `declineReason` varchar(1024) DEFAULT NULL,
  `declinedNotes` text,
  PRIMARY KEY (`id`),
  KEY `infoID` (`infoID`,`active`,`approved`),
  KEY `createdby` (`createdby`,`active`,`approved`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `info_sharing_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_sharing_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_activity_center_bases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_activity_center_bases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `centerID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `concurrentPatrols` int NOT NULL,
  `hoursLong` decimal(2,1) NOT NULL,
  `slots` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_activity_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_activity_centers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_adult_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_adult_allocations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `subCampID` int NOT NULL DEFAULT '0',
  `activityCenterID` int NOT NULL DEFAULT '0',
  `baseID` int NOT NULL DEFAULT '0',
  `roleID` int NOT NULL,
  `userID` int NOT NULL,
  `notes` text,
  `active` int NOT NULL,
  `position` int DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_adult_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_adult_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `position` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `jamboreeID` int NOT NULL,
  `jamboreeNumber` varchar(4) DEFAULT NULL,
  `stepComplete` int NOT NULL DEFAULT '0',
  `step1Complete` datetime DEFAULT NULL,
  `step2Complete` datetime DEFAULT NULL,
  `step3Complete` datetime DEFAULT NULL,
  `step4Complete` datetime DEFAULT NULL,
  `step5Complete` datetime DEFAULT NULL,
  `step6Complete` datetime DEFAULT NULL,
  `step7Complete` datetime DEFAULT NULL,
  `step8Complete` datetime DEFAULT NULL,
  `step1notes` text,
  `step2notes` text,
  `step3notes` text,
  `step4notes` text,
  `step5notes` text,
  `step6notes` text,
  `step7notes` text,
  `step8notes` text,
  `currentGrade` varchar(3) DEFAULT NULL,
  `advancementLevel` varchar(255) DEFAULT NULL,
  `pltuAttendedYear` varchar(255) DEFAULT NULL,
  `trainingAttended` text,
  `previousNational` text,
  `jamboreeAttended` varchar(3) DEFAULT NULL,
  `jamboreeYear` varchar(4) DEFAULT NULL,
  `capSize` varchar(25) DEFAULT NULL,
  `tShirtSize` varchar(25) DEFAULT NULL,
  `golfShirtSize` varchar(25) DEFAULT NULL,
  `busRegionID` int DEFAULT NULL,
  `TravelingWithChildren` int NOT NULL DEFAULT '0',
  `completed` int NOT NULL DEFAULT '0',
  `gpsCheckDone` int DEFAULT NULL,
  `ConsentLocation` varchar(1024) DEFAULT NULL,
  `busInvoiceLocation` varchar(255) DEFAULT NULL,
  `applicationApproved` int DEFAULT NULL,
  `applicationApprovedDate` datetime DEFAULT NULL,
  `applicationApprovedBy` int DEFAULT NULL,
  `declinedPosition` int DEFAULT NULL,
  `declinedPositionDate` datetime DEFAULT NULL,
  `declinedPositionBy` int DEFAULT NULL,
  `declinedReason` text,
  `passportGenerated` int DEFAULT NULL,
  `startDate` date NOT NULL DEFAULT '2017-12-08',
  `endDate` date NOT NULL DEFAULT '2017-12-16',
  `nrOfDays` int NOT NULL DEFAULT '8',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '2',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `active` (`active`,`completed`,`passportGenerated`),
  KEY `jamboreeID` (`jamboreeID`,`active`,`completed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_beds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_beds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subcampID` int NOT NULL,
  `type` int NOT NULL COMMENT '1 = Adults, 2 = Kids',
  `name` varchar(255) NOT NULL,
  `nrBeds` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_beds_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_beds_allocations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subcampID` int NOT NULL,
  `troopID` int NOT NULL,
  `patrolID` int NOT NULL,
  `bedID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `subcampID` (`patrolID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_bus_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_bus_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL DEFAULT '0',
  `regionID` int NOT NULL,
  `provider` varchar(255) NOT NULL,
  `totalBusCost` decimal(10,2) DEFAULT NULL,
  `perSeatInvoiceAmountExVAT` decimal(6,2) DEFAULT '0.00',
  `busNr` varchar(255) DEFAULT NULL,
  `availableSeats` int NOT NULL,
  `departureLocation` varchar(255) NOT NULL,
  `departureDate` date NOT NULL,
  `departureTime` varchar(255) NOT NULL,
  `arrivalLocation` varchar(255) DEFAULT NULL,
  `arrivalDate` date DEFAULT NULL,
  `arrivalTime` varchar(100) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_buses_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_buses_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `userID` int NOT NULL,
  `busID` int NOT NULL,
  `notes` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jamboreeID` (`jamboreeID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_core_team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_core_team` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL DEFAULT '2',
  `userID` int NOT NULL,
  `canAdmin` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_eoi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_eoi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `userID` int NOT NULL,
  `roleID` int NOT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_expr_of_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_expr_of_interest` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `userID` int NOT NULL,
  `parentID` int DEFAULT NULL,
  `positionID` int NOT NULL,
  `passportCountryID` int DEFAULT '0',
  `passportCheck` int DEFAULT '0',
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `offeredPosition` int DEFAULT NULL,
  `offeredPositionDate` datetime DEFAULT NULL,
  `offeredPositionBy` int DEFAULT NULL,
  `declinedPosition` int DEFAULT NULL,
  `declinedPositionDate` datetime DEFAULT NULL,
  `declinedPositionBy` int DEFAULT NULL,
  `declinedReason` text,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`),
  KEY `positionID` (`positionID`),
  KEY `jamboreeID` (`jamboreeID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_generated_pdfs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_generated_pdfs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `subCampID` int NOT NULL DEFAULT '0',
  `troopID` int NOT NULL DEFAULT '0',
  `busID` int NOT NULL DEFAULT '0',
  `userID` int NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `PDFLocation` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL,
  `year` int NOT NULL,
  `currency` varchar(10) NOT NULL,
  `scoutCostExVAT` decimal(6,2) NOT NULL,
  `adultCostExVAT` decimal(6,2) NOT NULL,
  `kidCostExVAT` decimal(6,2) NOT NULL,
  `busDepositExVAT` decimal(6,2) NOT NULL,
  `depositPercent` int NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_initial_thoughts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_initial_thoughts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL DEFAULT '2',
  `userID` int NOT NULL,
  `thought` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `userID` int NOT NULL,
  `invoiceAmountExVat` decimal(8,2) DEFAULT NULL,
  `invoiceVATAmount` decimal(8,2) DEFAULT NULL,
  `invoiceTotalAmount` decimal(8,2) DEFAULT NULL,
  `dueDate` date NOT NULL,
  `PDFLocation` varchar(255) DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_invoices_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_invoices_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoiceID` int NOT NULL,
  `applicantID` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `number` int NOT NULL,
  `unitAmount` decimal(8,2) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoiceID` (`invoiceID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_patrols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_patrols` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `troopID` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_payment_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `userID` int NOT NULL,
  `paymentType` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `jamboreeID` (`jamboreeID`,`userID`,`active`),
  KEY `jamboreeID_2` (`jamboreeID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_position_offered`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_position_offered` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `userID` int NOT NULL,
  `parentID` int DEFAULT NULL,
  `positionID` int NOT NULL,
  `passportCountryID` int NOT NULL,
  `passportCheck` int NOT NULL,
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  `offeredPosition` int DEFAULT NULL,
  `offeredPositionDate` datetime DEFAULT NULL,
  `offeredPositionBy` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_scouters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_scouters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `scouterPosition` varchar(255) NOT NULL,
  `scouterFirst` varchar(255) NOT NULL,
  `scouterSurname` varchar(255) NOT NULL,
  `scouterEmail` varchar(25) NOT NULL,
  `scouterCellNr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_sub_camp_troop_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_sub_camp_troop_allocations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `subCampID` int NOT NULL,
  `troopID` int NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_sub_camps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_sub_camps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_troop_patrol_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_troop_patrol_allocations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `troopID` int NOT NULL,
  `patrolID` int DEFAULT NULL,
  `roleID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `notes` text,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `troopID` (`troopID`,`roleID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jamboree_troops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jamboree_troops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jamboreeID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `subCampID` int DEFAULT NULL,
  `colour` varchar(25) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `national`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `national` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `countryID` int NOT NULL,
  `active` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `groupID` int NOT NULL,
  `districtID` int NOT NULL,
  `regionID` int NOT NULL,
  `countryID` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extended` text NOT NULL,
  `colour` varchar(100) NOT NULL COMMENT 'colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke',
  `active` int NOT NULL DEFAULT '1',
  `doNotShowBefore` date NOT NULL,
  `doNotShowAfter` date NOT NULL,
  `forType` int NOT NULL COMMENT '1 = Group, 2 = District, 3 = Region, 4 = National',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `shown` int NOT NULL DEFAULT '0',
  `dismissDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID_2` (`userID`,`active`,`shown`,`doNotShowBefore`,`doNotShowAfter`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications_archive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `groupID` int NOT NULL,
  `districtID` int NOT NULL,
  `regionID` int NOT NULL,
  `countryID` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extended` text NOT NULL,
  `colour` varchar(100) NOT NULL COMMENT 'colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke',
  `active` int NOT NULL DEFAULT '1',
  `doNotShowBefore` date NOT NULL,
  `doNotShowAfter` date NOT NULL,
  `forType` int NOT NULL COMMENT '1 = Group, 2 = District, 3 = Region, 4 = National',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `shown` int NOT NULL DEFAULT '0',
  `dismissDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projectForID` int NOT NULL,
  `countryID` int NOT NULL DEFAULT '0',
  `regionID` int NOT NULL DEFAULT '0',
  `districtID` int NOT NULL DEFAULT '0',
  `groupID` int NOT NULL DEFAULT '0',
  `typeID` int NOT NULL,
  `name` varchar(1024) NOT NULL,
  `description` text NOT NULL,
  `aim` text NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `contactCell` varchar(255) DEFAULT NULL,
  `contactWebsite` varchar(1024) DEFAULT NULL,
  `active` int NOT NULL,
  `approved` int DEFAULT '0',
  `approvedby` int DEFAULT NULL,
  `approveddate` datetime DEFAULT NULL,
  `declined` int DEFAULT '0',
  `declinedby` int DEFAULT NULL,
  `declineddate` datetime DEFAULT NULL,
  `declinedReason` text,
  `declinedNotes` text,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`,`approved`),
  KEY `regionID` (`regionID`,`active`,`approved`),
  KEY `districtID` (`districtID`,`active`,`approved`),
  KEY `groupID` (`groupID`,`active`,`approved`),
  KEY `countryID_2` (`countryID`,`active`,`approved`,`typeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `projects_for`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects_for` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `projects_supported`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects_supported` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projectID` int NOT NULL,
  `countryID` int NOT NULL DEFAULT '0',
  `regionID` int NOT NULL DEFAULT '0',
  `districtID` int NOT NULL DEFAULT '0',
  `groupID` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projectID` (`projectID`,`active`),
  KEY `projectID_2` (`projectID`,`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `short` varchar(3) DEFAULT NULL,
  `usingAMS` int NOT NULL DEFAULT '0' COMMENT '1 = Yes, 0 = No',
  `description` text NOT NULL,
  `phys_address` text NOT NULL,
  `countryID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `accountID` int NOT NULL DEFAULT '0',
  `censusDone` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `phys_country_id` (`countryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports_numbers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `assocToRegion` int NOT NULL,
  `assocToDistrict` int NOT NULL,
  `assocToGroup` int NOT NULL,
  `month` date NOT NULL,
  `meerkatsM` int NOT NULL DEFAULT '0',
  `meerkatsF` int NOT NULL DEFAULT '0',
  `cubsM` int DEFAULT '0',
  `cubsF` int DEFAULT '0',
  `scoutsM` int DEFAULT '0',
  `scoutsF` int DEFAULT '0',
  `roversM` int DEFAULT '0',
  `roversF` int DEFAULT '0',
  `adultsDenM` int NOT NULL DEFAULT '0',
  `adultsDenF` int NOT NULL DEFAULT '0',
  `adultsPackM` int DEFAULT '0',
  `adultsPackF` int DEFAULT '0',
  `adultsTroopM` int DEFAULT '0',
  `adultsTroopF` int DEFAULT '0',
  `adultsCrewM` int NOT NULL DEFAULT '0',
  `adultsCrewF` int NOT NULL DEFAULT '0',
  `adultsGroupM` int DEFAULT '0',
  `adultsGroupF` int DEFAULT '0',
  `committee` int DEFAULT '0',
  `helpers` int DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `month` (`month`,`assocToGroup`),
  KEY `assocToGroup` (`month`,`assocToDistrict`),
  KEY `assocToDistrict` (`month`,`assocToRegion`),
  KEY `assocToRegion` (`month`,`countryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `scouter_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scouter_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `roleID` int NOT NULL,
  `review` text NOT NULL,
  `reviewedFor` varchar(255) NOT NULL,
  `stars` int NOT NULL,
  `active` int NOT NULL,
  `approved` int NOT NULL DEFAULT '0',
  `approvedby` int DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `declined` int NOT NULL DEFAULT '0',
  `declinedby` int DEFAULT NULL,
  `declinedDate` datetime DEFAULT NULL,
  `declinedReason` text,
  `declinedNotes` text,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`,`approved`),
  KEY `userID` (`userID`,`active`,`approved`),
  KEY `regionID` (`regionID`,`active`,`approved`),
  KEY `districtID` (`districtID`,`active`,`approved`),
  KEY `groupID` (`groupID`,`active`,`approved`),
  KEY `active` (`active`,`approved`,`declined`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `scouter_reviews_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scouter_reviews_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviewID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `infoID` (`reviewID`,`active`),
  KEY `createdby` (`createdby`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sd_article_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sd_article_cats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sd_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sd_articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catID` int NOT NULL,
  `groupID` int DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `article` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` varchar(255) NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `catID` (`catID`),
  KEY `active` (`active`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `intro` (`intro`),
  FULLTEXT KEY `article` (`article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services_purchased`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_purchased` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emailAddress` varchar(255) NOT NULL,
  `paymentType` varchar(255) NOT NULL,
  `amountInclVAT` decimal(10,2) NOT NULL,
  `serviceName` text NOT NULL,
  `productDescription` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `processed` int NOT NULL DEFAULT '0',
  `processedDate` datetime DEFAULT NULL,
  `cancelled` int NOT NULL DEFAULT '0',
  `cancelledDate` datetime DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `associatedToGroupDate` datetime DEFAULT NULL,
  `associatedToGroupBy` int DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emailAddress` (`emailAddress`,`serviceName`(255),`active`,`processed`) USING BTREE,
  KEY `groupID` (`groupID`,`serviceName`(255),`active`,`processed`) USING BTREE,
  KEY `processed` (`processed`,`groupID`,`active`) USING BTREE,
  KEY `groupID_2` (`groupID`,`active`,`processed`,`endDate`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services_purchased_spreadsheets_received`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_purchased_spreadsheets_received` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `receivedDate` datetime NOT NULL,
  `location` varchar(1024) NOT NULL,
  `addedBy` int NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services_purchased_spreadsheets_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_purchased_spreadsheets_sent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `dateSent` datetime NOT NULL,
  `sentBy` int NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `star_awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `star_awards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` int NOT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL,
  `districtID` int NOT NULL,
  `groupID` int NOT NULL,
  `denID` int DEFAULT NULL,
  `packID` int DEFAULT NULL,
  `troopID` int DEFAULT NULL,
  `patrolID` int DEFAULT NULL,
  `crewID` int DEFAULT NULL,
  `scouterAskedAward` varchar(25) DEFAULT NULL,
  `scouterAskedAwardDate` datetime DEFAULT NULL,
  `scouterAskedAwardUserID` int DEFAULT NULL,
  `scouterMotivation` text,
  `nptmRecommended` varchar(25) DEFAULT NULL,
  `nptmAskedAwardDate` datetime DEFAULT NULL,
  `nptmAskedAwardUserID` int DEFAULT NULL,
  `nptmMotivation` text,
  `rtcRecommended` varchar(25) DEFAULT NULL,
  `rtcRecommendedDate` datetime DEFAULT NULL,
  `rtcRecommendedUserID` int DEFAULT NULL,
  `rtcMotivation` text,
  `chairAwarded` int DEFAULT NULL,
  `chairAwardedDate` datetime DEFAULT NULL,
  `chairAwardedUserID` int DEFAULT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`year`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `star_awards_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `star_awards_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupID` int NOT NULL,
  `denID` int DEFAULT NULL,
  `packID` int DEFAULT NULL,
  `troopID` int DEFAULT NULL,
  `patrolID` int DEFAULT NULL,
  `crewID` int DEFAULT NULL,
  `noteType` int NOT NULL COMMENT '1 = Group, 2 = District, 3 - Region, 4 = National',
  `note` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupID` (`groupID`,`active`,`noteType`,`created`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supportID` int NOT NULL,
  `userID` int NOT NULL,
  `direction` int NOT NULL COMMENT '1 = From User, 2 = From Admin',
  `chat` text NOT NULL,
  `created` datetime NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_chats_standard_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_chats_standard_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `answer` text NOT NULL,
  `autoClose` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_chats_start`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_chats_start` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `countryID` int NOT NULL,
  `regionID` int NOT NULL DEFAULT '0',
  `area` int NOT NULL,
  `topic` text NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `closed` int DEFAULT NULL,
  `closedDate` datetime DEFAULT NULL,
  `closedBy` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_chats_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_chats_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_ticket_priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_ticket_priorities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `support_ticket_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_ticket_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_account_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_cubs_challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_cubs_challenges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_cubs_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_cubs_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `highLevel` int NOT NULL DEFAULT '0',
  `investment` int NOT NULL DEFAULT '0',
  `colour` varchar(25) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_cubs_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_cubs_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `advancmentID` int NOT NULL,
  `advancementArea` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `advancmentID` (`advancmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_cubs_third`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_cubs_third` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `advancmentID` int NOT NULL,
  `secondID` int NOT NULL,
  `challenge` varchar(50) DEFAULT NULL,
  `theme` int NOT NULL DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `campingTask` int NOT NULL DEFAULT '0',
  `badgeTask` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `advancmentID` (`advancmentID`),
  KEY `secondID` (`secondID`),
  KEY `challenge` (`challenge`,`active`,`programType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_meerkats_challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_meerkats_challenges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_meerkats_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_meerkats_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `highLevel` int NOT NULL DEFAULT '1',
  `investment` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_meerkats_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_meerkats_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `advancmentID` int NOT NULL,
  `advancementArea` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `short` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `badgeTask` int NOT NULL DEFAULT '0',
  `theme` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `advancmentID` (`advancmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_meerkats_third`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_meerkats_third` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `advancmentID` int NOT NULL,
  `secondID` int NOT NULL,
  `challenge` int NOT NULL DEFAULT '0',
  `theme` int DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `campingTask` int NOT NULL DEFAULT '0',
  `badgeTask` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `advancmentID` (`advancmentID`),
  KEY `secondID` (`secondID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_rovers_challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_rovers_challenges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_rovers_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_rovers_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `htmlColor` varchar(25) DEFAULT NULL,
  `highLevel` int NOT NULL DEFAULT '1',
  `investment` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_rovers_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_rovers_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `advancmentID` int NOT NULL,
  `theme` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `campingTask` int NOT NULL DEFAULT '0',
  `badgeTask` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_scouts_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_scouts_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `scoutProgramTypeID` int NOT NULL DEFAULT '1',
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `htmlColor` varchar(15) DEFAULT NULL,
  `colour` varchar(100) DEFAULT NULL,
  `highLevel` int NOT NULL DEFAULT '1',
  `investment` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_scouts_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_scouts_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `scoutProgramTypeID` int NOT NULL DEFAULT '2',
  `programType` int NOT NULL DEFAULT '2',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL DEFAULT '0',
  `advancmentID` int NOT NULL,
  `theme` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `campingTask` int NOT NULL DEFAULT '0',
  `badgeTask` int NOT NULL DEFAULT '0',
  `oldID` varchar(11) NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `PGATask` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `advancmentID` (`advancmentID`),
  KEY `programType` (`programType`,`advancmentID`,`active`),
  KEY `programType_2` (`programType`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_scouts_second_entsha_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_scouts_second_entsha_badges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taskID` int NOT NULL,
  `badgeID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `badgeID` (`badgeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_advancement_scouts_second_entsha_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_advancement_scouts_second_entsha_themes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '2',
  `themeName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_asset_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_asset_condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_awards_rovers_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_awards_rovers_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `htmlColor` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_cubs_first`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_cubs_first` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `note` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_cubs_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_cubs_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `firstID` int NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `task` text NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_meerkats_first`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_meerkats_first` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Special',
  `note` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_meerkats_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_meerkats_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `firstID` int NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `task` text NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_rovers_first`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_rovers_first` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `type` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_rovers_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_rovers_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `firstID` int NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `task` text NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_scouts_first`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_scouts_first` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `type` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programType` (`programType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_scouts_second`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_scouts_second` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programType` int NOT NULL DEFAULT '1',
  `countryID` int NOT NULL DEFAULT '196',
  `firstID` int NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `task` text NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstID` (`firstID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_badge_scouts_to_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_badge_scouts_to_badge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `badgeID` int NOT NULL,
  `toBadgeTaskID` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_cities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_committee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_committee_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_council_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_council_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_country_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_country_names` (
  `country_id` bigint NOT NULL AUTO_INCREMENT,
  `country_code` varchar(3) NOT NULL,
  `country_name` varchar(50) NOT NULL,
  `continent_name` varchar(255) DEFAULT NULL,
  `region_name` varchar(255) DEFAULT NULL,
  `usingSD` int NOT NULL DEFAULT '0',
  `associationName` varchar(255) DEFAULT NULL,
  `branch1Name` varchar(255) DEFAULT NULL,
  `branch1ID` int DEFAULT NULL,
  `branch1StartingAge` decimal(3,1) NOT NULL DEFAULT '5.0',
  `branch1EndingAge` decimal(3,1) NOT NULL DEFAULT '7.0',
  `branch2Name` varchar(255) DEFAULT NULL,
  `branch2ID` int DEFAULT NULL,
  `branch2StartingAge` decimal(3,1) NOT NULL DEFAULT '7.0',
  `branch2EndingAge` decimal(3,1) NOT NULL DEFAULT '11.0',
  `branch3Name` varchar(255) DEFAULT NULL,
  `branch3ID` int DEFAULT NULL,
  `branch3StartingAge` decimal(3,1) NOT NULL DEFAULT '11.0',
  `branch3EndingAge` decimal(3,1) NOT NULL DEFAULT '18.0',
  `branch4Name` varchar(255) DEFAULT NULL,
  `branch4ID` int DEFAULT NULL,
  `branch4StartingAge` decimal(3,1) NOT NULL DEFAULT '18.0',
  `branch4EndingAge` decimal(3,1) NOT NULL DEFAULT '25.0',
  `branch5Name` varchar(255) DEFAULT NULL,
  `branch5ID` int DEFAULT NULL,
  `branch5StartingAge` decimal(3,1) NOT NULL DEFAULT '25.0',
  `branch5EndingAge` decimal(3,1) NOT NULL DEFAULT '35.0',
  PRIMARY KEY (`country_id`,`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_cubs_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_cubs_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_document_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_document_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `youth` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catID` int NOT NULL,
  `targetID` int NOT NULL DEFAULT '0',
  `q` varchar(255) NOT NULL,
  `a` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_faq_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_faq_cats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faqGroup` int NOT NULL DEFAULT '0' COMMENT '1 = Scouters, 2 = Parents, 3 = Scouts, 4 = AMS',
  `position` int NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `forNational` int NOT NULL DEFAULT '0',
  `forRegion` int NOT NULL DEFAULT '0',
  `forDistrict` int NOT NULL DEFAULT '0',
  `forGroupAdults` int NOT NULL DEFAULT '0',
  `forGroupParents` int NOT NULL DEFAULT '0',
  `forGroupScouts` int NOT NULL DEFAULT '0',
  `forGroupRovers` int NOT NULL DEFAULT '0',
  `forAlumni` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_financial_fee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_financial_fee_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `canBeProrated` int NOT NULL DEFAULT '0' COMMENT '1 = Yes, 0 = No',
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_group_event_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_group_event_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `position` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL COMMENT '1 = Active',
  `groupType` int NOT NULL DEFAULT '0',
  `districtType` int NOT NULL DEFAULT '0',
  `regionalType` int NOT NULL DEFAULT '0',
  `nationalType` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_group_management_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_group_management_level` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `type` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_parent_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_parent_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_program_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_program_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `area` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_program_types_cubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_program_types_cubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_program_types_meerkats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_program_types_meerkats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_program_types_rovers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_program_types_rovers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_program_types_scouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_program_types_scouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_roadmap_little`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_roadmap_little` (
  `id` int NOT NULL AUTO_INCREMENT,
  `area` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `releaseDate` date NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_rover_meeting_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_rover_meeting_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_rover_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_rover_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_scout_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_scout_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `maintenance` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_star_award_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_star_award_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `area` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `position` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_titles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_user_logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_user_logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int DEFAULT NULL,
  `regionID` int DEFAULT NULL,
  `districtID` int DEFAULT NULL,
  `groupID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `page` varchar(1024) NOT NULL,
  `IP` varchar(40) NOT NULL,
  `userAgent` varchar(1024) DEFAULT NULL,
  `post` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assocToGroup` (`groupID`),
  KEY `userID` (`userID`),
  KEY `created` (`created`),
  KEY `countryID` (`countryID`,`IP`) USING BTREE,
  KEY `IP` (`IP`,`userID`) USING BTREE,
  KEY `page` (`page`(767)) USING BTREE,
  KEY `IP_2` (`IP`,`page`(767)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_user_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sysAdmin` int NOT NULL DEFAULT '0',
  `nationalRole` int NOT NULL DEFAULT '0',
  `regionalRole` int NOT NULL DEFAULT '0',
  `superDistrictRole` int NOT NULL DEFAULT '0',
  `districtRole` int NOT NULL DEFAULT '0',
  `groupRole` int NOT NULL DEFAULT '0',
  `denRole` int NOT NULL DEFAULT '0',
  `packRole` int NOT NULL DEFAULT '0',
  `troopRole` int NOT NULL DEFAULT '0',
  `crewRole` int NOT NULL DEFAULT '0',
  `adultLeaderRole` int NOT NULL DEFAULT '0',
  `parentHelperRole` int NOT NULL DEFAULT '0',
  `alumniRole` int NOT NULL DEFAULT '0',
  `warrantedRole` int NOT NULL DEFAULT '0',
  `appointmentRole` int NOT NULL DEFAULT '0',
  `requiresCriminalClearance` int NOT NULL DEFAULT '1',
  `signsLeft` int DEFAULT NULL,
  `signsRight` int DEFAULT NULL,
  `chargeRole` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `canAdminAlumni` int NOT NULL DEFAULT '0',
  `canSeeAlumni` int NOT NULL DEFAULT '0',
  `canAdminNational` int NOT NULL DEFAULT '0',
  `canSeeNational` int NOT NULL DEFAULT '0',
  `canAdminRegion` int NOT NULL DEFAULT '0',
  `canSeeRegion` int NOT NULL DEFAULT '0',
  `canAdminRegionKids` int NOT NULL DEFAULT '0',
  `canAdminRegionTraining` int NOT NULL DEFAULT '0',
  `canAdminSuperDistrict` int NOT NULL DEFAULT '0',
  `canSeeSuperDistrict` int NOT NULL DEFAULT '0',
  `canAdminDistrict` int NOT NULL DEFAULT '0',
  `canSeeDistrict` int NOT NULL DEFAULT '0',
  `canAdminDistrictKids` int NOT NULL DEFAULT '0',
  `canAdminGroup` int NOT NULL DEFAULT '0',
  `canSeeGroup` int NOT NULL DEFAULT '0',
  `canAdminGroupAdults` int NOT NULL DEFAULT '0',
  `canAwardGroupMeerkats` int NOT NULL DEFAULT '0',
  `canAwardGroupCubs` int NOT NULL DEFAULT '0',
  `canAwardGroupScouts` int NOT NULL DEFAULT '0',
  `canAwardGroupRovers` int NOT NULL DEFAULT '0',
  `canSeeSupport` int NOT NULL DEFAULT '1',
  `canAdminSupport` int NOT NULL DEFAULT '0',
  `canAddWarrants` int NOT NULL DEFAULT '0',
  `canAdminProperty` int NOT NULL DEFAULT '0',
  `canSignWarrants` int NOT NULL DEFAULT '0',
  `canAdminForm29` int NOT NULL DEFAULT '0',
  `canAdminPoliceClearance` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`countryID`),
  KEY `id_2` (`id`,`adultLeaderRole`,`warrantedRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `oldID` int NOT NULL DEFAULT '0',
  `username` varchar(128) DEFAULT NULL,
  `passwordNew` varbinary(255) DEFAULT NULL,
  `lastPasswordChange` datetime DEFAULT NULL,
  `passwordChangedBy` int DEFAULT NULL,
  `lastLoginDate` datetime DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `otherName` varchar(128) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  `previousSurname` varchar(128) DEFAULT NULL,
  `knownName` varchar(128) DEFAULT NULL,
  `scoutName` varchar(64) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `thumb` varchar(128) DEFAULT NULL,
  `idNumber` varchar(13) DEFAULT NULL,
  `IDBookLocation` varchar(2048) DEFAULT NULL,
  `passportNumber` varchar(24) DEFAULT NULL,
  `passportCountry` int DEFAULT '196',
  `partnersFullName` varchar(128) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `race` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `dateInvested` date DEFAULT NULL,
  `multiID` int NOT NULL DEFAULT '0',
  `packID` int DEFAULT '0',
  `troopID` int DEFAULT '0',
  `dateToCubs` datetime DEFAULT NULL,
  `dateToScouts` datetime DEFAULT NULL,
  `scoutPatrolID` int DEFAULT NULL,
  `scoutPatrolTaskID` int DEFAULT NULL,
  `dateToRovers` datetime DEFAULT NULL,
  `phys_address` text,
  `gpsLat` varchar(25) DEFAULT NULL,
  `gpsLon` varchar(25) DEFAULT NULL,
  `gpsAccuracy` varchar(7) DEFAULT NULL,
  `phys_country_id` int NOT NULL DEFAULT '196',
  `postal_address` text,
  `postal_country_id` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  `user_type` int DEFAULT NULL,
  `parentType` int DEFAULT NULL,
  `active` int NOT NULL COMMENT '1 = active',
  `dateDeactivated` datetime DEFAULT NULL,
  `deactivatedBy` int DEFAULT NULL,
  `assoc_to_account` int NOT NULL,
  `assoc_to_group` int DEFAULT NULL,
  `branch` varchar(6) DEFAULT NULL,
  `assoc_to_district` int DEFAULT NULL,
  `assoc_to_region` int DEFAULT NULL,
  `trainingRegionName` varchar(24) DEFAULT NULL,
  `trainingDistrictName` varchar(64) DEFAULT NULL,
  `trainingGroupName` varchar(64) DEFAULT NULL,
  `language` varchar(5) DEFAULT NULL,
  `cellNr` varchar(32) DEFAULT NULL,
  `officeNr` varchar(32) DEFAULT NULL,
  `homeNr` varchar(32) DEFAULT NULL,
  `faxNr` varchar(64) DEFAULT NULL,
  `responsible_for_payment` int DEFAULT NULL COMMENT '1 = Yes',
  `mustChangePassword` int DEFAULT NULL COMMENT '1 = Must change password',
  `canLogon` int NOT NULL COMMENT '1 = Can Logon',
  `medicalAidName` varchar(128) DEFAULT NULL,
  `medicalAidNr` varchar(128) DEFAULT NULL,
  `medicalAidPrincipalMember` varchar(128) DEFAULT NULL,
  `doctorsName` varchar(128) DEFAULT NULL,
  `doctorsPhone` varchar(128) DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `allergiesInstructions` text,
  `disabilities` text,
  `disabilitiesInstructions` text,
  `medicalConditions` varchar(128) DEFAULT NULL,
  `medicalConditionsInstructions` text,
  `currentMedication` text,
  `emergencyContactName` varchar(128) DEFAULT NULL,
  `emergencyContactCell` varchar(128) DEFAULT NULL,
  `emergencyContactTel` varchar(128) DEFAULT NULL,
  `emergencyContactRelationship` varchar(64) DEFAULT NULL,
  `specialMealRequirements` text,
  `religiousAffilliation` varchar(128) DEFAULT NULL,
  `school` varchar(128) DEFAULT NULL,
  `religion` varchar(128) DEFAULT NULL,
  `religiousAffiliation` varchar(128) DEFAULT NULL,
  `hobbies` text,
  `sports` text,
  `interests` text,
  `canAdmin` int NOT NULL DEFAULT '0',
  `100CharID` varchar(100) DEFAULT NULL,
  `uniquePIN` int DEFAULT NULL,
  `weeklyEmailUnsubscribe` int NOT NULL DEFAULT '0',
  `weeklyEmailUnsubscribeText` text,
  `weeklyEmailUnsubscribeDate` datetime DEFAULT NULL,
  `logonEmailSent` int DEFAULT NULL COMMENT '1 = Yes',
  `LogonEmailDate` datetime DEFAULT NULL,
  `amsOnly` int NOT NULL DEFAULT '0' COMMENT '1 = Only AMS',
  `amsRole` int NOT NULL DEFAULT '0',
  `homeLanguage` int DEFAULT NULL,
  `otherLanguage` int DEFAULT NULL,
  `otherLanguages` text,
  `proficiencyInEnglish` int DEFAULT '0',
  `religiousBelief` varchar(32) DEFAULT NULL,
  `highestEducation` int DEFAULT NULL,
  `nrOfChildrenBoys` int DEFAULT NULL,
  `nrOfChildrenGirls` int DEFAULT NULL,
  `occupation` varchar(64) DEFAULT NULL,
  `typeOfEmployment` varchar(10) DEFAULT NULL,
  `employer` varchar(128) DEFAULT NULL,
  `maritalStatus` int DEFAULT NULL,
  `ref1Name` varchar(128) DEFAULT NULL,
  `ref1Address` text,
  `ref1Tel` varchar(128) DEFAULT NULL,
  `ref2Name` varchar(128) DEFAULT NULL,
  `ref2Address` text,
  `ref2Tel` varchar(128) DEFAULT NULL,
  `newsletterUnsubscribe` int DEFAULT '0',
  `newsletterUnsubscribeDate` datetime DEFAULT NULL,
  `reportView` int DEFAULT '10',
  `roverGroupID` int DEFAULT '0',
  `roverGroupRoleID` int DEFAULT '0',
  `roverGroupAccountID` int DEFAULT '0',
  `24WSJ` int DEFAULT '0',
  `24WSJRole` int DEFAULT '0',
  `24wsjNotListedDistrict` varchar(64) DEFAULT NULL,
  `24wsjNotListedGroup` varchar(64) DEFAULT NULL,
  `SANJamb2017` int NOT NULL DEFAULT '0',
  `SANJamb2017Role` varchar(3) NOT NULL DEFAULT '0',
  `sanJambNotListedRegion` varchar(64) DEFAULT NULL,
  `sanJambNotListedDistrict` varchar(64) DEFAULT NULL,
  `sanJambNotListedGroup` varchar(64) DEFAULT NULL,
  `infoRedacted` int NOT NULL DEFAULT '0' COMMENT '0 = Not Redacted, 1 = Redacted on screen',
  `SSANumber` varchar(32) DEFAULT NULL,
  `orphaned` int NOT NULL DEFAULT '0',
  `vulnerable` int NOT NULL DEFAULT '0',
  `sendAMSMail` int NOT NULL DEFAULT '1',
  `generalNotes` text,
  `form29Generated` int NOT NULL DEFAULT '0',
  `logonEmail` int NOT NULL DEFAULT '0',
  `weeklyProgramEmail` int NOT NULL DEFAULT '1',
  `profileChangesEmail` int NOT NULL DEFAULT '1',
  `newsletterEmail` int NOT NULL DEFAULT '1',
  `lowerStaffProfileChanges` int NOT NULL DEFAULT '1',
  `loggedInTo20` int NOT NULL DEFAULT '0',
  `canLogonTo20` int NOT NULL DEFAULT '1',
  `adultRecruit` int NOT NULL DEFAULT '0',
  `addedIn` int NOT NULL DEFAULT '1',
  `canAdminElearning` int NOT NULL DEFAULT '0',
  `canAdminElearningCourses` int NOT NULL DEFAULT '0',
  `view` int NOT NULL DEFAULT '1' COMMENT '1 = Line, 2 = Grid',
  `docsDeleted` int DEFAULT NULL,
  `takenSurvey` int DEFAULT '0',
  `ddValue` int NOT NULL DEFAULT '25',
  `DSDHostelName` varchar(255) DEFAULT NULL,
  `DSDTownshipName` varchar(255) DEFAULT NULL,
  `DSDDisabled` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_type` (`user_type`),
  KEY `username` (`username`),
  KEY `username_2` (`username`,`active`,`canLogon`),
  KEY `assoc_to_group_2` (`assoc_to_group`,`user_type`,`active`),
  KEY `assoc_to_group_3` (`assoc_to_group`,`dob`,`active`),
  KEY `orphanedVulnerable` (`active`),
  KEY `assoc_to_group` (`assoc_to_group`,`amsRole`,`active`),
  KEY `assoc_to_region` (`assoc_to_region`,`amsRole`,`active`,`sendAMSMail`),
  KEY `assoc_to_region_2` (`assoc_to_region`,`user_type`,`active`,`sendAMSMail`),
  KEY `id_2` (`id`,`assoc_to_region`),
  KEY `id_3` (`id`,`assoc_to_group`),
  KEY `100CharID` (`100CharID`),
  KEY `assoc_to_region_3` (`assoc_to_region`,`assoc_to_district`,`user_type`,`orphaned`,`vulnerable`,`active`),
  KEY `assoc_to_region_4` (`assoc_to_region`,`user_type`,`orphaned`,`vulnerable`,`active`),
  KEY `phys_country_id_2` (`phys_country_id`,`user_type`,`orphaned`,`vulnerable`,`active`),
  KEY `assoc_to_group_4` (`assoc_to_group`,`active`,`SANJamb2017Role`),
  KEY `assoc_to_account_2` (`assoc_to_account`,`user_type`,`active`),
  KEY `active` (`active`,`SANJamb2017`,`user_type`,`username`,`assoc_to_account`),
  KEY `assoc_to_group_5` (`assoc_to_group`,`user_type`,`amsRole`,`active`),
  KEY `GPS` (`id`,`active`,`gpsLat`,`gpsLon`),
  KEY `assoc_to_region_6` (`assoc_to_region`,`active`,`amsRole`),
  KEY `assoc_to_region_5` (`assoc_to_region`,`active`,`user_type`,`dateInvested`),
  KEY `assoc_to_group_6` (`assoc_to_group`,`user_type`,`title`,`active`),
  KEY `assoc_to_group_7` (`assoc_to_group`,`user_type`,`created`,`active`),
  KEY `assoc_to_group_8` (`assoc_to_group`,`user_type`,`scoutPatrolTaskID`,`active`),
  KEY `id_4` (`id`,`active`),
  KEY `assoc_to_account` (`assoc_to_account`,`assoc_to_group`,`active`),
  KEY `assoc_to_district` (`assoc_to_district`,`user_type`,`dob`,`active`),
  KEY `assoc_to_account_3` (`assoc_to_account`,`parentType`,`active`),
  KEY `Move To 2.0` (`active`,`modified`,`addedIn`),
  KEY `Logon` (`username`,`passwordNew`,`active`,`canLogon`,`phys_country_id`) USING BTREE,
  KEY `Form29` (`active`,`form29Generated`,`IDBookLocation`(767)) USING BTREE,
  KEY `lastLoginDate` (`lastLoginDate`),
  KEY `active_2` (`active`,`docsDeleted`,`dateDeactivated`) USING BTREE,
  KEY `UsingSDLite` (`active`,`generalNotes`(255),`startDate`) USING BTREE,
  KEY `id` (`id`,`assoc_to_account`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_email_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_email_verifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `emailAddress` varchar(150) NOT NULL,
  `emailFailedVerification` int NOT NULL DEFAULT '0',
  `dateVerified` datetime DEFAULT NULL,
  `response` text,
  `responseHeading` varchar(25) DEFAULT NULL,
  `sentConfirmationEmail` datetime DEFAULT NULL,
  `subjectReceivedBack` text,
  `messageReceivedBack` text,
  `messageReceivedBackDate` datetime DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_emergency_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_emergency_contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `contact1Title` varchar(10) DEFAULT NULL,
  `contact1FirstName` varchar(255) NOT NULL,
  `contact1Surname` varchar(255) NOT NULL,
  `contact1Cell` varchar(25) NOT NULL,
  `contact1Home` varchar(25) DEFAULT NULL,
  `contact1Work` varchar(25) DEFAULT NULL,
  `contact1Relationship` int DEFAULT NULL,
  `contact2Title` varchar(10) DEFAULT NULL,
  `contact2FirstName` varchar(255) NOT NULL,
  `contact12urname` varchar(255) NOT NULL,
  `contact2Cell` varchar(25) NOT NULL,
  `contact2Home` varchar(25) DEFAULT NULL,
  `contact2Work` varchar(25) DEFAULT NULL,
  `contact2Relationship` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_fingerprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_fingerprint` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `agent` text,
  `ipAddress` varchar(25) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`agent`(767),`ipAddress`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_forced_logouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_forced_logouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `userID` int NOT NULL,
  `fromURL` text NOT NULL,
  `toURL` text NOT NULL,
  `IPAddress` varchar(255) DEFAULT NULL,
  `extended` text,
  `userAgent` text,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`date`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_form29`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_form29` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `PDFLocation` varchar(1024) NOT NULL,
  `sentToDSD` date DEFAULT NULL,
  `DSDResponse` varchar(255) DEFAULT NULL,
  `DSDResponseNotes` text,
  `DSDResponseDate` datetime DEFAULT NULL,
  `DSDResponseBy` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_other_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_other_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `countryID` int NOT NULL DEFAULT '196',
  `regionID` int NOT NULL DEFAULT '0',
  `superDistrictID` int DEFAULT NULL,
  `districtID` int NOT NULL DEFAULT '0',
  `groupID` int NOT NULL DEFAULT '0',
  `roleID` int NOT NULL DEFAULT '0',
  `defaultRole` int NOT NULL DEFAULT '0',
  `active` int NOT NULL,
  `creationNotes` text,
  `actionCountryID` int NOT NULL DEFAULT '0',
  `actionRegionID` int NOT NULL DEFAULT '0',
  `actionSuperDistrictID` int NOT NULL DEFAULT '0',
  `actionDistrictID` int NOT NULL DEFAULT '0',
  `actionGroupID` int NOT NULL DEFAULT '0',
  `retired` int NOT NULL DEFAULT '0',
  `resigned` int NOT NULL DEFAULT '0',
  `suspended` int NOT NULL DEFAULT '0',
  `multiID` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`,`defaultRole`),
  KEY `groupID` (`groupID`,`userID`,`active`,`roleID`),
  KEY `countryID` (`countryID`,`userID`,`active`,`roleID`),
  KEY `regionID` (`regionID`,`userID`,`active`,`roleID`),
  KEY `districtID` (`districtID`,`userID`,`active`,`roleID`),
  KEY `userID_2` (`userID`,`active`,`id`),
  KEY `groupID_2` (`groupID`,`roleID`,`active`),
  KEY `districtID_2` (`districtID`,`roleID`,`active`),
  KEY `regionID_2` (`regionID`,`roleID`,`active`),
  KEY `countryID_3` (`countryID`,`roleID`,`active`),
  KEY `userID_3` (`userID`,`roleID`,`active`,`actionCountryID`,`actionRegionID`,`actionDistrictID`,`actionGroupID`),
  KEY `regionID_3` (`regionID`,`active`),
  KEY `districtID_3` (`districtID`,`active`),
  KEY `groupID_3` (`groupID`,`active`),
  KEY `countryID_4` (`countryID`,`active`),
  KEY `actionCountryID` (`actionCountryID`,`active`,`roleID`),
  KEY `actionRegionID` (`actionRegionID`,`active`,`roleID`),
  KEY `actionDistrictID` (`actionDistrictID`,`active`,`roleID`),
  KEY `actionGroupID` (`actionGroupID`,`active`,`roleID`),
  KEY `userID_4` (`userID`,`active`,`actionGroupID`),
  KEY `userID_5` (`userID`,`actionRegionID`,`active`,`roleID`),
  KEY `actionCountryID_2` (`actionCountryID`,`userID`,`active`),
  KEY `roleID` (`roleID`,`active`) USING BTREE,
  KEY `form29` (`actionCountryID`,`active`,`defaultRole`) USING BTREE,
  KEY `roleID_2` (`roleID`,`active`,`defaultRole`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `system_users_passwords_emailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users_passwords_emailed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(1024) NOT NULL,
  `date` datetime NOT NULL,
  `emailed` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_ban_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_ban_count` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `chatID` varchar(255) NOT NULL,
  `count` int NOT NULL,
  `firstAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `why` text,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`chatID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_currently_chatting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_currently_chatting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `systemUserID` int NOT NULL,
  `chattingToUserID` int NOT NULL,
  `active` int NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chattingToUserID` (`chattingToUserID`,`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT '0',
  `telegramUserID` varchar(255) DEFAULT NULL,
  `telegramFirstName` varchar(255) DEFAULT NULL,
  `telegramSurname` varchar(255) DEFAULT NULL,
  `telegramUsername` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `direction` varchar(12) NOT NULL COMMENT '''To SD'' or ''From SD''',
  `sentByID` int NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `markedRead` datetime DEFAULT NULL,
  `markedReadBy` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userID_2` (`userID`,`date`,`direction`) USING BTREE,
  KEY `telegramUserID` (`telegramUserID`),
  KEY `userID` (`userID`,`active`,`markedRead`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_random_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_random_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_sent_human_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_sent_human_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `date` date NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_standard_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_standard_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_usernames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_usernames` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `chatID` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `banned` int NOT NULL DEFAULT '0',
  `bannedDate` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `chatID` (`chatID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `countryID` int NOT NULL DEFAULT '196',
  `fromText` varchar(255) NOT NULL,
  `toText` text NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `countryID` (`countryID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wsm16_expression`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wsm16_expression` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `roleID` int NOT NULL,
  `active` int NOT NULL,
  `passportCountryID` int NOT NULL,
  `passportChecked` int NOT NULL DEFAULT '0',
  `countryID` int NOT NULL DEFAULT '196',
  `regionID` int NOT NULL DEFAULT '0',
  `districtID` int NOT NULL DEFAULT '0',
  `groupID` int NOT NULL DEFAULT '0',
  `applyRoleID` int NOT NULL,
  `invested` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`,`active`),
  KEY `roleID` (`roleID`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2025_09_10_130916_create_admin_404_pages_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2025_09_10_130916_create_admin_bad_logons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2025_09_10_130916_create_admin_banned_ips_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2025_09_10_130916_create_admin_good_logons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2025_09_10_130916_create_advancement_cubs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2025_09_10_130916_create_advancement_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2025_09_10_130916_create_advancement_meerkats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2025_09_10_130916_create_advancement_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_09_10_130916_create_advancement_photos_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_09_10_130916_create_advancement_rovers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_09_10_130916_create_advancement_scouters_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_09_10_130916_create_advancement_scouts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_09_10_130916_create_ams_adult_leader_moves_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_09_10_130916_create_ams_award_applications_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_09_10_130916_create_ams_award_headings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_09_10_130916_create_ams_award_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_09_10_130916_create_ams_award_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_09_10_130916_create_ams_charge_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_09_10_130916_create_ams_charge_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2025_09_10_130916_create_ams_criminal_check_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2025_09_10_130916_create_ams_disciplinary_headings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2025_09_10_130916_create_ams_disciplinary_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2025_09_10_130916_create_ams_disciplinary_offences_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2025_09_10_130916_create_ams_document_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2025_09_10_130916_create_ams_document_types_groups_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2025_09_10_130916_create_ams_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_09_10_130916_create_ams_documents_groups_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2025_09_10_130916_create_ams_highest_education_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2025_09_10_130916_create_ams_languages_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2025_09_10_130916_create_ams_marital_status_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_09_10_130916_create_ams_past_service_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_09_10_130916_create_ams_past_service_type_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2025_09_10_130916_create_ams_police_clearance_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_09_10_130916_create_ams_resign_leader_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2025_09_10_130916_create_ams_resign_reasons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_09_10_130916_create_ams_retire_leader_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_09_10_130916_create_ams_retire_reasons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_09_10_130916_create_ams_suspend_leader_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2025_09_10_130916_create_ams_suspend_reasons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_09_10_130916_create_ams_terminate_leader_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2025_09_10_130916_create_ams_terminate_reasons_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_09_10_130916_create_ams_training_courses_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2025_09_10_130916_create_ams_training_courses_annual_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2025_09_10_130916_create_ams_training_courses_annual_attendance_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2025_09_10_130916_create_ams_training_courses_annual_bookings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_09_10_130916_create_ams_training_courses_annual_bookings_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_09_10_130916_create_ams_training_courses_annual_bookings_tracking_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_09_10_130916_create_ams_training_courses_annual_dates_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_09_10_130916_create_ams_training_courses_annual_lecturers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_09_10_130916_create_ams_training_courses_annual_warrants_available_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2025_09_10_130916_create_ams_training_courses_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2025_09_10_130916_create_ams_training_locations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2025_09_10_130916_create_ams_training_past_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2025_09_10_130916_create_ams_training_past_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2025_09_10_130916_create_ams_warrant_applications_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2025_09_10_130916_create_ams_warrant_cancellation_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2025_09_10_130916_create_ams_warrant_extensions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2025_09_10_130916_create_ams_warrant_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2025_09_10_130916_create_ams_warrant_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2025_09_10_130916_create_api_keys_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2025_09_10_130916_create_api_usage_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2025_09_10_130916_create_badges_cubs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2025_09_10_130916_create_badges_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2025_09_10_130916_create_badges_meerkats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2025_09_10_130916_create_badges_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2025_09_10_130916_create_badges_photos_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2025_09_10_130916_create_badges_rovers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2025_09_10_130916_create_badges_scouts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2025_09_10_130916_create_census_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2025_09_10_130916_create_commerce_cart_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2025_09_10_130916_create_commerce_delivery_address_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2025_09_10_130916_create_commerce_delivery_providers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2025_09_10_130916_create_commerce_delivery_providers_delivery_options_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2025_09_10_130916_create_commerce_group_fees_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2025_09_10_130916_create_commerce_order_status_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2025_09_10_130916_create_commerce_orders_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2025_09_10_130916_create_commerce_orders_details_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2025_09_10_130916_create_commerce_payfast_transactions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2025_09_10_130916_create_commerce_products_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (80,'2025_09_10_130916_create_commerce_products_cat_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (81,'2025_09_10_130916_create_commerce_products_images_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (82,'2025_09_10_130916_create_commerce_products_reviews_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2025_09_10_130916_create_commerce_products_stock_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2025_09_10_130916_create_commerce_products_sub_subcat_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2025_09_10_130916_create_commerce_products_subcat_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2025_09_10_130916_create_commerce_search_queries_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2025_09_10_130916_create_commerce_shoppers_logins_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2025_09_10_130916_create_commerce_stock_locations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2025_09_10_130916_create_commerce_stock_suppliers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2025_09_10_130916_create_commerce_wallet_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2025_09_10_130916_create_commerce_wallets_transaction_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2025_09_10_130916_create_commerce_wish_list_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2025_09_10_130916_create_directory_professional_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2025_09_10_130916_create_directory_professional_likes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2025_09_10_130916_create_directory_professional_reviews_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2025_09_10_130916_create_directory_skills_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2025_09_10_130916_create_districts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2025_09_10_130916_create_districts_super_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2025_09_10_130916_create_error_logging_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (100,'2025_09_10_130916_create_event_booking_setup_changes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (101,'2025_09_10_130916_create_event_competition_score_adjudication_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (102,'2025_09_10_130916_create_event_competitions_answers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (103,'2025_09_10_130916_create_event_competitions_finances_invoices_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (104,'2025_09_10_130916_create_event_competitions_finances_payments_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (105,'2025_09_10_130916_create_event_competitions_gps_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (106,'2025_09_10_130916_create_event_competitions_groups_attending_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (107,'2025_09_10_130916_create_event_competitions_groups_participating_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (108,'2025_09_10_130916_create_event_competitions_internal_competitions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (109,'2025_09_10_130916_create_event_competitions_judges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (110,'2025_09_10_130916_create_event_competitions_judges_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (111,'2025_09_10_130916_create_event_competitions_location_logging_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (112,'2025_09_10_130916_create_event_competitions_questions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (113,'2025_09_10_130916_create_event_competitions_scoring_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (114,'2025_09_10_130916_create_event_competitions_scoring_areas_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (115,'2025_09_10_130916_create_event_competitions_scoring_dnp_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (116,'2025_09_10_130916_create_event_competitions_scoring_sheets_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (117,'2025_09_10_130916_create_event_competitions_scoring_sheets_headings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (118,'2025_09_10_130916_create_event_competitions_survey_responses_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (119,'2025_09_10_130916_create_event_user_booking_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (120,'2025_09_10_130916_create_event_user_booking_accomodation_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (121,'2025_09_10_130916_create_event_user_booking_credit_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (122,'2025_09_10_130916_create_event_user_booking_invoices_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (123,'2025_09_10_130916_create_event_user_booking_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (124,'2025_09_10_130916_create_event_user_booking_other_options_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (125,'2025_09_10_130916_create_event_user_booking_patrol_allocation_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (126,'2025_09_10_130916_create_event_user_booking_patrols_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (127,'2025_09_10_130916_create_event_user_booking_payments_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (128,'2025_09_10_130916_create_event_user_booking_pops_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (129,'2025_09_10_130916_create_event_user_booking_roles_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (130,'2025_09_10_130916_create_event_user_booking_transport_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (131,'2025_09_10_130916_create_group_account_transfers_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (132,'2025_09_10_130916_create_group_accounts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (133,'2025_09_10_130916_create_group_accounts_transfers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (134,'2025_09_10_130916_create_group_accounts_transfers_stages_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (135,'2025_09_10_130916_create_group_advancements_in_events_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (136,'2025_09_10_130916_create_group_advancements_in_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (137,'2025_09_10_130916_create_group_attendance_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (138,'2025_09_10_130916_create_group_badges_in_events_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (139,'2025_09_10_130916_create_group_badges_in_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (140,'2025_09_10_130916_create_group_committee_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (141,'2025_09_10_130916_create_group_council_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (142,'2025_09_10_130916_create_group_cub_packs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (143,'2025_09_10_130916_create_group_cubs_sixes_names_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (144,'2025_09_10_130916_create_group_district_reports_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (145,'2025_09_10_130916_create_group_district_reports_cubs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (146,'2025_09_10_130916_create_group_district_reports_cubs_attendance_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (147,'2025_09_10_130916_create_group_district_reports_scouts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (148,'2025_09_10_130916_create_group_district_reports_scouts_attendance_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (149,'2025_09_10_130916_create_group_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (150,'2025_09_10_130916_create_group_edit_record_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (151,'2025_09_10_130916_create_group_equipment_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (152,'2025_09_10_130916_create_group_equipment_store_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (153,'2025_09_10_130916_create_group_event_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (154,'2025_09_10_130916_create_group_events_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (155,'2025_09_10_130916_create_group_events_attending_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (156,'2025_09_10_130916_create_group_financial_annual_invoice_discounts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (157,'2025_09_10_130916_create_group_financial_credit_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (158,'2025_09_10_130916_create_group_financial_credit_notes_items_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (159,'2025_09_10_130916_create_group_financial_fee_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (160,'2025_09_10_130916_create_group_financial_fees_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (161,'2025_09_10_130916_create_group_financial_invoices_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (162,'2025_09_10_130916_create_group_financial_invoices_emailed_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (163,'2025_09_10_130916_create_group_financial_invoices_items_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (164,'2025_09_10_130916_create_group_financial_payments_made_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (165,'2025_09_10_130916_create_group_financial_years_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (166,'2025_09_10_130916_create_group_meerkat_dens_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (167,'2025_09_10_130916_create_group_meerkats_patrol_names_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (168,'2025_09_10_130916_create_group_newsletters_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (169,'2025_09_10_130916_create_group_parents_committee_minutes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (170,'2025_09_10_130916_create_group_programs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (171,'2025_09_10_130916_create_group_programs_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (172,'2025_09_10_130916_create_group_programs_online_tasks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (173,'2025_09_10_130916_create_group_programs_online_tasks_completion_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (174,'2025_09_10_130916_create_group_programs_online_tasks_documents_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (175,'2025_09_10_130916_create_group_programs_online_tasks_images_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (176,'2025_09_10_130916_create_group_programs_online_tasks_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (177,'2025_09_10_130916_create_group_programs_online_tasks_penalty_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (178,'2025_09_10_130916_create_group_programs_online_working_on_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (179,'2025_09_10_130916_create_group_rover_crews_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (180,'2025_09_10_130916_create_group_rovers_patrol_names_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (181,'2025_09_10_130916_create_group_scout_troops_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (182,'2025_09_10_130916_create_group_scouts_charges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (183,'2025_09_10_130916_create_group_scouts_patrol_names_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (184,'2025_09_10_130916_create_group_send_logon_details_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (185,'2025_09_10_130916_create_group_star_awards_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (186,'2025_09_10_130916_create_group_user_picture_changes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (187,'2025_09_10_130916_create_group_weekly_emails_emailed_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (188,'2025_09_10_130916_create_group_youth_charges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (189,'2025_09_10_130916_create_groups_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (190,'2025_09_10_130916_create_groups_entsha_move_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (191,'2025_09_10_130916_create_groups_multi_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (192,'2025_09_10_130916_create_groups_property_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (193,'2025_09_10_130916_create_groups_property_ownership_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (194,'2025_09_10_130916_create_groups_property_updates_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (195,'2025_09_10_130916_create_groups_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (196,'2025_09_10_130916_create_info_sharing_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (197,'2025_09_10_130916_create_info_sharing_likes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (198,'2025_09_10_130916_create_info_sharing_reviews_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (199,'2025_09_10_130916_create_info_sharing_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (200,'2025_09_10_130916_create_jamboree_activity_center_bases_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (201,'2025_09_10_130916_create_jamboree_activity_centers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (202,'2025_09_10_130916_create_jamboree_adult_allocations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (203,'2025_09_10_130916_create_jamboree_adult_roles_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (204,'2025_09_10_130916_create_jamboree_application_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (205,'2025_09_10_130916_create_jamboree_beds_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (206,'2025_09_10_130916_create_jamboree_beds_allocations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (207,'2025_09_10_130916_create_jamboree_bus_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (208,'2025_09_10_130916_create_jamboree_buses_users_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (209,'2025_09_10_130916_create_jamboree_core_team_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (210,'2025_09_10_130916_create_jamboree_eoi_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (211,'2025_09_10_130916_create_jamboree_expr_of_interest_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (212,'2025_09_10_130916_create_jamboree_generated_pdfs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (213,'2025_09_10_130916_create_jamboree_info_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (214,'2025_09_10_130916_create_jamboree_initial_thoughts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (215,'2025_09_10_130916_create_jamboree_invoices_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (216,'2025_09_10_130916_create_jamboree_invoices_items_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (217,'2025_09_10_130916_create_jamboree_patrols_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (218,'2025_09_10_130916_create_jamboree_payment_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (219,'2025_09_10_130916_create_jamboree_payments_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (220,'2025_09_10_130916_create_jamboree_position_offered_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (221,'2025_09_10_130916_create_jamboree_scouters_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (222,'2025_09_10_130916_create_jamboree_sub_camp_troop_allocations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (223,'2025_09_10_130916_create_jamboree_sub_camps_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (224,'2025_09_10_130916_create_jamboree_troop_patrol_allocations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (225,'2025_09_10_130916_create_jamboree_troops_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (226,'2025_09_10_130916_create_national_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (227,'2025_09_10_130916_create_notifications_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (228,'2025_09_10_130916_create_notifications_archive_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (229,'2025_09_10_130916_create_payment_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (230,'2025_09_10_130916_create_projects_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (231,'2025_09_10_130916_create_projects_for_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (232,'2025_09_10_130916_create_projects_supported_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (233,'2025_09_10_130916_create_regions_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (234,'2025_09_10_130916_create_reports_numbers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (235,'2025_09_10_130916_create_scouter_reviews_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (236,'2025_09_10_130916_create_scouter_reviews_likes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (237,'2025_09_10_130916_create_sd_article_cats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (238,'2025_09_10_130916_create_sd_articles_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (239,'2025_09_10_130916_create_services_purchased_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (240,'2025_09_10_130916_create_services_purchased_spreadsheets_received_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (241,'2025_09_10_130916_create_services_purchased_spreadsheets_sent_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (242,'2025_09_10_130916_create_star_awards_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (243,'2025_09_10_130916_create_star_awards_notes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (244,'2025_09_10_130916_create_support_chats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (245,'2025_09_10_130916_create_support_chats_standard_answers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (246,'2025_09_10_130916_create_support_chats_start_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (247,'2025_09_10_130916_create_support_chats_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (248,'2025_09_10_130916_create_support_ticket_priorities_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (249,'2025_09_10_130916_create_support_ticket_status_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (250,'2025_09_10_130916_create_system_account_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (251,'2025_09_10_130916_create_system_advancement_cubs_challenges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (252,'2025_09_10_130916_create_system_advancement_cubs_levels_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (253,'2025_09_10_130916_create_system_advancement_cubs_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (254,'2025_09_10_130916_create_system_advancement_cubs_third_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (255,'2025_09_10_130916_create_system_advancement_meerkats_challenges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (256,'2025_09_10_130916_create_system_advancement_meerkats_levels_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (257,'2025_09_10_130916_create_system_advancement_meerkats_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (258,'2025_09_10_130916_create_system_advancement_meerkats_third_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (259,'2025_09_10_130916_create_system_advancement_rovers_challenges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (260,'2025_09_10_130916_create_system_advancement_rovers_levels_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (261,'2025_09_10_130916_create_system_advancement_rovers_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (262,'2025_09_10_130916_create_system_advancement_scouts_levels_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (263,'2025_09_10_130916_create_system_advancement_scouts_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (264,'2025_09_10_130916_create_system_advancement_scouts_second_entsha_badges_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (265,'2025_09_10_130916_create_system_advancement_scouts_second_entsha_themes_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (266,'2025_09_10_130916_create_system_asset_condition_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (267,'2025_09_10_130916_create_system_awards_rovers_levels_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (268,'2025_09_10_130916_create_system_badge_cubs_first_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (269,'2025_09_10_130916_create_system_badge_cubs_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (270,'2025_09_10_130916_create_system_badge_meerkats_first_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (271,'2025_09_10_130916_create_system_badge_meerkats_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (272,'2025_09_10_130916_create_system_badge_rovers_first_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (273,'2025_09_10_130916_create_system_badge_rovers_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (274,'2025_09_10_130916_create_system_badge_scouts_first_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (275,'2025_09_10_130916_create_system_badge_scouts_second_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (276,'2025_09_10_130916_create_system_badge_scouts_to_badge_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (277,'2025_09_10_130916_create_system_cities_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (278,'2025_09_10_130916_create_system_committee_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (279,'2025_09_10_130916_create_system_council_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (280,'2025_09_10_130916_create_system_country_names_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (281,'2025_09_10_130916_create_system_cubs_tasks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (282,'2025_09_10_130916_create_system_document_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (283,'2025_09_10_130916_create_system_faq_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (284,'2025_09_10_130916_create_system_faq_cats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (285,'2025_09_10_130916_create_system_financial_fee_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (286,'2025_09_10_130916_create_system_group_event_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (287,'2025_09_10_130916_create_system_group_management_level_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (288,'2025_09_10_130916_create_system_parent_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (289,'2025_09_10_130916_create_system_program_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (290,'2025_09_10_130916_create_system_program_types_cubs_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (291,'2025_09_10_130916_create_system_program_types_meerkats_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (292,'2025_09_10_130916_create_system_program_types_rovers_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (293,'2025_09_10_130916_create_system_program_types_scouts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (294,'2025_09_10_130916_create_system_roadmap_little_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (295,'2025_09_10_130916_create_system_rover_meeting_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (296,'2025_09_10_130916_create_system_rover_tasks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (297,'2025_09_10_130916_create_system_scout_tasks_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (298,'2025_09_10_130916_create_system_settings_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (299,'2025_09_10_130916_create_system_star_award_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (300,'2025_09_10_130916_create_system_titles_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (301,'2025_09_10_130916_create_system_user_logging_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (302,'2025_09_10_130916_create_system_user_types_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (303,'2025_09_10_130916_create_system_users_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (304,'2025_09_10_130916_create_system_users_email_verifications_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (305,'2025_09_10_130916_create_system_users_emergency_contacts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (306,'2025_09_10_130916_create_system_users_fingerprint_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (307,'2025_09_10_130916_create_system_users_forced_logouts_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (308,'2025_09_10_130916_create_system_users_form29_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (309,'2025_09_10_130916_create_system_users_other_roles_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (310,'2025_09_10_130916_create_system_users_passwords_emailed_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (311,'2025_09_10_130916_create_telegram_ban_count_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (312,'2025_09_10_130916_create_telegram_currently_chatting_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (313,'2025_09_10_130916_create_telegram_messages_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (314,'2025_09_10_130916_create_telegram_random_message_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (315,'2025_09_10_130916_create_telegram_sent_human_message_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (316,'2025_09_10_130916_create_telegram_standard_messages_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (317,'2025_09_10_130916_create_telegram_usernames_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (318,'2025_09_10_130916_create_translations_table',0);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (319,'2025_09_10_130916_create_wsm16_expression_table',0);
