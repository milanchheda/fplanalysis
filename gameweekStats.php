<?php require 'header.php'; ?>
<?php
require_once __DIR__ . "/config.php";

session_start();
if(!is_numeric($_SESSION['teamID'])) {
	header('Location: index.php');
}

$teamId = $_SESSION['teamID'];

$query = mysqli_query($conn, "SELECT points, gameweek_number FROM users_gameweek_history where user_fpl_id = " . $teamId . " ORDER BY gameweek_number ASC");
while($row = mysqli_fetch_array($query)) {
	$pointsChartData[$row['gameweek_number']] = $row['points'];
}

$query = mysqli_query($conn, "SELECT rank, gameweek_number FROM users_gameweek_history where user_fpl_id = " . $teamId . " ORDER BY gameweek_number ASC");
while($row = mysqli_fetch_array($query)) {
	$rankChartData[$row['gameweek_number']] = $row['rank'];
}

$query = mysqli_query($conn, "SELECT overall_rank, gameweek_number FROM users_gameweek_history where user_fpl_id = " . $teamId . " ORDER BY gameweek_number ASC");
while($row = mysqli_fetch_array($query)) {
	$overallRankChartData[$row['gameweek_number']] = $row['overall_rank'];
}

$query = mysqli_query($conn, "SELECT team_value, gameweek_number FROM users_gameweek_history where user_fpl_id = " . $teamId . " ORDER BY gameweek_number ASC");
while($row = mysqli_fetch_array($query)) {
	$teamValueChartData[$row['gameweek_number']] = $row['team_value'];
}

?>

<div class='container-fluid'>
	<div class='container-fluid'>
		<div class="row">
	    	<div class="col-xs-12 col-md-6 leftContainerRightPadding">
		    	<div class="panel panel-default chart-container">
					<div class="panel-heading">Points across gameweeks</div>
					<div class="panel-body">
					</div>
					<canvas id='teams-canvas' width='535' height='300'></canvas>
				</div>

				<div class="panel panel-default chart-container">
					<div class="panel-heading">Ranks across gameweeks</div>
					<div class="panel-body">
					</div>
					<canvas id='yellow-canvas' width='535' height='300'></canvas>
				</div>
	    	</div>
		    <div class="col-xs-12 col-md-6 RightContainerLeftPadding">
		    	<div class="panel panel-default chart-container">
					<div class="panel-heading">Overall rank chart</div>
					<div class="panel-body">
					</div>
					<canvas id='red-canvas' width='535' height='300'></canvas>

				</div>

				<div class="panel panel-default chart-container">
					<div class="panel-heading">Teams value per gameweek</div>
					<div class="panel-body">
					</div>
					<canvas id='goals-canvas' width='535' height='300'></canvas>
				</div>
		    </div>
	  	</div>
	</div>
</div>

<script type="text/javascript">
	generatePointsChart(<?php echo json_encode($pointsChartData, JSON_NUMERIC_CHECK); ?>, 'teams-canvas', '#38003c', 'line')
	generatePointsChart(<?php echo json_encode($rankChartData, JSON_NUMERIC_CHECK); ?>, 'yellow-canvas', '#FFFF70', 'line')
	generatePointsChart(<?php echo json_encode($overallRankChartData, JSON_NUMERIC_CHECK); ?>, 'red-canvas', '#d00', 'line')
	generatePointsChart(<?php echo json_encode($teamValueChartData, JSON_NUMERIC_CHECK); ?>, 'goals-canvas', '#ff9999', 'line')

</script>
</body>
</html>
