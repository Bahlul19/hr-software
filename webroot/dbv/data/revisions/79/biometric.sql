             /*   CREATE TABLE `employee_attendance` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `employee_id` int(11) DEFAULT NULL,
                  `employee_name` varchar(50) DEFAULT NULL,
                  `shift` varchar(30) DEFAULT NULL,
                  `shift_start_at` time DEFAULT NULL,
                  `shift_end_at` time DEFAULT NULL,
                  `date` date DEFAULT NULL,
                  `checkin` time DEFAULT NULL,
                  `checkout` time DEFAULT NULL,
                  `hours_worked` varchar(30) DEFAULT '00:00:00',
                  `extra_hours` time DEFAULT NULL,
                  `late_by` time DEFAULT '00:00:00',
                  `early_by` time DEFAULT '00:00:00',
                  `is_present` tinyint(1) DEFAULT NULL,
                  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;*/


ALTER TABLE `employee_attendance` CHANGE `hours_worked` `hours_worked` VARCHAR(30) NULL DEFAULT '00:00:00';


           CREATE TABLE `min_week_hours` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `office_location` varchar(20) NOT NULL,
                  `hours` float NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
