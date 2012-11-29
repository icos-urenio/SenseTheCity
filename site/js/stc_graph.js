/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

function stcGraph(element, input, mainTitle, xtitle, ytitle, label, lower, upper, low_label, upp_label) {
	
	function draw() {
		drawChart();
		drawToolbar();
	}
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([
			['Mushrooms', 3],
			['Onions', 4],
			['Olives', -2],
			['Zucchini', 1],
			['Pepperoni', 2]
			]);
	
	function drawChart() {
		// Create the data table.
	
		// Set chart options
		var options = {
			'title':mainTitle,
			'width':'100%',
			'height':'100%'};
		
		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById(element));
		chart.draw(data, options);
			
	}		
	//
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


// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.


