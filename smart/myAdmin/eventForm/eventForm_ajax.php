<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/eventForm_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new eventForm_ajax();
    switch($page){
        case 'deleteeventForm':
            $ajax->deleteeventForm();
        break;
         case 'active_eventForm':
            $ajax->fetch_eventForm();
        break;
           case 'draft_eventForm':
            $ajax->fetch_draft_eventForm();
        break;
    }
}

?>