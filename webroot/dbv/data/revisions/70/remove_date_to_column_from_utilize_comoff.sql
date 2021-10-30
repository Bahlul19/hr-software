ALTER TABLE `utilize_comoffs` DROP `date_to`;
ALTER TABLE `utilize_comoffs` CHANGE `date_from` `date` DATE NOT NULL;