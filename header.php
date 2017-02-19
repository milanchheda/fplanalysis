<?php
$getEnv = getenv('LOCAL_ENV');
$navigation = [
                'playerStats.php' => 'Player Stats',
                'teamStats.php' => 'Team Stats',
                'gameweekStats.php' => 'Gameweek Stats'
                ];
$navUrls = '';
foreach ($navigation as $key => $value) {
    $class = '';
    if(basename ($_SERVER['PHP_SELF']) == $key) {
        $class = "class='active'";
    }
    $navUrls .= '<li ' . $class . '><a href="' . $key . '">' . $value . '</a></li>';
}
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

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1.0.1">
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css?v=1.0.1"/>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0.1"> 
    <script type="text/javascript" src="js/Chart.bundle.min.js?v=1.0.1"></script>
    <script type="text/javascript" src="js/datatables.min.js?v=1.0.1"></script>
    <script type="text/javascript" src="js/fpl.js?v=1.0.1"></script>
<?php
    if($getEnv != 'local'){
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
<?php }
?>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">FPL Analysis</a>
        </div>
        <ul class="nav navbar-nav">
            <?php echo $navUrls; ?>
        </ul>
        <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search" action="teamStats.php" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter team ID" name="fpl-team-id" id="fpl-team-id">
                    <div class="input-group-btn">
                        <button class="btn btn-default search-icon" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</nav>
