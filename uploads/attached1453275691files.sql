-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `files` (`id`, `property_id`, `filename`, `uploaded`) VALUES
(1,	2,	'Double-Room.jpg',	'2016-01-14 12:14:37'),
(2,	2,	'bentley-hotel-nyc-guestroom-view.jpg',	'2016-01-14 12:14:37'),
(3,	2,	'Hotel.jpeg',	'2016-01-14 12:14:37'),
(4,	2,	'Hotel_Regent_(1).jpg',	'2016-01-14 12:14:37'),
(5,	2,	'hotel-room-oceanfront.jpg',	'2016-01-14 12:14:37'),
(6,	2,	'img09.png',	'2016-01-14 12:14:37');

-- 2016-01-18 03:45:23
