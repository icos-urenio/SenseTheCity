
CREATE TABLE IF NOT EXISTS `#__sensethecity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `serial` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `description` text,
  `address` text,
  `email` text,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__sensethecity_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skey` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

INSERT INTO `#__sensethecity_keys` (`skey`) VALUES ('1234567890123456');

CREATE TABLE IF NOT EXISTS `#__sensethecity_offering` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `description` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__sensethecity_offering` (`name`, `description`) VALUES ('Weather','weather information e.g. temperature, humidity');
INSERT INTO `#__sensethecity_offering` (`name`, `description`) VALUES ('AirQuality','air quality information e.g. O3, CO, CO2');

CREATE TABLE IF NOT EXISTS `#__sensethecity_phenomenon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `description` varchar(255),
  `unit` varchar(30) NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('temperature','measurements of temperature expressed as double value', 'oC');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('humidity','percentage of humidity', '%');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('CO','measurements of carbon monoxide expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('CO2','measurements of carbon dioxide expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('NO2','measurements of nitrogen dioxide expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('NH3','measurements of ammonium hydroxide or ammonia expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('SH2','measurements of Hydrogen sulfide expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('C2H6O', 'measurements of ethanol expressed as double value', 'ug/m3');
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit) VALUES ('C7H8', 'measurements of toluene expressed as double value', 'ug/m3');

CREATE TABLE IF NOT EXISTS `#__sensethecity_observation` ( 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `phenomenon_id` int(11) NOT NULL,
  `time_stamp` TIMESTAMP NOT NULL,
  `time_stamp_inserted` TIMESTAMP NOT NULL,
  `numeric_value` DOUBLE,
  `corrected_value` DOUBLE,
  `battery` int(11),
  `temperature` DOUBLE,
  `serial` varchar(100),
  PRIMARY KEY(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;


INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,1,'2012-09-11 11:00:00','2012-09-11 11:03:00',63, 63);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,3,'2012-09-11 11:00:00','2012-09-11 11:03:00',70, 70);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,5,'2012-09-11 11:00:00','2012-09-11 11:03:00',66.7, 66.7);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,7,'2012-09-11 11:00:00','2012-09-11 11:03:00',69.1, 69.1);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,1,'2012-09-11 11:00:00','2012-09-11 11:03:00',59.2, 59.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,3,'2012-09-11 11:00:00','2012-09-11 11:03:00',53.3, 53.3);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,5,'2012-09-11 11:00:00','2012-09-11 11:03:00',54.5, 54.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,7,'2012-09-11 11:00:00','2012-09-11 11:03:00',47.5, 47.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,1,'2012-09-11 11:00:00','2012-09-11 11:03:00',40.9, 40.9);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,3,'2012-09-11 11:00:00','2012-09-11 11:03:00',89, 89);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,5,'2012-09-11 11:00:00','2012-09-11 11:03:00',77.65, 77.65);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,7,'2012-09-11 11:00:00','2012-09-11 11:03:00',98.23, 98.23);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:00:00','2012-09-11 11:03:00',63, 63);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,1,'2012-09-11 11:00:00','2012-09-11 11:03:00',70, 70);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-09-11 11:00:00','2012-09-11 11:03:00',66.7, 66.7);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,5,'2012-09-11 11:00:00','2012-09-11 11:03:00',69.1, 69.1);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,4,'2012-09-11 11:00:00','2012-09-11 11:03:00',59.2, 59.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,6,'2012-09-11 11:00:00','2012-09-11 11:03:00',53.3, 53.3);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,8,'2012-09-11 11:00:00','2012-09-11 11:03:00',54.5, 54.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,9,'2012-09-11 11:00:00','2012-09-11 11:03:00',47.5, 47.5);

INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:05:00','2012-09-11 11:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:10:00','2012-09-11 11:03:00',58, 58);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:15:00','2012-09-11 11:03:00',45, 45);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:20:00','2012-09-11 11:03:00',65, 65);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:25:00','2012-09-11 11:03:00',25, 25);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:30:00','2012-09-11 11:03:00',67, 67);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:35:00','2012-09-11 11:03:00',56, 56);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:40:00','2012-09-11 11:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:45:00','2012-09-11 11:03:00',49, 49);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:50:00','2012-09-11 11:03:00',48, 48);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 11:55:00','2012-09-11 11:03:00',55, 55);

INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:05:00','2012-09-11 11:03:00',35, 35);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:10:00','2012-09-11 11:03:00',48, 48);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:15:00','2012-09-11 11:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:20:00','2012-09-11 11:03:00',61, 61);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:25:00','2012-09-11 11:03:00',33, 33);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:30:00','2012-09-11 11:03:00',45, 45);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:35:00','2012-09-11 11:03:00',56, 56);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:40:00','2012-09-11 11:03:00',44, 44);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:45:00','2012-09-11 11:03:00',74, 74);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:50:00','2012-09-11 11:03:00',54, 54);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 12:55:00','2012-09-11 11:03:00',51, 51);


INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:05:00','2012-09-11 11:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:10:00','2012-09-11 11:03:00',58, 58);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:15:00','2012-09-11 11:03:00',45, 45);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:20:00','2012-09-11 11:03:00',65, 65);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:25:00','2012-09-11 11:03:00',25, 25);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:30:00','2012-09-11 11:03:00',67, 67);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:35:00','2012-09-11 11:03:00',56, 56);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:40:00','2012-09-11 11:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:45:00','2012-09-11 11:03:00',49, 49);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:50:00','2012-09-11 11:03:00',48, 48);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-12 11:55:00','2012-09-11 11:03:00',55, 55);


INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:05:00','2012-09-11 11:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:10:00','2012-09-11 11:03:00',52, 52);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:15:00','2012-09-11 11:03:00',45, 45);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:20:00','2012-09-11 11:03:00',62, 62);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:25:00','2012-09-11 11:03:00',25, 25);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:30:00','2012-09-11 11:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:35:00','2012-09-11 11:03:00',56, 56);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:40:00','2012-09-11 11:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:45:00','2012-09-11 11:03:00',40, 40);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:50:00','2012-09-11 11:03:00',48, 48);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-15 11:55:00','2012-09-11 11:03:00',51, 51);

INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:05:00','2012-09-11 11:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:10:00','2012-09-11 11:03:00',54, 54);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:15:00','2012-09-11 11:03:00',45, 45);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:20:00','2012-09-11 11:03:00',65, 65);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:25:00','2012-09-11 11:03:00',42, 42);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:30:00','2012-09-11 11:03:00',67, 67);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:35:00','2012-09-11 11:03:00',56, 56);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:40:00','2012-09-11 11:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:45:00','2012-09-11 11:03:00',47, 47);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:50:00','2012-09-11 11:03:00',43, 43);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-18 11:55:00','2012-09-11 11:03:00',53, 53);
               
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,1,'2012-09-11 13:00:00','2012-09-11 13:03:00',50, 50);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,3,'2012-09-11 13:00:00','2012-09-11 13:03:00',60, 60);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,5,'2012-09-11 13:00:00','2012-09-11 13:03:00',65, 65);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (1,7,'2012-09-11 13:00:00','2012-09-11 13:03:00',63, 63);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,1,'2012-09-11 13:00:00','2012-09-11 13:03:00',61.2, 61.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,3,'2012-09-11 13:00:00','2012-09-11 13:03:00',50,50);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,5,'2012-09-11 13:00:00','2012-09-11 13:03:00',48.5, 48.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (2,7,'2012-09-11 13:00:00','2012-09-11 13:03:00',51.5, 51.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,1,'2012-09-11 13:00:00','2012-09-11 13:03:00',42.9, 42.9);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,3,'2012-09-11 13:00:00','2012-09-11 13:03:00',91.5, 91.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,5,'2012-09-11 13:00:00','2012-09-11 13:03:00',77.2, 77.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,7,'2012-09-11 13:00:00','2012-09-11 13:03:00',94.44, 94.44);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (3,4,'2012-09-11 13:00:00','2012-09-11 13:03:00',55, 55);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,1,'2012-09-11 13:00:00','2012-09-11 13:03:00',72, 72);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-09-11 13:00:00','2012-09-11 13:03:00',63.7, 63.7);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,5,'2012-09-11 13:00:00','2012-09-11 13:03:00',69.5, 69.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,4,'2012-09-11 13:00:00','2012-09-11 13:03:00',56.2, 56.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,6,'2012-09-11 13:00:00','2012-09-11 13:03:00',57.3, 57.3);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,8,'2012-09-11 13:00:00','2012-09-11 13:03:00',54, 54);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,9,'2012-09-11 13:00:00','2012-09-11 13:03:00',47, 47);
                          
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 18:00:00','2012-10-11 18:03:00',68,68);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 19:00:00','2012-10-11 19:03:00',71,70);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 20:00:00','2012-10-11 20:03:00',70.5,70.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 21:00:00','2012-10-11 21:03:00',70.8,70.8);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 22:00:00','2012-10-11 22:03:00',69.5,69.5);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-10-11 23:00:00','2012-10-11 23:03:00',69.8,69.8);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 00:00:00','2012-11-11 00:03:00',70.1,70.1);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 01:00:00','2012-11-11 01:03:00',70.7,70.7);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 02:00:00','2012-11-11 02:03:00',73,73);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 03:00:00','2012-11-11 03:03:00',72.2,72.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 04:00:00','2012-11-11 04:03:00',71.2,71.2);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 05:00:00','2012-11-11 05:03:00',69.7,69.7);
INSERT INTO `#__sensethecity_observation`  (station_id, phenomenon_id, time_stamp, time_stamp_inserted, numeric_value, corrected_value) VALUES (4,3,'2012-11-11 06:00:00','2012-11-11 06:03:00',68.5,68.5);


CREATE TABLE IF NOT EXISTS `#__sensethecity_phen_off` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phenomenon_id` int(11) NOT NULL,
  `offering_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (1,1);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (2,1);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (3,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (4,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (5,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (6,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (7,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (8,2);
INSERT INTO `#__sensethecity_phen_off` (phenomenon_id, offering_id) VALUES (9,2);

CREATE TABLE IF NOT EXISTS `#__sensethecity_sta_phen` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `phenomenon_id` int(11) NOT NULL,  
  `min_phen_value` FLOAT,
  `max_phen_value` FLOAT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,3,0,55);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,4,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,5,0,30);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,6,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,7,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,8,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (1,9,0,60);

INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,3,0,55);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,4,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,5,0,30);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,6,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,7,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,8,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (2,9,0,60);

INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,3,0,55);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,4,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,5,0,30);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,6,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,7,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,8,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (3,9,0,60);

INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,3,0,55);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,4,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,5,0,30);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,6,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,7,0,65);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,8,0,45);
INSERT INTO `#__sensethecity_sta_phen` (station_id, phenomenon_id, min_phen_value, max_phen_value) VALUES (4,9,0,60);
