<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/freeResources_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new documents_ajax();
    switch($page){
        case 'delete':
            $ajax->deletedocuments();
        break;
    }
}

?>