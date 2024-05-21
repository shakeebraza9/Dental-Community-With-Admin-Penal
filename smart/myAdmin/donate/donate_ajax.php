<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/donate_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new donate_ajax();
    switch($page){
        case 'deleteNews':
            $ajax->deleteNews();
        break;

    }
}

?>