<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.13/af-2.1.3/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/se-1.2.0/datatables.min.js"></script>
    <script type="text/javascript" src="js/fpl.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">FPL Analysis</a>
        </div>
        <ul class="nav navbar-nav">
            <!--<li class="active"><a href="#">Home</a></li>-->
            <li><a href="playerStats.php">Player Stats</a></li>
            <li><a href="teamStats.php">Team Stats</a></li>
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
