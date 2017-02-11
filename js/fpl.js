function generatePointsChart(resultPoints, canvasID, backgroundColor) {
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
                borderColor: '#000',
                hoverBackgroundColor: '#DDD',
                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                data: points,
                fill: false,
            }
        ]
    };

    var ctx = $("#" + canvasID);

    var barGraph = new Chart(ctx, {
        type: 'bar',
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
