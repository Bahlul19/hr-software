DROP TABLE IF EXISTS `hubstaff_hours`;
CREATE TABLE IF NOT EXISTS `hubstaff_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` varchar(20) DEFAULT NULL,
  `time_zone` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `project` text,
  `member` varchar(50) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `task` text,
  `time` time DEFAULT NULL,
  `activity` varchar(10) DEFAULT NULL,
  `spent` varchar(20) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_hubsatff_member_name` (`member`)
);

ALTER TABLE `employees` ADD `hubstaff_name` VARCHAR(50) NULL DEFAULT NULL AFTER `is_pm`;
ALTER TABLE `assign_processes` ADD `office` INT NULL DEFAULT NULL AFTER `employee_id`;
ALTER TABLE `assign_processes` CHANGE `employee_id` `employee_id` INT(11) NULL DEFAULT '0';