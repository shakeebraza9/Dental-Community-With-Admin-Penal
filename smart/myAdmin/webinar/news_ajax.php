<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/webinar.class.php");
    $page=$_GET['page'];

    $ajax = new webinar_ajax();
    switch($page){
        case 'deleteWebinar':
            $ajax->deleteWebinar();
        break;

    }
}

?>