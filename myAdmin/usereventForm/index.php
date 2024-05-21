<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="eventManagement"; // ul menu active

switch($page):
    case ("usereventForm"):
        $subMenu='usereventForm';
        $content = include "usereventForm.php";
        break;
    case ("edit"):
        $subMenu='usereventForm';
        $content = include "usereventFormEdit.php";
        break;

    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['User Event Forms']) .'</h3>';
echo $content;

include("../footer.php");

?>