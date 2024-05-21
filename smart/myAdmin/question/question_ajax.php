<?php



if(isset($_GET['page'])){

    require_once(__DIR__ . "/classes/question_ajax.class.php");

    $page=$_GET['page'];



    $ajax=new question_ajax();

    switch($page){

        case 'deleteQuestion':

            $ajax->deleteQuestion();

        break;



    }

}



?>