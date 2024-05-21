<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="tabsnewM"; // ul menu active

switch($page):
    case ("tabsnew"):
        $subMenu='tabsnew';
        $content = include "tabsnew.php";
        break;
    case ("edit"):
        $subMenu='tabsnew';
        $content = include "tabsnewEdit.php";
        break;
    case ("addTabs"):
        $subMenu='addTabs';
        $content = include "tabsnewNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['Tabs Management']) .'</h3>';
echo $content;

include("../footer.php");

?>