CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locations` text NOT NULL,
  `short` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
)

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `locations`, `short`) VALUES
(1, 'New York', 'NYC'),
(2, 'Sylhet', 'SYL'),
(3, 'Goa', 'GOA'),
(4, 'Dhaka', 'DHK'),
(5, 'Ukraine', 'UKR');