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
		
		//get station last measures from sensors
		$latest = $model->getStationLastMeasures($stationId);
		
		$ret['html'] = SensethecityHelper::formatStationInfoData($station, $phen, $latest); 
		echo json_encode($ret);
		return;
	}

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
	
	public function getStationOffering()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
		//get model and items
		$model = $this->getModel('measurements');
		$items = array();
		$items	= $model->getOffering();
		echo json_encode($items);
		return;		
	}
	
	public function getStationObservation()
	{
		JRequest::checkToken('get') or jexit('Invalid Token');
		
		//get request
		$stationId = JRequest::getInt('stationId');		
		
		//get model and items
		$model = $this->getModel('measurements');
		$items = array();
		$items	= $model->getObservation($stationId);
		echo json_encode($items);
		return;
	}
	
	

}
