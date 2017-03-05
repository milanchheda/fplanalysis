<?php
ini_set('display_errors', 'Off');
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/stats.php";
$getEnv = getenv('LOCAL_ENV');

$liveContent = explode("###", file_get_contents('live.txt'));
session_start();
unset($_SESSION['teamID']);
$topStats = getGameweekStatsForPosition1($conn);
$result = getGameweekStats($conn);
$count = 1;
$html = '';
foreach ($result as $key => $value) {
    if($count == 1 || $count == 5) {
        $html .= '<div class="row">';
    }
    $label = str_replace('_', ' ', $key);
    $label = ucwords($label);
    $html .= '<div class="col-md-3">
        <section class="widget widget-simple-sm">
            <div class="widget-simple-sm-statistic">
                <div class="number">' . $value . '</div>
                <div class="caption color-blue">' . $label . ' </div>
            </div>
        </section>
    </div>';
    if($count == 4 || $count == 7) {
        $html .= '</div>';
    }
    $count++;
}

$table = '';
$topHtml .= '<div class="row">';
foreach($topStats as $key => $value) {
    $positionName = $value[0]['name'];
    $table .= '<div class="col-md-3">
                <section class="card">
                <header class="card-header card-header-lg">
                    Top ' . $positionName . 's
                </header>
                    <div class="card-block">
                        <table class="table table-hover">';
    foreach($value as $k => $v) {
        $table .= "<tr>
                <td>" . $v['web_name'] . "</td>
                <td>" . $v['total_points'] . "</td>
            </tr>";
    }
    $table .= "</table></div></section></div>";
}
$topHtml .= $table . '</div>';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>FPL Analysis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="FPL Analysis">
    <meta name="description" content="FPL Analysis for Fantasy Premier League Managers">
    <meta name="keywords" content="English Premier League, Fantasy Premier League, EPL, BPL, Barclays Premier League, Premier League">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/widgets.min.css">
    <link rel="stylesheet" href="css/index.css">
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

<body class="with-side-menu  sidebar-hidden">
    <header class="site-header">
        <div class="container-fluid">
                <a href='index.php' class="logoClass">FPL Analysis</a>
                <span class="gameweekHeaderNumber">Gameweek: <?php echo $liveContent[1]; ?></span>
            <div class="site-header-content">
                <div class="site-header-content-in">
                    <div class="site-header-collapsed">
                        <div class="site-header-collapsed-in">
                            <div class="site-header-search-container">
                                 <form class="form" role="form" action="teamStats.php" method="POST">
                                    <input type="text" class="form-control" placeholder="Team ID"  name="fpl-team-id" id="fpl-team-id" required="true" pattern="\d*" maxlength="15">
                                    <!-- <button type="submit">
                                        <span class="font-icon-search"></span>
                                    </button> -->
                                    <div class="overlay"></div>
                                </form>
                            </div>
                        </div><!--.site-header-collapsed-in-->
                    </div><!--.site-header-collapsed-->
                </div><!--site-header-content-in-->
            </div><!--.site-header-content-->
        </div><!--.container-fluid-->
    </header>
    <div class="page-content">
        <div class="container-fluid">
            <?php echo $html; ?>
            <?php echo $topHtml; ?>
        </div><!--.container-fluid-->
    </div><!--.page-content-->
</body>
</html>
