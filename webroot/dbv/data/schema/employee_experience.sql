CREATE TABLE `employee_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `previous_company` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `date_of_service_from` date DEFAULT NULL,
  `date_of_service_to` date DEFAULT NULL,
  `last_earned_salary` int(10) DEFAULT NULL,
  `designation` varchar(20) DEFAULT NULL,
  `reported_to` varchar(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `employee_experience_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1