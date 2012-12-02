/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

/*
function getStationData(){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');
	
	jImc.ajax({
		type : 'POST',
		url : 'index.php',
		datatype: 'json',
		data: jImc('#com_sensethecity_postdata').serialize(),
		success: function(data){
			jImc('#waitingIndicator').html('');

		}

	});
}
*/


$(document).ready(function(){
	//
});



function getStationInfo(stationId, token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStationInfo&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicator').html('');
			jImc('#stationInfo').html(data.html);
		}		
	});
}

function getLatestStationMeasures(stationId, token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getLatestStationMeasures&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicator').html('');
			jImc('#stationLatestMeasures').html(data.html);
		}		
	});
}

function getMaxMeasures(token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicatorStatistics').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getMaxMeasures&format=json&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicatorStatistics').html('');
			jImc('#measureStatistics').html(data.html);
		}		
	});
}

function getStationMeasuresGraphTabs(stationId, token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicatorGraphTabs').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStationPhenomenon&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicatorGraphTabs').html('');
			jImc('#graphTabs').html(data.html);

			//trick to allow displaying graphs and also autoheight current tab afterwards
			jImc('a[href=#tab'+data.phenom[1].id+']').tab('show');
			jImc('a[href=#tab'+data.phenom[0].id+']').tab('show');
			
			//click on tab to load 1st graph
			jImc('a[href=#tab'+data.phenom[0].id+']').click();
			
		}		
	});
}

function getStaPhenObservationGraph(stationId, phenId, token){

	var base = window.com_sensethecity.base;
	jImc('#waitingIndicatorGraphTabs').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStaPhenObservation&format=json&stationId=' + stationId + '&phenId=' + phenId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicatorGraphTabs').html('');

			stcCandleStickGraph("graphContainer"+phenId, data, phenId, token);
			
			
			/*
			stcCandleStickGraph("graphContainer"+data.phenom.id, 
					  data.graphdata,
					  data.phenom.description, 
					  'Ημερομηνία', 
					  data.phenom.unit, 
					  data.phenom.name,
					  data.phenom.lower,
					  data.phenom.upper,
					  'κάτω όριο',
					  'άνω όριο',
					  token
					  );
			
			
			for(a=0;a<data.phenom.length;a++){
				stcGraph("graphContainer"+data.phenom[a].id, 
										  data.graphdata[data.phenom[a].id],
										  data.phenom[a].description, 
										  'Ημερομηνία', 
										  data.phenom[a].unit, 
										  data.phenom[a].name,
										  data.phenom[a].lower,
										  data.phenom[a].upper,
										  'κάτω όριο',
										  'άνω όριο'
										  );
				
				break; //do not call all phenomenons together... get it only if user change tab
			}
			*/
			
		}		
	});
}


