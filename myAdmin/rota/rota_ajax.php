<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/rota_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new rota_ajax();
    switch($page){
        case 'deleteshift':
            $ajax->deleteshift();
            break;
        case 'deleterota':
            $ajax->deleterota();   
            break;
    }
}

?>