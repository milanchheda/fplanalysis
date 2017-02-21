<?php
// Create app and add keys from 
// https://apps.twitter.com/

// API OAuth 
// You need add files: 
// OAuth.php 
// twitteroauth.php  
// and keys $consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret
require_once('twitteroauth.php');
require('config.php');

$random = rand(1, 6);

switch ($random) {
	case 1:
		$msg = getTopThreeSelectedByPlayers();
		break;
	case 2:
		$msg = getTopTransferredInPlayer();
		break;
	case 3:
		$msg = getTopTransferredOutPlayer();
		break;
	case 4:
		$msg = getTopThreePlayersInForm();
		break;
	case 5:
		$msg = getTopThreeGoalScorers();
		break;
	case 6:
		$msg = getTopThreeAssists();
		break;
	default:
		$msg = getTopThreeSelectedByPlayers();
		break;
}

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
$append = "\n#PremierLeague #EPL #FPL";
$msg .= $append;
if(strlen($msg) < 140) { 	
	$t = $tweet->post('statuses/update', array('status' => $msg));
}


function getTopThreeSelectedByPlayers() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, selected_by FROM players ORDER BY selected_by DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = $result['selected_by'] . "% — " . "#" . $result['web_name'];
	}
	$msg = "Most selected #FPL players:\n" . implode("\n", $players);
	return $msg;
}

function getTopTransferredInPlayer() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, transfers_in_event FROM players ORDER BY transfers_in_event DESC limit 1");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$playerName = "#" . $result['web_name'];
		$transferred = $result['transfers_in_event'];
	}
	$msg = number_format($transferred) . " transfers and counting. " . $playerName . " is on FIRE.";
	return $msg;
}

function getTopTransferredOutPlayer() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name FROM players ORDER BY transfers_out_event DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$playerName[] = "#" . $result['web_name'];
	}
	$msg = "Most transferred out #FPL players:\n" . implode("\n", $playerName);
	return $msg;
}

function getTopThreePlayersInForm() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, form FROM players where status = 'a' ORDER BY transfers_in_event DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['form'];
	}
	$msg = "players in Top form:\n" . implode("\n", $players);
	return $msg;
}

function getTopThreeGoalScorers() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, goals_scored FROM players where status = 'a' ORDER BY goals_scored DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['goals_scored'];
	}
	$msg = "Top 3 Goal Scorers:\n" . implode("\n", $players);
	return $msg;
}

function getTopThreeAssists() {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, assists FROM players where status = 'a' ORDER BY assists DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['assists'];
	}
	$msg = "Top 3 players with Maximum Assists:\n" . implode("\n", $players);
	return $msg;
}

?>
