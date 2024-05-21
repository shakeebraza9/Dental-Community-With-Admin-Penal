<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/post_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new post_ajax();
    switch($page){
        case 'deletepost':
            $ajax->deletepost();
        break;

    }
}

?>