<html>

<head>
<script src="foundation-5.2.1/js/vendor/jquery.js"></script>
<script src="Chart.js-master/Chart.js"></script>
<script src="smoothie.js"></script>
</head>

<body><h1>It works!</h1>

<canvas id="stockChart1" width="500" height="500"></canvas>
<canvas id="stockChart2" width="500" height="500"></canvas>
<canvas id="stockChart3" width="500" height="500"></canvas>
<canvas id="assetsChart" width="500" height="500"></canvas>

<script>

// Data
var line1 = new TimeSeries();
var line2 = new TimeSeries();
var line3 = new TimeSeries();
var line4 = new TimeSeries();

setInterval(function() {
	$.getJSON('get_current.php', function(data) {
		//console.log(data);

		var data1_temp = parseFloat(data[0].quote[0].ask) + Math.random()*10;
		var data2_temp = parseFloat(data[0].quote[0].ask) + Math.random()*10;
		var data3_temp = parseFloat(data[0].quote[0].ask) + Math.random()*10;

		var data1 = parseFloat(data[0].quote[0].ask);
	    var data2 = parseFloat(data[0].quote[1].ask);
	    var data3 = parseFloat(data[0].quote[2].ask);

	    line1.append(new Date().getTime(), data1_temp);
	    line2.append(new Date().getTime(), data2_temp);
	    line3.append(new Date().getTime(), data3_temp);

	    var count1 = parseInt(data[1].stocks[0].count);
	    var count2 = parseInt(data[1].stocks[1].count);
	    var count3 = parseInt(data[1].stocks[2].count);

	    var assets = data1_temp*count1 + data2_temp*count2 + data3_temp*count3 + parseFloat(data[1].balance[0].balance);
	    line4.append(new Date().getTime(), assets);
	 });
}, 1000);

var stockChart1 = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
stockChart1.addTimeSeries(line1, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
stockChart1.streamTo(document.getElementById("stockChart1"));

var stockChart2 = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
stockChart2.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
stockChart2.streamTo(document.getElementById("stockChart2"));

var stockChart3 = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
stockChart3.addTimeSeries(line3, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
stockChart3.streamTo(document.getElementById("stockChart3"));

var assetsChart = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
assetsChart.addTimeSeries(line4, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
assetsChart.streamTo(document.getElementById("assetsChart"));


/*
var ticker_data = JSON.parse('<?php include "get_history.php"; ?>');

var dates = new Array();
var open = new Array();
var close = new Array();

for(var i = 0; i < ticker_data.day.length; i++) { 
    dates[i] = ticker_data.day[i].date;
    open[i] = ticker_data.day[i].open;
    close[i] = ticker_data.day[i].close;
}

var data = {
	labels : dates,
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,1)",
			pointColor : "rgba(220,220,220,1)",
			pointStrokeColor : "#fff",
			data : open
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			data : close
		}
	]
}
var ctx = document.getElementById("myChart2").getContext("2d");
var myNewChart = new Chart(ctx).Line(data);
*/
</script>
</body>
</html>