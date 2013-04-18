
CREATE TABLE `verteiler` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `degree` int(5) NOT NULL,
  `cm` int(5) NOT NULL,
  `team` enum('men','women') COLLATE utf8_bin NOT NULL,
  `set` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `team` (`team`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

