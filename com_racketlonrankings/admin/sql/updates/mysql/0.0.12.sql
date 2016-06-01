ALTER TABLE `#__players` DROP COLUMN `uk`;
ALTER TABLE `#__players` ADD `country` VARCHAR(10);

ALTER TABLE `#__matches` ADD `bonus` INT NOT NULL;