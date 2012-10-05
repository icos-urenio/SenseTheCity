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
