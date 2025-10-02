-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 02, 2025 at 12:43 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `knowauthority`
--

-- --------------------------------------------------------

--
-- Table structure for table `oai_identify`
--

DROP TABLE IF EXISTS `oai_identify`;
CREATE TABLE IF NOT EXISTS `oai_identify` (
  `id` int NOT NULL AUTO_INCREMENT,
  `repository_name` varchar(255) DEFAULT NULL,
  `base_url` text,
  `protocol_version` varchar(50) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `earliest_datestamp` varchar(50) DEFAULT NULL,
  `deleted_record` varchar(50) DEFAULT NULL,
  `granularity` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `oai_identify`
--

INSERT INTO `oai_identify` (`id`, `repository_name`, `base_url`, `protocol_version`, `admin_email`, `earliest_datestamp`, `deleted_record`, `granularity`) VALUES
(1, 'DSpace CEDAP', 'https://cedap.ufrgs.br/oai/request', '2.0', 'cedap@ufrgs.br', '2016-11-27T11:42:29Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(2, 'Repositório Institucional da  UFSC', 'https://repositorio.ufsc.br/oai/request', '2.0', 'repositorio@sistemas.ufsc.br', '2025-09-25T15:48:27Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(3, 'Lume 5.8', 'http://www.lume.ufrgs.br/oai/request/', '2.0', 'manuelakf@cpd.ufrgs.br', '2012-05-15T16:59:37Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(4, 'Centro de Integração de Dados e Conhecimento para Saúde Dataverse OAI Archive', 'https://hml.dataverse.cidacs.org/oai', '2.0', 'noreply.cidacs@fiocruz.br', '2025-05-30T17:42:17Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(5, 'Em Questão', 'https://seer.ufrgs.br/index.php/EmQuestao/oai', '2.0', 'emquestao@ufrgs.br', '2017-05-08T15:11:59Z', 'persistent', 'YYYY-MM-DDThh:mm:ssZ');

-- --------------------------------------------------------

--
-- Table structure for table `oai_records`
--

DROP TABLE IF EXISTS `oai_records`;
CREATE TABLE IF NOT EXISTS `oai_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `repository` int NOT NULL DEFAULT '0',
  `oai_identifier` varchar(255) DEFAULT NULL,
  `datestamp` varchar(50) DEFAULT NULL,
  `setSpec` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oai_identifier` (`oai_identifier`(50),`repository`)
) ENGINE=MyISAM AUTO_INCREMENT=467521 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `oai_sets`
--

DROP TABLE IF EXISTS `oai_sets`;
CREATE TABLE IF NOT EXISTS `oai_sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identify_id` int DEFAULT NULL,
  `set_spec` varchar(255) DEFAULT NULL,
  `set_name` text,
  `set_description` text,
  PRIMARY KEY (`id`),
  KEY `identify_id` (`identify_id`)
) ENGINE=MyISAM AUTO_INCREMENT=237 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `oai_triples`
--

DROP TABLE IF EXISTS `oai_triples`;
CREATE TABLE IF NOT EXISTS `oai_triples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `record_id` int DEFAULT NULL,
  `property` varchar(100) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `summarize`
--

DROP TABLE IF EXISTS `summarize`;
CREATE TABLE IF NOT EXISTS `summarize` (
  `id_d` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `d_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `d_indicator` char(10) NOT NULL,
  `d_valor` int NOT NULL,
  UNIQUE KEY `id_d` (`id_d`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
