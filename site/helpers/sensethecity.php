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
		foreach ($phen as $name){
			$phenList .= $name . ',';
		}
		$phenList = substr($phenList, 0, -1);
		$phenList .= ')';
		
		$html  = '';
		$html .= '<h2>' . $data['title'] . '</h2>';
		$html .= '<i class="icon-info-sign"></i> ' .$data['description'] . '<br />';
		$html .= '<i class="icon-map-marker"></i> LAT: ' . $data['latitude'].' , LON: '.$data['longitude'] . '<br />';
		$html .= '<i class="icon-th-list"></i> ' .$phenList . '<br />';
		return $html;
	}
	
	public function formatMaxMeasures($items) {
		$html  = '';
		foreach($items as $item){
			$html .= $item['unit'] . ' ' . $item['maximum'] . '<br />';
		}
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

