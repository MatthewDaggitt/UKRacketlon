ALTER TABLE `#__players` MODIFY `dob` DATE;
ALTER TABLE `#__players` MODIFY `gender` BOOLEAN;




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
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;