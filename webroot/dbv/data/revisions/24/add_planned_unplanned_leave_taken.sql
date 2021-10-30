ALTER TABLE `leave_requests` ADD `unplanned_leave_taken` INT(20) NOT NULL AFTER `earned_leave_taken`, ADD `planned_leave_taken` INT(20) NOT NULL AFTER `unplanned_leave_taken`;
