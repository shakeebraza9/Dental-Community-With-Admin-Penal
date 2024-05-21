<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/tabsnew_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new tabsnew_ajax();
    switch($page){
        case 'deleteTabs':
            $ajax->deleteTabs();
        break;

    }
}

?>