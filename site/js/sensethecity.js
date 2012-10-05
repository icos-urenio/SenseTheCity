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


				//create a container for the new comment
			/*
				var content = '<div class="imc-chat"><span class="imc-chat-info">'+data.comments.textual_descr+'</span><span class=\"imc-chat-desc\">'+data.comments.description+'</span><div>';
				div = jImc(content).prependTo("#imc-comments-wrapper");
				jImc("#imc-comment-area").val('');
				div.effect("highlight", {color: '#60FF05'}, 1500);
			*/
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
		data: 'option=com_sensethecity&task=mobile.getStationObservation&format=json&stationId=' + stationId + '&' + token + '=1',
		success: function(data){
			jImc('#waitingIndicator').remove();
			jImc("#stationMeasures").html("ok");
			
			basic_bars_thermiSensors("graphContainer",data);
			//alert(data);
			
	
			
			
		}		
	});
}