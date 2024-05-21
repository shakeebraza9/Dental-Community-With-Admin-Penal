<?php



if(isset($_GET['page'])){

    require_once(__DIR__ . "/classes/domain_ajax.class.php");

    $page=$_GET['page'];



    $ajax=new domain_ajax();

    switch($page){

        case 'deleteDomain':

            $ajax->deleteDomain();

        break;



    }

}



?>