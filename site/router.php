<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */


function SensethecityBuildRoute(&$query)
{
	$segments = array();

	if (isset($query['view'])) {
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if (isset($query['station_id'])) {
		$segments[] = $query['station_id'];
		unset($query['station_id']);
	}	
	if (isset($query['task'])) {
		$segments[] = $query['task'];
		unset($query['task']);
	}

	if (isset($query['controller'])) {
		$segments[] = $query['controller'];
		unset($query['controller']);
	}
			
	return $segments;
}


function SensethecityParseRoute( $segments )
{
       $vars = array();
	   switch($segments[0])
       {
			case 'station':
				$vars['view'] = 'station';
				$vars['station_id'] = (int) $segments[1];				   
			break;
			case 'stations':
				$vars['view'] = 'stations';
				if(@$segments[1] == 'sensethecity')
					$vars['controller'] = 'sensethecity';
			break;
			case 'printStation':
				$vars['task'] = 'printStation';
				$vars['controller'] = 'sensethecity';
				$vars['station_id'] = (int) $segments[0];
			break;				
			case 'printStations':
				$vars['task'] = 'printStations';
				$vars['controller'] = 'sensethecity';
			break;			
       }
	   
	   //TODO: revision needed...
	   if(isset($segments[1])){
			switch($segments[1]){
				case 'printStation':
					$vars['task'] = 'printStation';
					$vars['controller'] = 'sensethecity';
					$vars['station_id'] = (int) $segments[0];
				break;			
				case 'printStations':
					$vars['task'] = 'printStations';
					$vars['controller'] = 'sensethecity';
				break;						
			}
	   }
	   
       return $vars;
}
