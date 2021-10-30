
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `roles` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_added` (`created_by`)
);

/*ALTER TABLE forms ADD CONSTRAINT fk_user_added FOREIGN key (created_by) REFERENCES employees(id)*/