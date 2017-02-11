<?php require 'header.php'; ?>
<?php
require_once __DIR__ . "/config.php";

session_start();

if(isset($_POST['fpl-team-id']) && is_numeric($_POST['fpl-team-id']) && strlen($_POST['fpl-team-id']) < 12){
	$teamId = $_POST['fpl-team-id'];
	$_SESSION['teamID'] = $_POST['fpl-team-id'];
}
else if(isset($_SESSION['teamID']))
	$teamId = $_SESSION['teamID'];
else
	header('Location: index.php');

mysqli_query($conn, "INSERT INTO get_users_data (fpl_team_id, requested_on, status) values('" . $teamId . "', '". time() . "', '1')");


// $teamId = 109123;
$contents = json_decode(file_get_contents("https://fantasy.premierleague.com/drf/entry/" . $teamId . "/event/1"));

$current_event = $contents->ce;

mysqli_query($conn, "DELETE FROM fpl_user_data WHERE id = '" . $contents->entry->id . "'");
mysqli_query($conn, "INSERT INTO fpl_user_data values ('" . $contents->entry->id . "', '" . $contents->entry->player_first_name . "', '" . $contents->entry->player_last_name . "', '" . $contents->entry->player_region_name . "','" . $contents->entry->summary_overall_points . "','" . $contents->entry->summary_overall_rank . "','" . $contents->entry->summary_event_points . "','" . $contents->entry->summary_event_rank . "','" . $contents->entry->current_event . "','" . $contents->entry->total_transfers . "','" . $contents->entry->name . "')");

mysqli_query($conn, "INSERT INTO get_users_data (fpl_team_id, requested_on, status, gameweek_number) values('" . $teamId . "', '". time() . "', '1', '".$current_event."')");

//HISTORY
$history = json_decode(file_get_contents("https://fantasy.premierleague.com/drf/entry/" . $teamId . "/history"));
foreach($history->history as $value) {
	mysqli_query($conn, "INSERT INTO users_gameweek_history (user_fpl_id, points, total_points, rank, overall_rank, gameweek_number, team_value) values('" . $teamId . "', '". $value->points . "', '" . $value->total_points . "', '" . $value->rank . "', '" . $value->overall_rank . "', '" . $value->event . "', '" . $value->value . "')");
}


$queryCheck = mysqli_query($conn, "SELECT gameweek_number from user_gameweek_picks where user_fpl_id = " . $teamId . " AND gameweek_number=" . $current_event);
$resultCheck = mysqli_fetch_array($queryCheck);
if($resultCheck['gameweek_number'] != $current_event) {
	header('Location: playerStats.php');	
}

$query = mysqli_query($conn, "SELECT * FROM fpl_user_data where fpl_user_data_id = " . $teamId);
$teamData = mysqli_fetch_array($query);

$query = mysqli_query($conn, "select sum(points) totalPoints, p.web_name 
	from user_gameweek_picks ugp
	join fpl_user_data fud on fud.fpl_user_data_id = ugp.user_fpl_id
	join players p on p.id = ugp.player_code
where has_played = 1
and ugp.user_fpl_id = " . $teamId . "
group by web_name
order by sum(points) desc
limit 0, 10");
while($row = mysqli_fetch_array($query)) {
	$topPerformers[$row['web_name']] = $row['totalPoints'];
}


$query = mysqli_query($conn, "select sum(points) totalPoints, p.web_name from user_gameweek_picks ugp
join fpl_user_data fud on fud.fpl_user_data_id = ugp.user_fpl_id
join players p on p.id = ugp.player_code
where has_played = 1
and ugp.user_fpl_id = " . $teamId . "
group by web_name
order by sum(points) ASC
limit 0, 10");
while($row = mysqli_fetch_array($query)) {
	$lowPerformers[$row['web_name']] = $row['totalPoints'];
}

$query = mysqli_query($conn, "SELECT distinct player_code, sum(ugp.points) total_points, p.web_name, et.name as elementTypeName
from user_gameweek_picks ugp
join players p on p.id = ugp.player_code
join element_types et on et.id = p.element_type
where user_fpl_id = " . $teamId . "
group by ugp.player_code
order by sum(ugp.points) desc");
$table = '<table id="gameweekPlayers" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Total points</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Total points</th>
            </tr>
        </tfoot>
        <tbody>';
while($row = mysqli_fetch_array($query)) {
	$table .= "<tr>
				<td>" . $row['web_name'] . "</td>
				<td>" . $row['elementTypeName'] . "</td>
				<td>" . $row['total_points'] . "</td>
			</tr>"; 
}

$table .= "</tbody></table>";

$query = mysqli_query($conn, "SELECT distinct player_code, sum(ugp.points) total_points, p.web_name, et.name as elementTypeName
from user_gameweek_picks ugp
join players p on p.id = ugp.player_code
join element_types et on et.id = p.element_type
where user_fpl_id = " . $teamId . "
AND is_captain = 1
group by ugp.player_code
order by sum(ugp.points) desc");
$captainsTable = '<table id="gameweekCaptains" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Total points</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Total points</th>
            </tr>
        </tfoot>
        <tbody>';
while($row = mysqli_fetch_array($query)) {
	$captainsTable .= "<tr>
				<td>" . $row['web_name'] . "</td>
				<td>" . $row['elementTypeName'] . "</td>
				<td>" . $row['total_points'] . "</td>
			</tr>"; 
}

$captainsTable .= "</tbody></table>";
?>

<div class="row tile_count">
	<div class="col-md-4 col-sm-4 col-xs-6 team_name">
	  <div class="count_top">Team Name</div>
	  <div class="count"><?php echo $teamData['team_name']; ?></div>
	</div>
	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count bg_yellow">
	  <div class="count_top">Overall Points</div>
	  <div class="count"><?php echo number_format($teamData['summary_overall_points']); ?></div>
	</div>
	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count bg_green">
	  <div class="count_top">Overall Rank</div>
	  <div class="count"><?php echo number_format($teamData['summary_overall_rank']); ?></div>
	  
	</div>
	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count bg_red">
	  <div class="count_top">Gameweek Points</div>
	  <div class="count green"><?php echo number_format($teamData['summary_event_points']); ?></div>
	  
	</div>
	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count bg_aqua">
	  <div class="count_top">Gameweek Rank</div>
	  <div class="count"><?php echo number_format($teamData['summary_event_rank']); ?></div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-sm-4 col-xs-6 gameweekPlayersTable">
			<div class="count_top">Players You selected from Gameweek 1</div>
			<div class="panel-body"><?php echo $table; ?></div>
		</div>
		<div class="col-md-6 col-sm-4 col-xs-6 gameweekPlayersTable">
			<div class="count_top">Captains you selected from Gameweek 1</div>
			<div class="panel-body"><?php echo $captainsTable; ?></div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
	    	<div class="col-xs-12 col-md-6 leftContainerRightPadding">
		    	<div class="panel panel-default chart-container">
					<div class="panel-heading">Overall FPL: Top Performers</div>
					<div class="panel-body">
					</div>
					<canvas id='top-performers-canvas' width='535' height='300'></canvas>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 RightContainerLeftPadding">
				<div class="panel panel-default chart-container">
					<div class="panel-heading">Overall FPL: Low Performers</div>
					<div class="panel-body">
					</div>
					<canvas id='low-performers-canvas' width='535' height='300'></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#gameweekPlayers, #gameweekCaptains').DataTable({
	    	fixedHeader: true,
	    	order: [[2, 'desc']],
	    });
	});

	generatePointsChart(<?php echo json_encode($topPerformers, JSON_NUMERIC_CHECK); ?>, 'top-performers-canvas', '#1ABB9C');
	generatePointsChart(<?php echo json_encode($lowPerformers, JSON_NUMERIC_CHECK); ?>, 'low-performers-canvas', '#E74C3C')
</script>
