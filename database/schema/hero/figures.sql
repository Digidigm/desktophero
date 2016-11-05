# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.20)
# Database: hero
# Generation Time: 2016-11-05 17:13:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table figures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `figures`;

CREATE TABLE `figures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `figure_name` varchar(64) DEFAULT NULL,
  `figure_data` text,
  `figure_story` text,
  `photo_render` varchar(255) DEFAULT NULL,
  `photo_inspiration` varchar(255) DEFAULT NULL,
  `photo_thumbnail` varchar(255) DEFAULT NULL,
  `flag_nsfw_sex` tinyint(1) DEFAULT NULL,
  `flag_nsfw_violence` tinyint(1) DEFAULT NULL,
  `flag_nsfw_other` tinyint(1) DEFAULT NULL,
  `flag_deleted` tinyint(1) DEFAULT NULL,
  `flag_hidden` tinyint(1) DEFAULT NULL,
  `flag_featured` tinyint(1) DEFAULT NULL,
  `flag_private` tinyint(1) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `count_downloads` int(11) DEFAULT NULL,
  `count_views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
