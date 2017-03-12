<?php
// ini_set('display_errors', 'Off');
require_once __DIR__ . "/config.php";

if($_POST['msgname'] != '' && $_POST['msgemail'] != '' && $_POST['msgmessage'] != '') {
    $msgname = $_POST['msgname'];
    $msgemail = $_POST['msgemail'];
    $message = $_POST['msgmessage'];

    mysqli_query($conn, "INSERT INTO feedback (name, email, message) VALUES ('" . $msgname . "', '" . $msgemail . "', '" . $message . "')");
    echo "<div class='thankYouForFeedback'><span>Thank you for the feedback!</span></div>";
} else {
    echo 0;
}

?>
