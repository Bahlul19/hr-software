CREATE TABLE `employee_salaries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `compensation_amt` int(20) unsigned NOT NULL,
  `pay_type` varchar(30) CHARACTER SET utf8 NOT NULL,
  `salary_change_reason` varchar(30) CHARACTER SET utf8 NOT NULL,
  `tax_related` varchar(50) CHARACTER SET utf8 NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `employees_salary_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1