<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/terms_ajax.class.php");
    $page=$_GET['page'];
    $ajax=new terms_ajax();
    switch($page){
        case 'deleteTerms':
            $ajax->deleteTerms();
        break;

    }
}

?>