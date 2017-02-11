<?php

session_start();
if(!is_numeric($_SESSION['teamID'])) {
	header('Location: index.php');
}

require_once __DIR__ . "/config.php";

$query = mysqli_query($conn, "select sum(total_points) totalPoints, short_name from teams t
join players p on t.code = p.team_code
group by short_name
order by short_name ASC");
while($row = mysqli_fetch_array($query)) {
	$teamChart[$row['short_name']] = $row['totalPoints'];
}

$query = mysqli_query($conn, "select sum(yellow_cards) yellow_cards, short_name from teams t
join players p on t.code = p.team_code
group by short_name
order by short_name ASC");
while($row = mysqli_fetch_array($query)) {
	$yellowCardChart[$row['short_name']] = $row['yellow_cards'];
}

$query = mysqli_query($conn, "select sum(red_cards) red_cards, short_name from teams t
join players p on t.code = p.team_code
group by short_name
order by short_name ASC");
while($row = mysqli_fetch_array($query)) {
	$redCardChart[$row['short_name']] = $row['red_cards'];
}

$query = mysqli_query($conn, "select sum(goals_conceded) goals_conceded, short_name from teams t
join players p on t.code = p.team_code
where p.element_type = 1
group by short_name
order by short_name ASC");
while($row = mysqli_fetch_array($query)) {
	$goalsConcededChart[$row['short_name']] = $row['goals_conceded'];
}

?>
<?php require 'header.php'; ?>

<div class='container-fluid'>

<div class="panel panel-default">
  <div class="panel-heading">Overall FPL: Player Stats</div>
<?php

$table = '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>Position</th>
                <th>Goals scored</th>
                <th>Assists</th>
                <th>Clean sheets</th>
                <th>Goals conceded</th>
                <th>Own goals</th>
                <th>Minutes</th>
                <th>Total points</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>Position</th>
                <th>Goals scored</th>
                <th>Assists</th>
                <th>Clean sheets</th>
                <th>Goals conceded</th>
                <th>Own goals</th>
                <th>Minutes</th>
                <th>Total points</th>
            </tr>
        </tfoot>
        <tbody>';

$query = mysqli_query($conn, "select p.web_name, t.name, p.goals_scored, p.assists, p.clean_sheets, p.goals_scored, p.goals_conceded, p.own_goals, p.minutes, p.total_points, et.name elementName from players p
join teams t on t.code = p.team_code
join element_types et on et.id = p.element_type
order by p.total_points desc");
while($row = mysqli_fetch_array($query)) {
	$table .= "<tr>
				<td>" . $row['web_name'] . "</td>
				<td>" . $row['name'] . "</td>
				<td>" . $row['elementName'] . "</td>
				<td>" . $row['goals_scored'] . "</td>
				<td>" . $row['assists'] . "</td>
				<td>" . $row['clean_sheets'] . "</td>
				<td>" . $row['goals_conceded'] . "</td>
				<td>" . $row['own_goals'] . "</td>
				<td>" . $row['minutes'] . "</td>
				<td>" . $row['total_points'] . "</td>
			</tr>"; 
}

$table .= "</tbody></table>";
echo $table;
?>

</div>



<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 col-md-6 leftContainerRightPadding">
	    	<div class="panel panel-default chart-container">
				<div class="panel-heading">Overall FPL: Team Stats</div>
				<div class="panel-body">
				</div>
				<canvas id='teams-canvas' width='535' height='300'></canvas>
			</div>

			<div class="panel panel-default chart-container">
				<div class="panel-heading">Overall FPL: Yellow Cards by each team</div>
				<div class="panel-body">
				</div>
				<canvas id='yellow-canvas' width='535' height='300'></canvas>
			</div>
    	</div>
	    <div class="col-xs-12 col-md-6 RightContainerLeftPadding">
	    	<div class="panel panel-default chart-container">
				<div class="panel-heading">Overall FPL: Red Cards by each team</div>
				<div class="panel-body">
				</div>
				<canvas id='red-canvas' width='535' height='300'></canvas>

			</div>

			<div class="panel panel-default chart-container">
				<div class="panel-heading">Overall FPL: Goals Conceded by each team</div>
				<div class="panel-body">
				</div>
				<canvas id='goals-canvas' width='535' height='300'></canvas>
			</div>
	    </div>
  	</div>
</div>

</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable({
	    	fixedHeader: true,
	    	order: [[9, 'desc']],
	    });
	});

	generatePointsChart(<?php echo json_encode($teamChart, JSON_NUMERIC_CHECK); ?>, 'teams-canvas', '#38003c')
	generatePointsChart(<?php echo json_encode($yellowCardChart, JSON_NUMERIC_CHECK); ?>, 'yellow-canvas', '#FFFF70')
	generatePointsChart(<?php echo json_encode($redCardChart, JSON_NUMERIC_CHECK); ?>, 'red-canvas', '#d00')
	generatePointsChart(<?php echo json_encode($goalsConcededChart, JSON_NUMERIC_CHECK); ?>, 'goals-canvas', '#ff9999')

</script>
</body>
</html>
