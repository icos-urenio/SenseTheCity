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

jimport('joomla.application.component.view');

/**
 * HTML View class for the Sensethecity component
 */
class SensethecityViewStations extends JView
{
	protected $state;
	protected $items;
	protected $categories;
	protected $pagination;
	protected $params;
	protected $pageclass_sfx;
	protected $customMarkers = '';
	protected $filters = '';
	protected $markers = '';
	protected $statusFilters = '';
	protected $getLimitBox = '';
	protected $language = '';
	protected $region = '';
	protected $lat = '';
	protected $lon = '';
	protected $searchterm = '';
	protected $zoom;
	protected $loadjquery;
	protected $loadbootstrap;
	protected $loadbootstrapcss;
	protected $credits;
	protected $arCat;
	protected $loadjqueryui;
	
	public $f = '';	
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$this->params		= $app->getParams();
		
		//remove || from title
		$strip_title = $this->params->get('page_title');
		$strip_title = str_replace('||', '', $strip_title);
		$this->params->set('page_title', $strip_title);
		
		$this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));
		$this->state = $this->get('State');		
		
		// Get some data from the models
		$this->items	= $this->get('Items');
		//echo json_encode($this->items);
		$this->categories = $this->get('Categories');
		$this->pagination	= $this->get('Pagination');
		$this->arCat = $this->createFiltersAsArray($this->categories);
		$this->createFilters($this->categories);				
		$this->statusFilters = $this->createStatusFilters();
		$this->getLimitBox = $this->createLimitBox();

		//merge params
		$this->params	= $this->state->get('params');
		
		$lang = $this->params->get('maplanguage');
		$region = $this->params->get('mapregion');
		$lat = $this->params->get('latitude');
		$lon = $this->params->get('longitude');
		$term = $this->params->get('searchterm');
		$zoom = $this->params->get('zoom');
		$this->loadjquery = $this->params->get('loadjquery');
		$this->loadbootstrap = $this->params->get('loadbootstrap');
		$this->loadbootstrapcss = $this->params->get('loadbootstrapcss');
		$this->credits = $this->params->get('credits');
		$this->showcomments = $this->params->get('showcomments');
		$this->approveissue = $this->params->get('approveissue');
		$this->loadjqueryui = $this->params->get('loadjqueryui');		
		
		$this->language = (empty($lang) ? "en" : $lang);
		$this->region = (empty($region) ? "GB" : $region);
		$this->lat = (empty($lat) ? 40.54629751976399 : $lat);
		$this->lon = (empty($lon) ? 23.01861169311519 : $lon);
		$this->searchterm = (empty($term) ? "" : $term);
		$this->zoom = (empty($zoom) ? 17 : $zoom);

		
		
		//testing: retrieve data from another model
		//$model = $this->getModel('issue');
		//$item = $model->getItem();		
		//testing ends
		

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
        parent::display($tpl);
		
		// Set the document
		$this->setDocument();
		
		
	}
	
	protected function createFilters($cats = array())
	{
		$filter_category = $this->state->get('filter_category');	
	
		$this->filters .= '<ul>';
		foreach($cats as $JCatNode){
			//id is the category id
			if(empty($filter_category)){
				if($JCatNode->parentid == 'root')		
					$this->filters .='<li><input path="'.$JCatNode->path.'" parent="box'.$JCatNode->parentid.'" name="cat[]" value="'.$JCatNode->id.'" type="checkbox" checked="checked" id="cat-'.$JCatNode->id.'" onclick="boxclick2(this,'.$JCatNode->id.')" /><span class="root">'.$JCatNode->title.'</span></li>' . "\n";
				else
					$this->filters .='<li><input path="'.$JCatNode->path.'" parent="box'.$JCatNode->parentid.'" name="cat[]" value="'.$JCatNode->id.'" type="checkbox" checked="checked" id="cat-'.$JCatNode->id.'" onclick="boxclick2(this,'.$JCatNode->id.')" />'.$JCatNode->title.'</li>' . "\n";
			}
			else{
				if($JCatNode->parentid == 'root'){
					$this->filters .='<li><input path="'.$JCatNode->path.'" parent="box'.$JCatNode->parentid.'" name="cat[]" value="'.$JCatNode->id.'" type="checkbox" '; if(in_array($JCatNode->id, $filter_category)) $this->filters .= 'checked="checked"'; $this->filters .= ' id="cat-'.$JCatNode->id.'" onclick="boxclick2(this,'.$JCatNode->id.')" /><span class="root">'.$JCatNode->title.'</span></li>' . "\n";
				}
				else{
					$this->filters .='<li><input path="'.$JCatNode->path.'" parent="box'.$JCatNode->parentid.'" name="cat[]" value="'.$JCatNode->id.'" type="checkbox" '; if(in_array($JCatNode->id, $filter_category)) $this->filters .= 'checked="checked"'; $this->filters .= ' id="cat-'.$JCatNode->id.'" onclick="boxclick2(this,'.$JCatNode->id.')" />'.$JCatNode->title.'</li>' . "\n";
				}	
			}
			
			if(!empty($JCatNode->children)){
				$this->createFilters($JCatNode->children);
			}
		
		}
		$this->filters .= '</ul>';

		return $this->filters;
	}
	
	protected function createFiltersAsArray($cats)
	{
		$ar[] = null;
		foreach($cats as $cat){
			$this->filters = '';
			$ar[] = $this->createFilters(array($cat));
		}
		$this->filters = '';
		return $ar;
	}
	
	protected function createStatusFilters()
	{
		$filter_status = $this->state->get('filter_status');
		$html = '';
		if(empty($filter_status)){
			//$html = '<ul>';
			$html .= '<li style="display: inline;"><input name="status[]" value="1" type="checkbox" checked="checked" id="status-1" />'.JText::_('OPEN').'</li>' . "\n";
			$html .= '<li style="display: inline;"><input name="status[]" value="2" type="checkbox" checked="checked" id="status-2" />'.JText::_('ACK').'</li>' . "\n";
			$html .= '<li style="display: inline;"><input name="status[]" value="3" type="checkbox" checked="checked" id="status-3" />'.JText::_('CLOSED').'</li>' . "\n";
			//$html .= '</ul>';
		}
		else {
			//$html = '<ul>';
			$html .= '<li style="display: inline;"><input name="status[]" value="1" type="checkbox" '; if(in_array(1, $filter_status)) $html .= 'checked="checked"'; $html .= ' id="status-1" />'.JText::_('OPEN').'</li>' . "\n";
			$html .= '<li style="display: inline;"><input name="status[]" value="2" type="checkbox" '; if(in_array(2, $filter_status)) $html .= 'checked="checked"'; $html .= ' id="status-2" />'.JText::_('ACK').'</li>' . "\n";
			$html .= '<li style="display: inline;"><input name="status[]" value="3" type="checkbox" '; if(in_array(3, $filter_status)) $html .= 'checked="checked"'; $html .= ' id="status-3" />'.JText::_('CLOSED').'</li>' . "\n";
			//$html .= '</ul>';
		}
		return $html;
	}	
	

	protected function createLimitBox()
	{
		$selected = $this->state->get('list.limit');
		$html = '';
		$values = array (10, 20, 100, 0);
		foreach($values as $i){
			$a = $i;
			if($a == 0)
				$a = JText::_('ALL');
			if($selected == $i){
				$html .= '<li><a href="#" onclick="jImc(\'input[name=limit]\').val('.$i.');jImc(\'#adminForm\').submit();">'.$a.' <i class="icon-ok"></i></a></li>';
			}
			else {
				$html .= '<li><a href="#" onclick="jImc(\'input[name=limit]\').val('.$i.');jImc(\'#adminForm\').submit();">'.$a.'</a></li>';
			}
		}
		return $html;
	}	

	
	protected function createCustomMarkers($cats = array())
    {
        if(is_array($cats))
        {
			
            $i = 0;
            $return = array();
            foreach($cats as $JCatNode)
            {
                $return[$i]->title = $JCatNode->title;
                $return[$i]->id = $JCatNode->id;

				$return[$i]->image = $JCatNode->image;

				if(!empty($return[$i]->image)){
					$this->customMarkers .= $return[$i]->id . ": {icon: '".JURI::root(true).'/'.$return[$i]->image."', shadow: '".JURI::root(true).'/images/markers/shadow.png'."' }," . "\n";
				}

				if(!empty($JCatNode->children))
                    $return[$i]->children = $this->createCustomMarkers($JCatNode->children);
                else
                    $return[$i]->children = false;
                $i++;
            }
            return $return;
        }
        return false;
    }		
	
	protected function getMarkersArrayFromItems() {
		$ar = array();
		foreach($this->items as $item){
			$ar[] = array('name'=>$item->title,
						'description'=>$item->description,
						'catid'=>$item->catid,
						'id'=>$item->id,
						'lat'=>$item->latitude,
						'lng'=>$item->longitude
						);
		}
		
		return $ar;
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		if($this->loadbootstrapcss == 1)
			$document->addStyleSheet(JURI::root(true).'/components/com_sensethecity/bootstrap/css/bootstrap.min.css');	
		
		$document->addStyleSheet(JURI::root(true).'/components/com_sensethecity/css/mega-menu.css');	
		$document->addStyleSheet(JURI::root(true).'/components/com_sensethecity/css/sensethecity.css');	
		

		//add scripts
		if($this->loadjquery == 1){
			$document->addScript(JURI::root(true).'/components/com_sensethecity/js/jquery-1.7.1.min.js');
			
			//jquery noConflict
			$document->addScriptDeclaration( 'var jImc = jQuery.noConflict();' );
		}
				
		if($this->loadbootstrap == 1)
			$document->addScript(JURI::root(true).'/components/com_sensethecity/bootstrap/js/bootstrap.min.js');


		//add google graph 
		$document->addScript('https://www.google.com/jsapi');
		$document->addScriptDeclaration("google.load('visualization', '1.1', {packages: ['corechart', 'controls']});");
		

		//add component's scrips
		$document->addScript(JURI::root(true).'/components/com_sensethecity/js/stc_graph.js');
		$document->addScript(JURI::root(true).'/components/com_sensethecity/js/sensethecity.js');
		
		//add google maps
		$document->addScript("https://maps.google.com/maps/api/js?sensor=false&language=". $this->language ."&region=". $this->region);
		$document->addScript(JURI::root(true).'/components/com_sensethecity/js/infobox_packed.js');
		$document->addScript(JURI::root(true).'/components/com_sensethecity/js/geolocationmarker-compiled.js');

		$document->addScriptDeclaration('var jsonMarkers = '.json_encode($this->getMarkersArrayFromItems()).';');
		
		$LAT = $this->lat;
		$LON = $this->lon;
		
		//prepare custom icons accordingly (get images from improvemycity categories)
		$this->createCustomMarkers($this->categories);
		$this->customMarkers = substr($this->customMarkers, 0, -2);	//remove /n and comma
		
		$googleMapInit = "
			var geocoder = new google.maps.Geocoder();
			var map = null;
			var GeoMarker;
			var gmarkers = [];
			
			
			function zoomIn() {
				map.setCenter(marker.getPosition());
				map.setZoom(map.getZoom()+1);
			}

			function zoomOut() {
				map.setCenter(marker.getPosition());
				map.setZoom(map.getZoom()-1);
			}
			
			var customIcons = {
			  ".$this->customMarkers."
			};
			
			// Creating a LatLngBounds object
			var bounds = new google.maps.LatLngBounds();			
			var infoWindow = null;
			var infoBox = null;

			function initialize() {
				var LAT = ".$LAT.";
				var LON = ".$LON.";

				var latLng = new google.maps.LatLng(LAT, LON);
				map = new google.maps.Map(document.getElementById('mapCanvas'), {
				zoom: ".$this->zoom.",
				center: latLng,
				panControl: false,
				streetViewControl: false,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL
				},
				mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				
			    draw_circle = new google.maps.Circle({
			        strokeWeight: 2,
			        fillOpacity: 0.1,
			    });				
				
				GeoMarker = new GeolocationMarker(map, null, draw_circle);
				GeoMarker.setMinimumAccuracy(250);

				infoWindow = new google.maps.InfoWindow;
				
				var infoBoxOptions = {
					disableAutoPan: false
					,maxWidth: 0
					,pixelOffset: new google.maps.Size(-100, 0)
					,zIndex: null
					,boxStyle: { 
					  background: \"url(" . JURI::base().'components/com_sensethecity/images/tipbox.gif' . ") -40px 0 no-repeat\"
					  ,opacity: 0.75
					  ,width: \"200px\"
					 }
					,closeBoxMargin: \"10px 2px 2px 2px\"
					,closeBoxURL: \"https://www.google.com/intl/en_us/mapfiles/close.gif\"
					,infoBoxClearance: new google.maps.Size(1, 1)
					,isHidden: false
					,pane: \"floatPane\"
					,enableEventPropagation: false
				};
				infoBox = new InfoBox(infoBoxOptions);				

				for (var i = 0; i < jsonMarkers.length; i++) {
					var name = jsonMarkers[i].name;
					var description = jsonMarkers[i].description;
					var catid = jsonMarkers[i].catid;
					var id = jsonMarkers[i].id;

					var point = new google.maps.LatLng(
						parseFloat(jsonMarkers[i].lat),
						parseFloat(jsonMarkers[i].lng)
					);

					var html = '<strong>' + name + '</strong>';
					var icon = customIcons[catid] || {};
					var marker = new google.maps.Marker({
						map: map,
						position: point,
						title: name,
						icon: icon.icon,
						shadow: icon.shadow,
						s: false
					});
					
					marker.catid = catid;
					marker.id = id;
					marker.description = description;
					
					//bindInfoWindow(marker, map, infoWindow, html);
					bindInfoBox(marker, map, infoBox, html);
					
					gmarkers.push(marker);
				}

				resetBounds();

				google.maps.event.addListenerOnce(map, 'idle', function(){
					google.maps.event.trigger(gmarkers[gmarkers.length-1], 'click'); //FIRST POI IS SELECTED BY DEFAULT (TODO: set this on settings) 
				});
				
				jImc(\"#loading\").hide();
			}

			function bindInfoWindow(marker, map, infoWindow, html) {
			  google.maps.event.addListener(marker, 'click', function() {
				infoWindow.setContent(html);
				infoWindow.open(map, marker);
				map.panTo(marker.getPosition());
				//showInfo(marker);
			  });
			}
			
			//alternative to infoWindow is the infoBox
			function bindInfoBox(marker, map, infoWindow, html) {
				var boxText = document.createElement(\"div\");
				boxText.style.cssText = \"border: 1px solid black; margin-top: 8px; background-color: yellow; padding: 5px;\";
				boxText.innerHTML = html;			
		
				google.maps.event.addListener(marker, 'click', function() {
					infoBox.setContent(boxText);
					infoBox.open(map, marker);
					showInfo(marker.id);					
				});
			  
				google.maps.event.addListener(marker, 'mouseover', function() {
					//infoBox.setContent(boxText);
					//infoBox.open(map, marker);
				});			  
				
				google.maps.event.addListener(marker, 'mouseout', function() {
					//infoBox.close();
				});			  
			}			
			
			function downloadUrl(url, callback) {
			  var request = window.ActiveXObject ?
				  new ActiveXObject('Microsoft.XMLHTTP') :
				  new XMLHttpRequest;

			  request.onreadystatechange = function() {
				if (request.readyState == 4) {
				  request.onreadystatechange = doNothing;
				  callback(request, request.status);
				  resetBounds();
				}
			  };

			  request.open('GET', url, true);
			  request.send(null);
			}

			function doNothing() {}
			
			function resetBounds() {
				var a = 0;
				bounds = null;
				bounds = new google.maps.LatLngBounds();
				for (var i=0; i<gmarkers.length; i++) {
					if(gmarkers[i].getVisible()){
						a++;
						bounds.extend(gmarkers[i].position);	
					}
				}
				if(a > 0){
					map.fitBounds(bounds);
					var listener = google.maps.event.addListener(map, 'idle', function() { 
					  if (map.getZoom() > 16) map.setZoom(16); 
					  google.maps.event.removeListener(listener); 
					});
				}
			}
			
			//show markers according to filtering
			function show(category) {
				// == check the checkbox ==
				document.getElementById('cat-'+category).checked = true;
			}			
			
			function hide(category) {
				// == clear the checkbox ==
				document.getElementById('cat-'+category).checked = false;
			}
			
			//--- non recursive since IE cannot handle it (doh!!)
			function boxclick2(box, category) {
				if (box.checked) {
					show(category);
				} else {
					hide(category);	
				}
				var com = box.getAttribute('path');
				var arr = new Array();
				arr = document.getElementsByName('cat[]');
				for(var i = 0; i < arr.length; i++)
				{
					var obj = document.getElementsByName('cat[]').item(i);
					var c = obj.id.substr(4, obj.id.length);

					var path = obj.getAttribute('path');
					if(com == path.substring(0,com.length)){
						if (box.checked) {
							obj.checked = true;
							show(c);
						} else {
							obj.checked = false;
							hide(c);
						}
					}
				}
				return false;
			}			
			
			function markerclick(id) {
				var index;
				for (var i=0; i<gmarkers.length; i++) {				
					gmarkers[i].s = false;
					if(gmarkers[i].id == id){
						index = i;
						gmarkers[i].s = true;	
					}
					
				}			
				google.maps.event.trigger(gmarkers[index],'click');
			}			

			function markerhover(id) {
				var index;
				for (var i=0; i<gmarkers.length; i++) {				
					if(gmarkers[i].id == id){
						index = i;
					}
				}
				google.maps.event.trigger(gmarkers[index],'mouseover');
			}
			
			function markerout(id) {
				var index;
				for (var i=0; i<gmarkers.length; i++) {				
					if(gmarkers[i].id == id){
						index = i;
						
					}
				}
				google.maps.event.trigger(gmarkers[index],'mouseout');

			}			
			//marker.id
			function showInfo(id){
			
				var index;
				for (var i=0; i<gmarkers.length; i++) {				
					gmarkers[i].s = false;
					if(gmarkers[i].id == id){
						index = i;
						gmarkers[i].s = true;	
					}
					
				}				
			
				getStationInfo(id, '".JUtility::getToken()."');
				getLatestStationMeasures(id, '".JUtility::getToken()."');
				getStationMeasuresGraphTabs(id, '".JUtility::getToken()."');
				getMaxMeasures('".JUtility::getToken()."');
			}

			function getCurrentStationId(){
				var sid;
				for (var i=0; i<gmarkers.length; i++) {				
					if(gmarkers[i].s == true){
						sid = gmarkers[i].id;
					}
				}
				return sid;
			}
			
			// Onload handler to fire off the app.
			google.maps.event.addDomListener(window, 'load', initialize);
		";

		
		$megamenu_js = "
		
		jImc(document).ready(function() {
		jImc(\".imc-issue-item\").mouseenter(function(event)
		{
		jImc(this).addClass(\"imc-highlight\");
		markerhover(jImc(this).attr('id').substring(8));
		});
		
		jImc(\".imc-issue-item\").mouseleave(function(event)
		{
		jImc(this).removeClass(\"imc-highlight\");
		markerout(jImc(this).attr('id').substring(8));
		});
		
		jImc(document).click(function(e) {
		if( jImc('#drop-1').is('.hover')) { jImc('#drop-1').removeClass('hover');	}
		if( jImc('#drop-2').is('.hover')) { jImc('#drop-2').removeClass('hover');	}
		if( jImc('#drop-3').is('.hover')) { jImc('#drop-3').removeClass('hover');	}
		});
			
		jImc('#btn-1').click(function(event)
		{
		if( jImc('#drop-2').is('.hover')) { jImc('#btn-2').click(); }
		if( jImc('#drop-3').is('.hover')) { jImc('#btn-3').click(); }
		
		if( jImc('#drop-1').is('.hover')) {
			jImc('#drop-1').removeClass('hover');
		}
		else{
			jImc('#drop-1').addClass('hover');
		}
		event.stopPropagation();
		});
			
		jImc('#btn-2').click(function(event)
		{
		if( jImc('#drop-1').is('.hover')) { jImc('#btn-1').click(); }
		if( jImc('#drop-3').is('.hover')) { jImc('#btn-3').click(); }
			
		if( jImc('#drop-2').is('.hover')) {
			jImc('#drop-2').removeClass('hover');
		}
		else{
			jImc('#drop-2').addClass('hover');
		}
		event.stopPropagation();
		});
		jImc('#btn-3').click(function(event)
		{
		if( jImc('#drop-1').is('.hover')) { jImc('#btn-1').click(); }
		if( jImc('#drop-2').is('.hover')) { jImc('#btn-2').click(); }
			
		if( jImc('#drop-3').is('.hover')) {
			jImc('#drop-3').removeClass('hover');
		}
		else{
			jImc('#drop-3').addClass('hover');
		}
		event.stopPropagation();
		});
			
		jImc('.megadrop').click(function(event) { event.stopPropagation();	});
			
		});
		";
		
		//add the javascript to the head of the html document
		$document->addScriptDeclaration($googleMapInit);
		$document->addScriptDeclaration($megamenu_js);
		
		
		//also pass base so as to display comment image indicator
		$js = "var com_sensethecity = {};\n";
		$js.= "com_sensethecity.base = '".JURI::root(true)."';\n";
		$document->addScriptDeclaration($js);		
		
	}
}
