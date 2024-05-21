<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/icons_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new icons_ajax();
    switch($page){
        case 'deleteIcons':
            $ajax->deleteIcons();
        break;
    }
}

?>