
<?php
$navigation = [
                'playerStats.php' => 'Player Stats',
                'teamStats.php' => 'Team Stats',
                'gameweekStats.php' => 'Gameweek Stats'
                ];
$navUrls = '';
foreach ($navigation as $key => $value) {
    $class = '';
    if(basename ($PHP_SELF,".php") == $key) {
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.js"></script>
    <script type="text/javascript" src="js/fpl.js"></script>
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
