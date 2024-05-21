<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/client_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new client_ajax();
    switch($page){
        case 'deleteclient':
            $ajax->deleteclient();
        break;
        case 'clientSort':
            $ajax->clientSort();
            break;
    }
}

?>