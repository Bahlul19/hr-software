ALTER TABLE `leave_days` ADD `planned_leave` FLOAT NOT NULL AFTER `earned_leave`, ADD `unplanned_leave` FLOAT NOT NULL AFTER `planned_leave`;