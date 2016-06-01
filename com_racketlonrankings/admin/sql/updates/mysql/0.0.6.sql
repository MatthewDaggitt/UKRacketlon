DROP TABLE IF EXISTS `#__players`;
 
CREATE TABLE `#__players` (
	`id`        INT(11)     	NOT NULL AUTO_INCREMENT,
	`name`      VARCHAR(100) 	NOT NULL,
	`gender`    BOOLEAN    		NOT NULL,
	`dob`       DATE			NOT NULL,
	`published` tinyint(4)  	NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
 
INSERT INTO `#__players` (`name`, `gender`, `dob`) VALUES
('Matthew Daggitt', FALSE, '1992-09-16'),
('Ruby Marsden', TRUE, '1993-01-30');