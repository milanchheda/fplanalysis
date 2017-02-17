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

function tog(v){return v?'addClass':'removeClass';} 

$(document).ready(function(){

    $('#example').DataTable({
        fixedHeader: true,
        order: [[9, 'desc']],
    });

    $(document).on('input', '.input-sm', function(){
        $(this)[tog(this.value)]('x');
    }).on('mousemove', '.x', function( e ){
        $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
    }).on('touchstart click', '.onX', function( ev ){
        ev.preventDefault();
        $(this).removeClass('x onX').val('').change();
        $(this).keyup();
    });

    $("body").on('click', ".searchByFilter", function(){
        $('div.dataTables_filter input').addClass('x').val($(this).text()).keyup();
    });
});