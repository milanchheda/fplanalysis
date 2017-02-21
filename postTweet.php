<?php
// Create app and add keys from 
// https://apps.twitter.com/

// API OAuth 
// You need add files: 
// OAuth.php 
// twitteroauth.php  
// and keys $consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret
require_once('twitteroauth.php');

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

$msg = "It works @fpl_analysis";
if(strlen($msg) < 140) { 	
$t = $tweet->post('statuses/update', array('status' => $msg));
echo "Tweet was send <br>";
//print_r($t);
}
?>
