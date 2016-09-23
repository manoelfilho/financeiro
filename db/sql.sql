# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 108.179.253.210 (MySQL 5.5.40-36.1)
# Base de Dados: manoe136_financeiro
# Tempo de Geração: 2016-05-20 2:53:56 PM +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela categorias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) unsigned NOT NULL,
  `criacao` datetime NOT NULL,
  `modificacao` datetime NOT NULL,
  `categoria` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_usuario_id_categoria` (`usuario_id`),
  CONSTRAINT `fk_usuario_id_categoria` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;

INSERT INTO `categorias` (`id`, `usuario_id`, `criacao`, `modificacao`, `categoria`)
VALUES
	(2,701,'2015-10-07 15:02:41','2015-10-07 15:02:41','Transporte'),
	(3,701,'2015-10-07 15:02:50','2015-10-07 15:02:50','Alimentação'),
	(4,701,'2015-10-07 15:03:04','2015-10-07 15:03:04','Saúde'),
	(5,701,'2015-10-07 15:03:13','2015-10-07 15:03:13','Cultura');

/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela contas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contas`;

CREATE TABLE `contas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) unsigned NOT NULL,
  `criacao` date DEFAULT NULL,
  `modificacao` date DEFAULT NULL,
  `banco` varchar(500) DEFAULT NULL,
  `conta` varchar(500) DEFAULT NULL,
  `saldo` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_id_conta` (`usuario_id`),
  CONSTRAINT `fk_usuario_id_conta` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contas` WRITE;
/*!40000 ALTER TABLE `contas` DISABLE KEYS */;

INSERT INTO `contas` (`id`, `usuario_id`, `criacao`, `modificacao`, `banco`, `conta`, `saldo`)
VALUES
	(1,701,'2015-10-07','2015-10-07','Banco do Brasil','00001',0),
	(2,701,'2015-10-07','2015-10-07','Caixa Econômica Federal','00002',0),
	(3,701,'2015-10-07','2015-10-07','Santander','00003',0),
	(4,701,'2015-10-08','2015-10-08','Bradesco','00004',0);

/*!40000 ALTER TABLE `contas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela estados
# ------------------------------------------------------------

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criacao` datetime NOT NULL,
  `modificacao` datetime NOT NULL,
  `sigla` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regiao` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;

INSERT INTO `estados` (`id`, `criacao`, `modificacao`, `sigla`, `estado`, `regiao`)
VALUES
	(1,'0000-00-00 00:00:00','0000-00-00 00:00:00','DF','Distrito Federal','Centro-Oeste');

/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela grupos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grupos`;

CREATE TABLE `grupos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criacao` date DEFAULT NULL,
  `modificacao` date DEFAULT NULL,
  `grupo` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;

INSERT INTO `grupos` (`id`, `criacao`, `modificacao`, `grupo`)
VALUES
	(1,NULL,NULL,'Grupo 1');

/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela movimentacoes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movimentacoes`;

CREATE TABLE `movimentacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `criacao` datetime NOT NULL,
  `modificacao` datetime NOT NULL,
  `conta_id` int(11) unsigned NOT NULL,
  `categoria_id` int(11) unsigned DEFAULT NULL,
  `data` datetime NOT NULL,
  `historico` varchar(500) DEFAULT NULL,
  `documento` varchar(500) DEFAULT NULL,
  `valor` double NOT NULL,
  `rubrica` varchar(500) DEFAULT NULL,
  `atividade` varchar(500) DEFAULT NULL,
  `favorecido` varchar(500) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`),
  KEY `fk_usuario` (`usuario_id`),
  KEY `fk_conta_id` (`conta_id`),
  KEY `fk_categoria_id` (`categoria_id`),
  CONSTRAINT `fk_categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_conta_id` FOREIGN KEY (`conta_id`) REFERENCES `contas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `movimentacoes` WRITE;
/*!40000 ALTER TABLE `movimentacoes` DISABLE KEYS */;

INSERT INTO `movimentacoes` (`id`, `usuario_id`, `criacao`, `modificacao`, `conta_id`, `categoria_id`, `data`, `historico`, `documento`, `valor`, `rubrica`, `atividade`, `favorecido`, `descricao`)
VALUES
	(1,701,'2015-10-07 15:05:24','2015-10-07 15:05:24',1,4,'2015-06-10 00:00:00','Consulta médica','0001',120,'','','',''),
	(2,701,'2015-10-07 15:27:08','2015-10-07 15:27:08',2,5,'2015-05-05 00:00:00','Cinema','',150,'','','',''),
	(3,701,'2015-10-07 16:06:37','2015-10-07 16:06:37',1,3,'2015-06-08 00:00:00','','',200,'','','',''),
	(4,701,'2015-10-07 16:10:15','2015-10-07 16:10:15',1,4,'2015-07-07 00:00:00','','',50,'','','',''),
	(5,701,'2015-10-07 22:21:04','2015-10-07 22:21:04',2,2,'2015-07-07 00:00:00','','',50,'','','',''),
	(9,701,'2015-10-07 22:28:30','2015-10-07 22:28:30',1,2,'2015-10-06 00:00:00','','',456,'','','',''),
	(10,701,'2015-10-07 22:32:18','2015-10-07 22:32:18',3,5,'2015-10-06 00:00:00','','',200,'','','',''),
	(11,701,'2015-10-07 22:32:56','2015-10-07 22:32:56',3,5,'2015-10-21 00:00:00','','',38,'','','',''),
	(12,701,'2015-10-08 10:49:58','2015-10-08 10:49:58',4,3,'2015-10-06 00:00:00','Histórico','Documento',1800,'','','',''),
	(13,701,'2015-11-08 17:45:44','2015-11-08 17:45:44',4,3,'2015-11-02 00:00:00','','',89,'','','','');

/*!40000 ALTER TABLE `movimentacoes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela municipios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `municipios`;

CREATE TABLE `municipios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criacao` datetime NOT NULL,
  `modificacao` datetime NOT NULL,
  `municipio` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `estado_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkEstado` (`estado_id`),
  CONSTRAINT `fk_estado_id` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `municipios` WRITE;
/*!40000 ALTER TABLE `municipios` DISABLE KEYS */;

INSERT INTO `municipios` (`id`, `criacao`, `modificacao`, `municipio`, `estado_id`)
VALUES
	(1,'0000-00-00 00:00:00','0000-00-00 00:00:00','Brasília',1);

/*!40000 ALTER TABLE `municipios` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `criacao` datetime DEFAULT NULL,
  `modificacao` datetime DEFAULT NULL,
  `sexo` char(1) DEFAULT '',
  `estado_id` int(11) unsigned DEFAULT NULL,
  `municipio_id` int(11) unsigned DEFAULT NULL,
  `email` varchar(255) DEFAULT '',
  `senha` varchar(500) DEFAULT '',
  `categoria` varchar(100) DEFAULT '',
  `codigo_mudanca` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_id` (`estado_id`),
  KEY `fk_municipio_id` (`municipio_id`),
  CONSTRAINT `fk_municipio_id` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`id`, `nome`, `criacao`, `modificacao`, `sexo`, `estado_id`, `municipio_id`, `email`, `senha`, `categoria`, `codigo_mudanca`)
VALUES
	(701,'Usuário da Silva','2015-10-07 14:58:35','2016-04-19 17:07:38','m',1,1,'usuario@email.com','e10adc3949ba59abbe56e057f20f883e','permissao1',NULL);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela usuarios_grupos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios_grupos`;

CREATE TABLE `usuarios_grupos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) unsigned DEFAULT NULL,
  `grupo_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_id` (`usuario_id`),
  KEY `fk_grupo_id` (`grupo_id`),
  CONSTRAINT `fk_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios_grupos` WRITE;
/*!40000 ALTER TABLE `usuarios_grupos` DISABLE KEYS */;

INSERT INTO `usuarios_grupos` (`id`, `usuario_id`, `grupo_id`)
VALUES
	(1,701,1);

/*!40000 ALTER TABLE `usuarios_grupos` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
