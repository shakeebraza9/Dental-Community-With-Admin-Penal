<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/issues_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new issues_ajax();
    switch($page){
        case 'deleteIssues':
            $ajax->deleteIssues();
        break;

    }
}

?>