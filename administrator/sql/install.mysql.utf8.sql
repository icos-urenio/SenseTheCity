
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
  `garbagemin` double NOT NULL,
  `garbagemax` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('temperature','measurements of temperature expressed as double value', 'oC', -20, 80);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('humidity','percentage of humidity', '%', 0, 100);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('CO','measurements of carbon monoxide expressed as double value', 'ug/m3', 0, 10);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('CO2','measurements of carbon dioxide expressed as double value', 'ug/m3', 0, 1500);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('NO2','measurements of nitrogen dioxide expressed as double value', 'ug/m3', 0.1, 1);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('NH3','measurements of ammonium hydroxide or ammonia expressed as double value', 'ug/m3', 0, 400);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('SH2','measurements of Hydrogen sulfide expressed as double value', 'ug/m3', 0, 0.1);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('C2H6O', 'measurements of ethanol expressed as double value', 'ug/m3', 0, 1500);
INSERT INTO `#__sensethecity_phenomenon` (name, description, unit, garbagemin, garbagemax) VALUES ('C7H8', 'measurements of toluene expressed as double value', 'ug/m3',0, 900);

CREATE TABLE IF NOT EXISTS `#__sensethecity_observation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `phenomenon_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `measurement_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `numeric_value` double DEFAULT NULL,
  `corrected_value` double DEFAULT NULL,
  `battery` int(11) NOT NULL,
  `temperature` double NOT NULL,
  `serial` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT COLLATE=utf8_general_ci;


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
  `x1` DOUBLE NOT NULL DEFAULT '0',
  `y1` DOUBLE NOT NULL DEFAULT '0',
  `x2` DOUBLE NOT NULL DEFAULT '0',
  `y2` DOUBLE NOT NULL DEFAULT '0', 
  `a` DOUBLE NOT NULL DEFAULT '0',
  `b` DOUBLE NOT NULL DEFAULT '0',  
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
