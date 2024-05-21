<?php



if(isset($_GET['page'])){

    require_once(__DIR__ . "/classes/paper_ajax.class.php");

    $page=$_GET['page'];



    $ajax=new paper_ajax();

    switch($page){

        case 'deletePaper':

            $ajax->deletePaper();

        break;

        case 'getQuestions':

            $ajax->getQuestions();

        break;

        case 'deleteAssignedPaper':

            $ajax->deleteAssignedPaper();

        break;

          case 'Fetch_AssignedPaper':

            $ajax->Fetch_AssignedPaper();

        break;

    }

}



?>