CREATE TABLE `employee_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `educational_institute_name` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `year_of_completion` date DEFAULT NULL,
  `certification` varchar(20) DEFAULT NULL,
  `percentage` varchar(20) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `employee_education_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1