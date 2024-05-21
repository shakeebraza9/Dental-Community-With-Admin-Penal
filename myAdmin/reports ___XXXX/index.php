<?php

require_once("../global.php");

@$page = $_GET['page'];

global $menu;
global $subMenu;
$menu="reportsM"; // ul menu active

switch($page):
    case ("reports"):
        $subMenu='reports';
        $content = include "reports.php";
        break;
    case ("edit"):
        $subMenu='reports';
        $content = include "reportsEdit.php";
        break;
    case ("addreports"):
        $subMenu='addreports';
        $content = include "reportsNew.php";
        break;
    default:
        $content = "Page Not Found.";
        break;
    endswitch;


include("../header.php");
echo '<h3 class="main_heading">'. _uc($_e['reports Management']) .'</h3>';
echo $content;

include("../footer.php");

?>