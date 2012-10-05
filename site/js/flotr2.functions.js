function basic (element) {

	var container = document.getElementById(element);

	var d1 = [[0, 3], [4, 8], [8, 5], [9, 13]]; // First data series
	var d2 = [];                                // Second data series
	var i, graph;

	// Generate first data set
	for (i = 0; i < 14; i += 0.5) {
		d2.push([i, Math.sin(i)]);
	}

	// Draw Graph
	graph = Flotr.draw(container, [ d1, d2 ], {
		xaxis: {minorTickFreq: 4}, 
		grid: {minorVerticalLines: true}
	});

}



function basic_time_thermiSensors (element, input, mainTitle) {

	var container = document.getElementById(element);

	var d=[];
	var options, graph, i, x, o;
	
	// Generate first data set
	for (i = 0; i < input.length; i++) {
		x = (new Date(input[i][0])).getTime();
		y = input[i][1];
		d.push([x, y]);
	}
	
	options = {
			xaxis: {mode: "time", labelsAngle: 45},
			selection: {mode: "x"},
			HtmlText: false,
			title: mainTitle
	};
	
	function drawGraph(opts) {
		o = Flotr._.extend(Flotr._.clone(options), opts || {});
		return Flotr.draw(container, [d], o);
	}
	
	
	graph = drawGraph();
		
	graph = drawGraph({
		xaxis: {min: area.x1,max: area.x2,mode: "time",labelsAngle: 45, minorTickFreq: input.length},
		yaxis: {min: area.y1,max: area.y2},				
		});
					
}



function basic_bars_thermiSensors(element, input, mainTitle) {

	var container = document.getElementById(element);
	
	var data = [];
	var point, i;

	// Generate first data set
	for (i = 0; i < input.length; i++) {
		x = (new Date(input[i][0])).getTime();
		y = input[i][1];
		y = Math.round(y*100)/100;
		data.push([i, y]);
	}
//alert(data);
	Flotr.draw(container, [data], {
			bars: {show: true, horizontal: false, shadowSize: 0, barWidth: 0.5},
			mouse: {track: true, relative: true},
			yaxis: {min: 0, autoscaleMargin: 1},
			title: mainTitle
	});
	
}


function basic_time(element) {

	var container = document.getElementById(element);

	var d1 = [];
	var start = (new Date("2009/01/01 01:00")).getTime();
	var options, graph, i, x, o;
	
	
	for (i = 0; i < 100; i++) {
		x = start + i * 1000 * 3600 * 24 * 36.5;
		d1.push([x, i + Math.random() * 30 + Math.sin(i / 20 + Math.random() * 2) * 20 + Math.sin(i / 10 + Math.random()) * 10]);
	}
	
	options = {
			xaxis: {mode: "time",labelsAngle: 45},
			selection: {mode: "x"},
			HtmlText: false,
			title: "Time"
	};

	function drawGraph(opts) {
		o = Flotr._.extend(Flotr._.clone(options), opts || {});
		return Flotr.draw(container, [d1], o);
	}
	

	graph = drawGraph();
	
	Flotr.EventAdapter.observe(container, "flotr:select", function(area) {
					graph = drawGraph({
					xaxis: {min: area.x1,max: area.x2,mode: "time",labelsAngle: 45	},
					yaxis: {min: area.y1,max: area.y2}
					});
	});


	Flotr.EventAdapter.observe(container, "flotr:click", function() {
		graph = drawGraph();
	});
	
}


function basic_timeNoInteraction(element) {

	var container = document.getElementById(element);

	var d1 = [];
	var start = (new Date("2009/01/01 01:00")).getTime();
	var options, graph, i, x, o;
	
	
	for (i = 0; i < 100; i++) {
		x = start + i * 1000 * 3600 * 24 * 36.5;
		d1.push([x, i + Math.random() * 30 + Math.sin(i / 20 + Math.random() * 2) * 20 + Math.sin(i / 10 + Math.random()) * 10]);
	}
	
	options = {
			xaxis: {mode: "time",labelsAngle: 45},
			selection: {mode: "x"},
			HtmlText: false,
			title: "Time"
	};

	function drawGraph(opts) {
		o = Flotr._.extend(Flotr._.clone(options), opts || {});
		return Flotr.draw(container, [d1], o);
	}
	
	graph = drawGraph();
	graph = drawGraph({
		xaxis: {min: area.x1,max: area.x2,mode: "time",labelsAngle: 45	},
		yaxis: {min: area.y1,max: area.y2}
		});

}

function basic_axis(element) {

	var container = document.getElementById(element);
	
	var d1 = [];
	var d2 = [];
	var d3 = [];
	var d4 = [];
	var d5 = [];
	var ticks = [[0, "Lower"], 10, 20, 30, [40, "Upper"] ];
	var graph;
	
	
	for (var i = 0; i <= 10; i += 0.1) {
		d1.push([i, 4 + Math.pow(i, 1.5)]);
		d2.push([i, Math.pow(i, 3)]);
		d3.push([i, i * 5 + 3 * Math.sin(i * 4)]);
		d4.push([i, i]);
		if (i.toFixed(1) % 1 == 0) {
			d5.push([i, 2 * i]);
		}
	}
	
	
	d3[30][1] = null;
	d3[31][1] = null;

	function ticksFn(n) {
		return "(" + n + ")";
	}
	
	
	graph = Flotr.draw(container, [
						{data: d1, label: "y = 4 + x^(1.5)", lines: {fill: true}}, 
						{data: d2, label: "y = x^3"},
						{data: d3, label: "y = 5x + 3sin(4x)"},
						{data: d4, label: "y = x"},
						{data: d5, label: "y = 2x", lines: {show: true}, points: {show: true}}
					],
					{
						xaxis: {noTicks: 7, tickFormatter: ticksFn, min: 1, max: 7.5},
						yaxis: {ticks: ticks, max: 40 },
						grid: {verticalLines: false, backgroundColor: {colors: [[0, "#fff"],[1, "#ccc"]],start: "top",end: "bottom"}},
						legend: {position: "nw"},
						title: "Basic Axis example",
						subtitle: "This is a subtitle"
					}
				);
	
	
}




function basic_bars(element, horizontal) {

	var container = document.getElementById(element);
	
	
	var horizontal = horizontal ? true : false;
	var d1 = [];
	var d2 = [];
	var point, i;
	
	for (i = 0; i < 4; i++) {
		if (horizontal) {
			point = [Math.ceil(Math.random() * 10), i];
		} 
		else {
			point = [i, Math.ceil(Math.random() * 10)];
		}
		d1.push(point);
		
		if (horizontal) {
			point = [Math.ceil(Math.random() * 10), i + 0.5];
		} 
		else {
			point = [i + 0.5, Math.ceil(Math.random() * 10)];
		}
		d2.push(point);
	}


	Flotr.draw(container, [d1, d2], {
		bars: {show: true, horizontal: horizontal, shadowSize: 0, barWidth: 0.5},
		mouse: {track: true, relative: true},
		yaxis: {min: 0, autoscaleMargin: 1}
	});
}




function basic_legend(element) {

	var container = document.getElementById(element);

	var d1 = [];
	var d2 = [];
	var d3 = [];
	var data, graph, i;

	for (i = 0; i < 15; i += 0.5) {
		d1.push([i, i + Math.sin(i + Math.PI)]);
		d2.push([i, i]);
		d3.push([i, 15 - Math.cos(i)]);
	}
	
	data = [
			{data: d1, label: "x + sin(x+&pi;)"},
			{data: d2, label: "x"},
			{data: d3, label: "15 - cos(x)"}
		];

	function labelFn(label) {
		return "y = " + label;
	}

	graph = Flotr.draw(
						container,
						data,
						{legend: {position: "se", labelFormatter: labelFn, backgroundColor: "#D2E8FF"},HtmlText: false}
						);
}
