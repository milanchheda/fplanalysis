function generatePointsChart(resultPoints, canvasID, backgroundColor, chartType='bar') {
    var event = [];
    var points = [];

    for(var i in resultPoints) {
        event.push(i);
        points.push(resultPoints[i]);
    }

    var chartdata = {
        labels: event,
        datasets : [
            {
                label: 'Points',
                backgroundColor: backgroundColor,
                borderColor: backgroundColor,
                lineTension: 0.1, 
                borderCapStyle: 'butt',
                borderJoinStyle: 'miter',
                pointBackgroundColor: "#000",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                hoverBackgroundColor: '#DDD',
                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                data: points,
                fill: false,
            }
        ]
    };

    var ctx = $("#" + canvasID);

    var barGraph = new Chart(ctx, {
        type: chartType,
        data: chartdata,
        options : {
        	legend: {
        		display: false
        	},
            scales: {
                yAxes: [{
                    gridLines: {
                        lineWidth: 0,
                        color: "rgba(255,255,255,0)"
                    }
                }],
                xAxes: [{
                    gridLines: {
                        lineWidth: 0,
                        color: "rgba(255,255,255,0)"
                    }
                }]
            }
    	}
    });
}
