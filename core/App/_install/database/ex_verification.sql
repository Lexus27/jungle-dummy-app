-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.22-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица jungle.ex_verification
CREATE TABLE IF NOT EXISTS `ex_verification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope_key` varchar(255) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'Связанный пользователь',
  `session_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL COMMENT 'Код верификации',
  `data` text NOT NULL COMMENT 'Данные верификации',
  `satisfied` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `invoke_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время требования',
  `satisfy_time` datetime DEFAULT NULL,
  `verification_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ex_verification_unique_verification` (`scope_key`,`user_id`,`session_id`,`verification_key`),
  KEY `FK_ex_verification_ex_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Верификация действий';

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
