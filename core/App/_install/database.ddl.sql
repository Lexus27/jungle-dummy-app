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

-- Дамп структуры для таблица jungle.ex_user
CREATE TABLE IF NOT EXISTS `ex_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name_id_uindex` (`id`),
  UNIQUE KEY `table_name_username_uindex` (`username`),
  KEY `ex_user_password_hash_index` (`password_hash`),
  KEY `ex_user_password2222_hash_index` (`password_hash`),
  KEY `222222` (`password_hash`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица jungle.ex_user_group
CREATE TABLE IF NOT EXISTS `ex_user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rank` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ex_user_group_id_uindex` (`id`),
  UNIQUE KEY `ex_user_group_title_uindex` (`name`),
  KEY `FK_ex_user_group_ex_user_group` (`parent_id`),
  CONSTRAINT `FK_ex_user_group_ex_user_group` FOREIGN KEY (`parent_id`) REFERENCES `ex_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица jungle.ex_user_group_member
CREATE TABLE IF NOT EXISTS `ex_user_group_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `join_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ex_user_group_member_id_uindex` (`id`),
  KEY `ex_user_group_member_ex_user_id_fk` (`user_id`),
  KEY `ex_user_group_member_ex_user_group_id_fk` (`group_id`),
  CONSTRAINT `ex_user_group_member_ex_user_group_id_fk` FOREIGN KEY (`group_id`) REFERENCES `ex_user_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ex_user_group_member_ex_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `ex_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


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
