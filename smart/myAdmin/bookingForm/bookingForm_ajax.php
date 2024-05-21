<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/bookingForm_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new bookingForm_ajax();
    switch($page){
        case 'deletebookingForm':
            $ajax->deletebookingForm();
        break;
        case 'lunchandlearn':
            $ajax->lunchandlearn();
        break;
    }
}

?>