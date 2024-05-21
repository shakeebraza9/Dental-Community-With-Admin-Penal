<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/usertraining_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new userevent_ajax();
    switch($page){
        case 'deleteusertraining':
            $ajax->deleteusertraining();
        break;
    }
}

?>