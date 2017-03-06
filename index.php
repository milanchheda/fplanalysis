<?php
ini_set('display_errors', 'Off');

$getEnv = getenv('LOCAL_ENV');

$liveContent = explode("###", file_get_contents('live.txt'));
$lastGameweekNumber = $liveContent[1];
session_start();
unset($_SESSION['teamID']);
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
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
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
                <span class="gameweekHeaderNumber">Gameweek: <span class='gameweekNumber'><?php echo $lastGameweekNumber; ?></span></span>
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

        </div><!--.container-fluid-->
    </div><!--.page-content-->

    <a href="#" class="navigation navigation-prev" id=<?php echo $lastGameweekNumber-1; ?>>
        <img src="images/left.png" height="45" width="45"/>
    </a>
    <a href="#" class="navigation navigation-next" id=<?php echo $lastGameweekNumber+1; ?> style="margin-right: 0px;">
        <img src="images/right.png" height="45" width="45"/>
    </a>

    <script type="text/javascript" src="js/datatables.min.js?v=1.0.2"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            getData($(".gameweekNumber").text());
            $(".navigation").on('click', function(){
                $(".gameweekNumber").text($(this).attr("id"));
                getData($(this).attr("id"));
                if($(this).hasClass("navigation-prev")) {
                    $(this).attr("id", ($(this).attr("id")-1));
                    $(".navigation-next").attr('id', ($(this).attr("id")));
                } else {
                    $(this).attr("id", ($(this).attr("id")+1));
                    $(".navigation-prev").attr('id', ($(this).attr("id")));
                }
            });
        });

        function getData(gw_no) {
            $(".navigation").hide();
            $(".page-content .container-fluid").html("<img src='images/loading.gif' style='margin:10% 37%;'/>");
            $.ajax({
                url: "getStats.php",
                data: { id: gw_no },
                datatype: 'html',
                type: "post",
                success: function(data, textStatus, jqXHR) {
                    $(".gameweekNumber").text(gw_no);
                    $(".page-content .container-fluid").html(data);
                    $(".navigation").show();
                }
            });
        }
    </script>
</body>
</html>
