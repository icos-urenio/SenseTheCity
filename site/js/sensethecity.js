/*sensethecity js*/
function getStationData(){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').append('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');
	
	jImc.ajax({
		type : 'POST',
		url : 'index.php',
		datatype: 'json',
		data: jImc('#com_sensethecity_postdata').serialize(),
		success: function(data){
			jImc('#waitingIndicator').remove();

		}

	});
}


function getStationInfo(stationId, token){
	//var base = window.com_sensethecity.base;
	//jImc('#waitingIndicator').append('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStationInfo&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			//jImc('#waitingIndicator').remove();
			jImc('#stationInfo').html(data.html);
		}		
	});
}

function getMaxMeasures(token){
	//var base = window.com_sensethecity.base;
	//jImc('#waitingIndicator').append('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getMaxMeasures&format=json&' + token + '=1',
		success: function(data){
			//jImc('#waitingIndicator').remove();
			jImc('#measureStatistics').html(data.html);
		}		
	});
}

function getStationMeasures(stationId, token){
	var base = window.com_sensethecity.base;
	jImc('#waitingIndicator').append('<div id="ajaxBusy"><p><img src="'+base+'/components/com_sensethecity/images/ajax-loader.gif"></p></div>');

	jImc.ajax({
		type : 'GET',
		url : 'index.php',
		datatype: 'json',
		data: 'option=com_sensethecity&task=measures.getStationObservation&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicator').remove();
			basic_bars_thermiSensors("graphContainer",data);
			
		}		
	});
}




