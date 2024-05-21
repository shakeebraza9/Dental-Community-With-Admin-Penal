<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/documents_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new documents_ajax();
    switch($page){
        case 'deletedocuments':
            $ajax->deletedocuments();
        break;
    }
}

?>