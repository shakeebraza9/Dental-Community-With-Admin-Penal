<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/usereventForm_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new usereventForm_ajax();
    switch($page){
        case 'deleteusereventForm':
            $ajax->deleteusereventForm();
        break;
          case 'active_usereventForm':
            $ajax->fetch_usereventForm();
        //echo"ssssssssssssssssssssssssssssssssssssssssss";
        break;
    }
}

?>