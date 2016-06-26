CREATE TABLE `#__rankings_config` (
	`property`		VARCHAR(10),
	`value`      	VARCHAR(20),
	PRIMARY KEY (`property`)
)
	ENGINE =MyISAM
	DEFAULT CHARSET =utf8mb4
	COLLATE utf8mb4_unicode_ci;
	
INSERT INTO `#__rankings_config` (`property`, `value`) VALUES ('updating', '0');