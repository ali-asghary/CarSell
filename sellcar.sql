-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2022 at 05:21 PM
-- Server version: 10.5.4-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sellcar`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_costs`
--

DROP TABLE IF EXISTS `action_costs`;
CREATE TABLE IF NOT EXISTS `action_costs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vipcost` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usercost` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_bids`
--

DROP TABLE IF EXISTS `auction_bids`;
CREATE TABLE IF NOT EXISTS `auction_bids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auctionid` int(11) NOT NULL,
  `maxbid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidtime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_bids_auctionid_foreign` (`auctionid`),
  KEY `auction_bids_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_claim_infos`
--

DROP TABLE IF EXISTS `auction_claim_infos`;
CREATE TABLE IF NOT EXISTS `auction_claim_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auctionid` int(11) NOT NULL,
  `investigationtime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '259200000',
  `claimdealclearingtime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '172800000',
  `carpagertime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '86400000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_claim_infos_auctionid_foreign` (`auctionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_infos`
--

DROP TABLE IF EXISTS `auction_infos`;
CREATE TABLE IF NOT EXISTS `auction_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `registerprovinceid` int(11) NOT NULL,
  `lien` tinyint(1) NOT NULL DEFAULT 0,
  `unpaiddebt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otherdisclusure` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `startdate` date NOT NULL,
  `starttime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starttoclose` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '86400000',
  `decisiontime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1800000',
  `tasktime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '259200000',
  `auctiondealclearingtime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '172800000',
  `claim` tinyint(1) NOT NULL DEFAULT 0,
  `startprice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minreservedprice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_infos_carid_foreign` (`carid`),
  KEY `auction_infos_registerprovinceid_foreign` (`registerprovinceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_users`
--

DROP TABLE IF EXISTS `auction_users`;
CREATE TABLE IF NOT EXISTS `auction_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auctionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `pay_type` int(11) NOT NULL,
  `auto_bid` tinyint(1) NOT NULL DEFAULT 0,
  `maxbid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auto_bid_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_users_auctionid_foreign` (`auctionid`),
  KEY `auction_users_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discounttype` tinyint(1) NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mileage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bodytypeid` int(11) NOT NULL,
  `drivetrain` int(11) NOT NULL,
  `transmission` int(11) NOT NULL,
  `fueltypeid` int(11) NOT NULL,
  `enginetypeid` int(11) NOT NULL,
  `condition` int(11) NOT NULL,
  `accident` int(11) NOT NULL,
  `door` int(11) NOT NULL,
  `vinnumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `auction` tinyint(1) NOT NULL,
  `userid` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_make_foreign` (`make`),
  KEY `cars_model_foreign` (`model`),
  KEY `cars_bodytypeid_foreign` (`bodytypeid`),
  KEY `cars_drivetrain_foreign` (`drivetrain`),
  KEY `cars_transmission_foreign` (`transmission`),
  KEY `cars_fueltypeid_foreign` (`fueltypeid`),
  KEY `cars_enginetypeid_foreign` (`enginetypeid`),
  KEY `cars_condition_foreign` (`condition`),
  KEY `cars_accident_foreign` (`accident`),
  KEY `cars_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_accidents`
--

DROP TABLE IF EXISTS `car_accidents`;
CREATE TABLE IF NOT EXISTS `car_accidents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_body_types`
--

DROP TABLE IF EXISTS `car_body_types`;
CREATE TABLE IF NOT EXISTS `car_body_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_certifieds`
--

DROP TABLE IF EXISTS `car_certifieds`;
CREATE TABLE IF NOT EXISTS `car_certifieds` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_certifieds_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_conditions`
--

DROP TABLE IF EXISTS `car_conditions`;
CREATE TABLE IF NOT EXISTS `car_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_damages`
--

DROP TABLE IF EXISTS `car_damages`;
CREATE TABLE IF NOT EXISTS `car_damages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_damages_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_disclosures`
--

DROP TABLE IF EXISTS `car_disclosures`;
CREATE TABLE IF NOT EXISTS `car_disclosures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_drive_trains`
--

DROP TABLE IF EXISTS `car_drive_trains`;
CREATE TABLE IF NOT EXISTS `car_drive_trains` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_engine_types`
--

DROP TABLE IF EXISTS `car_engine_types`;
CREATE TABLE IF NOT EXISTS `car_engine_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_fax_proofs`
--

DROP TABLE IF EXISTS `car_fax_proofs`;
CREATE TABLE IF NOT EXISTS `car_fax_proofs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_fax_proofs_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_fuel_types`
--

DROP TABLE IF EXISTS `car_fuel_types`;
CREATE TABLE IF NOT EXISTS `car_fuel_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_inquiries`
--

DROP TABLE IF EXISTS `car_inquiries`;
CREATE TABLE IF NOT EXISTS `car_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_inquiries_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_inspections`
--

DROP TABLE IF EXISTS `car_inspections`;
CREATE TABLE IF NOT EXISTS `car_inspections` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_inspections_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_makes`
--

DROP TABLE IF EXISTS `car_makes`;
CREATE TABLE IF NOT EXISTS `car_makes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_mechanical_issues`
--

DROP TABLE IF EXISTS `car_mechanical_issues`;
CREATE TABLE IF NOT EXISTS `car_mechanical_issues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_models`
--

DROP TABLE IF EXISTS `car_models`;
CREATE TABLE IF NOT EXISTS `car_models` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `make` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_models_make_foreign` (`make`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_modifications`
--

DROP TABLE IF EXISTS `car_modifications`;
CREATE TABLE IF NOT EXISTS `car_modifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_options`
--

DROP TABLE IF EXISTS `car_options`;
CREATE TABLE IF NOT EXISTS `car_options` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_pictures`
--

DROP TABLE IF EXISTS `car_pictures`;
CREATE TABLE IF NOT EXISTS `car_pictures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_pictures_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_services`
--

DROP TABLE IF EXISTS `car_services`;
CREATE TABLE IF NOT EXISTS `car_services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `imageaddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_services_carid_foreign` (`carid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_transmissions`
--

DROP TABLE IF EXISTS `car_transmissions`;
CREATE TABLE IF NOT EXISTS `car_transmissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_warning_lights`
--

DROP TABLE IF EXISTS `car_warning_lights`;
CREATE TABLE IF NOT EXISTS `car_warning_lights` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinceid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_provinceid_foreign` (`provinceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_infos`
--

DROP TABLE IF EXISTS `company_infos`;
CREATE TABLE IF NOT EXISTS `company_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `companyname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autogroupname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `businessnumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealercode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mechanicallevel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpfirstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cplastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpmobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpemail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpposition` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cppicture` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_infos_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `confirm_codes`
--

DROP TABLE IF EXISTS `confirm_codes`;
CREATE TABLE IF NOT EXISTS `confirm_codes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiredate` date NOT NULL,
  `expiretime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmtype` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `confirm_codes_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_05_07_164325_create_company_infos_table', 1),
(6, '2022_05_07_164435_create_upgrated_user_infos_table', 1),
(7, '2022_05_07_190643_create_confirm_codes_table', 1),
(8, '2022_05_08_170532_create_cars_table', 1),
(9, '2022_05_08_172638_create_auction_infos_table', 1),
(10, '2022_05_08_173607_create_car_body_types_table', 1),
(11, '2022_05_08_174113_create_car_fuel_types_table', 1),
(12, '2022_05_08_174155_create_car_engine_types_table', 1),
(13, '2022_05_08_174735_create_countries_table', 1),
(14, '2022_05_08_174826_create_provinces_table', 1),
(15, '2022_05_08_175117_create_cities_table', 1),
(16, '2022_05_09_170202_create_car_drive_trains_table', 1),
(17, '2022_05_09_170412_create_car_transmissions_table', 1),
(18, '2022_05_09_170545_create_car_conditions_table', 1),
(19, '2022_05_09_170742_create_car_accidents_table', 1),
(20, '2022_05_09_170913_create_car_modifications_table', 1),
(21, '2022_05_09_171350_create_car_disclosures_table', 1),
(22, '2022_05_09_171756_create_car_mechanical_issues_table', 1),
(23, '2022_05_09_171847_create_car_warning_lights_table', 1),
(24, '2022_05_09_192314_create_car_options_table', 1),
(25, '2022_05_09_192354_create_relation_car_options_table', 1),
(26, '2022_05_09_192534_create_relation_car_modifications_table', 1),
(27, '2022_05_09_192641_create_relation_car_disclosures_table', 1),
(28, '2022_05_09_192727_create_relation_car_mechanical_issues_table', 1),
(29, '2022_05_09_192816_create_relation_car_warning_lights_table', 1),
(30, '2022_05_16_171158_create_car_makes_table', 1),
(31, '2022_05_16_171324_create_car_models_table', 1),
(32, '2022_05_16_175946_create_car_pictures_table', 1),
(33, '2022_05_16_180556_create_car_certifieds_table', 1),
(34, '2022_05_16_180928_create_car_fax_proofs_table', 1),
(35, '2022_05_16_181129_create_car_inspections_table', 1),
(36, '2022_05_16_181337_create_car_services_table', 1),
(37, '2022_05_16_184117_create_car_damages_table', 1),
(38, '2022_05_18_172408_create_auction_claim_infos_table', 1),
(39, '2022_05_18_174836_create_car_inquiries_table', 1),
(40, '2022_05_20_170957_create_user_vip_infos_table', 1),
(41, '2022_05_21_180011_create_auction_users_table', 1),
(42, '2022_05_21_182836_create_action_costs_table', 1),
(43, '2022_05_22_164920_create_auction_bids_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countryid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinces_countryid_foreign` (`countryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relation_car_disclosures`
--

DROP TABLE IF EXISTS `relation_car_disclosures`;
CREATE TABLE IF NOT EXISTS `relation_car_disclosures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `disclosureid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_car_disclosures_carid_foreign` (`carid`),
  KEY `relation_car_disclosures_disclosureid_foreign` (`disclosureid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relation_car_mechanical_issues`
--

DROP TABLE IF EXISTS `relation_car_mechanical_issues`;
CREATE TABLE IF NOT EXISTS `relation_car_mechanical_issues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `mechanicalissueid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_car_mechanical_issues_carid_foreign` (`carid`),
  KEY `relation_car_mechanical_issues_mechanicalissueid_foreign` (`mechanicalissueid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relation_car_modifications`
--

DROP TABLE IF EXISTS `relation_car_modifications`;
CREATE TABLE IF NOT EXISTS `relation_car_modifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `modificationid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_car_modifications_carid_foreign` (`carid`),
  KEY `relation_car_modifications_modificationid_foreign` (`modificationid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relation_car_options`
--

DROP TABLE IF EXISTS `relation_car_options`;
CREATE TABLE IF NOT EXISTS `relation_car_options` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `optionid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_car_options_carid_foreign` (`carid`),
  KEY `relation_car_options_optionid_foreign` (`optionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relation_car_warning_lights`
--

DROP TABLE IF EXISTS `relation_car_warning_lights`;
CREATE TABLE IF NOT EXISTS `relation_car_warning_lights` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carid` int(11) NOT NULL,
  `warninglightid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_car_warning_lights_carid_foreign` (`carid`),
  KEY `relation_car_warning_lights_warninglightid_foreign` (`warninglightid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upgrated_user_infos`
--

DROP TABLE IF EXISTS `upgrated_user_infos`;
CREATE TABLE IF NOT EXISTS `upgrated_user_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `upgradedate` date NOT NULL,
  `upgradeexpire` date NOT NULL,
  `pad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upgrated_user_infos_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countryid` int(11) NOT NULL,
  `provinceid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profilepicture` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `subcategory` int(11) NOT NULL,
  `class` int(11) NOT NULL DEFAULT 0,
  `birthdate` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `emailconfirmed` tinyint(1) NOT NULL DEFAULT 0,
  `phoneconfirmed` tinyint(1) NOT NULL DEFAULT 0,
  `wallet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_countryid_foreign` (`countryid`),
  KEY `users_provinceid_foreign` (`provinceid`),
  KEY `users_cityid_foreign` (`cityid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_vip_infos`
--

DROP TABLE IF EXISTS `user_vip_infos`;
CREATE TABLE IF NOT EXISTS `user_vip_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `expiredate` date NOT NULL,
  `pad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_vip_infos_userid_foreign` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
