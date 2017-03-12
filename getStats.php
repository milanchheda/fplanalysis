<?php
ini_set('display_errors', 'Off');
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/stats.php";

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $gameweekNumber = $_REQUEST['id'];
    $topStats = getGameweekStatsForPosition1($conn, $gameweekNumber);
    $result = getGameweekStats($conn, $gameweekNumber);
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
    echo $html . $topHtml;
} else {
    echo 0;
}
?>
