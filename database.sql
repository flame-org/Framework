-- Adminer 3.3.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `name` varchar(75) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `web` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `content` varchar(1000) COLLATE utf8_czech_ci NOT NULL,
  `created` datetime NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_post` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `file` varchar(150) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `newsreel`;
CREATE TABLE `newsreel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  `hit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  UNIQUE KEY `name` (`name`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `created` datetime NOT NULL,
  `hit` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `created` datetime NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `comment` tinyint(1) NOT NULL DEFAULT '1',
  `hit` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(35) COLLATE utf8_czech_ci NOT NULL,
  `password` char(128) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(150) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2012-07-11 20:38:54