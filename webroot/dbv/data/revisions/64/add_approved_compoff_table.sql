CREATE TABLE `approved_compoff` ( `id` INT(16) NOT NULL AUTO_INCREMENT , `employee_id` INT(16) NOT NULL , `employee_name` VARCHAR(255) NOT NULL , `approved_hour` FLOAT(10) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`employee_id`)) ENGINE = InnoDB;