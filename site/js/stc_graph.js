/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

//function stcCandleStickGraph(element, input, mainTitle, xtitle, ytitle, label, lower, upper, low_label, upp_label, token) {
function stcLineGraph(element, input, phenId, stationId, title, unit, lower, upper, token) {
	
	if (typeof input.rows === 'undefined')
		return;
	
	mainTitle = title + " (" + unit + ")";
		
	/* USE THIS FOR ALL MEASUREMENTS
	var i =input.rows.length - 1;
	var d = input.rows[i].c[0].f;
	var n = d.split(" "); 
	var res = n[0].split("-");
	var year = res[0];
	var month = res[1];
	var day = res[2];
	var startDate = new Date(year, month, day);
	startDate.setDate(startDate.getDate() - 2);
	var endDate = new Date(year, month, day);
	*/
	
	
	/* USE THIS FOR DAILY AVERAGE  */
	var i =input.rows.length - 1;
	var d = input.rows[i].c[0].f;
	var res = d.split("-"); 
	var year = res[0];
	var month = res[1];
	var day = res[2];
	var startDate = new Date(year, month, day);
	startDate.setDate(startDate.getDate() - 4);
	var endDate = new Date(year, month, day);

	
	
	function draw() {
		drawVisualization();
		drawToolbar();
	}

	function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
             document.getElementById(element));
        
         var control = new google.visualization.ControlWrapper({
           'controlType': 'ChartRangeFilter',
           'containerId': element+'control',
           'options': {
        	   
             // Filter by the date axis.
             'filterColumnIndex': 0,
             'ui': {
               'chartType': 'LineChart',
               'chartOptions': {
                 'chartArea': {'width': '100%'},
                 'hAxis': {'baselineColor': '#ffffff'}

               },
               // Display a single series that shows the timeline.
               // Thus, this view has two columns: the date (axis) and the daily average (line series).
               'chartView': {
                 'columns': [0, 2]
               },
               // 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
               'minRangeSize': 86400000 * 2
             }
           },
           // Initial range: 
           'state': {'range': {'start': startDate, 'end': endDate }}
         });
      
         var chart = new google.visualization.ChartWrapper({
           'chartType': 'LineChart',
           'containerId': element+'chart',
           'options': {
        	 'title': mainTitle,
             'hAxis': {'slantedText': false},
             //'vAxis': {'slantedText': false, 'title':unit},

             //'vAxis': {'viewWindow': {'min': lower, 'max': upper}},
             'colors': ['#DC3912','#3366CC','#9F4E3B'],
             'legend': {'position':'right'},
             'chartArea':{'left':40,'top':20, 'width':"80%",'height':"70%"}             
           },
           // Convert the first column from 'date' to 'string'.
           
           'view': {
             'columns': [
               {
                 'calc': function(dataTable, rowIndex) {
                   return dataTable.getFormattedValue(rowIndex, 0);
                 },
                 'type': 'string'
               }, 1, 2]
           }
           
         });

         var data = new google.visualization.DataTable(input);
         
         dashboard.bind(control, chart);
         dashboard.draw(data);
                  
    }	
	
	
    function drawToolbar() {
        var components = [
            //{type: 'html', datasource: 'index.php?option=com_sensethecity&task=measures.getStaPhenObservation&format=json&stationId=' + stationId + '&phenId=' + phenId + '&' + token + '=1;out:html'},
            {type: 'csv', datasource:  'index.php?option=com_sensethecity&task=measures.getStaPhenObservation&format=json&stationId=' + stationId + '&phenId=' + phenId + '&' + token + '=1;out:html'}
        ];

        var container = document.getElementById('graphToolbar');
        google.visualization.drawToolbar(container, components);
    };
    
	google.setOnLoadCallback(draw());
	
}



