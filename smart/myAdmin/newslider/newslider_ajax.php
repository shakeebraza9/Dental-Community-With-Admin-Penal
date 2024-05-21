<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/newslider_ajax.class.php");
    $page=$_GET['page'];

    $ajax = new newslider_ajax();
    switch($page){
        case 'deleteslid':
            $ajax->deleteslid();
        break;
        case 'newsliderSort':
            $ajax->newsliderSort();
            break;
    }
}

?>