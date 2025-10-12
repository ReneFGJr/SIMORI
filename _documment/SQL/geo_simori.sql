-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2025 at 12:22 AM
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
-- Database: `simori`
--

-- --------------------------------------------------------

--
-- Table structure for table `geo_city`
--

DROP TABLE IF EXISTS `geo_city`;
CREATE TABLE IF NOT EXISTS `geo_city` (
  `id_city` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(150) COLLATE utf8mb3_bin NOT NULL,
  `id_state` int DEFAULT NULL,
  `id_country` int NOT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`id_city`),
  KEY `id_state` (`id_state`),
  KEY `id_country` (`id_country`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `geo_city`
--

INSERT INTO `geo_city` (`id_city`, `city_name`, `id_state`, `id_country`, `latitude`, `longitude`) VALUES
(1, 'Rio Branco', 1, 1, -9.974990, -67.824300),
(2, 'Maceió', 2, 1, -9.665990, -35.735000),
(3, 'Macapá', 3, 1, 0.034934, -51.069400),
(4, 'Manaus', 4, 1, -3.119028, -60.021731),
(5, 'Salvador', 5, 1, -12.971400, -38.501400),
(6, 'Fortaleza', 6, 1, -3.717220, -38.543300),
(7, 'Brasília', 7, 1, -15.780100, -47.929200),
(8, 'Vitória', 8, 1, -20.315500, -40.312800),
(9, 'Goiânia', 9, 1, -16.686900, -49.264800),
(10, 'São Luís', 10, 1, -2.529720, -44.302800),
(11, 'Cuiabá', 11, 1, -15.601000, -56.097400),
(12, 'Campo Grande', 12, 1, -20.442800, -54.646400),
(13, 'Belo Horizonte', 13, 1, -19.916700, -43.934500),
(14, 'Belém', 14, 1, -1.455020, -48.502400),
(15, 'João Pessoa', 15, 1, -7.115090, -34.864100),
(16, 'Curitiba', 16, 1, -25.428400, -49.273300),
(17, 'Recife', 17, 1, -8.047560, -34.877000),
(18, 'Teresina', 18, 1, -5.091940, -42.803400),
(19, 'Rio de Janeiro', 19, 1, -22.906800, -43.172900),
(20, 'Natal', 20, 1, -5.794480, -35.211000),
(21, 'Porto Alegre', 21, 1, -30.034647, -51.217658),
(22, 'Porto Velho', 22, 1, -8.761940, -63.903900),
(23, 'Boa Vista', 23, 1, 2.819970, -60.673300),
(24, 'Florianópolis', 24, 1, -27.595400, -48.548000),
(25, 'São Paulo', 25, 1, -23.550520, -46.633308),
(26, 'Aracaju', 26, 1, -10.947200, -37.073100),
(27, 'Palmas', 27, 1, -10.184000, -48.333700),
(28, 'Los Angeles', 3, 2, 34.052235, -118.243683),
(29, 'Nova York', 4, 2, 40.712776, -74.005974),
(30, 'Lisboa', NULL, 4, 38.716898, -9.139606),
(31, 'Buenos Aires', NULL, 3, -34.603722, -58.381592);

-- --------------------------------------------------------

--
-- Table structure for table `geo_country`
--

DROP TABLE IF EXISTS `geo_country`;
CREATE TABLE IF NOT EXISTS `geo_country` (
  `id_country` int NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) COLLATE utf8mb3_bin NOT NULL,
  `iso_code` char(2) COLLATE utf8mb3_bin DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`id_country`),
  UNIQUE KEY `iso_code` (`iso_code`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `geo_country`
--

INSERT INTO `geo_country` (`id_country`, `country_name`, `iso_code`, `latitude`, `longitude`) VALUES
(1, 'Brasil', 'BR', -14.235004, -51.925282),
(2, 'Estados Unidos', 'US', 37.090240, -95.712891),
(3, 'Argentina', 'AR', -38.416097, -63.616672),
(4, 'Portugal', 'PT', 39.399872, -8.224454);

-- --------------------------------------------------------

--
-- Table structure for table `geo_state`
--

DROP TABLE IF EXISTS `geo_state`;
CREATE TABLE IF NOT EXISTS `geo_state` (
  `id_state` int NOT NULL AUTO_INCREMENT,
  `state_name` varchar(100) COLLATE utf8mb3_bin NOT NULL,
  `abbreviation` varchar(10) COLLATE utf8mb3_bin DEFAULT NULL,
  `id_country` int NOT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`id_state`),
  KEY `id_country` (`id_country`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `geo_state`
--

INSERT INTO `geo_state` (`id_state`, `state_name`, `abbreviation`, `id_country`, `latitude`, `longitude`) VALUES
(1, 'Rio Grande do Sul', 'RS', 1, -30.034647, -51.217658),
(2, 'São Paulo', 'SP', 1, -23.550520, -46.633308),
(3, 'California', 'CA', 2, 36.778259, -119.417931),
(4, 'New York', 'NY', 2, 43.000000, -75.000000);

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `oai_identify`
--

INSERT INTO `oai_identify` (`id`, `repository_name`, `base_url`, `protocol_version`, `admin_email`, `earliest_datestamp`, `deleted_record`, `granularity`) VALUES
(1, 'DSpace CEDAP', 'https://cedap.ufrgs.br/oai/request', '2.0', 'cedap@ufrgs.br', '2016-11-27T11:42:29Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(2, 'Repositório Institucional da  UFSC', 'https://repositorio.ufsc.br/oai/request', '2.0', 'repositorio@sistemas.ufsc.br', '2025-09-25T15:48:27Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(3, 'Lume 5.8', 'http://www.lume.ufrgs.br/oai/request/', '2.0', 'manuelakf@cpd.ufrgs.br', '2012-05-15T16:59:37Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(4, 'Centro de Integração de Dados e Conhecimento para Saúde Dataverse OAI Archive', 'https://hml.dataverse.cidacs.org/oai', '2.0', 'noreply.cidacs@fiocruz.br', '2025-05-30T17:42:17Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(5, 'Em Questão', 'https://seer.ufrgs.br/index.php/EmQuestao/oai', '2.0', 'emquestao@ufrgs.br', '2017-05-08T15:11:59Z', 'persistent', 'YYYY-MM-DDThh:mm:ssZ'),
(6, 'Repositório Digital Institucional da Universidade Federal do Paraná', 'https://acervodigital.ufpr.br/oai/request', '2.0', 'informacaodigital@ufpr.br', '2004-06-21T13:12:37Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(7, NULL, 'https://repositorio.bc.ufg.br/home/oai/request', NULL, NULL, NULL, NULL, NULL),
(8, 'Universidade Federal da Bahia', 'https://repositorio.ufba.br/oai/request', '2.0', 'suporteri@ufba.br', '0001-01-01T03:00:00Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ'),
(9, 'Repositório Institucional da Universidade Federal de Mato Grosso do Sul', 'https://repositorio.ufms.br/oai/request', '2.0', 'ri.prograd@ufms.br', '2006-01-01T03:00:00Z', 'transient', 'YYYY-MM-DDThh:mm:ssZ');

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
  `harvesting` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oai_identifier` (`oai_identifier`(50),`repository`),
  KEY `repository` (`repository`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `repository`
--

DROP TABLE IF EXISTS `repository`;
CREATE TABLE IF NOT EXISTS `repository` (
  `id_rp` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rp_name` char(200) NOT NULL,
  `rp_instituicao` varchar(100) NOT NULL,
  `rp_url` char(100) NOT NULL,
  `rp_plataforma` char(30) NOT NULL,
  `rp_versao` char(10) NOT NULL,
  `rp_status` int NOT NULL DEFAULT '0',
  `rp_update` date NOT NULL,
  `rp_cidade` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_rp` (`id_rp`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repository`
--

INSERT INTO `repository` (`id_rp`, `rp_name`, `rp_instituicao`, `rp_url`, `rp_plataforma`, `rp_versao`, `rp_status`, `rp_update`, `rp_cidade`, `created_at`) VALUES
(1, 'Repositório\'s de publicações', '', 'http://rbrd.ibict.br/repositorios-de-publicacao/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(2, 'Repositórios de dados', '', 'http://rbrd.ibict.br/repositorio-de-dados/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(3, 'Repositório Institucional da CFB', 'CFB', 'http://repositorio.cfb.org.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(4, 'Repositório Institucional da ENAP', 'ENAP', 'http://repositorio.enap.gov.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(5, 'Repositório Institucional da IPEA (RCIpea)', 'IPEA', 'https://repositorio.ipea.gov.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(6, 'Repositório Institucional da UCB', 'UCB', 'https://repositorio.ucb.br:9443/jspui/', '', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(7, 'Repositório Institucional da UFG', 'UFG', 'https://repositorio.bc.ufg.br/home', 'DSpace', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(8, 'Repositório Institucional da UFMS', 'UFMS', 'https://repositorio.ufms.br/', 'DSpace', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(9, 'Repositório Institucional do IBICT', 'IBICT', 'https://repositorio.ibict.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(10, 'Repositório Institucional do UniCEUB', 'UniCEUB', 'https://repositorio.uniceub.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(11, 'Biblioteca Digital de Teses e Dissertações da UFG', 'UFG', 'http://repositorio.bc.ufg.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(12, 'Biblioteca Digital de Teses e Dissertações da UFGD', 'UFGD', 'https://portal.ufgd.edu.br/setor/biblioteca/repositorio', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(13, 'Repositório Institucional do IDP', 'IDP', 'https://repositorio.idp.edu.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(14, 'Rede Brasileira de Serviços de Preservação Digital Cariniana – Ibict Dataverse', 'IBICT', 'https://repositoriopesquisas.ibict.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(15, 'Repositório da Produção Científica e Intelectual do SENAI CIMATEC', 'FIEB', 'http://repositoriosenaiba.fieb.org.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(16, 'Repositório Institucional da Escola Bahiana de Medicina e Saúde Pública', '', 'https://repositorio.bahiana.edu.br:8443/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(17, 'Repositório Institucional da IFBA', 'IFBA', 'http://www.repositorio.ifba.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(18, 'Repositório Institucional da UFBA', 'UFBA', 'https://repositorio.ufba.br/', 'DSpace', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(19, 'Repositório Institucional da UFMA', 'UFMA', 'https://repositorio.ufma.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(20, 'Repositório Institucional da UFPB', 'UFPB', 'https://repositorio.ufpb.br/?locale=pt_BR', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(21, 'Repositório Institucional da UFPE', 'UFPE', 'https://repositorio.ufpe.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(22, 'Repositório Institucional da UFRB', 'UFRB', 'https://repositorio.ufrb.edu.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(23, 'Repositório Institucional da UFRN', 'UFRN', 'https://repositorio.ufrn.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(24, 'Repositório Institucional da UNILAB', 'UNILAB', 'https://repositorio.unilab.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(25, 'Repositório Institucional da Universidade Federal de Alagoas (UFAL)', 'UFAL', 'https://www.repositorio.ufal.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(26, 'Repositório Institucional da Universidade Federal do Ceará (UFC)', 'UFC', 'https://repositorio.ufc.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(27, 'Repositório Institucional do IFPB', 'IFPB', 'https://repositorio.ifpb.edu.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(28, 'Repositório Institucional do IFPE', 'IFPE', 'https://repositorio.ifpe.edu.br/xmlui/', '', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(29, 'Biblioteca Digital de Teses e Dissertações da UFERSA', 'UFERSA', 'https://repositorio.ufersa.edu.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(30, 'Biblioteca Digital de Teses e Dissertações da UFPB', 'UFPB', 'https://repositorio.ufpb.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(31, 'Repositório do Instituto Federal do Amapá', '', 'http://repositorio.ifap.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(32, 'Repositório Institucional da FACIMED', 'FACIMED', 'http://repositorio.facimed.edu.br/xmlui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(33, 'Repositório Institucional da UFPA', 'UFPA', 'https://www.repositorio.ufpa.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(34, 'Repositório Institucional da UFRA', 'UFRA', 'http://repositorio.ufra.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(35, 'Repositório Institucional da UFRR', 'UFRR', 'https://antigo.ufrr.br/bibliotecas/destaques/221-repositorios-institucionais', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(36, 'Repositório Institucional da UFT', 'UFT', 'https://repositorio.uft.edu.br/?locale=pt_BR', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(37, 'Repositório Institucional da Universidade do Estado do Amazonas (UEA)', '', 'http://repositorioinstitucional.uea.edu.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(38, 'Repositório Institucional da Universidade Federal do Amapá (UNIFAP)', '', 'http://repositorio.unifap.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(39, 'Repositório Institucional da Universidade Federal do Oeste do Pará (UFOPA)', '', 'https://repositorio.ufopa.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(40, 'Repositório Institucional do IFAM (Repositório Institucional do Instituto Federal do Amazonas)', 'IFAM ', 'http://repositorio.ifam.edu.br/jspui/?contributor_page=1', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(41, 'Repositório Institucional do INPA', 'INPA', 'https://repositorio.inpa.gov.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(42, 'Repositório Institucional do Instituto Federal de Educação, Ciência e Tecnologia de Rondônia', '', 'https://repositorio.ifro.edu.br/home', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(43, 'Repositório Institucional do MPEG', 'MPEG', 'https://repositorio.museu-goeldi.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(44, 'Biblioteca Digital de Teses e Dissertações do INPA', 'INPA', 'https://repositorio.inpa.gov.br/handle/1/6', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(45, 'Repositório da Faculdade de Direito de Vitória', 'FDV', 'http://repositorio.fdv.br:8080/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(46, 'Repositório Institucional da Fundação João Pinheiro', '', 'https://fjp.mg.gov.br/biblioteca/repositorio/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(47, 'Repositório Institucional do IEN', 'IEN', 'https://repositorio.mcti.gov.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(48, 'Repositório Institucional do IPEN', 'IPEN', 'http://repositorio.ipen.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(49, 'Repositório do Instituto de Tecnologia de Alimentos', '', 'http://repositorio.ital.sp.gov.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(50, 'Repositório Institucional do INMETRO', 'INMETRO', 'http://repositorios.inmetro.gov.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(51, 'Repositório Institucional do INT (Repositório Institucional – Instituto Nacional de Tecnologia Ri – INT)', 'INT ', 'https://sistema.bibliotecas-bdigital.fgv.br/bases/int-instituto-nacional-de-tecnologia-repositorio-i', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(52, 'Scientia – Repositório Institucional', '', 'https://repositorio.pgsskroton.com/cogna/pages/home/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(53, 'Repositório Institucional da Diretoria do Patrimônio Histórico e Documentação da Marinha', '', 'https://www.repositorio.mar.mil.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(54, 'Repositório Institucional PUC-Campinas', 'PUC-Campinas', 'https://repositorio.sis.puc-campinas.edu.br/', '', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(55, 'Repositório Institucional da UNITAU', 'UNITAU', 'http://repositorio.unitau.br:8080/jspui/?locale=pt_BR', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(56, 'Repositório da Produção Científica e Intelectual da Unicamp', '', 'https://repositorio.unicamp.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(57, 'Repositório Institucional da UNESP', 'UNESP', 'https://www.franca.unesp.br/#!/sobre2108/biblioteca/repositorio-institucional/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(58, 'Repositório Institucional da UNIFEI (RIUNIFEI)', 'RIUNIFEI', 'https://repositorio.unifei.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(59, 'Repositório Institucional da UFJF', 'UFJF', 'https://repositorio.ufjf.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(60, 'Repositório Institucional da UFLA', 'UFLA', 'http://repositorio.ufla.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(61, 'Repositório Institucional da UFMG', 'UFMG', 'https://repositorio.ufmg.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(62, 'Repositório Institucional da UFOP', 'UFOP', 'https://www.repositorio.ufop.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(63, 'Repositório Institucional da UFSCAR', 'UFSCAR', 'https://repositorio.ufscar.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(64, 'Repositório Institucional da UNIFESP', 'UNIFESP', 'https://repositorio.unifesp.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(65, 'Repositório Institucional da UFU', 'UFU', 'https://repositorio.ufu.br/?locale=pt_BR', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(66, 'Repositório Institucional da Universidade Federal do Espírito Santo (riUfes)', 'UFES', 'https://repositorio.ufes.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(67, 'Repositório Hórus', 'UNIRIO', 'http://www.repositorio-bc.unirio.br:8080/xmlui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(68, 'Repositório Institucional da Universidade Federal Fluminense (RIUFF)', 'UFF', 'https://www.uff.br/?q=tags/repositorio-institucional', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(69, 'Repositório Institucional da Metodista', '', 'https://metodista.br/stricto-sensu/ciencias-da-religiao/publicacoes/repositorio-digital-de-publicaco', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(70, 'Biblioteca Digital de Teses e Dissertações da PUC_CAMPINAS', 'PUC-CAMPINAS', 'https://repositorio.sis.puc-campinas.edu.br/handle/123456789/1955', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(71, 'Biblioteca Digital de Teses e Dissertações da USC', 'USC', 'https://repositorio.unisagrado.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(72, 'Biblioteca Digital de Teses e Dissertações do CDTN', '', 'http://www.repositorio.cdtn.br:8080/jspui/?locale=pt_BR', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(73, 'Repositório COVID-19 Data Sharing/BR (Fapesp)', 'Fapesp', 'https://repositoriodatasharingfapesp.uspdigital.usp.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(74, 'Repositório de Dados de Pesquisa UNIFESP', 'UNIFESP', 'https://repositoriodedados.unifesp.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(76, 'Repositório Institucional da FURG (RI FURG)', 'FURG', 'https://www.repositorio.furg.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(77, 'Repositório Institucional da UCS', 'UCS', 'https://repositorio.ucs.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(78, 'Repositório Institucional da UEPG', 'UEPG', 'https://ead.uepg.br/site/repositorios/repositorio-nutead-2', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(79, 'Repositório Institucional da UFPR', 'UFPR', 'https://acervodigital.ufpr.br/', 'DSpace', '', 1, '0000-00-00', 0, '2025-10-03 12:18:02'),
(80, 'Repositório Institucional da UFSC', 'UFSC', 'https://repositorio.ufsc.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(81, 'Repositório Institucional da UNESC', 'UNESC', 'http://repositorio.unesc.net/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(82, 'Repositório Institucional da UNISINOS (RBDU Repositório Digital da Biblioteca da Unisinos)', 'UNISINOS', 'http://repositorio.jesuita.org.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(83, 'Repositório Institucional da Universidade Estadual de Maringá (RI-UEM)', 'UEM', 'http://repositorio.uem.br:8080/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(84, 'Repositório Institucional da UPF', 'UPF', 'http://repositorio.upf.br/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(85, 'Repositório Institucional da UTFPR da Universidade Tecnológica Federal do Paraná (RIUT)', 'UTFPR', 'https://repositorio.utfpr.edu.br/jspui/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(86, 'Repositório Institucional PUCRS', 'PUCRS', 'https://repositorio.pucrs.br/dspace/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(87, 'Repositório Institucional Uninter', 'Uninter', 'https://repositorio.uninter.com/', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(88, 'Biblioteca Digital de Teses e Dissertações do UFSM', 'UFSM', 'https://repositorio.ufsm.br/handle/1/25', '', '', 0, '0000-00-00', 0, '2025-10-03 12:18:02'),
(89, 'Lume', 'UFRGS', 'https://lume.ufrgs.br/', 'DSpace', '', 404, '2025-05-10', 0, '2025-10-03 17:43:12');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
