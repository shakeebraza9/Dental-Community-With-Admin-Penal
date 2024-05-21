<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/setting_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new setting_ajax();
    switch($page){
        case 'deleteHardWord':
            $ajax->deleteHardWord();
        break; 

       case 'active_setting':
            $ajax->fetc_Trash();
        break;
        case 'DeleteTrashDataadmin':
            $ajax->DeleteTrashDataadmin();
        break;
         case 'active_history':
            $ajax->fetch_history();
        break;

    }
}

?>