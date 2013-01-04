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
		
		//for every phenonomenon get daily average and merge
		$i = 0;
		foreach($latest as $item){
			$avg = $model->getLatestObservationDailyAvg($stationId, $item['id']);
			$latest[$i]['avg'] = $avg;
			$i++;
		}
	
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

		$phenom = $model->getStationPhenomenon($stationId, $phenId);		
		//$graphdata = $model->getObservation($stationId, $phenId);
		$graphdata = $model->getObservationDailyAvg($stationId, $phenId);

		
		$dataTable = array(
			'cols' => array(
				// each column needs an entry here, like this:
				//array('label' => 'Ημερομηνία', 'type' => 'datetime'),
				array('label' => 'Ημερομηνία', 'type' => 'date'),
				array('label' => 'Άνω όριο', 'type' => 'number'),
				array('label' => 'Μέση ημερήσια τιμή', 'type' => 'number'),
				array('label' => 'Κάτω όριο', 'type' => 'number')
			)
		);	

		
		foreach($graphdata as $data) {
			
			//$date = DateTime::createFromFormat("Y-n-j G:i:s", $data[0]);
			$date = DateTime::createFromFormat("Y-n-j", $data[0]);
			$year =  $date->format("Y");
			$month =  $date->format("n");
			$day =  $date->format("j");
			//$hour =  $date->format("G");
			//$minute =  intval($date->format("i"));
			//$second =  $date->format("s");
									
			
			$dataTable['rows'][] = array(
				'c' => array (
					//array('v' => "Date({$year},{$month},{$day},{$hour},{$minute},{$second})", 'f' => "{$data[0]}"),
					array('v' => "Date({$year},{$month},{$day})", 'f' => "{$data[0]}"),
					array('v' => $phenom[0]['upper']),
					array('v' => $data[1]),
					array('v' => $phenom[0]['lower'])
				)
			);
		}		
		
		
		$ret['graphdata'] = $dataTable;	//raw db records from table observation for specified station and phenomenon
		$ret['phenom'] = $phenom[0];	//phenom is one record containing phenomenon names and min,max values

		//echo json_encode($dataTable);
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
