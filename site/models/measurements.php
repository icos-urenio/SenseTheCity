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
	
	function IsGarbage($calibratedValue, $phenId)
	{
		$limits = $this->getCarbageLimits($phenId);
		if( $calibratedValue > $limits['garbagemax'] || $calibratedValue < $limits['garbagemin'])
			return true;
		return false;
	} 
	
	function insertMeasurements($measurements)
	{
		/*
		ob_start();
		echo 'hello';
		echo $measurements;
		$var = ob_get_contents();
		ob_end_clean();
		$fp=fopen('zlog2.txt','w');
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
			if(!empty($station['measurements']) && !empty($station['datetime']) && $station['id'] != '?'){
				$sql .= 'INSERT INTO `#__sensethecity_observation` (`station_id`, `measurement_datetime`, `phenomenon_id`, `numeric_value`, `corrected_value`, `battery`, `temperature`, `serial`) VALUES '. "\r";
				foreach($station['measurements'] as $data){
					if(  isset($data['raw'])  && isset($data['value']) ) {
						$receivedCorrectly = true;
						
						//make datetime from custom string						
						$dtString = $station['datetime'];
						$dt = str_split($dtString, 2);
						$dt = "20{$dt[0]}-{$dt[1]}-{$dt[2]} {$dt[3]}:{$dt[4]}:00";
						

						//get a, b for calibration
						$ab = $this->getStaPhenAB($station['id'], $data['sensor']);
						if(!empty($ab)){
							$a = $ab[0]['a'];
							$b = $ab[0]['b'];
							$calibrated = ($data['raw'] - $b) / $a;												
						}
						else{
							$calibrated = $data['raw'];
						}
						
						
						//check if calibrated value is outside garbage limits.
						if ( $this->IsGarbage($calibrated, $data['sensor']) )
							return -1;
						
						/*
						ob_start();
						echo 'raw=' . $data['raw'];
						echo 'a='.$a;
						echo 'b='.$b;
						print_r($ab);
						echo 'station=' . $station['id'];
						echo 'sensor='. $data['sensor'];
						echo 'calibrated='. $calibrated;
						$var = ob_get_contents();
						ob_end_clean();
						$fp=fopen('zlog.txt','w');
						fputs($fp,$var);
						fclose($fp);
						*/						
						
						$sql .= "('{$station['id']}','{$dt}','{$data['sensor']}','{$data['raw']}','{$calibrated}','{$station['battery']}','{$station['temperature']}','{$station['serial']}')," . "\r";
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
	
	
	function getCarbageLimits($phenId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('a.garbagemin, a.garbagemax');
		$query->from('`#__sensethecity_phenomenon` AS a');
		$query->where('a.id='.$phenId);
		$query->where('a.state=1');
	
		$db->setQuery($query);
		$result = $db->loadAssoc();
		return $result;
	}	
	
	
	function getStations()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('a.id, a.title');
		$query->from('`#__sensethecity` AS a');
		$query->where('a.state=1');
	
		$db->setQuery($query);
		$result = $db->loadAssocList();
		return $result;
	}	
	
	
	function getStationLastMeasures($stationId)
	{

		// Create a new query object.
		$db		= $this->getDbo();

		$query = '
			SELECT a.*, c.id, c.name, c.unit, s.max_phen_value, s.min_phen_value 
			FROM `#__sensethecity_observation` AS a
			LEFT JOIN `#__sensethecity_phenomenon` AS c on c.id = a.phenomenon_id 
			LEFT JOIN `#__sensethecity_sta_phen` AS s on c.id = s.phenomenon_id AND s.station_id = ' .$stationId. '
			WHERE a.measurement_datetime = ( 
			SELECT MAX( b.measurement_datetime ) AS latest
			FROM `#__sensethecity_observation` AS b
			WHERE b.station_id = '.$stationId.' ) AND a.station_id = ' . $stationId . ' '.
			'ORDER BY c.id'; 
		
		
		$db->setQuery($query);
		$result = $db->loadAssocList();
		return $result;
	}
	
	function getStationPhenomenon($stationId, $phenId = null)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('b.id AS id, b.name AS name, b.unit AS unit, b.description AS description, a.max_phen_value AS upper, a.min_phen_value AS lower');
		$query->from('#__sensethecity_sta_phen AS a');
		$query->where('a.station_id='.$stationId);
		if($phenId != null)
			$query->where('b.id='.$phenId);
		$query->join('LEFT', '`#__sensethecity_phenomenon` AS b on b.id = a.phenomenon_id');

		$db->setQuery($query);
		$result = $db->loadAssocList();

		return $result;
	}
	

	function getStaPhenAB($stationId, $phenId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('a.a, a.b');
		$query->from('#__sensethecity_sta_phen AS a');
		$query->where('a.station_id='.$stationId);
		$query->where('a.phenomenon_id='.$phenId);
	
		$db->setQuery($query);
		$result = $db->loadAssocList();
	
		return $result;
	}
	
	
	function getMaxMeasures()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('c.id, c.title AS station, b.name, MAX( a.corrected_value ) AS maximum, b.unit, a.measurement_datetime AS inserted');
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
	
	function getObservation($stationId, $phenomenonId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		//$query->select('a.measurement_datetime, a.corrected_value');
		$query->select('a.timestamp, a.corrected_value');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		$query->where('a.phenomenon_id='.$phenomenonId);
		//$query->order('a.measurement_datetime ASC');
		$query->order('a.timestamp ASC');
		
		//TODO: Debug only.. remove limit
		$query .= " limit 200";
		
		$db->setQuery($query);
		$result = $db->loadRowList();
	
		//convert datetime so as to display graphically (ticks)
		/*
		$i = 0;
		foreach($result as $res){
			$result[$i][0] = (int)(strtotime( $res[0] )*1000 );
			$i++;
		}
		*/
		
		
		return $result;
	}	
	
	
	function getObservationDailyAvg($stationId, $phenomenonId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		$query->select('DATE( (a.`timestamp`) ) AS `timestamp`,	AVG(a.`corrected_value`) AS `corrected_value`');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		$query->where('a.phenomenon_id='.$phenomenonId);
		$query->group('DATE( (a.`timestamp`) )');
		$query->order('a.timestamp ASC');
	

		/*
		 
		SELECT 
			DATE( (a.`timestamp`) ) AS `timestamp`, 
			AVG(a.`corrected_value`) AS `corrected_value`
		
		FROM `batb5_sensethecity_observation` AS a
		WHERE 
			a.`station_id` = 3 AND
		        a.`phenomenon_id` = 7
			
		GROUP BY DATE( (a.`timestamp`) )
		ORDER BY a.`timestamp`
				
		
		
		*/		

	
		$db->setQuery($query);
		$result = $db->loadRowList();

	
		return $result;
	}	
	
	
	function getLatestObservationDailyAvg($stationId, $phenomenonId)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select('AVG(a.`corrected_value`) AS `corrected_value`');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		$query->where('a.phenomenon_id='.$phenomenonId);
		$query->group('DATE( (a.`timestamp`) )');
		$query->order('a.timestamp DESC LIMIT 1');
	
		$db->setQuery($query);
		$result = $db->loadResult();
	
	
		return $result;
	}	
	
}
