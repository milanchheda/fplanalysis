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
    <meta name="keywords" content="English Premier League, Fantasy Premier League, EPL, BPL, Barclays Premier League, Premier League">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1.0.1">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0.1"> 
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-91316667-2', 'auto');
        ga('send', 'pageview');
    </script>
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
    <footer>
        <center>
            <div class="devunit">
               Made with <span class="love"><i class="glyphicon glyphicon-heart"></i></span>  by <a href="//milanchheda.com" target="_BLANK">Milan Chheda</a>
            </div>
        </center>
    </footer>
</body>
</html>
