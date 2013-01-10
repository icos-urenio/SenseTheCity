#1.0.0
ALTER TABLE `#__sensethecity_observation`
CHANGE `timestamp` `timestamp`
TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP


ALTER TABLE `batb5_sensethecity_phenomenon` ADD `garbagemin` DOUBLE NOT NULL ,
ADD `garbagemax` DOUBLE NOT NULL 
