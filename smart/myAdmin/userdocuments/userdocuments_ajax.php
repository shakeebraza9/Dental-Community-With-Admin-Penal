<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/userdocuments_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new userdocuments_ajax();
    switch($page){
        case 'deleteuserdocuments':
            $ajax->deleteuserdocuments();
        break;
          case 'active_userdocuments':
            $ajax->fetch_userdocuments();
        break;
    }
}

?>