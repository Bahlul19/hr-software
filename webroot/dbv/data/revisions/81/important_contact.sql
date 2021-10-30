CREATE TABLE IF NOT EXISTS `important_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_of_contact` text NOT NULL,
  `type` text NOT NULL,
  `location` varchar(20) DEFAULT NULL,
  `role` varchar(10) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)