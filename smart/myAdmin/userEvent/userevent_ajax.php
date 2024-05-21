<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/userevent_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new userevent_ajax();
    switch($page){
        case 'deleteuserevent':
            $ajax->deleteuserevent();
        break;
        
          case 'active_userEvent':
            $ajax->fetch_userevent();
        break;
        case 'draft_userEvent':
            $ajax->fetch_draft_userevent();
        break;
    }
}

?>