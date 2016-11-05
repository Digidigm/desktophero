# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.20)
# Database: hero
# Generation Time: 2016-11-05 17:14:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `email_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `pass_phrase` varchar(255) COLLATE utf8_bin NOT NULL,
  `birthdate` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `preferences` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `token_facebook` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `token_google` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `photo` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `bio` text COLLATE utf8_bin,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `username`, `email_address`, `pass_phrase`, `birthdate`, `active`, `preferences`, `first_name`, `last_name`, `token_facebook`, `token_google`, `photo`, `bio`)
VALUES
	(1,X'74657374',X'7465737440746573742E636F6D',X'61393461386665356363623139626136316334633038373364333931653938373938326662626433',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
