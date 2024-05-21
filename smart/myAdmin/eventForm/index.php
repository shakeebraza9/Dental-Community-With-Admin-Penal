<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="eventManagement"; // ul menu active

switch($page):
    case ("eventForm"):
        $subMenu='eventForm';
        $content = include "eventForm.php";
        break;
        case ("addeventForm"):
        $subMenu='addeventForm';
        $content = include "addeventForm.php";
        break;
        
    case ("edit"):
        $subMenu='eventForm';
        $content = include "eventFormEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Event Forms']) .'</h3>';
echo $content;

include("../footer.php");

?>