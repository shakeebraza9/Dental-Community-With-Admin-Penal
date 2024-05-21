<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/safetyData_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new safetyData_ajax();
    switch($page){
        case 'deleteSafetyData':
            $ajax->deleteSafetyData();
        break;
        case 'safetyDataSort':
            $ajax->safetyDataSort();
            break;
    }
}

?>