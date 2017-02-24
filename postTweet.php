<?php
// Create app and add keys from 
// https://apps.twitter.com/
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/twitteroauth.php";

// API OAuth 
// You need add files: 
// OAuth.php 
// twitteroauth.php  
// and keys $consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret
//require_once('twitteroauth.php');
//require('config.php');

$random = rand(1, 6);

switch ($random) {
	case 1:
		$msg = getTopThreeSelectedByPlayers($conn);
		break;
	case 2:
		$msg = getTopTransferredInPlayer($conn);
		break;
	case 3:
		$msg = getTopTransferredOutPlayer($conn);
		break;
	case 4:
		$msg = getTopThreePlayersInForm($conn);
		break;
	case 5:
		$msg = getTopThreeGoalScorers($conn);
		break;
	case 6:
		$msg = getTopThreeAssists($conn);
		break;
	default:
		$msg = getTopThreeSelectedByPlayers($conn);
		break;
}

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
$append = "\n#PremierLeague #EPL #FPL";
$msg .= $append;
if(strlen($msg) < 140) { 	
	$t = $tweet->post('statuses/update', array('status' => $msg));
}


function getTopThreeSelectedByPlayers($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, selected_by FROM players ORDER BY selected_by DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = $result['selected_by'] . "% — " . "#" . $result['web_name'];
	}
	$msg = "Most selected #FPL players:\n" . implode("\n", $players);
	return $msg;
}

function getTopTransferredInPlayer($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, transfers_in_event FROM players ORDER BY transfers_in_event DESC limit 1");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$playerName = "#" . $result['web_name'];
		$transferred = $result['transfers_in_event'];
	}
	$msg = number_format($transferred) . " transfers and counting. " . $playerName . " is on FIRE.";
	return $msg;
}

function getTopTransferredOutPlayer($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name FROM players ORDER BY transfers_out_event DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$playerName[] = "#" . $result['web_name'];
	}
	$msg = "Most transferred out #FPL players:\n" . implode("\n", $playerName);
	return $msg;
}

function getTopThreePlayersInForm($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, form FROM players where status = 'a' ORDER BY transfers_in_event DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['form'];
	}
	$msg = "players in Top form:\n" . implode("\n", $players);
	return $msg;
}

function getTopThreeGoalScorers($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, goals_scored FROM players where status = 'a' ORDER BY goals_scored DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['goals_scored'];
	}
	$msg = "Top 3 Goal Scorers:\n" . implode("\n", $players);
	return $msg;
}

function getTopThreeAssists($conn) {
	$getTopThreeSelectedBy = mysqli_query($conn, "SELECT web_name, assists FROM players where status = 'a' ORDER BY assists DESC limit 3");
	while($result = mysqli_fetch_array($getTopThreeSelectedBy)) {
		$players[] = "#" . $result['web_name'] . " — " . $result['assists'];
	}
	$msg = "Top 3 players with Maximum Assists:\n" . implode("\n", $players);
	return $msg;
}

?>
