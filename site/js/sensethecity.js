/*sensethecity js*/
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

function getStationMeasuresGraph(stationId, token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').html('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStationObservation&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicator').html('');
			basic_bars_thermiSensors("graphContainer",data);
			
		}		
	});
}




