<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/reports_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new reports_ajax();
    switch($page){
        case 'deletereports':
            $ajax->deletereports();
        break;

    }
}

?>