<?php
session_start();
unset($_SESSION['teamID']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FPL Analysis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="FPL Analysis">
    <meta name="description" content="FPL Analysis for Fantasy Premier League Managers">
    <meta name="keywords" content="English Premier League, Fantasy Premier League, EPL, BPL, Barclays Premier League">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.css"/> -->
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/fpl.js"></script> -->
</head>
<body>
    <div class="container" id="container" data-page="">
        <div class="lookup-view">
            <div class="row">
                <h1 class="homePageHeader">Data analysis tool for Fantasy Premier League Managers</h1>
                <h2 class="subheading">Season 2016/17</h2>
                <div class="row">
                    <div class="col col-md-6">
                        <p>FPL Analysis is a tool for any Fantasy Premier League manager/fan, providing information on players picked, players in dreamteam, top/under performers, game-week history and much more...</p>
                        <h2 class="lookup-title">Features</h2>
                        <ul style="padding-right:40px">
                            <li>Detailed player analysis in sortable searchable tables.</li>
                            <li>Graph and Charts of various statistics.</li>
                            <li>Your game-week history, on how have you progressed so far.</li>
			    <li>Red & Yellow cards per team.</li>
			    <li>Goals conceded per team.</li>
			    <li>Your teams all-time High and Low performers.</li>
			    <li>Total points by each player in this season.</li>
			    <li>Total points by each position in this season.</li>
			    <li>Total points by each team in this season.</li>
                        </ul>
                        <br>
                        <!-- <h2 class="lookup-title">See it in action?</h2> -->
                        <!-- <p>See it in action by viewing <a href="/2697186/dashboard" class="leader">Hebknut</a>, the current FPL overall leader.</p> -->
                    </div>
                    <div class="col col-md-6">
                        <div class="box">
                            <h2 class="box__title">How to use?</h2>
                            <div class="box__content">
                                <h3>Enter team ID below</h3>
                                <form class="form" role="form" action="teamStats.php" method="POST">
                                    <div class="clearfix">
                                        <div class="col col--8">
                                            <div class="form__item">
                                                <input type="text" class="form-control" placeholder="Team ID"  name="fpl-team-id" id="fpl-team-id" required="true" pattern="\d*" maxlength="15">
                                            </div>
                                        </div>
                                        <div class="col col--4">
                                            <button type="submit" class="btn btn--primary btn--submit">Find team</button>
                                        </div>
                                    </div>
                                    <div class="form-help">
                                        <h3>How to find your team id?</h3>
                                        <p class="notes">Navigate to your points screen and your id is included in the page URL e.g: fantasy.premierleague.com/a/team/<strong>xxxxxx</strong>/event/x</p>
                                    </div>
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
