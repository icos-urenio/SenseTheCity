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
	
		if(empty($latest))
			return "";
		
		//latest values
		$html = '
		<table class="table table-striped">
	
		<caption>'.JText::_('COM_SENSETHECITY_LATEST_MEASUREMENTS').'</caption>
		<thead>
		<tr>
		<th>'.JText::_('COM_SENSETHECITY_MEASURE').'</th>
		<th>'.JText::_('COM_SENSETHECITY_VALUE').'</th>
		<th>'.JText::_('COM_SENSETHECITY_LIMIT').'</th>
		<th>'.JText::_('COM_SENSETHECITY_AVG').'</th>
		</tr>
		</thead>
		<tbody>
		';
		
		foreach($latest as $item){
			$html .= ($item['corrected_value'] > $item['max_phen_value'] || $item['corrected_value'] < $item['min_phen_value'] ? '<tr class="over">':'<tr class="under">');
			$html .= '<td>' . $item['name'] . '</td> ';
			$html .= '<td>' . number_format(round(floatval($item['corrected_value']),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';
			$html .=  '<td>' . $item['max_phen_value'] . ' ' . $item['unit'] . '</td> ';
			$html .=  '<td>' . number_format(round(floatval($item['avg']),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';
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
			
			<div class="row-fluid">	
				<div class="span8">
					<h3>'.JText::_('COM_SENSETHECITY_DAILY_AVG').'</h3>
				</div>
				
				<div class="span4">
					<div id="graphToolbar" class="pull-right"></div>
				</div>
					
			</div>	
			
								
			<div class="tabbable tabs-below"> 
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
			$html .= '<td>' . number_format(round(floatval($item['maximum']),1), 1, ',', '') . ' ' . $item['unit'] . '</td> ';

			$html .= '<td>' . date("d/m/Y H:i",strtotime($item['inserted'])) . '</td> ';
			$html .='</tr>';
		}
		
		$html .= '</tbody></table>';
		
		
		return $html;
	}
		
	
	public function formatSummaryTable($stations) {
		$html  = '
		<table class="table sumtable">
	
		<caption>'.JText::_('COM_SENSETHECITY_SUMMARY_TABLE').'</caption>
		<thead>
		<tr>
		';
		
		foreach($stations as $station){
			$html .='<th><a href="javascript:void(0);" onclick="markerclick('.$station['id'].')">' . $station['title']. '</a></th>';
		}

		$html .= '
		</tr>
		</thead>
		<tbody>
		';
		
		$s = count($stations);
		foreach($stations as $station){
			$a = -1;
			foreach($station['latest'] as $item){
				$a++;
				$html .='<tr>';
				for($i=0;$i < $s; $i++){
					//$html .= '<td class="cell_under"><span>' . $item['name'] . '</span></td> ';
					if(isset($stations[$i]['latest'][$a]['name'])){
						$over = ($stations[$i]['latest'][$a]['corrected_value'] > $stations[$i]['latest'][$a]['max_phen_value'] || $stations[$i]['latest'][$a]['corrected_value'] < $stations[$i]['latest'][$a]['min_phen_value'] ? true:false);
						$value = number_format(round(floatval($stations[$i]['latest'][$a]['corrected_value']),1), 1, ',', '') . $stations[$i]['latest'][$a]['unit'];
						$lower = number_format(round(floatval($stations[$i]['latest'][$a]['min_phen_value']),1), 1, ',', '') . $stations[$i]['latest'][$a]['unit'];
						$upper = number_format(round(floatval($stations[$i]['latest'][$a]['max_phen_value']),1), 1, ',', ''). $stations[$i]['latest'][$a]['unit'];
						$timestamp = $stations[$i]['latest'][$a]['timestamp'];
						
						if($over)
							$html .= '<td title="Η τελευταία μέτρηση στις '.$timestamp.', '.$value.' είναι εκτός ορίων ('.$lower.' - '.$upper.')" class="cell_over"><span>' . $stations[$i]['latest'][$a]['name'] . '</span></td> ';
						else
							$html .= '<td title="Μέτρηση εντός ορίων ('.$value.')" class="cell_under"><span>' . $stations[$i]['latest'][$a]['name'] . '</span></td> ';
					}
					else
						$html .= '<td title="Δεν υπάρχει διαθέσιμη μέτρηση" class="cell_nan"><span>' . '</span></td> ';
				}
				$html .='</tr>';
			}
			
		}
		
	
		$html .= '</tbody></table>';

	
		return $html;
	}	
	

}

