<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="eventManagement"; // ul menu active

switch($page):
    case ("eventManagement"):
        $subMenu='eventManagement';
        $content = include "eventManagement.php";
      break;
     case ("addeventManagement"):
        $subMenu='addeventManagement';
        $content = include "addeventManagement.php";

        break;
    case ("edit"):
        $subMenu='eventManagement';
        $content = include "eventManagementEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Event Management']) .'</h3>';
echo $content;

include("../footer.php");

?>