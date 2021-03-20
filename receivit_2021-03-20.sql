# ************************************************************
# Sequel Ace SQL dump
# Version 3024
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.7.26)
# Database: receivit
# Generation Time: 2021-03-20 15:42:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table clientes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL DEFAULT '',
  `documento` varchar(18) NOT NULL DEFAULT '',
  `nascimento` date NOT NULL,
  `endereco` varchar(200) NOT NULL DEFAULT '',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;

INSERT INTO `clientes` (`id`, `nome`, `documento`, `nascimento`, `endereco`, `created_date`, `updated_date`)
VALUES
	(1,'Dona Florinda','143837','1990-01-01','Rua Oscilio Maia, 327','2021-03-18 20:07:56','2021-03-18 21:15:30'),
	(2,'Bruno Tubio 2','10017272742','1983-11-29','Rua General Oscilio Maia, 327','2021-03-18 20:10:00',NULL),
	(5,'Cliente com muitos títulos','10017272742','1983-11-29','Rua dos devedores, 327','2021-03-18 20:57:00','2021-03-19 22:20:34'),
	(7,'Edson Arantes do Nascimento','1213415','2001-01-01','Rua de Teste, 357','2021-03-19 19:34:23',NULL),
	(9,'Xuxa Meneghel','12345678','2000-03-02','Rua Do Janeiro, 778','2021-03-19 20:09:40',NULL),
	(11,'Angelica do Luciano Hulk','3334876','1998-12-15','General Das Brancas de neve, 255','2021-03-19 20:11:46',NULL),
	(13,'Chitaozinho e Xororó','12345678','1987-05-13','No Rancho fundo','2021-03-19 20:13:29',NULL),
	(18,'Fausto Silva','13242314','1976-12-05','Rua da Rede Globo, 171','2021-03-19 20:38:04',NULL);

/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table titulos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `titulos`;

CREATE TABLE `titulos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `descricao` longtext NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date NOT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `titulos` WRITE;
/*!40000 ALTER TABLE `titulos` DISABLE KEYS */;

INSERT INTO `titulos` (`id`, `cliente_id`, `descricao`, `valor`, `vencimento`, `updated_date`, `created_date`)
VALUES
	(1,5,'Another day in paradise',6666.99,'2022-03-16','2021-03-19 00:07:24','2021-03-18 23:34:49'),
	(3,5,'Outro de pagamento',1234.00,'2021-03-16',NULL,'2021-03-18 23:44:35'),
	(4,1,'Outro de pagamento',1234.99,'2021-03-16',NULL,'2021-03-18 23:45:29'),
	(5,13,'Descrição do Título',22.35,'2021-03-17',NULL,'2021-03-20 09:00:25'),
	(6,5,'Descrição do Título',22.35,'2013-01-01',NULL,'2021-03-20 09:02:42');

/*!40000 ALTER TABLE `titulos` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
