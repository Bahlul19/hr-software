CREATE TABLE `designation_changes` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `employee_id` INT(60) NULL DEFAULT NULL , `designation_change` VARCHAR(255) NOT NULL , `change_date` VARCHAR(60) NOT NULL , `created` DATETIME NULL DEFAULT NULL , `modified` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;