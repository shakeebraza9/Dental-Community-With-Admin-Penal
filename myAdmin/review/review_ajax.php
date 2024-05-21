<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/review_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new review_ajax();
    switch($page){
        case 'deleteReview':
            $ajax->deleteReview();
        break;
        // case 'bannersSort':
        //     $ajax->bannersSort();
        //     break;
    }
}

?>