CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `announcement` text NOT NULL,
  `date` date NOT NULL,
  `offices` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1