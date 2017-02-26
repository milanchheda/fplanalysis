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
                lineTension: 0,
                borderWidth: 2,
                borderCapStyle: 'round',
                // borderJoinStyle: 'miter',
                // pointBackgroundColor: "#000",
                showLine: true,
                // pointBorderWidth: 1,
                // pointHoverRadius: 2,
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
                        display: true,
                        lineWidth: 1,
                        color: "rgba(0,0,0,0.1)"
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: 1,
                        color: "rgba(0,0,0,0)"
                    }
                }]
            }
    	}
    });
}

function tog(v){return v?'addClass':'removeClass';} 


$(document).ready(function(){
    window.setTimeout(function(){
        $(".twitter-timeline").contents().find(".MediaCard-media").remove();
    }, 1500);

    if($('.homepage-tabs').length) {
        $('.homepage-tabs').DataTable({
            fixedHeader: true,
            searching: false,
            bLengthChange: false,
            // "lengthMenu": [[5, 10, 15, -1], [10, 25, 50, "All"]]
        });    
    }

    if($('#example').length) {
        $('#example').DataTable({
            fixedHeader: true,
            order: [[9, 'desc']],
        });    
    }
    
    $(".showMyTeamDashboard").click(function(){
        $("#fpl-team-id").val(109123);
        $(".form").submit();
        return false;
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