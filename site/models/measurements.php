<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Model
 */
class SensethecityModelMeasurements extends JModel
{
	function insertMeasurements($measurements)
	{
		/*
		ob_start();
		echo 'hello';
		$var = ob_get_contents();
		ob_end_clean();
		$fp=fopen('zlog.txt','w');
		fputs($fp,$var);
		fclose($fp);
		*/
		
		$sql = '';
		$errors = 0;
		$receivedCorrectly = false;
		$input = json_decode($measurements, true);
		if(empty($input))
			return -1;
		
		foreach ($input as $station){
			if(!empty($station['measurements']) && !empty($station['datetime']) ){
				$sql .= 'INSERT INTO `#__sensethecity_observation` (`station_id`, `measurement_datetime`, `phenomenon_id`, `numeric_value`, `corrected_value`) VALUES '. "\r";
				foreach($station['measurements'] as $data){
					if(  isset($data['raw'])  && isset($data['value']) ) {
						$receivedCorrectly = true;
						
						//make datetime from custom string						
						$dtString = $station['datetime'];
						$dt = str_split($dtString, 2);
						$dt = "20{$dt[0]}-{$dt[1]}-{$dt[2]} {$dt[3]}:{$dt[4]}:00";
												
						$sql .= "('" . $station['id'] . "','" . $dt . "','" . $data['sensor'] . "','" . $data['raw'] . "','" . $data['value'] . "')," . "\r";
					}
					else{
						$errors++;
					}
				}
				$sql = substr($sql, 0, -2);
				$sql .= ';';
			}
			else {
				//just in case measurements are completely empty
				return -1;				
			}
		}
		
		//if at least one record received correctly insert into DB
		if($receivedCorrectly){
			$db	= $this->getDbo();
			$db->setQuery($sql);
			
			if (!$db->query()) {
				$this->setError($db->getErrorMsg());
				return -1;
			}
			
			//also return the number of sensor errors if any... (0 if none)
			return $errors;
				
		}
		else {
			//all went wrong			
			return -1;
		}

	}
	
	
	function getStationInfo($stationId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.*');
		$query->from('`#__sensethecity` AS a');
		$query->where('a.id='.$stationId);
		$query->where('a.state=1');
		
		$db->setQuery($query);
		$result = $db->loadAssoc();	
		return $result;
	}	
	
	function getStationLastMeasures($stationId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		/*
		$query	= $db->getQuery(true);
		$query->select('a.*, MAX(a.measurement_datetime) AS latest');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		$query->where('a.measurement_datetime=latest');
		*/
		$query = '
			SELECT a.*, c.name, c.unit  
			FROM `#__sensethecity_observation` AS a
			LEFT JOIN `#__sensethecity_phenomenon` AS c on c.id = a.phenomenon_id
			WHERE a.measurement_datetime = ( 
			SELECT MAX( b.measurement_datetime ) AS latest
			FROM `#__sensethecity_observation` AS b
			WHERE b.station_id = '.$stationId.' )'; 
		
		$db->setQuery($query);
		$result = $db->loadAssocList();
		return $result;
	}
	
	function getStationPhenomenon($stationId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('b.name');
		$query->from('#__sensethecity_sta_phen AS a');
		$query->where('a.station_id='.$stationId);
		$query->join('LEFT', '`#__sensethecity_phenomenon` AS b on b.id = a.phenomenon_id');
	
		$db->setQuery($query);
		$result = $db->loadResultArray();
		return $result;
	}
	
	function getMaxMeasures()
	{
		
		/*
		 SELECT c.title, b.name, MAX(a.corrected_value) AS maximum, b.unit, DATE_FORMAT(a.time_stamp_inserted,"%W, %M %e, %Y @ %h:%i %p") AS inserted
		FROM batb5_sensethecity_observation AS a
		LEFT JOIN batb5_sensethecity_phenomenon AS b on b.id = a.phenomenon_id
		LEFT JOIN batb5_sensethecity AS c on c.id = a.station_id
		GROUP BY a.phenomenon_id
		 */	
		
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('c.title AS station, b.name, MAX( a.corrected_value ) AS maximum, b.unit, a.measurement_datetime AS inserted');
		$query->from('#__sensethecity_observation AS a');
		$query->join('LEFT', '#__sensethecity_phenomenon AS b on b.id = a.phenomenon_id');
		$query->join('LEFT', '#__sensethecity AS c on c.id = a.station_id');		
		$query->group('a.phenomenon_id');	
		$db->setQuery($query);
		$result = $db->loadAssocList();
		return $result;
	}	
	
	
	
	function getOffering()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('a.*');
		$query->from('`#__sensethecity_offering` AS a');
	
		$db->setQuery($query);
		$result = $db->loadRowList();
	
		return $result;
	}	
	
	function getObservation($stationId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.measurement_datetime, a.corrected_value');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		
		$db->setQuery($query);
		$result = $db->loadRowList();
	
		return $result;
	}	
}
