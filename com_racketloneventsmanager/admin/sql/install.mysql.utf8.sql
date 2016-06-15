DROP TABLE IF EXISTS `#__racketloneventsmanager`;
 
CREATE TABLE `#__racketloneventsmanager` (
	`id`       	INT(11)     	NOT NULL AUTO_INCREMENT,
	`name` 		VARCHAR(100) 	NOT NULL,
	`type`		VARCHAR(25)		NOT NULL,
	`link`		VARCHAR(1000)	NOT NULL,
	`year`		VARCHAR(4)		NOT NULL,
	`dated`		BOOLEAN			NOT NULL, 
	`startdate`	DATE			NOT NULL,
	`enddate`	DATE			NOT NULL,
	`singles`	BOOLEAN			NOT NULL,
	`doubles`	BOOLEAN			NOT NULL,
	`teams`		BOOLEAN			NOT NULL,
	`location` 	VARCHAR(25)		NOT NULL,
	`postcode`	VARCHAR(10)		NOT NULL,
	`email`		VARCHAR(100)	NOT NULL,
	`phone`		VARCHAR(20)		NOT NULL,
	`published` tinyint(4) 		NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
 
INSERT INTO
`#__racketloneventsmanager` (`name`, `type`, `link`, `singles`, `doubles`, `startdate`, `enddate`, `location`, `postcode`, `teams`, `dated`, `year`)
VALUES
('Test event 1', 'International', 'www.racketlon.co.uk', TRUE, FALSE, '2016-04-03', '2016-04-03', 'Oxford', 'OX5 2BB', TRUE, TRUE, '2016'),
('Test event 2', 'National tour', 'www.google.com', FALSE, TRUE, '2016-05-03', '2016-05-04', 'Cambridge', 'CB5 8BL', FALSE, FALSE, '2016');