DROP TABLE IF EXISTS `#__players`;
 
CREATE TABLE `#__players` (
	`id`        INT(11)     	NOT NULL AUTO_INCREMENT,
	`name`      VARCHAR(100) 	NOT NULL,
	`gender`    BOOLEAN,
	`dob`       DATE,
	`country`	VARCHAR(10),
	`rating`	INT,
	`ratingtt`	INT,
	`ratingbd`	INT,
	`ratingsq`	INT,
	`ratingtn`	INT,
	`class`		VARCHAR(2),
	`classtt`	VARCHAR(2),
	`classbd`	VARCHAR(2),
	`classsq`	VARCHAR(2),
	`classtn`	VARCHAR(2),
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;




DROP TABLE IF EXISTS `#__matches`;
 
CREATE TABLE `#__matches` (
	`id`        	INT 	    	NOT NULL AUTO_INCREMENT,
	`tournament`	VARCHAR(200) 	NOT NULL,
	`tour`		    VARCHAR(10)		NOT NULL,
	`matchNo`		INT 			NOT NULL,
	`date`       	DATE			NOT NULL,
	`p1id`			INT				NOT NULL,
	`p2id`			INT				NOT NULL,
	`p2name`		VARCHAR(100)	NOT NULL,
	`p1rating`		INT				NOT NULL,
	`p2rating`		INT 			NOT NULL,
	`p1ratingtt`	INT				NOT NULL,
	`p2ratingtt`	INT 			NOT NULL,
	`p1ratingbd`	INT				NOT NULL,
	`p2ratingbd`	INT 			NOT NULL,
	`p1ratingsq`	INT				NOT NULL,
	`p2ratingsq`	INT 			NOT NULL,
	`p1ratingtn`	INT				NOT NULL,
	`p2ratingtn`	INT 			NOT NULL,
	`tt1`			SMALLINT		NOT NULL,
	`tt2`			SMALLINT		NOT NULL,
	`bd1`			SMALLINT		NOT NULL,
	`bd2`			SMALLINT		NOT NULL,
	`sq1`			SMALLINT		NOT NULL,
	`sq2`			SMALLINT		NOT NULL,
	`tn1`			SMALLINT		NOT NULL,
	`tn2`			SMALLINT		NOT NULL,
	`tot1`			SMALLINT		NOT NULL,
	`tot2`			SMALLINT		NOT NULL,
	`p1ratingchg`	INT				NOT NULL,
	`p1ratingchgtt`	INT				NOT NULL,
	`p1ratingchgbd`	INT				NOT NULL,
	`p1ratingchgsq`	INT				NOT NULL,
	`p1ratingchgtn`	INT				NOT NULL,
	`bonus`			INT 			NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;