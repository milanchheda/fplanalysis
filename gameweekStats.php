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


$table = '<div class="container-fluid"><div class="panel panel-default">
  <div class="panel-heading">Gameweek stats</div><table id="gameweeksTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>GW</th>
                <th>GW Points</th>
                <th>Total Points</th>
                <th>GW Rank</th>
                <th>Overall Rank</th>
                <th>Team Value</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>GW</th>
                <th>GW Points</th>
                <th>Total Points</th>
                <th>GW Rank</th>
                <th>Overall Rank</th>
                <th>Team Value</th>
            </tr>
        </tfoot>
        <tbody>';

$query = mysqli_query($conn, "SELECT * FROM users_gameweek_history where user_fpl_id = " . $teamId . " ORDER BY gameweek_number ASC");
while($row = mysqli_fetch_array($query)) {
	if($row['gameweek_number'] == 1)
		$prevRank = 0;

	$addClass = '<div class="no-arrow">&mdash;</div>';
	if($row['gameweek_number'] > 1) {
		if($row['overall_rank'] > $prevRank)
			$addClass = '<div class="down-arrow"></div>';
		elseif($row['overall_rank'] < $prevRank)
			$addClass = '<div class="up-arrow"></div>';	
	}
	

	$table .= "<tr>
				<td>" . $addClass . $row['gameweek_number'] . "</td>
				<td>" . $row['points'] . "</td>
				<td>" . number_format($row['total_points']) . "</td>
				<td>" . number_format($row['rank']) . "</td>
				<td>" . number_format($row['overall_rank']) . "</td>
				<td>" . $row['team_value']/10 . "</td>
			</tr>"; 
	$prevRank = $row['overall_rank'];
}

$table .= "</tbody></table></div>";
echo $table;
?>
	<div class='container-fluid'>
		<div class="row">
	    	<div class="col-xs-12 col-md-6 leftContainerRightPadding">
		    	<div class="panel panel-default chart-container">
					<div class="panel-heading">Points across gameweeks</div>
					<div class="panel-body">
					</div>
					<canvas id='teams-canvas' width='535' height='220'></canvas>
				</div>

				<div class="panel panel-default chart-container">
					<div class="panel-heading">Ranks across gameweeks</div>
					<div class="panel-body">
					</div>
					<canvas id='yellow-canvas' width='535' height='220'></canvas>
				</div>
	    	</div>
		    <div class="col-xs-12 col-md-6 RightContainerLeftPadding">
		    	<div class="panel panel-default chart-container">
					<div class="panel-heading">Overall rank chart</div>
					<div class="panel-body">
					</div>
					<canvas id='red-canvas' width='535' height='220'></canvas>

				</div>

				<div class="panel panel-default chart-container">
					<div class="panel-heading">Teams value per gameweek</div>
					<div class="panel-body">
					</div>
					<canvas id='goals-canvas' width='535' height='220'></canvas>
				</div>
		    </div>
	  	</div>
	</div>
</div>
<footer>
    <center>
        <div class="devunit">
           Made with <span class="love"><i class="glyphicon glyphicon-heart"></i></span>  by <a href="//milanchheda.com" target="_BLANK">Milan Chheda</a>
        </div>
    </center>
</footer>
<script type="text/javascript">
	generatePointsChart(<?php echo json_encode($pointsChartData, JSON_NUMERIC_CHECK); ?>, 'teams-canvas', '#BBB', 'line')
	generatePointsChart(<?php echo json_encode($rankChartData, JSON_NUMERIC_CHECK); ?>, 'yellow-canvas', '#6cc644', 'line')
	generatePointsChart(<?php echo json_encode($overallRankChartData, JSON_NUMERIC_CHECK); ?>, 'red-canvas', '#d00', 'line')
	generatePointsChart(<?php echo json_encode($teamValueChartData, JSON_NUMERIC_CHECK); ?>, 'goals-canvas', '#6e5494', 'line')

</script>
</body>
</html>
