<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/myUploads_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new myUploads_ajax();
    switch($page){
        case 'deletemyUploads':
            $ajax->deletemyUploads();
        break;
        case 'fileManagerSort':
            $ajax->filesManagerSort();
            break;
               case 'active_MyUploads':
            $ajax->fetch_MyUploads();
            break;
    }
}

?>