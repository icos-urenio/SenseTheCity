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
		return "TODO: insert into database this: " . $measurements;	
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
		
		$query->select('c.title AS station, b.name, MAX( a.corrected_value ) AS maximum, b.unit, a.time_stamp_inserted AS inserted');
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
		
		$query->select('a.time_stamp, a.corrected_value');
		$query->from('`#__sensethecity_observation` AS a');
		$query->where('a.station_id='.$stationId);
		
		$db->setQuery($query);
		$result = $db->loadRowList();
	
		return $result;
	}	
}
