<?php
$lifetime=(3600*24*30);
if (session_status() == PHP_SESSION_NONE || session_id() == '') {
    session_set_cookie_params(3600 * 24 * 7, "/");
    session_start();
}

if(isset($_GET['errorId'])){
    $error = $_GET['errorId'];
    echo "<pre>";
        print_r($_SESSION['error'][$error]);
    echo "</pre>";
}
else {
    header("Location: https://smartdentalcompliance.com");
    echo "Set 404 custome page from admin.";
    echo "<pre>";
        print_r($_REQUEST);
        print_r($_GET);
    echo "</pre>";
}
?>