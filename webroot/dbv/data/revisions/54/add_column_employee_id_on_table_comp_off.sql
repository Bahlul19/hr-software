ALTER TABLE `comp_off` ADD `employee_id` INT(11) NOT NULL AFTER `id`, ADD INDEX (`employee_id`);