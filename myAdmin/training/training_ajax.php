<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/training_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new training_ajax();
    switch($page){
        case 'deletetraining':
            $ajax->deletetraining();
        break;
    }
}

?>