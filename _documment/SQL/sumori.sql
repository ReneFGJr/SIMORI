-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2025 at 08:33 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simori`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_repository_access`
--

DROP TABLE IF EXISTS `log_repository_access`;
CREATE TABLE IF NOT EXISTS `log_repository_access` (
  `id_ra` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ra_repository` int DEFAULT NULL,
  `ra_status` int DEFAULT NULL,
  `ra_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_ra` (`id_ra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oai_identify`
--

DROP TABLE IF EXISTS `oai_identify`;
CREATE TABLE IF NOT EXISTS `oai_identify` (
  `id_rp` int NOT NULL AUTO_INCREMENT,
  `repository_id` int DEFAULT NULL,
  `repository_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `base_url` text COLLATE utf8mb4_general_ci,
  `protocol_version` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `earliest_datestamp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_record` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `granularity` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_rp`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oai_identify`
--

INSERT INTO `oai_identify` (`id_rp`, `repository_id`, `repository_name`, `base_url`, `protocol_version`, `admin_email`, `earliest_datestamp`, `deleted_record`, `granularity`) VALUES
(1, 2, 'Aleia Dataverse OAI Archive', 'https://aleia.ibict.br/oai', '2.0', 'aleia@apps.ibict.br', '2024-03-13T14:55:55Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(2, 4, 'Repositório Institucional da ENAP', 'http://repositorio.enap.gov.br/oai/request', '2.0', 'danismar2008@gmail.com', '2013-11-12T18:04:57Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(3, 93, 'TECdatos Repository Dataverse OAI Archive', 'https://dataverse.tec.ac.cr/oai', '2.0', 'datostec@itcr.ac.cr', '2025-04-07T15:24:30Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(4, 90, 'Repositório Arca Fiocruz', 'https://api.arca.fiocruz.br/oai/request', '2.0', 'repositorio.arca@fiocruz.br', '2010-08-23T16:00:11Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(5, 90, 'Repositório Arca Fiocruz', 'https://api.arca.fiocruz.br/oai/request', '2.0', 'repositorio.arca@fiocruz.br', '2010-08-23T16:00:11Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ');

-- --------------------------------------------------------

--
-- Table structure for table `oai_records`
--

DROP TABLE IF EXISTS `oai_records`;
CREATE TABLE IF NOT EXISTS `oai_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `repository` int NOT NULL DEFAULT '0',
  `oai_identifier` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `datestamp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `setSpec` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `deleted` tinyint(1) DEFAULT '0',
  `harvesting` int NOT NULL DEFAULT '0',
  `xml` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oai_identifier` (`oai_identifier`(50),`repository`),
  KEY `repository` (`repository`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oai_sets`
--

DROP TABLE IF EXISTS `oai_sets`;
CREATE TABLE IF NOT EXISTS `oai_sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identify_id` int DEFAULT NULL,
  `set_spec` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `set_name` text COLLATE utf8mb4_general_ci,
  `set_description` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `identify_id` (`identify_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oai_triples`
--

DROP TABLE IF EXISTS `oai_triples`;
CREATE TABLE IF NOT EXISTS `oai_triples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `record_id` int DEFAULT NULL,
  `property` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `repository_id` int NOT NULL DEFAULT '0',
  `setspec` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repository`
--

DROP TABLE IF EXISTS `repository`;
CREATE TABLE IF NOT EXISTS `repository` (
  `id_rp` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rp_name` char(200) COLLATE utf8mb4_general_ci NOT NULL,
  `rp_instituicao` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rp_url` char(100) COLLATE utf8mb4_general_ci NOT NULL,
  `rp_url_oai` char(200) COLLATE utf8mb4_general_ci NOT NULL,
  `rp_repository_id` int DEFAULT NULL,
  `rp_plataforma` char(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rp_versao` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rp_description` text COLLATE utf8mb4_general_ci,
  `rp_rbrd` int NOT NULL DEFAULT '0',
  `rp_cidade` int DEFAULT NULL,
  `rp_status` int NOT NULL DEFAULT '0',
  `rp_update` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_rp` (`id_rp`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repository`
--

INSERT INTO `repository` (`id_rp`, `rp_name`, `rp_instituicao`, `rp_url`, `rp_url_oai`, `rp_repository_id`, `rp_plataforma`, `rp_versao`, `rp_description`, `rp_rbrd`, `rp_cidade`, `rp_status`, `rp_update`, `created_at`) VALUES
(1, 'Repositório\'s de publicações', '', 'http://rbrd.ibict.br/repositorios-de-publicacao/', '', NULL, '', '', NULL, 0, NULL, 404, '2025-10-06', '2025-10-03 12:18:02'),
(2, 'ALEIA - Repositórios de dados', '', 'https://aleia.ibict.br/', 'https://aleia.ibict.br/oai', NULL, 'Dataverse', '6.4', NULL, 0, NULL, 1, '2025-10-08', '2025-10-03 12:18:02'),
(3, 'Repositório Institucional da CFB', 'CFB', 'http://repositorio.cfb.org.br/', 'http://repositorio.cfb.org.br/oai/request', NULL, 'DSpace', '6.0', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(4, 'Repositório Institucional da ENAP', 'ENAP', 'http://repositorio.enap.gov.br/', 'http://repositorio.enap.gov.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-08', '2025-10-03 12:18:02'),
(5, 'Repositório Institucional da IPEA (RCIpea)', 'IPEA', 'https://repositorio.ipea.gov.br/', '', NULL, 'DSpace7+', '', NULL, 0, NULL, 1, '0000-00-00', '2025-10-03 12:18:02'),
(6, 'Repositório Institucional da UCB', 'UCB', 'http://repositorio.ucb.br:9443/', '', NULL, 'DSpace', '', NULL, 0, NULL, 404, '0000-00-00', '2025-10-03 12:18:02'),
(7, 'Repositório Institucional da UFG', 'UFG', 'https://repositorio.bc.ufg.br/riserver', '', NULL, 'DSpace7+', '', NULL, 0, NULL, 1, '0000-00-00', '2025-10-03 12:18:02'),
(8, 'Repositório Institucional da UFMS', 'UFMS', 'https://repositorio.ufms.br/', 'https://repositorio.ufms.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(9, 'Repositório Institucional do IBICT', 'IBICT', 'https://repositorio.ibict.br/', '', NULL, '', '', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(10, 'Repositório Institucional do UniCEUB', 'UniCEUB', 'https://repositorio.uniceub.br/', 'https://repositorio.uniceub.br/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(11, 'Biblioteca Digital de Teses e Dissertações da UFG', 'UFG', 'http://repositorio.bc.ufg.br/', 'http://repositorio.bc.ufg.br/server/oai/request', NULL, 'DSpace', '7.6.5', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(12, 'Biblioteca Digital de Teses e Dissertações da UFGD', 'UFGD', 'https://repositorio.ufgd.edu.br/', '', NULL, 'DSpace', '', NULL, 0, NULL, 1, '0000-00-00', '2025-10-03 12:18:02'),
(13, 'Repositório Institucional do IDP', 'IDP', 'https://repositorio.idp.edu.br/', 'https://repositorio.idp.edu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(14, 'Rede Brasileira de Serviços de Preservação Digital Cariniana – Ibict Dataverse', 'IBICT', 'https://repositoriopesquisas.ibict.br/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(15, 'Repositório da Produção Científica e Intelectual do SENAI CIMATEC', 'FIEB', 'http://repositoriosenaiba.fieb.org.br/', 'http://repositoriosenaiba.fieb.org.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(16, 'Repositório Institucional da Escola Bahiana de Medicina e Saúde Pública', '', 'https://repositorio.bahiana.edu.br:8443/jspui/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(17, 'Repositório Institucional da IFBA', 'IFBA', 'http://www.repositorio.ifba.edu.br/jspui/', 'http://www.repositorio.ifba.edu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(18, 'Repositório Institucional da UFBA', 'UFBA', 'https://repositorio.ufba.br/', 'https://repositorio.ufba.br/oai/request', NULL, 'DSpace', '6.4', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(19, 'Repositório Institucional da UFMA', 'UFMA', 'https://repositorio.ufma.br', '', NULL, 'DSpace', '', NULL, 0, NULL, 1, '2025-10-06', '2025-10-03 12:18:02'),
(20, 'Repositório Institucional da UFPB', 'UFPB', 'https://repositorio.ufpb.br', 'https://repositorio.ufpb.br/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(21, 'Repositório Institucional da UFPE', 'UFPE', 'https://repositorio.ufpe.br/', 'https://repositorio.ufpe.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(22, 'Repositório Institucional da UFRB', 'UFRB', 'https://repositorio.ufrb.edu.br/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(23, 'Repositório Institucional da UFRN', 'UFRN', 'https://repositorio.ufrn.br/', 'https://repositorio.ufrn.br/server/oai/request', NULL, 'DSpace', '7.6.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(24, 'Repositório Institucional da UNILAB', 'UNILAB', 'https://repositorio.unilab.edu.br/jspui/', 'https://repositorio.unilab.edu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(25, 'Repositório Institucional da Universidade Federal de Alagoas (UFAL)', 'UFAL', 'https://www.repositorio.ufal.br/', 'https://www.repositorio.ufal.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(26, 'Repositório Institucional da Universidade Federal do Ceará (UFC)', 'UFC', 'https://repositorio.ufc.br/', 'https://repositorio.ufc.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(27, 'Repositório Institucional do IFPB', 'IFPB', 'https://repositorio.ifpb.edu.br/', 'https://repositorio.ifpb.edu.br/oai/request', NULL, 'DSpace', '5.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(28, 'Repositório Institucional do IFPE', 'IFPE', 'https://repositorio.ifpe.edu.br/xmlui/', '', NULL, '', '', NULL, 0, NULL, 1, '0000-00-00', '2025-10-03 12:18:02'),
(29, 'Biblioteca Digital de Teses e Dissertações da UFERSA', 'UFERSA', 'https://repositorio.ufersa.edu.br/', 'https://repositorio.ufersa.edu.br/server/oai/request', NULL, 'DSpace', '7.5', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(30, 'Biblioteca Digital de Teses e Dissertações da UFPB', 'UFPB', 'https://repositorio.ufpb.br/', 'https://repositorio.ufpb.br/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(31, 'Repositório do Instituto Federal do Amapá', '', 'http://repositorio.ifap.edu.br/jspui/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(32, 'Repositório Institucional da FACIMED', 'FACIMED', 'http://repositorio.facimed.edu.br/xmlui/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(33, 'Repositório Institucional da UFPA', 'UFPA', 'https://www.repositorio.ufpa.br/', 'https://www.repositorio.ufpa.br/server/oai/request', NULL, 'DSpace', '7.6.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(34, 'Repositório Institucional da UFRA', 'UFRA', 'http://repositorio.ufra.edu.br/jspui/', 'http://repositorio.ufra.edu.br/oai/request', NULL, 'DSpace', '6.0', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(35, 'Repositório Institucional da UFRR', 'UFRR', 'https://antigo.ufrr.br/bibliotecas/destaques/221-repositorios-institucionais', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(36, 'Repositório Institucional da UFT', 'UFT', 'https://repositorio.uft.edu.br/?locale=pt_BR', 'https://repositorio.uft.edu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(37, 'Repositório Institucional da Universidade do Estado do Amazonas (UEA)', '', 'http://repositorioinstitucional.uea.edu.br/', '', NULL, '', '', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(38, 'Repositório Institucional da Universidade Federal do Amapá (UNIFAP)', '', 'http://repositorio.unifap.br/', 'http://repositorio.unifap.br/server/oai/request', NULL, 'DSpace', '9.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(39, 'Repositório Institucional da Universidade Federal do Oeste do Pará (UFOPA)', 'UFOPA', 'https://repositorio.ufopa.edu.br/', '', NULL, 'DSpace 7+', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(40, 'Repositório Institucional do IFAM (Repositório Institucional do Instituto Federal do Amazonas)', 'IFAM ', 'http://repositorio.ifam.edu.br/jspui/?contributor_page=1', 'http://repositorio.ifam.edu.br/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(41, 'Repositório Institucional do INPA', 'INPA', 'https://repositorio.inpa.gov.br/', 'https://repositorio.inpa.gov.br/server/oai/request', NULL, 'DSpace', '9.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(42, 'Repositório Institucional do Instituto Federal de Educação, Ciência e Tecnologia de Rondônia', '', 'https://repositorio.ifro.edu.br/home', 'https://repositorio.ifro.edu.br/server/oai/request', NULL, 'DSpace', '7.6.5', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(43, 'Repositório Institucional do MPEG', 'MPEG', 'https://repositorio.museu-goeldi.br/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(44, 'Biblioteca Digital de Teses e Dissertações do INPA', 'INPA', 'https://repositorio.inpa.gov.br/handle/1/6', 'https://repositorio.inpa.gov.br/handle/1/6/server/oai/request', NULL, 'DSpace', '9.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(45, 'Repositório da Faculdade de Direito de Vitória', 'FDV', 'http://repositorio.fdv.br:8080/', 'http://repositorio.fdv.br:8080/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(46, 'Repositório Institucional da Fundação João Pinheiro', '', 'https://fjp.mg.gov.br/biblioteca/repositorio/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(47, 'Repositório Institucional do IEN', 'IEN', 'https://repositorio.mcti.gov.br/', 'https://repositorio.mcti.gov.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(48, 'Repositório Institucional do IPEN', 'IPEN', 'http://repositorio.ipen.br/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(49, 'Repositório do Instituto de Tecnologia de Alimentos', '', 'http://repositorio.ital.sp.gov.br/jspui/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(50, 'Repositório Institucional do INMETRO', 'INMETRO', 'http://repositorios.inmetro.gov.br/', 'http://repositorios.inmetro.gov.br/oai/request', NULL, 'DSpace', '', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(51, 'Repositório Institucional do INT (Repositório Institucional – Instituto Nacional de Tecnologia Ri – INT)', 'INT ', 'https://sistema.bibliotecas-bdigital.fgv.br/bases/int-instituto-nacional-de-tecnologia-repositorio-i', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(52, 'Scientia – Repositório Institucional', '', 'https://repositorio.pgsskroton.com/cogna/pages/home/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(53, 'Repositório Institucional da Diretoria do Patrimônio Histórico e Documentação da Marinha', '', 'https://www.repositorio.mar.mil.br/', 'https://www.repositorio.mar.mil.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(54, 'Repositório Institucional PUC-Campinas', 'PUC-Campinas', 'https://repositorio.sis.puc-campinas.edu.br/', '', NULL, '', '', NULL, 0, NULL, 1, '0000-00-00', '2025-10-03 12:18:02'),
(55, 'Repositório Institucional da UNITAU', 'UNITAU', 'http://repositorio.unitau.br:8080/jspui/?locale=pt_BR', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(56, 'Repositório da Produção Científica e Intelectual da Unicamp', '', 'https://repositorio.unicamp.br/', 'https://repositorio.unicamp.br/oai/request', NULL, 'DSpace', '', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(57, 'Repositório Institucional da UNESP', 'UNESP', 'https://www.franca.unesp.br/#!/sobre2108/biblioteca/repositorio-institucional/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(58, 'Repositório Institucional da UNIFEI (RIUNIFEI)', 'RIUNIFEI', 'https://repositorio.unifei.edu.br/jspui/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(59, 'Repositório Institucional da UFJF', 'UFJF', 'https://repositorio.ufjf.br/jspui/', 'https://repositorio.ufjf.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(60, 'Repositório Institucional da UFLA', 'UFLA', 'https://repositorio.ufla.br/', 'https://repositorio.ufla.br/server/oai/request', NULL, 'DSpace', '8.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(61, 'Repositório Institucional da UFMG', 'UFMG', 'https://repositorio.ufmg.br/', 'https://repositorio.ufmg.br/server/oai/request', NULL, 'DSpace', '8.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(62, 'Repositório Institucional da UFOP', 'UFOP', 'https://www.repositorio.ufop.br/', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(63, 'Repositório Institucional da UFSCAR', 'UFSCAR', 'https://repositorio.ufscar.br/', 'https://repositorio.ufscar.br/server/oai/request', NULL, 'DSpace', '9.0', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(64, 'Repositório Institucional da UNIFESP', 'UNIFESP', 'https://repositorio.unifesp.br/home', 'https://repositorio.unifesp.br/server/oai/request', NULL, '', '', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(65, 'Repositório Institucional da UFU', 'UFU', 'https://repositorio.ufu.br/?locale=pt_BR', 'https://repositorio.ufu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(66, 'Repositório Institucional da Universidade Federal do Espírito Santo (riUfes)', 'UFES', 'https://repositorio.ufes.br/', 'https://repositorio.ufes.br/server/oai/request', NULL, 'DSpace', '7.4', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(67, 'Repositório Hórus', 'UNIRIO', 'http://www.repositorio-bc.unirio.br:8080/xmlui/', 'http://www.repositorio-bc.unirio.br:8080/oai/request', NULL, 'DSpace', '5.6', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(68, 'Repositório Institucional da Universidade Federal Fluminense (RIUFF)', 'UFF', 'https://www.uff.br/?q=tags/repositorio-institucional', '', NULL, '', '', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(69, 'Repositório Institucional da Metodista', '', 'https://metodista.br/stricto-sensu/ciencias-da-religiao/publicacoes/repositorio-digital-de-publicaco', '', NULL, '', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(70, 'Biblioteca Digital de Teses e Dissertações da PUC_CAMPINAS', 'PUC-CAMPINAS', 'https://repositorio.sis.puc-campinas.edu.br/handle/123456789/1955', 'https://repositorio.sis.puc-campinas.edu.br/oai/request', NULL, 'DSpace', '6.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(71, 'Biblioteca Digital de Teses e Dissertações da USC', 'USC', 'https://repositorio.unisagrado.edu.br/jspui/', 'https://repositorio.unisagrado.edu.br/oai/request', NULL, 'DSpace', '6.0', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(72, 'Biblioteca Digital de Teses e Dissertações do CDTN', '', 'http://www.repositorio.cdtn.br:8080/jspui/?locale=pt_BR', 'http://www.repositorio.cdtn.br:8080/oai/request', NULL, 'DSpace', '5.5', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(73, 'Repositório COVID-19 Data Sharing/BR (Fapesp)', 'Fapesp', 'https://repositoriodatasharingfapesp.uspdigital.usp.br/', 'https://repositoriodatasharingfapesp.uspdigital.usp.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(74, 'Repositório de Dados de Pesquisa UNIFESP', 'UNIFESP', 'https://repositoriodedados.unifesp.br/', 'https://domusdados.unifesp.br/oai', NULL, 'Dataverse', '5.13', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 12:18:02'),
(76, 'Repositório Institucional da FURG (RI FURG)', 'FURG', 'https://www.repositorio.furg.br/', 'https://www.repositorio.furg.br/oai/request', NULL, 'DSpace', '6.4', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(77, 'Repositório Institucional da UCS', 'UCS', 'https://repositorio.ucs.br/', 'https://repositorio.ucs.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(78, 'Repositório Institucional da UEPG', 'UEPG', 'https://ead.uepg.br/site/repositorios/repositorio-nutead-2', '', NULL, '', '', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(79, 'Repositório Institucional da UFPR', 'UFPR', 'https://acervodigital.ufpr.br/', 'https://acervodigital.ufpr.br/oai/request', NULL, 'DSpace', '6.5', NULL, 0, NULL, 1, '2025-10-08', '2025-10-03 12:18:02'),
(80, 'Repositório Institucional da UFSC', 'UFSC', 'https://repositorio.ufsc.br/', 'https://repositorio.ufsc.br/oai/request', NULL, 'DSpace', '6.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(81, 'Repositório Institucional da UNESC', 'UNESC', 'http://repositorio.unesc.net/', 'http://repositorio.unesc.net/oai/request', NULL, 'DSpace', '6.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(82, 'Repositório Institucional da UNISINOS (RBDU Repositório Digital da Biblioteca da Unisinos)', 'UNISINOS', 'https://repositorio.jesuita.org.br/', 'https://repositorio.jesuita.org.br/oai/request', NULL, 'DSpace', '4.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(83, 'Repositório Institucional da Universidade Estadual de Maringá (RI-UEM)', 'UEM', 'http://repositorio.uem.br:8080/jspui/', 'http://repositorio.uem.br:8080/oai/request', NULL, 'DSpace', '5.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(84, 'Repositório Institucional da UPF', 'UPF', 'http://repositorio.upf.br/', 'http://repositorio.upf.br/oai/request', NULL, 'DSpace', '5.7', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(85, 'Repositório Institucional da UTFPR da Universidade Tecnológica Federal do Paraná (RIUT)', 'UTFPR', 'https://repositorio.utfpr.edu.br/jspui/', 'https://repositorio.utfpr.edu.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 500, '2025-10-07', '2025-10-03 12:18:02'),
(86, 'Repositório Institucional PUCRS', 'PUCRS', 'https://repositorio.pucrs.br/dspace/', 'https://repositorio.pucrs.br/oai/request', NULL, 'DSpace', '5.1', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(87, 'Repositório Institucional Uninter', 'Uninter', 'https://repositorio.uninter.com/', 'https://repositorio.uninter.com/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(88, 'Biblioteca Digital de Teses e Dissertações do UFSM', 'UFSM', 'https://repositorio.ufsm.br/handle/1/25', 'https://repositorio.ufsm.br/oai/request', NULL, 'DSpace', '6.3', NULL, 0, NULL, 1, '2025-10-07', '2025-10-03 12:18:02'),
(89, 'Lume', 'UFRGS', 'https://lume.ufrgs.br', 'https://lume.ufrgs.br/oai/request', NULL, 'DSpace', '', NULL, 0, NULL, 0, '0000-00-00', '2025-10-03 17:43:12'),
(90, 'Arca FioCruz', 'FIOCRUZ', 'https://arca.fiocruz.br/', 'https://api.arca.fiocruz.br/oai/request', NULL, 'DSpace', '8.1', NULL, 0, NULL, 1, '2025-10-09', '2025-10-07 17:54:23'),
(91, 'ArcaDados - FIOCRUZ', '', 'http://arcadados.fiocruz.br/', 'http://arcadados.fiocruz.br/oai', NULL, 'Dataverse', '6.2', NULL, 0, NULL, 1, '2025-10-07', '2025-10-07 18:04:41'),
(92, 'Deposita Dados Ibict', '', 'http://depositadados.ibict.br/', 'http://depositadados.ibict.br/oai', NULL, 'Dataverse', '6.4', NULL, 0, NULL, 1, '2025-10-07', '2025-10-07 18:10:45'),
(93, 'TECdados', '', 'https://dataverse.tec.ac.cr/', 'https://dataverse.tec.ac.cr/oai', NULL, 'Dataverse', '6.2', NULL, 0, NULL, 1, '2025-10-08', '2025-10-08 17:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `summarize`
--

DROP TABLE IF EXISTS `summarize`;
CREATE TABLE IF NOT EXISTS `summarize` (
  `id_d` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `d_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `d_indicator` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `d_valor` int NOT NULL,
  `d_repository` int DEFAULT NULL,
  UNIQUE KEY `id_d` (`id_d`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
