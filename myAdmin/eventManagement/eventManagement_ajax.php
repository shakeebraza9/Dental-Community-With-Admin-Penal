<?php

if(isset($_GET['page'])){
    require_once(__DIR__ . "/classes/eventManagement_ajax.class.php");
    $page=$_GET['page'];

    $ajax=new eventManagement_ajax();
    switch($page){
        case 'deleteeventManagement':
            $ajax->deleteeventManagement();
        break; 
      
       case 'active_eventManagement':
            $ajax->fetch_eventManagement();
        break; 
        case 'draft_eventManagement':
            $ajax->fetch_draft_eventManagement();
        break;

    }
}
// if (isset($_GET['page'])) {
//     require_once(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."eventManagement".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."eventManagement_ajax.class.php");
//     $page = $_GET['page'];

//     $ajax = new ajax();
//     switch ($page) {

//         case 'active_eventManagement':
//             $ajax->fetch_eventManagement();
//         break;

//     }
// }

?>