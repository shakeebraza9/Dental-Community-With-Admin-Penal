<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/cpdGenerater_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new cpdGenerater_ajax();
    switch($page){
        case 'deleteNews':
            $ajax->deleteNews();
        break;

    }
}

?>