# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.20)
# Database: hero
# Generation Time: 2016-11-05 19:47:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table figure_admin_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `figure_admin_queue`;

CREATE TABLE `figure_admin_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `figure_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `whence` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table figure_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `figure_likes`;

CREATE TABLE `figure_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `figure_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `whence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table figure_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `figure_tags`;

CREATE TABLE `figure_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `figure_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `whence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table figures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `figures`;

CREATE TABLE `figures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `figure_name` varchar(64) DEFAULT NULL,
  `figure_data` text,
  `figure_story` text,
  `figure_description` text,
  `figure_automatic_description` text,
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

LOCK TABLES `figures` WRITE;
/*!40000 ALTER TABLE `figures` DISABLE KEYS */;

INSERT INTO `figures` (`id`, `user_id`, `figure_name`, `figure_data`, `figure_story`, `figure_description`, `figure_automatic_description`, `photo_render`, `photo_inspiration`, `photo_thumbnail`, `flag_nsfw_sex`, `flag_nsfw_violence`, `flag_nsfw_other`, `flag_deleted`, `flag_hidden`, `flag_featured`, `flag_private`, `date_created`, `date_updated`, `count_downloads`, `count_views`)
VALUES
	(1,1,'Ralph',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(2,1,'Justine',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(3,1,'Lemuel',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(4,1,'Satan the Destroying Angel',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,1,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(5,1,'Lewd Dude',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',1,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(6,1,'Robin Hood',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(7,1,'Sir Reginault',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(8,1,'Madame West',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(9,1,'Bobby Sharpshooter',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(10,1,'X134',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(11,1,'Spike',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(12,1,'Nebuchadnezzar King of Persia',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(13,1,'Rupert Madden Knickersley-Knockerbotham IV',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(14,1,'Mildred Snodgrass-Wigglesworth',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(15,1,'Spencer Clippingsworth-Twistleton',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3),
	(16,1,'呂羽都',NULL,'Pellentesque nibh felis, eleifend id, commodo in, interdum vitae, leo. Praesent eu elit. Ut eu ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas elementum augue nec nisl. Proin auctor lorem at nibh. Curabitur nulla purus, feugiat id, elementum in, lobortis quis, pede. Vivamus sodales adipiscing sapien. Vestibulum posuere nulla eget wisi. Integer volutpat ligula eget enim. Suspendisse vitae arcu. Quisque pellentesque. Nullam consequat, sem vitae rhoncus tristique, mauris nulla fermentum est, bibendum ullamcorper sapien magna et quam. Sed dapibus vehicula odio. Proin bibendum gravida nisl. Fusce lorem. Phasellus sagittis, nulla in hendrerit laoreet, libero lacus feugiat urna, eget hendrerit pede magna vitae lorem. Praesent mauris.',NULL,NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1478370992,1478370992,1,3);

/*!40000 ALTER TABLE `figures` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `figure_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(24) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `caption` varchar(64) DEFAULT NULL,
  `flag_nsfw` tinyint(1) DEFAULT NULL,
  `flag_deleted` tinyint(1) DEFAULT NULL,
  `flag_featured` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;

INSERT INTO `gallery` (`id`, `created`, `figure_id`, `user_id`, `type`, `photo`, `thumbnail`, `caption`, `flag_nsfw`, `flag_deleted`, `flag_featured`)
VALUES
	(1,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Aliquam in lacus.',NULL,NULL,NULL),
	(9,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Phasellus aliquam enim et tortor.',NULL,NULL,NULL),
	(10,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Proin ornare dignissim lacus.',NULL,1,NULL),
	(11,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Dignissim lacus.',NULL,NULL,NULL),
	(12,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Phasellus pulvinar, nulla non aliquam eleifend, tortor wisi scel',NULL,NULL,NULL),
	(13,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Vestibulum at metus.',NULL,NULL,NULL),
	(14,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Nunc quis justo.',NULL,NULL,NULL),
	(15,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Proin ornare dignissim lacus.',NULL,NULL,NULL),
	(16,1478368169,1,1,'print','http://beerhold.it/300/500','http://beerhold.it/200/300','Donec nisl.',NULL,NULL,NULL),
	(17,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Praesent ultricies facilisis nisl.',NULL,NULL,NULL),
	(18,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Phasellus pulvinar, nulla non aliquam eleifend, tortor wisi scel',NULL,NULL,NULL),
	(19,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Quisque posuere, purus sit amet malesuada blandit, sapien sapien',NULL,NULL,NULL),
	(20,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Nullam nibh dolor, blandit sed, fermentum id, imperdiet sit amet',NULL,NULL,NULL),
	(21,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Quisque sit amet est et sapien ullamcorper pharetra.',1,NULL,NULL),
	(22,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Aliquam sagittis magna in felis egestas rutrum.',NULL,NULL,NULL),
	(23,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Etiam non wisi.',NULL,NULL,NULL),
	(24,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Aliquam erat volutpat.',NULL,NULL,NULL),
	(25,1478368169,1,1,'featured','http://beerhold.it/300/500','http://beerhold.it/200/300','Curabitur sed leo.',NULL,NULL,NULL);

/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table model_admin_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `model_admin_queue`;

CREATE TABLE `model_admin_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `whence` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table model_presets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `model_presets`;

CREATE TABLE `model_presets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `preset_name` varchar(64) DEFAULT NULL,
  `preset_data` text,
  `preset_short_desc` varchar(255) DEFAULT NULL,
  `preset_category` varchar(64) DEFAULT NULL,
  `preset_type` int(11) DEFAULT NULL,
  `preset_model_id` varchar(64) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table model_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `model_tags`;

CREATE TABLE `model_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `whence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table models
# ------------------------------------------------------------

DROP TABLE IF EXISTS `models`;

CREATE TABLE `models` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `model_name` varchar(64) DEFAULT NULL,
  `model_data` text,
  `model_story` text,
  `model_short_desc` varchar(255) DEFAULT NULL,
  `model_category` varchar(64) DEFAULT NULL,
  `model_type` varchar(16) DEFAULT NULL,
  `model_attachment` varchar(64) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;

INSERT INTO `models` (`id`, `user_id`, `model_name`, `model_data`, `model_story`, `model_short_desc`, `model_category`, `model_type`, `model_attachment`, `photo_render`, `photo_inspiration`, `photo_thumbnail`, `flag_nsfw_sex`, `flag_nsfw_violence`, `flag_nsfw_other`, `flag_deleted`, `flag_hidden`, `flag_featured`, `flag_private`, `date_created`, `date_updated`)
VALUES
	(1,1,'Heroic Male Body',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','body','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(2,1,'Lithe Female Body',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','body','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(3,1,'Rotund Male Body',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','body','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(4,1,'Vixen Famel Body',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','body','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(5,1,'Mighty Arms',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(8,1,'Beefy Arms',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(9,1,'Dainty Arms',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(10,1,'Tentacle Arms',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(11,1,'Gymnast Legs',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(12,1,'Skinny Legs',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(13,1,'Chicken Legs',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(14,1,'Hoofed Legs',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(15,1,'Handsome Man',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(16,1,'Elderly Man',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(17,1,'Knockout Woman',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(18,1,'Hag Woman',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(19,1,'Forest Robber',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','clothing','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(20,1,'Temple Guard',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','clothing','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(21,1,'Cowboy',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','clothing','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(22,1,'Cowgirl',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','clothing','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(23,1,'Chainmail Bikini',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','clothing','mesh',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(24,1,'Heroic Skeleton',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','human','skeleton',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(25,1,'Elfin Skeleton',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','human','skeleton',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(26,1,'Centaur Skeleton',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','human','skeleton',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(27,1,'Tentacles Skeleton',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','human','skeleton',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(28,1,'Laughing at Danger',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(29,1,'Weeping from Fear',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(30,1,'Defiant Eyes',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(31,1,'Sneaky Look',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','head','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(32,1,'Ready to Run',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(33,1,'Dynamic Stand',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(34,1,'Martial Arts Kick',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(35,1,'Sitting',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','legs','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(36,1,'Kung Fu Grip',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(37,1,'Come Get Some',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(38,1,'Lo and Behold',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(39,1,'Lookout!',NULL,'Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing congue metus. Nam pede. Etiam non wisi. Sed accumsan dolor ac augue. Pellentesque eget lectus. Aliquam nec dolor nec tellus ornare venenatis. Nullam blandit placerat sem. Curabitur quis ipsum. Mauris nisl tellus, aliquet eu, suscipit eu, ullamcorper quis, magna. Mauris elementum, pede at sodales vestibulum, nulla tortor congue massa, quis pellentesque odio dui id est. Cras faucibus augue.','Pellentesque vel dui sed orci faucibus iaculis. Suspendisse dictum magna id purus tincidunt rutrum. Nulla congue. Vivamus sit amet lorem posuere dui vulputate ornare. Phasellus mattis sollicitudin ligula. Duis dignissim felis et urna. Integer adipiscing c','arms','pose',NULL,'https://placekitten.com/g/640/640','https://placekitten.com/g/640/640','https://placekitten.com/g/64/64',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0);

/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `token` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `session_data` text COLLATE utf8_bin,
  PRIMARY KEY (`token`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`token`, `user_id`, `time_created`, `expires`, `session_data`)
VALUES
	(X'3132346238353763393336366633356266366135366533326262613735306339',0,'2016-08-19 14:18:46','0000-00-00 00:00:00',X'59546F794F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F6949784D6A52694F445533597A6B7A4E6A5A6D4D7A56695A6A5A684E545A6C4D7A4A69596D45334E54426A4F534937637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3138346134626438353064336231316635326535333030393036366131373631',1,'2016-08-19 15:55:23','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F6949314E4759794D5442694E7A6C69595755794D6A426C4F5445344E444135593252695A54646D4D54466D59794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A45344E474530596D51344E54426B4D3249784D5759314D6D55314D7A41774F5441324E6D45784E7A5978496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A49354D6A4D37637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3139656337613336363930336563343131383565323033643266646536383531',1,'2016-08-19 16:21:06','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694931597A49784D44466B4D4445784E574A685954646A593259794D6A4E694D3252694E6A4530596A646D4D794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A45355A574D3359544D324E6A6B774D32566A4E4445784F44566C4D6A417A5A444A6D5A4755324F445578496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A51304E6A5937637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3534663231306237396261653232306539313834303963646265376631316663',1,'2016-08-19 15:55:19','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F6949314E4759794D5442694E7A6C69595755794D6A426C4F5445344E444135593252695A54646D4D54466D59794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A55305A6A49784D4749334F574A685A5449794D4755354D5467304D446C6A5A474A6C4E3259784D575A6A496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A49354D546B37637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3539626265306636396635333463356432333936363430316533666535396331',1,'2016-08-19 16:21:29','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694931597A49784D44466B4D4445784E574A685954646A593259794D6A4E694D3252694E6A4530596A646D4D794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A5535596D4A6C4D4759324F5759314D7A526A4E5751794D7A6B324E6A51774D57557A5A6D55314F574D78496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A51304F446B37637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3563323130316430313135626161376363663232336233646236313462376633',1,'2016-08-19 16:20:12','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694931597A49784D44466B4D4445784E574A685954646A593259794D6A4E694D3252694E6A4530596A646D4D794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A566A4D6A45774D5751774D544531596D46684E324E6A5A6A49794D32497A5A4749324D5452694E32597A496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A51304D544937637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3762653035323835313761373962383834626562373965633633306461356530',1,'2016-08-19 16:20:16','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694931597A49784D44466B4D4445784E574A685954646A593259794D6A4E694D3252694E6A4530596A646D4D794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A64695A5441314D6A67314D5464684E7A6C694F446730596D56694E7A6C6C597A597A4D4752684E575577496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A51304D545937637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'3838353239326337333538643939313862346330313162623232303631363266',1,'2016-08-19 16:21:10','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694931597A49784D44466B4D4445784E574A685954646A593259794D6A4E694D3252694E6A4530596A646D4D794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496A67344E5449354D6D4D334D7A55345A446B354D5468694E474D774D544669596A49794D4459784E6A4A6D496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A51304E7A4137637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D'),
	(X'6436616463633966656663383661303066326561633961373764343336343363',1,'2016-08-19 16:18:45','0000-00-00 00:00:00',X'59546F324F6E747A4F6A5536496C52505330564F496A747A4F6A4D794F694A6B4E6D466B59324D355A6D566D597A6732595441775A6A4A6C59574D35595463335A44517A4E6A517A59794937637A6F334F694A31633256794C6D6C6B496A747A4F6A4536496A45694F334D364E546F69644739725A5734694F334D364D7A4936496D51325957526A597A6C6D5A575A6A4F445A684D44426D4D6D5668597A6C684E7A646B4E444D324E444E6A496A747A4F6A6736496D78765A32646C5A476C75496A74694F6A4537637A6F334F694A6C65484270636D567A496A74704F6A45304E7A45334D6A517A4D6A5537637A6F784D446F69633278706253356D6247467A6143493759546F774F6E743966513D3D');

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_hint` varchar(255) DEFAULT NULL,
  `tag_label` varchar(24) DEFAULT NULL,
  `tag_synonyms` text,
  `flag_nsfw` tinyint(1) DEFAULT NULL,
  `flag_approved` tinyint(1) DEFAULT NULL,
  `flag_deleted` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
