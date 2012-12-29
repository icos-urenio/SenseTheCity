<?php
/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */
 
abstract class SensethecityHelper
{
	/* 
	*	Simple helper to add itemid to every link so as to match joomla's active menu id 
	*
	*/
	public function generateRouteLink($link) {
		return JRoute::_($link.'&amp;Itemid='.JRequest::getint( 'Itemid' ));
	}	

	public function formatStationInfoData($data, $phen) {

		$phenList = '(';
		foreach ($phen as $ph){
			$phenList .= $ph['name'] . ',';
		}
		$phenList = substr($phenList, 0, -1);
		$phenList .= ')';
		
		$html  = '<div id="station-info-wrapper">';
		$html .= '<h2>' . $data['title'] . '</h2>';
		$html .= '<span class="extra-info"><i title="'.JText::_('COM_SENSETHECITY_EXTRA_INFO').'" class="icon-info-sign"></i> ' .$data['description'] . '</span>';
		$html .= '<span class="extra-info"><i title="'.JText::_('COM_SENSETHECITY_GEOLOCATION').'"class="icon-map-marker"></i> LAT: ' . $data['latitude'].' , LON: '.$data['longitude'] . '</span>';
		//$html .= '<span class="extra-info"><i title="'.JText::_('COM_SENSETHECITY_MEASUREMENTS').'"class="icon-th-list"></i> ' .$phenList . '</span>';
		$html .= '</div>';
		
		return $html;
	}
	
	public function formatLatestStationMeasures($latest) {
	
		//latest values
		$html = '
		<table class="table table-striped">
	
		<caption>'.JText::_('COM_SENSETHECITY_LATEST_MEASUREMENTS').'</caption>
		<thead>
		<tr>
		<th>'.JText::_('COM_SENSETHECITY_MEASURE').'</th>
		<th>'.JText::_('COM_SENSETHECITY_VALUE').'</th>
		</tr>
		</thead>
		<tbody>
		';
	
		foreach($latest as $item){
			$html .='<tr>';
			$html .= '<td>' . $item['name'] . '</td> ';
			
			//$val = ($item['name'] == 'CO2' ? $item['corrected_value'] / 1.0e+156 : $item['corrected_value'] );
			$val = $item['corrected_value'];
			
			$html .= '<td>' . number_format(round(floatval($val),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';
			$html .='</tr>';
		}
		
		$html .= '</tbody></table>';
		$html .= '<i title="'.JText::_('COM_SENSETHECITY_LAST_MEASUREMENT_DATE').'"class="icon-time"></i> ' .date("d/m/Y H:i",strtotime($latest[0]['measurement_datetime'])) . '<br />';	
		
		
		return $html;
	}	
	

	public function formatGraphTabs($phenomenons) 
	{

	
		
		$html = '
		<div class="row-fluid">
			<div class="span12">
				
			<div id="waitingIndicatorGraphTabs"></div>
			
			<div class="row-fluid"	
				<div class="span12">
					<div id="graphToolbar" class="pull-right"></div>
				</div>
			</div>	
				
			<div class="tabbable tabs-below" style="margin: 2em 0;"> 
			<div class="tab-content">';

		foreach($phenomenons as $phenomenon){
			$html .= '
				<div class="tab-pane active" id="tab'.$phenomenon['id'].'">
					
					<div id="graphContainer'.$phenomenon['id'].'" style="width:95%; height:280px; margin: 8px auto;">
				        <div id="graphContainer'.$phenomenon['id'].'chart" style="width: 100%; height: 230px;"></div>
        				<div id="graphContainer'.$phenomenon['id'].'control" style="width: 100%; height: 50px;"></div>							
					</div>
				</div>';
		}
		
		$html .= '
			</div>
			<ul class="nav nav-tabs">
		';
		
		$i = 0;
		foreach($phenomenons as $phenomenon){
			$i++;	
			if($i == 1){
				$html .= '<li class="active"><a href="#tab'.$phenomenon['id'].'" data-toggle="tab">'.$phenomenon['name'].'</a></li>';
			}
			else{
				$html .= '<li><a href="#tab'.$phenomenon['id'].'" data-toggle="tab">'.$phenomenon['name'].'</a></li>';
			}
		}
		$html .= '
				</ul>
			</div>
		';
		
		$html .= '
			</div>
		</div>					
		';
		
		
		//set also onclick for each tab
		$html .= '<script type="text/javascript">';
		foreach($phenomenons as $phenomenon){
			$html .= "
			jImc('a[href=#tab".$phenomenon['id']."]').click(function (e) {
				e.preventDefault();
				getStaPhenObservationGraph(getCurrentStationId(), ".$phenomenon['id'].", '".JUtility::getToken()."');
			})
			";
		}
		$html .= '</script>';		
		
		return $html;
	}
	
	
	public function formatMaxMeasures($items) {
		$html  = '
		<table class="table table-striped">
		
		<caption>'.JText::_('COM_SENSETHECITY_MAX_MEASUREMENTS').'</caption>
		<thead>
		<tr>
		<th>'.JText::_('COM_SENSETHECITY_MEASURE').'</th>
		<th>'.JText::_('COM_SENSETHECITY_STATION').'</th>
		<th>'.JText::_('COM_SENSETHECITY_VALUE').'</th>
		<th>'.JText::_('COM_SENSETHECITY_DATE').'</th>
		</tr>
		</thead>
		<tbody>
		';
		
		
		foreach($items as $item){
			$html .='<tr>';
			$html .= '<td>' . $item['name'] . '</td> ';
			$html .= '<td><a href="javascript:void(0);" onclick="markerclick('.$item['id'].')">' . $item['station'] . '</a></td> ';
			
			//$val = ($item['name'] == 'CO2' ? $item['maximum'] / 1.0e+156 : $item['maximum'] );
			$val = $item['maximum'];
			
			$html .= '<td>' . number_format(round(floatval($val),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';

			$html .= '<td>' . date("d/m/Y H:i",strtotime($item['inserted'])) . '</td> ';
			$html .='</tr>';
		}
		
		$html .= '</tbody></table>';
		
		
		return $html;
	}
		
	public static function getRelativeTime($time)
	{
		if(strtotime($time) <= 0)
			return '';
		
		// Load the parameters.
		$app = JFactory::getApplication();
		$params	= $app->getParams();
		$showrelativedates = $params->get('showrelativedates');		
		$dateformat = $params->get('dateformat');		
		
		if(!$showrelativedates){
			//$item->reported_rel = date("d/m/Y",strtotime($item->reported));
			return date($dateformat,strtotime($time));
		}
		
		$SECOND = 1;
		$MINUTE = 60 * $SECOND;
		$HOUR = 60 * $MINUTE;
		$DAY = 24 * $HOUR;
		$MONTH = 30 * $DAY;
 
		$delta = time() - strtotime($time);
		
		if ($delta < 1 * $MINUTE)
		{
			return $delta == 1 ? JText::_('ONE_SECOND_AGO') : sprintf(JText::_('SECONDS_AGO'), $delta);
		}
		if ($delta < 2 * $MINUTE)
		{
		  return JText::_('A_MINUTE_AGO');
		}
		if ($delta < 45 * $MINUTE)
		{
			return sprintf(JText::_('MINUTES_AGO'), floor($delta / $MINUTE));
		}
		if ($delta < 90 * $MINUTE)
		{
		  return JText::_('AN_HOUR_AGO');
		}
		if ($delta < 24 * $HOUR)
		{
		  return sprintf(JText::_('HOURS_AGO'), floor($delta / $HOUR));
		}
		if ($delta < 48 * $HOUR)
		{
		  return JText::_('YESTERDAY');
		}
		if ($delta < 30 * $DAY)
		{
			return sprintf(JText::_('DAYS_AGO'), floor($delta / $DAY));
		}
		if ($delta < 12 * $MONTH)
		{
		  $months = floor($delta / $DAY / 30);
		  return $months <= 1 ? JText::_('ONE_MONTH_AGO') : sprintf(JText::_('MONTHS_AGO'), $months);
		}
		else
		{
			$years = floor($delta / $DAY / 365);
			if(years < 100)	//TODO: needed for versions older than PHP5.3
				return $years <= 1 ? JText::_('ONE_YEAR_AGO') : sprintf(JText::_('YEARS_AGO'), $years);
			else
				return '';
		}

	}

}

