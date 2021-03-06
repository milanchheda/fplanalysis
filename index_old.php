<?php

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/stats.php";
$getEnv = getenv('LOCAL_ENV');

session_start();
unset($_SESSION['teamID']);
$getRandomNumber = rand(1,12);
$getAnotherRandomNumber = rand(1,12);
while($getAnotherRandomNumber == $getRandomNumber) {
    $getAnotherRandomNumber = rand(1,12);
}
$image = 'images/'.$getRandomNumber.'.jpg';
$image1 = 'images/'.$getAnotherRandomNumber.'.jpg';
$isLive = getenv('IS_LIVE');
seeIfGameweekIsLive($conn);
$liveContent = explode("###", file_get_contents('live.txt'));
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1.0.2">
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css?v=1.0.2"/>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0.2">
    <script type="text/javascript" src="js/datatables.min.js?v=1.0.2"></script>
    <script type="text/javascript" src="js/fpl.js?v=1.0.2"></script>
<?php
if($getEnv != 'local') {
?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-91316667-2', 'auto');
        ga('send', 'pageview');
    </script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '827358514068521'); // Insert your pixel ID here.
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=827358514068521&ev=PageView&noscript=1"
    /></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
<?php
}
?>
</head>
<body>
    <div class="container" id="container">
        <div class="lookup-view">
            <div class="row">
                <h1 class="homePageHeader">Data analysis tool for Fantasy Premier League Managers</h1>
                <h2 class="subheading">Season 2016/17</h2>
                <div class="row">
                    <!-- <div class="col col-md-6">
                        <img class="homePageBanner" src="<?php echo $image; ?>" height="315" width=572 />
                    </div>
                    <div class="col col-md-6">
                        <img class="homePageBanner" src="<?php echo $image1; ?>" height="315" width=572 />
                    </div> -->
                    <div class="col col-md-12">
                        <ul class="nav nav-tabs">
                            <?php
                                if($liveContent[0] == 'ON')
                                echo '<li class="active"><a data-toggle="tab" href="#live">Live</a></li>
                                                            <li ><a data-toggle="tab" href="#home">Top Selections</a></li>';
                                else
                                    echo '<li class="active"><a data-toggle="tab" href="#home">Top Selections</a></li>';
                            ?>
                            <li><a data-toggle="tab" href="#menu1">Injuries</a></li>
                            <li><a data-toggle="tab" href="#menu2">Suspensions</a></li>
                            <li><a data-toggle="tab" href="#menu3">Unavailable</a></li>
                        </ul>

                        <div class="tab-content">
                        <?php
                            if($liveContent[0] == 'ON') {
                        ?>
                          <div id="live" class="tab-pane fade in active">
                            <p><?php echo getLiveData($conn); ?></p>
                          </div>
                          <div id="home" class="tab-pane fade">
                            <p><?php echo getTopSelections($conn); ?></p>
                          </div>
                        <?php
                            } else {
                        ?>
                          <div id="home" class="tab-pane fade in active">
                            <p><?php echo getTopSelections($conn); ?></p>
                          </div>
                          <?php } ?>
                          <div id="menu1" class="tab-pane fade">
                            <p><?php echo getInjuredPlayers($conn, 'i'); ?></p>
                          </div>
                          <div id="menu2" class="tab-pane fade">
                            <p><?php echo getInjuredPlayers($conn, 's'); ?></p>
                          </div>
                          <div id="menu3" class="tab-pane fade">
                            <p><?php echo getInjuredPlayers($conn, 'u'); ?></p>
                          </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col col-md-6">
                        <div class="box aboutFPL">
                            <p>FPL Analysis is a tool for any Fantasy Premier League manager/fan, providing information on players picked, players in dreamteam, top/under performers, game-week history and much more...</p>
                            <h4 class="lookup-title">Features</h4>
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
                        </div>
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
                                    <h4 class="lookup-title">See it in action?</h4><p>See it in action by viewing <a href="#" class="showMyTeamDashboard">My team</a>.</p>
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
