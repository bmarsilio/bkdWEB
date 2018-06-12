-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioid` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`logid`),
  KEY `usuarioid` (`usuarioid`),
  CONSTRAINT `log_ibfk_1` FOREIGN KEY (`usuarioid`) REFERENCES `usuario` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `notificacao`;
CREATE TABLE `notificacao` (
  `notificacaoid` int(11) NOT NULL AUTO_INCREMENT,
  `paginaid` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `dtclick` date NOT NULL,
  `palavraencontrada` varchar(255) NOT NULL,
  PRIMARY KEY (`notificacaoid`),
  KEY `paginaid` (`paginaid`),
  CONSTRAINT `notificacao_ibfk_1` FOREIGN KEY (`paginaid`) REFERENCES `pagina` (`paginaid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pagina`;
CREATE TABLE `pagina` (
  `paginaid` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `reload` varchar(255) NOT NULL,
  `busca` varchar(255) NOT NULL,
  `htmlatual` text NOT NULL,
  `countreload` int(11) NOT NULL DEFAULT '0',
  `filtrarHtml` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`paginaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE `tipousuario` (
  `tipousuarioid` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`tipousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tipousuario` (`tipousuarioid`, `descricao`) VALUES
(1,	'admin');

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `usuarioid` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL DEFAULT '123456',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `tipousuarioid` int(11) NOT NULL,
  PRIMARY KEY (`usuarioid`),
  KEY `tipousuarioid` (`tipousuarioid`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipousuarioid`) REFERENCES `tipousuario` (`tipousuarioid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `usuario` (`usuarioid`, `nome`, `login`, `senha`, `ativo`, `tipousuarioid`) VALUES
(2,	'admin',	'admin',	'e10adc3949ba59abbe56e057f20f883e',	1,	1);

-- 2018-06-12 02:18:08
