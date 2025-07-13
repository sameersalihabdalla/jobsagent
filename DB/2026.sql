/*
SQLyog Ultimate v10.42 
MySQL - 8.3.0 : Database - jobsagent
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin` */

CREATE TABLE `admin` (
  `aid` int NOT NULL,
  `auser` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `aemail` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apass` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `adob` date NOT NULL,
  `aphone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `cities` */

CREATE TABLE `cities` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` mediumint unsigned NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` mediumint unsigned NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2014-01-01 08:31:01',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`),
  KEY `cities_test_ibfk_1` (`state_id`),
  KEY `cities_test_ibfk_2` (`country_id`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  CONSTRAINT `cities_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153661 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Table structure for table `countries` */

CREATE TABLE `countries` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeric_code` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tld` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `native` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_id` mediumint unsigned DEFAULT NULL,
  `subregion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subregion_id` mediumint unsigned DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezones` text COLLATE utf8mb4_unicode_ci,
  `translations` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `emoji` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emojiU` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`),
  KEY `country_continent` (`region_id`),
  KEY `country_subregion` (`subregion_id`),
  CONSTRAINT `country_continent_final` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  CONSTRAINT `country_subregion_final` FOREIGN KEY (`subregion_id`) REFERENCES `subregions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `email_settings` */

CREATE TABLE `email_settings` (
  `id` int NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` int DEFAULT NULL,
  `smtp_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `favorites` */

CREATE TABLE `favorites` (
  `user_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `jobs` */

CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'غير محدد',
  `desciption` longtext COLLATE utf8mb3_unicode_ci,
  `date` date DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `salary` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `job_cat_id` int DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `visable` int DEFAULT NULL,
  `add_date` date DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2287 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Table structure for table `jobs_cat` */

CREATE TABLE `jobs_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `job_en` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Table structure for table `jobs_type` */

CREATE TABLE `jobs_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Table structure for table `logs` */

CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `notifications` */

CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `regions` */

CREATE TABLE `regions` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translations` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `settings` */

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_description` text COLLATE utf8mb4_unicode_ci,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `states` */

CREATE TABLE `states` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` mediumint unsigned NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fips_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`),
  KEY `country_region` (`country_id`),
  CONSTRAINT `country_region_final` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5228 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Table structure for table `subregions` */

CREATE TABLE `subregions` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translations` text COLLATE utf8mb4_unicode_ci,
  `region_id` mediumint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`),
  KEY `subregion_continent` (`region_id`),
  CONSTRAINT `subregion_continent_final` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `user` */

CREATE TABLE `user` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `uemail` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `uphone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `upass` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `utype` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `uimage` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verify_code` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_code` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `visitors` */

CREATE TABLE `visitors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `datee` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=497247 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Table structure for table `myjobs` */

DROP TABLE IF EXISTS `myjobs`;

/*!50001 CREATE TABLE  `myjobs`(
 `id` int ,
 `job_title` varchar(255) ,
 `desciption` longtext ,
 `date` date ,
 `city_id` int ,
 `country_id` int ,
 `salary` int ,
 `job_type_id` int ,
 `company` varchar(255) ,
 `job_cat_id` int ,
 `link` varchar(255) ,
 `email` varchar(255) ,
 `visable` int ,
 `job_cat` varchar(255) ,
 `logo` varchar(255) ,
 `job_cat_en` varchar(255) ,
 `name` varchar(255) ,
 `name_en` varchar(100) ,
 `city_name` varchar(255) ,
 `city_name_en` varchar(255) ,
 `wikiDataId` varchar(255) ,
 `job_type` varchar(100) ,
 `job_type_en` varchar(100) ,
 `add_date` date ,
 `capital` varchar(255) ,
 `currency_name` varchar(255) ,
 `currency` varchar(255) ,
 `latitude` decimal(10,8) ,
 `longitude` decimal(11,8) ,
 `phonecode` varchar(255) ,
 `iso2` char(2) ,
 `native` varchar(255) 
)*/;

/*View structure for view myjobs */

/*!50001 DROP TABLE IF EXISTS `myjobs` */;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `myjobs` AS select `jobs`.`id` AS `id`,`jobs`.`job_title` AS `job_title`,`jobs`.`desciption` AS `desciption`,`jobs`.`date` AS `date`,`jobs`.`city_id` AS `city_id`,`jobs`.`country_id` AS `country_id`,`jobs`.`salary` AS `salary`,`jobs`.`job_type_id` AS `job_type_id`,`jobs`.`company` AS `company`,`jobs`.`job_cat_id` AS `job_cat_id`,`jobs`.`link` AS `link`,`jobs`.`email` AS `email`,`jobs`.`visable` AS `visable`,`jobs_cat`.`job` AS `job_cat`,`jobs_cat`.`logo` AS `logo`,`jobs_cat`.`job_en` AS `job_cat_en`,`countries`.`native` AS `name`,`countries`.`name` AS `name_en`,`cities`.`name` AS `city_name`,`cities`.`name` AS `city_name_en`,`cities`.`wikiDataId` AS `wikiDataId`,`jobs_type`.`name` AS `job_type`,`jobs_type`.`name_en` AS `job_type_en`,`jobs`.`add_date` AS `add_date`,`countries`.`capital` AS `capital`,`countries`.`currency_name` AS `currency_name`,`countries`.`currency` AS `currency`,`countries`.`latitude` AS `latitude`,`countries`.`longitude` AS `longitude`,`countries`.`phonecode` AS `phonecode`,`countries`.`iso2` AS `iso2`,`countries`.`native` AS `native` from ((((`cities` join `jobs` on((`jobs`.`city_id` = `cities`.`id`))) join `countries` on((`jobs`.`country_id` = `countries`.`id`))) join `jobs_cat` on((`jobs`.`job_cat_id` = `jobs_cat`.`id`))) join `jobs_type` on((`jobs`.`job_type_id` = `jobs_type`.`id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
