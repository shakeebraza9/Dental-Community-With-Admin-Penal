<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="eventManagement"; // ul menu active

switch($page):
    case ("userevent"):
        $subMenu='userevent';
        $content = include "userevent.php";
        break;
    case ("edit"):
        $subMenu='userevent';
        $content = include "usereventEdit.php";
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