CREATE TABLE IF NOT EXISTS `bets` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(7) unsigned NOT NULL,
  `rid` int(7) unsigned NOT NULL,
  `uid` int(7) unsigned NOT NULL,
  `date` int(20) unsigned NOT NULL,
  `value` int(7) unsigned NOT NULL,
  `status` enum('waiting','won','lost') NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `challenges` (
  `cid` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` int(7) unsigned NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` int(20) NOT NULL,
  `timeToDo` smallint(3) unsigned NOT NULL,
  `forSum` int(11) unsigned NOT NULL DEFAULT '0',
  `againstSum` int(11) unsigned NOT NULL DEFAULT '0',
  `completed` int(5) unsigned NOT NULL DEFAULT '0',
  `totalSum` int(7) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `realizations` (
  `rid` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(7) unsigned NOT NULL,
  `uid` int(7) unsigned NOT NULL,
  `status` enum('accepted','failed','moderating','done') NOT NULL DEFAULT 'accepted',
  `start` int(20) unsigned NOT NULL,
  `end` int(20) unsigned NOT NULL,
  `forSum` int(10) unsigned NOT NULL,
  `againstSum` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `karma` int(7) NOT NULL,
  `mailHash` char(32) NOT NULL,
  `pass` varchar(87) NOT NULL,
  `session` varchar(26) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`mailHash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;