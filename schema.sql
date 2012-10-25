-- Create syntax for TABLE 'regions'
CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'voters'
CREATE TABLE `voters` (
  `voter_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL DEFAULT '',
  `allowed` int(1) NOT NULL,
  `ssn` char(9) DEFAULT NULL,
  PRIMARY KEY (`voter_id`),
  KEY `region_id` (`region_id`),
  CONSTRAINT `voters_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'zipcodes'
CREATE TABLE `zipcodes` (
  `region_id` int(11) NOT NULL,
  `zipcode` char(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`region_id`,`zipcode`),
  CONSTRAINT `zipcodes_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;