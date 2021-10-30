DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `available_from` date DEFAULT NULL,
  `available_to` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_added` (`created_by`)
);

DROP TABLE IF EXISTS `form_feedback_for`;
CREATE TABLE IF NOT EXISTS `form_feedback_for` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) DEFAULT NULL,
  `role_id` int(10) DEFAULT NULL,
  `employee_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_feedback_for` (`form_id`)
) ;

DROP TABLE IF EXISTS `form_fields`;
CREATE TABLE IF NOT EXISTS `form_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) NOT NULL,
  `field_data` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `form_submissions`;
CREATE TABLE IF NOT EXISTS `form_submissions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `submitted_data` text NOT NULL,
  `feedback_for` int(11) DEFAULT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedback_for` (`feedback_for`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_form_id` (`form_id`)
);
DROP TABLE IF EXISTS `form_visibility`;
CREATE TABLE IF NOT EXISTS `form_visibility` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_visibility` (`form_id`),
  KEY `fk_form_visibility_roles` (`role_id`)
) ;