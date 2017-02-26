<?php


function getInjuredPlayers($conn, $status) {
	$table = '<table class="table table-striped table-bordered homepage-tabs" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>News</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>News</th>
            </tr>
        </tfoot>
        <tbody>';
	$query = mysqli_query($conn, "SELECT p.web_name, p.news, t.name 
						FROM players p
						JOIN teams t on t.code = p.team_code
						WHERE p.status = '".$status."'");

	while($row = mysqli_fetch_array($query)){
			$table .= "<tr>
				<td>" . $row['web_name'] . "</td>
				<td>" . $row['name'] . "</td>
				<td>" . $row['news'] . "</td>
			</tr>"; 
	}
	$table .= "</tbody></table>";
	
	return $table;
}

function getTopSelections($conn) {
	$table = '<table class="table table-striped table-bordered homepage-tabs" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Team</th>
                <th>Selected By</th>
            </tr>
        </thead>
        <tbody>';
	$query = mysqli_query($conn, "SELECT web_name, selected_by, t.name
				FROM players p
				JOIN teams t on t.code = p.team_code
				ORDER BY selected_by DESC limit 10");
	while($row = mysqli_fetch_array($query)){
			$table .= "<tr>
				<td>" . $row['web_name'] . "</td>
				<td>" . $row['name'] . "</td>
				<td>" . $row['selected_by'] . "%</td>
			</tr>"; 
	}
	$table .= "</tbody></table>";
	
	return $table;
}

function seeIfGameweekIsLive($conn) {
	$lastUpdated = getenv('LAST_UPDATED');
	if(time() - $lastUpdated > 1800) {
		if(getenv('IS_LIVE') == 'ON') {
			$gameweekNumber = getenv('gw_no');
			// prepare first part of the query (before values)
			$query = "INSERT INTO live (
			   player_id,
			   yellow_cards,
			   red_cards,
			   goals_conceded,
			   goals_scored,
			   bonus,
			   total_points,
			   minutes,
			   clean_sheets,
			   assists
			) VALUES ";
			$contents = json_decode(file_get_contents("https://fantasy.premierleague.com/drf/event/" . $gameweekNumber . "/live"));

			foreach ($contents->elements as $key => $value) {
				$query_values[] = "(".$key.", ".$value->stats->yellow_cards.", ".$value->stats->red_cards.", ".$value->stats->goals_conceded.",".$value->stats->goals_scored.", ".$value->stats->bonus.",".$value->stats->total_points.",".$value->stats->minutes.",".$value->stats->clean_sheets.",".$value->stats->assists.")";
			}
			
			mysqli_query($conn, $query . implode(',',$query_values));
		}
	}
}


function getLiveData($conn) {
	$query = mysqli_query($conn, "SELECT p.web_name, l.total_points, l.bonus, l.assists, l.goals_scored, l.minutes, l.clean_sheets, l.yellow_cards, l.red_cards
		from live l
		join players p on p.id = l.player_id
		order by l.total_points desc");
	$table = '<table id="live_players_stats" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Bonus</th>
                <th>Assists</th>
                <th>Goals Scored</th>
                <th>Minutes</th>
                <th>Clean Sheets</th>
                <th>Yellow Cards</th>
                <th>Red Cards</th>
            </tr>
        </thead>
        <tbody>';
	while($row = mysqli_fetch_array($query)) {
		$table .= "<tr>
					<td>" . $row['web_name'] . "</td>
					<td>" . $row['total_points'] . "</td>
					<td>" . $row['bonus'] . "</td>
					<td>" . $row['assists'] . "</td>
					<td>" . $row['goals_scored'] . "</td>
					<td>" . $row['minutes'] . "</td>
					<td>" . $row['clean_sheets'] . "</td>
					<td>" . $row['yellow_cards'] . "</td>
					<td>" . $row['red_cards'] . "</td>
				</tr>"; 
	}

	$table .= "</tbody></table>";
	return $table;
}
?>