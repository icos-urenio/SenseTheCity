/**
 * @version     1.0.0
 * @package     com_sensethecity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the Information Technologies Institute (CERTH/ITI)
 */

function basic_graph_thermiSensors(element, input, mainTitle, xtitle, ytitle, label, lower, upper, low_label, upp_label) {

	var container = document.getElementById(element);
	
	var upperdata = [];
	var lowerdata = [];
	var data = [];
	var point, i;

	// Generate first data set
	for (i = 0; i < input.length; i++) {
		//x = (new Date(input[i][0])).getTime();
		//x = +new Date(input[i][0]);
		x = input[i][0];

		y = input[i][1];
		y = Math.round(y*100)/100;
		data.push([x, y]);
		
		upperdata.push([x,upper]);
		lowerdata.push([x,lower]);
	}

	
	
	Flotr.draw(container, [
	    {
			data:data,
			label: label, 
			lines: {fill: true, show: true}
	    	//bars: {show: true, horizontal: false, shadowSize: 0, barWidth: 0.5}
		},
		{
			data:upperdata, 
			label: upp_label,
			lines: {fill: false, show: true}
		},
		{
			data:lowerdata, 
			label: low_label,
			lines: {fill: false, show: true}
		}
		
		],

		
		{
		title: label,
		subtitle: mainTitle,
		yaxis: {
			min: 0, 
			autoscale: true,
			autoscaleMargin: 1,
			title: ytitle
		},
        xaxis: {
        	autoscale: true,
			autoscaleMargin: 1,
			labelsAngle: 45,
            tickFormatter: function(o) {
                /* comment this block if Date is not used*/
                var
                d = new Date(parseInt(o, 10)),
                    year = d.getFullYear(),
                    month = d.getMonth(),
                    day = d.getDate(),
                    tick = '';

                if (day < 10) {
                    tick += '0';
                }
                tick += day + '/';

                if (month < 10) {
                    tick += '0';
                }
                tick += month + '/';
                tick += year.toString().substring(2,4);
                return tick;
            },
            title : xtitle
        },
        spreadsheet: {
            show: true,
            tickFormatter: function(e) {
                return e + "";
            }
        },
        
	});
	
	
}

