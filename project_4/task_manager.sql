-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `to_do`;
CREATE TABLE `to_do` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'task id',
  `description` varchar(500) NOT NULL COMMENT 'task description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `to_do` (`id`, `description`) VALUES
(1,	'Mow the lawn'),
(3,	'Make dinner'),
(5,	'Take out the trash'),
(6,	'Clean the bathroom'),
(8,	'Make lunch'),
(9,	'Make breakfast'),
(10,	'Do laundry'),
(12,	'Paint the house'),
(14,	'Pack lunch'),
(15,	'Fix the sink'),
(16,	'Mop the floor'),
(17,	'Feed the fish'),
(19,	'Clean the garage'),
(25,	'Mop the floor'),
(26,	'Mop the floor'),
(28,	'Clean the garage'),
(29,	'Clean the garage'),
(30,	'Clean the garage'),
(31,	'Read the paper'),
(32,	'Watch a movie'),
(33,	'Watch a better movie');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `api_key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `username`, `password`, `created`, `api_key`) VALUES
(10,	'Chelsea',	'$2y$10$OXRqGTtgyFQjqxb.Z9O6Quv3NXJjvuWeNiIlPTmeuLxbCG4wzD69q',	'2016-12-01 02:33:41',	'4f2f5a9cba10ec31f385de7e6b011f40'),
(11,	'Pablo',	'$2y$10$Eoj3UpS8XnFwFUdzNMixXueMFDvXDkYv9Ncjpj/BiuHHwJn8qY102',	'2016-12-01 02:35:20',	'6f3e93677f270e4adc11ac75c14efb94'),
(12,	'Henry',	'$2y$10$Kz.XjkompIIDJ9L1i4.x6.kJhpip82JWD.bajdwhhIXYTgebVnkxy',	'2016-12-01 02:36:17',	'022b1d6719c2aa7fc40f6d9ec6df1b04'),
(13,	'greger',	'$2y$10$L5prsnjwzpo1zOnTGYxyx.VGDfXONPXev37PreqTZZKnfPjKiVR2m',	'2016-12-01 03:29:51',	'0e25aebc2a8edd30b95f4aeeef64c398'),
(14,	'Mel Fisher',	'$2y$10$f/6sppt5pxHJYc1Nj9WjpOl.Eetsa4NniVh/Ux.ZU4//4rJ50WBgO',	'2016-12-01 03:30:42',	'd220b334743b7deda16a8b2055e8b061'),
(15,	'Seungri',	'$2y$10$WFsJNiiHAPlgVjuyWfsuXONUi/BzW8b566zRscFgKxnKUZREWg1ny',	'2016-12-01 03:31:17',	'4d082cf3f671bf86986d2135cf6937de'),
(16,	'Dog',	'$2y$10$LKLR9T0C/BhZmwK2mX9/FO/6WPF3yRo4ZiT88dGE0KbSG.F49toui',	'2016-12-04 20:05:58',	'd143e1da44a1e53359e30a1998b6db0e'),
(17,	'Bob',	'$2y$10$RAYP3CJBxm2dQm9J90/BR.LG1o4aug.X9ECumRb6MwdRb0T.9r7fm',	'2016-12-04 20:08:42',	'40f67497af3176def46a2cfcc01b9c0c'),
(18,	'John',	'$2y$10$PjySVGH/cos6ZCPk2JKFeuHAke1wp0Z3odsMnO9Gjc1YIFBIrpCum',	'2016-12-06 02:04:29',	'7fd3f15dc958cfffa6c9ec6dcc1953ef'),
(19,	'Erin',	'$2y$10$rtDmej1kX7xU4ghJioiW3eVcG2/yX4xkGX5d33M7jQfCVvi4r5D7m',	'2016-12-06 02:10:27',	'f72b0d791bd4f0677853bc675ebfb1bb');

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(500) NOT NULL,
  `create` int(11) NOT NULL DEFAULT '0',
  `read` int(11) NOT NULL DEFAULT '0',
  `readAll` int(11) NOT NULL DEFAULT '0',
  `update` int(11) NOT NULL DEFAULT '0',
  `delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user_log` (`id`, `username`, `create`, `read`, `readAll`, `update`, `delete`) VALUES
(1,	'Chelsea',	0,	0,	0,	0,	0),
(2,	'Pablo',	0,	0,	0,	0,	0),
(3,	'Henry',	7,	1,	6,	3,	9),
(4,	'greger',	0,	0,	0,	0,	0),
(5,	'Mel Fisher',	0,	0,	0,	0,	0),
(6,	'Seungri',	0,	5,	7,	1,	0),
(7,	'Dog',	0,	0,	0,	0,	0),
(8,	'Bob',	0,	0,	0,	0,	0),
(9,	'John',	1,	1,	2,	3,	1),
(10,	'Erin',	2,	0,	0,	0,	0);

-- 2016-12-06 02:17:43
