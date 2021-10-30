ALTER TABLE form_visibility add CONSTRAINT fk_form_visibility FOREIGN key (form_id) REFERENCES forms (id);
ALTER TABLE form_visibility add CONSTRAINT fk_form_visibility_roles FOREIGN key (role_id) REFERENCES roles (id);
ALTER TABLE `form_submissions` ADD `is_visible` TINYINT NOT NULL DEFAULT '0' AFTER `feedback_for`;