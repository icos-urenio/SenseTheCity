/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

function stcGraph(element, input, mainTitle, xtitle, ytitle, label, lower, upper, low_label, upp_label, token) {
	
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
                 'chartArea': {'width': '90%'},
                 'hAxis': {'baselineColor': 'none'}
               },
               // Display a single series that shows the closing value of the stock.
               // Thus, this view has two columns: the date (axis) and the stock value (line series).
               'chartView': {
                 'columns': [0, 3]
               },
               // 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
               'minRangeSize': 86400000
             }
           },
           // Initial range: 2012-02-09 to 2012-03-20.
           'state': {'range': {'start': new Date(2012, 9, 1), 'end': new Date(2012, 10, 1)}}
         });
      
         var chart = new google.visualization.ChartWrapper({
           'chartType': 'CandlestickChart',
           'containerId': element+'chart',
           'options': {
        	 'title':mainTitle,
             // Use the same chart area width as the control for axis alignment.
             'chartArea': {'height': '80%', 'width': '90%'},
             'hAxis': {'slantedText': false},
             'vAxis': {'viewWindow': {'min': 0, 'max': 2000}},
             'legend': {'position': 'none'}
           },
           // Convert the first column from 'date' to 'string'.
           'view': {
             'columns': [
               {
                 'calc': function(dataTable, rowIndex) {
                   return dataTable.getFormattedValue(rowIndex, 0);
                 },
                 'type': 'string'
               }, 1, 2, 3, 4]
           }
         });
      
         var data = new google.visualization.DataTable();
         data.addColumn('date', 'Date');
         data.addColumn('number', 'Κάτω όριο');
         data.addColumn('number', 'Χαμηλό ημέρας');
         data.addColumn('number', 'Υψηλό ημέρας');
         data.addColumn('number', 'Άνω όριο');
      
         // Create random stock values, just like it works in reality.
         var open, close = 300;
         var low, high;
         for (var day = 1; day < 365; ++day) {
           var change = (Math.sin(day / 2.5 + Math.PI) + Math.sin(day / 3) - Math.cos(day * 0.7)) * 150;
           change = change >= 0 ? change + 10 : change - 10;
           open = close;
           close = Math.max(50, open + change);
           low = Math.min(open, close) - (Math.cos(day * 1.7) + 1) * 15;
           low = Math.max(0, low);
           high = Math.max(open, close) + (Math.cos(day * 1.3) + 1) * 15;
           var date = new Date(2012, 0 ,day);
           data.addRow([date, Math.round(low), Math.round(open), Math.round(close), Math.round(high)]);
         }
         
         dashboard.bind(control, chart);
         dashboard.draw(data);
    }	
	
	
    function drawToolbar() {
        var components = [
            {type: 'html', datasource: 'https://spreadsheets.google.com/tq?key=pCQbetd-CptHnwJEfo8tALA'},
            {type: 'csv', datasource:  'https://spreadsheets.google.com/tq?key=pCQbetd-CptHnwJEfo8tALA'},
        ];

        var container = document.getElementById('graphToolbar');
        google.visualization.drawToolbar(container, components);
    };
	
	
	
	google.setOnLoadCallback(draw());


	
}



