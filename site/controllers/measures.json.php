<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.controller');
jimport('joomla.application.component.helper');

class SensethecityControllerMeasures extends JController
{
	/*
	 * get info like title, geolocation and what measure types (CO2, etc) the station supports
	 */
	public function getStationInfo()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');

		//get request
		$stationId = JRequest::getInt('stationId');		
		
		//get station info
		$model = $this->getModel('measurements');
		$station = $model->getStationInfo($stationId);
		
		//get station phenomenon
		$phen = $model->getStationPhenomenon($stationId);
		
		$ret['html'] = SensethecityHelper::formatStationInfoData($station, $phen); 
		echo json_encode($ret);
		return;
	}
	
	/*
	 * get the latest measures of the specified station
	 */
	public function getLatestStationMeasures()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
	
		//get request
		$stationId = JRequest::getInt('stationId');
	
		//get station info
		$model = $this->getModel('measurements');
		//get station last measures from sensors
		$latest = $model->getStationLastMeasures($stationId);
	
		$ret['html'] = SensethecityHelper::formatLatestStationMeasures($latest);
		echo json_encode($ret);
		return;
	}	
	

	/*
	 * get Max Measures for every measurement type from every station
	 */
	public function getMaxMeasures()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
	
		//get station info
		$model = $this->getModel('measurements');
		$items = $model->getMaxMeasures();
	
		$ret['html'] = SensethecityHelper::formatMaxMeasures($items);
		echo json_encode($ret);
		return;
	}	
	
	/*
	public function getStationOffering()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
		//get model and items
		$model = $this->getModel('measurements');
		$items = array();
		$items	= $model->getOffering();
		echo json_encode($items);
		return;		
	}*/
	
	public function getStaPhenObservation()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
		
		
		//get request
		$stationId = JRequest::getInt('stationId');
		$phenId = JRequest::getInt('phenId');

		$model = $this->getModel('measurements');

		$phenomenons = $model->getStationPhenomenon($stationId);		
		
		//get data items for every phenomenon
		$items = array();
		$phenom = array();
		
		foreach($phenomenons as $phen){
			if($phen['id'] == $phenId) {
				$items[0] = $model->getObservation($stationId, $phen['id']);
				$phenom[0] = array('id' => $phen['id'], 
									'name' => $phen['name'], 
									'unit' => $phen['unit'], 
									'description' => $phen['description'], 
									'upper' => $phen['upper'], 
									'lower' => $phen['lower']);
				break;			
			}
		}

		$ret['graphdata'] = $items;
		$ret['phenom'] = $phenom;

		echo json_encode($ret);
		return;
	}
	
	
	public function getStationPhenomenon()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');

		//get request
		$stationId = JRequest::getInt('stationId');
		$model = $this->getModel('measurements');
		
		$phenomenons = $model->getStationPhenomenon($stationId);
		$ret['phenom'] = $phenomenons;
		$ret['html'] = SensethecityHelper::formatGraphTabs($phenomenons);
		echo json_encode($ret);
		return;
	}
	
	
	

}
